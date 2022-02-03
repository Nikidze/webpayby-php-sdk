<?php

namespace Nikidze\Webpay\Handler;

use Nikidze\Webpay\Credential\AccountCredential;
use Nikidze\Webpay\Helper\SignatureHelper;
use Nikidze\Webpay\Response\ServiceResponse;

class ServiceUrlHandler
{

    private AccountCredential $credential;

    public function __construct(AccountCredential $credential)
    {
        $this->credential = $credential;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function parseRequestFromPostRaw(): ServiceResponse
    {
        $data = json_decode(file_get_contents('php://input'));

        if ($data === null) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }

        return $this->parseRequestFromObject($data);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function parseRequestFromObject(object $data): ServiceResponse
    {
        $response = new ServiceResponse($data);
        $signature = SignatureHelper::mathSignature(
            [
                'batch_timestamp' => $response->getBatchTimestamp(),
                'currency_id' => $response->getCurrencyId(),
                'amount' => $response->getAmount(),
                'payment_method' => $response->getPaymentMethod(),
                'order_id' => $response->getOrderId(),
                'site_order_id' => $response->getSiteOrderId(),
                'transaction_id' => $response->getTransactionId(),
                'payment_type' => $response->getPaymentType(),
                'rrn' => $response->getRrn(),
                'secret_key' => $this->credential->getSecret(),
            ],
            SignatureHelper::RESPONSE,
        );

        if ($signature != $response->getSignature()) {
            throw new \InvalidArgumentException("Signatures mismatch");
        }

        return $response;
    }
}
