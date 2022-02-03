<?php

namespace Nikidze\Webpay\Response;

use Nikidze\Webpay\Contract\ResponseInterface;

class Response implements ResponseInterface
{
    protected object $data;

    public function __construct(object $data) {
        $this->data = $data;
    }

    public function getData(): object
    {
        return $this->data;
    }

    public static function getClass()
    {
        return get_called_class();
    }
}
