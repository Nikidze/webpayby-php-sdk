<?php

namespace Nikidze\Webpay\Domain;

class Customer
{
    private string $name;

    private string $address;

    private string $email;

    private string $phone;

    public function __construct(string $name, string $address, string $email, string $phone)
    {
        $this->name = $name;
        $this->address = $address;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}
