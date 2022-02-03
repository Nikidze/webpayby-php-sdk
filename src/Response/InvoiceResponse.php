<?php

namespace Nikidze\Webpay\Response;

class InvoiceResponse extends Response
{
    public function getRedirectUrl(): string
    {
        return $this->data->redirectUrl;
    }
}