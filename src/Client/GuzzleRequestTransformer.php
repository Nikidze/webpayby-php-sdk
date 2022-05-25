<?php

namespace Nikidze\Webpay\Client;

use GuzzleHttp\Client;
use Nikidze\Webpay\Contract\RequestTransformerInterface;
use Nikidze\Webpay\Request\ApiRequest;
use Nikidze\Webpay\Contract\ResponseInterface;

class GuzzleRequestTransformer implements RequestTransformerInterface
{
    public function transform(ApiRequest $request): ResponseInterface
    {
        $endpoint = $request->getEndpoint();
        $data = $request->getTransactionData();
        $response = (new Client())->post(
            $endpoint->getUrl(),
            [
                'json' => array_filter($data),
                'headers' => [
                    'Origin' => $request->getReferer(),
                    'Referer' => $request->getReferer()
                ]
            ]
        );
        return $request->getResponse(json_decode($response->getBody()->getContents())->data);
    }
}
