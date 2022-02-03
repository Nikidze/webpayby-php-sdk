<?php

namespace Nikidze\Webpay\Contract;

interface EndpointInterface
{

    public function getUrl(): string;

    public function getMethod(): string;

}
