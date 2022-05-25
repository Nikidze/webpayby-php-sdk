<?php

namespace Nikidze\Webpay\Request;

use GuzzleHttp\Exception\ClientException;
use Nikidze\Webpay\Client\GuzzleRequestTransformer;
use Nikidze\Webpay\Contract\EndpointInterface;
use Nikidze\Webpay\Contract\RequestTransformerInterface;
use Nikidze\Webpay\Contract\ResponseInterface;
use Nikidze\Webpay\Credential\AccountCredential;
use Nikidze\Webpay\Endpoint\ApiEndpoint;
use Nikidze\Webpay\Helper\SignatureHelper;

abstract class ApiRequest
{
    const API_VERSION = 2;

    private RequestTransformerInterface $transformer;

    private EndpointInterface $endpoint;

    private AccountCredential $credential;

    private string $seed;

    public function __construct(AccountCredential $credential, string $seed)
    {
        $this->credential = $credential;
        $this->seed = $seed;
    }

    public function getTransactionData(): array
    {
        return [
            'wsb_storeid' => $this->credential->getAccount(),
            'wsb_signature' => SignatureHelper::mathSignature(
                $this->getRequestSignatureFieldsValues(),
                SignatureHelper::REQUEST
            ),
            'wsb_seed' => $this->seed,
            'wsb_version' => self::API_VERSION,
        ];
    }

    public function getRequestSignatureFieldsValues(): array
    {
        return [
            'wsb_seed' => $this->seed,
            'wsb_storeid' => $this->credential->getAccount(),
            'secret_key' => $this->credential->getSecret()
        ];
    }

    public function getResponseSignatureFieldsRequired(): array
    {
        return [];
    }

    public function getEndpoint(): EndpointInterface
    {
        if (!isset($this->endpoint)) {
            $this->endpoint = new ApiEndpoint();
        }

        return $this->endpoint;
    }

    public function getReferer()
    {
        return $this->credential->getReferer();
    }


    public function setEndpoint(EndpointInterface $endpoint): self
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    public function getTransformer(): RequestTransformerInterface
    {
        if (!isset($this->transformer)) {
            $this->transformer = new GuzzleRequestTransformer();
        }
        return $this->transformer;
    }

    /**
     * @param RequestTransformerInterface $transformer
     * @return ApiRequest
     */
    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;
        return $this;
    }

    /**
     * @return ResponseInterface
     * @throws ClientException
     */
    public function send(): ResponseInterface
    {
        return $this->getTransformer()->transform($this);
    }

    abstract public function getResponseClass(): string;

    /**
     * @throws \Exception
     */
    public function getResponse(object $data): ResponseInterface
    {
        $class = $this->getResponseClass();
        $response = new $class($data);

        /*
        if ($signatureRequired = array_flip($this->getResponseSignatureFieldsRequired())) {
            $expected = SignatureHelper::mathSignature(
                array_intersect_key( // https://stackoverflow.com/a/17438222
                    array_replace($signatureRequired, $data),
                    $signatureRequired
                ),
            );

            if (
                !isset($data['merchantSignature'])
                || $expected !== $data['merchantSignature']
            ) {
                throw new SignatureException(
                    'Response signature mismatch: expected ' . $expected . ', got ' . $data['merchantSignature']
                );
            }
        }
        */

        return $response;
    }
}
