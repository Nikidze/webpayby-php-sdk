<?php

namespace Nikidze\Webpay\Collection;

use Illuminate\Support\Collection;
use Nikidze\Webpay\Domain\Item;

class ItemCollection
{

    private Collection $items;

    public function __construct(array $items)
    {
        $this->items = new Collection($items);
    }

    public function add(Item $item): void
    {
        $this->items->add($item);
    }

    public function getNames(): array
    {
        return $this->items->pluck('name')->toArray();
    }

    public function getPrices(): array
    {
        return $this->items->pluck('price')->toArray();
    }

    public function getQuantities(): array
    {
        return $this->items->pluck('quantity')->toArray();
    }

    public function getTotal(): float
    {
        return $this->items->sum(function (Item $item)
        {
            return $item->price * $item->quantity;
        });
    }
}
