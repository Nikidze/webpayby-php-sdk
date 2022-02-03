<?php

namespace Nikidze\Webpay\Endpoint;

use Nikidze\Webpay\Contract\EndpointInterface;

class InvoiceEndpoint implements EndpointInterface
{
    public function getUrl(): string
    {
        return 'https://payment.webpay.by/api/v1/payment';
    }

    public function getMethod(): string
    {
        return 'POST';
    }
}
