<?php

namespace Nikidze\Webpay\Domain;

class Item
{
    public string $name;

    public float $price;

    public int $quantity;

    public function __construct(string $name, float $price, int $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }
}
