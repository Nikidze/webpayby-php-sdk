<?php

namespace Nikidze\Webpay\Endpoint;

use Nikidze\Webpay\Contract\EndpointInterface;

class InvoiceTestEndpoint implements EndpointInterface
{
    public function getUrl(): string
    {
        return 'https://securesandbox.webpay.by/api/v1/payment';
    }

    public function getMethod(): string
    {
        return 'POST';
    }
}
