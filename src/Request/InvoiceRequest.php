<?php

namespace Nikidze\Webpay\Request;

use Nikidze\Webpay\Collection\ItemCollection;
use Nikidze\Webpay\Credential\AccountCredential;
use Nikidze\Webpay\Domain\Customer;
use Nikidze\Webpay\Domain\Discount;
use Nikidze\Webpay\Domain\Shipping;
use Nikidze\Webpay\Response\InvoiceResponse;

class InvoiceRequest extends ApiRequest
{

    private array $transactionData;

    public function __construct(AccountCredential $credential, string $seed, array $transactionData)
    {
        parent::__construct($credential, $seed);
        $this->transactionData = $transactionData;
    }

    public function getResponseClass(): string
    {
        return InvoiceResponse::getClass();
    }

    public function getRequestSignatureFieldsValues(): array
    {
        return array_merge(
            parent::getRequestSignatureFieldsValues(),
            [
                'wsb_order_num' => $this->transactionData['wsb_order_num'],
                'wsb_test' => $this->transactionData['wsb_test'],
                'wsb_currency_id' => $this->transactionData['wsb_currency_id'],
                'wsb_total' => $this->transactionData['wsb_total'],
            ]
        );
    }

    public function getTransactionData(): array
    {
        return array_merge(
            parent::getTransactionData(),
            $this->transactionData
        );
    }

    public function send(): InvoiceResponse
    {
        return parent::send();
    }


}
