<?php

namespace Nikidze\Webpay\Domain;

class Shipping extends Item
{
    public function __construct(string $name, float $price)
    {
        parent::__construct($name, $price, 1);
    }
}
