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
    public function checkSignature(object $data): bool
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

        return $signature == $response->getSignature();
    }
}
