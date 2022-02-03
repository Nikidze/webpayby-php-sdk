<?php

namespace Nikidze\Webpay\Credential;

class AccountCredential
{
    private string $account;

    private string $secret;

    public function __construct(string $account, string $secret)
    {
        $this->account = $account;
        $this->secret = $secret;
    }
    public function getAccount(): string
    {
        return $this->account;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }
}
