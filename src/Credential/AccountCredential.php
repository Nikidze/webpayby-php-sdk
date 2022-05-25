<?php

namespace Nikidze\Webpay\Credential;

class AccountCredential
{
    private string $account;

    private string $secret;

    private string $referer;

    public function __construct(string $account, string $secret, string $referer)
    {
        $this->account = $account;
        $this->secret = $secret;
        $this->referer = $referer;
    }
    public function getAccount(): string
    {
        return $this->account;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function getReferer(): string
    {
        return $this->referer;
    }
}
