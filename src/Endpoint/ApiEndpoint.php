<?php

namespace Nikidze\Webpay\Endpoint;

use Nikidze\Webpay\Contract\EndpointInterface;

class ApiEndpoint implements EndpointInterface
{
    public function getUrl(): string
    {
        return '';
    }

    public function getMethod(): string
    {
        return 'POST';
    }
}