<?php

namespace Nikidze\Webpay\Contract;

use Nikidze\Webpay\Request\ApiRequest;

interface RequestTransformerInterface
{
    public function transform(ApiRequest $request):ResponseInterface;
}