<?php

namespace Nikidze\Webpay\Contract;

interface ResponseInterface
{
    public function getData(): object;
}