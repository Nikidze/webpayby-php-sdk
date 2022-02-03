<?php

namespace Nikidze\Webpay\Wizard;

use Nikidze\Webpay\Collection\ItemCollection;
use Nikidze\Webpay\Credential\AccountCredential;
use Nikidze\Webpay\Domain\Currency;
use Nikidze\Webpay\Domain\Customer;
use Nikidze\Webpay\Domain\Discount;
use Nikidze\Webpay\Domain\Language;
use Nikidze\Webpay\Domain\MerchantTypes;
use Nikidze\Webpay\Domain\Shipping;
use Nikidze\Webpay\Endpoint\InvoiceEndpoint;
use Nikidze\Webpay\Endpoint\InvoiceTestEndpoint;
use Nikidze\Webpay\Request\InvoiceRequest;

class InvoiceWizard extends BaseWizard
{

    protected AccountCredential $credential;

    protected string $order_number;

    protected string $currency = Currency::BYN;

    protected string $seed;

    protected bool $is_test = false;

    protected ItemCollection $items;

    protected float $total;

    protected string $store_title;

    protected string $language = Language::RU;

    protected string $return_url;

    protected string $failed_url;

    protected string $service_url;

    protected Customer $customer;

    protected string $service_date;

    protected float $tax = 0;

    protected Shipping $shipping;

    protected Discount $discount;

    protected string $order_tag;

    protected string $order_contract;

    protected string $tab = MerchantTypes::TAB_CARD;

    protected string $start_time;

    protected string $start_datetime;

    protected array $propertyRequired = [
        'order_number',
        'seed',
        'items',
    ];

    public function __construct(AccountCredential $credential)
    {
        $this->credential = $credential;
    }

    public static function get(AccountCredential $credential): self
    {
        return new self($credential);
    }

    public function setOrderNumber(string $order_number): self
    {
        $this->order_number = $order_number;
        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function setSeed(string $seed): self
    {
        $this->seed = $seed;
        return $this;
    }

    function setTest(bool $is_test): self
    {
        $this->is_test = $is_test;
        return $this;
    }

    public function setItems(ItemCollection $items): self
    {
        $this->items = $items;
        return $this;
    }

    public function setStoreTitle(string $title): self
    {
        $this->store_title = $title;
        return $this;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    public function setReturnUrl(string $url): self
    {
        $this->return_url = $url;;
        return $this;
    }

    public function setFailedUrl(string $url): self
    {
        $this->failed_url = $url;
        return $this;
    }

    public function setServiceUrl(string $url): self
    {
        $this->service_url = $url;
        return $this;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;
        return $this;
    }

    public function setServiceDate(string $service_date): self
    {
        $this->service_date = $service_date;
        return $this;
    }

    public function setTax(float $tax): self
    {
        $this->tax = $tax;
        return $this;
    }

    public function setShipping(Shipping $shipping): self
    {
        $this->shipping = $shipping;
        return $this;
    }

    public function setDiscount(Discount $discount): self
    {
        $this->discount = $discount;
        return $this;
    }

    public function setOrderTag(string $tag): self
    {
        $this->order_tag = $tag;
        return $this;
    }

    public function setTab(string $tab): self
    {
        $this->tab = $tab;
        return $this;
    }

    public function setStartTime(string $timestamp): self
    {
        $this->start_time = $timestamp;
        return $this;
    }

    public function setStartDateTime(string $datetime): self
    {
        $this->start_datetime = $datetime;
        return $this;
    }

    private function mathTotal()
    {
        $total = $this->items->getTotal() + $this->tax;
        if (isset($this->shipping)) {
            $total += $this->shipping->price;
        }
        if (isset($this->discount)) {
            $total -= $this->discount->price;
        }
        $this->total = $total;
    }

    private function mathSeed()
    {
        if (!isset($this->seed)) {
            $this->seed = (string)rand(100, 10000000);
        }
    }

    public function getRequest(): InvoiceRequest
    {
        $this->mathTotal();
        $this->mathSeed();

        $this->check();

        return (new InvoiceRequest($this->credential, $this->seed, [
            "wsb_order_num" => $this->order_number,
            "wsb_currency_id" => $this->currency,
            "wsb_test" => $this->is_test,
            "wsb_invoice_item_name" => $this->items->getNames(),
            "wsb_invoice_item_quantity" => $this->items->getQuantities(),
            "wsb_invoice_item_price" =>  $this->items->getPrices(),
            "wsb_total" => $this->total,
            "wsb_store" => $this->store_title ?? null,
            "wsb_language_id" => $this->language ?? null,
            "wsb_return_url" => $this->return_url ?? null,
            "wsb_cancel_return_url" => $this->failed_url ?? null,
            "wsb_notify_url" => $this->service_url ?? null,
            "wsb_customer_name" => isset($this->customer) ? $this->customer->getName() : null,
            "wsb_customer_address" => isset($this->customer) ? $this->customer->getAddress() : null,
            "wsb_service_date" => $this->service_date ?? null,
            "wsb_tax" => $this->tax ?? null,
            "wsb_shipping_name" => $this->shipping->name ?? null,
            "wsb_shipping_price" => $this->shipping->price ?? null,
            "wsb_discount_name" => $this->discount->name ?? null,
            "wsb_discount_price" => $this->discount->price ?? null,
            "wsb_order_tag" => $this->order_tag ?? null,
            "wsb_email" => isset($this->customer) ? $this->customer->getEmail() : null,
            "wsb_phone" => isset($this->customer) ? $this->customer->getPhone() : null,
            "wsb_order_contract" => $this->order_contract ?? null,
            "wsb_tab" => $this->tab ?? null,
            "wsb_startsesstime" => $this->start_time ?? null,
            "wsb_startsessdatetime" => $this->start_datetime ?? null,
        ]))->setEndpoint($this->is_test ? new InvoiceTestEndpoint : new InvoiceEndpoint);
    }
}
