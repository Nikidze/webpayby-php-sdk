<?php

namespace Nikidze\Webpay\Response;

class ServiceResponse extends Response
{
    public function getBatchTimestamp(): string
    {
        return $this->data->batch_timestamp;
    }

    public function getCurrencyId(): string
    {
        return $this->data->currency_id;
    }

    public function getAmount(): string
    {
        return $this->data->amount;
    }

    public function getPaymentMethod(): string
    {
        return $this->data->payment_method;
    }

    public function getOrderId(): string
    {
        return $this->data->order_id;
    }

    public function getSiteOrderId(): string
    {
        return $this->data->site_order_id;
    }

    public function getTransactionId(): string
    {
        return $this->data->transaction_id;
    }

    public function getPaymentType(): string
    {
        return $this->data->payment_type;
    }

    public function getRrn(): string
    {
        return $this->data->rrn;
    }

    public function getSignature(): string
    {
        return $this->data->wsb_signature;
    }

}