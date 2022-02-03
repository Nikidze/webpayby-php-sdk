<?php

use Nikidze\Webpay\Collection\ItemCollection;
use Nikidze\Webpay\Credential\AccountCredential;
use Nikidze\Webpay\Domain\Customer;
use Nikidze\Webpay\Domain\Discount;
use Nikidze\Webpay\Domain\Item;
use Nikidze\Webpay\Domain\Shipping;
use Nikidze\Webpay\Wizard\InvoiceWizard;

require_once __DIR__ . '/../vendor/autoload.php';

$itemCollection = new ItemCollection([
    new Item("Куртка", 10, 2),
    new Item("Шапка", 10, 1),
    new Item("Сапоги", 10, 5)
]);

$discount = new Discount("Скидка постоянному покупателю", 12);
$shipping = new Shipping("Доставка до Кукуево", 1000);

$customer = new Customer(
    "Сидоров Никита Сергеевич",
    '',
    'nikidze-backend@ya.ru',
    ''
);

$credentials = new AccountCredential("login", "secret");

$redirectUrl = InvoiceWizard::get($credentials)
    ->setItems($itemCollection)
    ->setOrderNumber("ORDER-14")
    ->setTax(5.2)
    ->setTest(true)
    ->setStoreTitle("Самый лучший магазин")
    ->setDiscount($discount)
    ->setShipping($shipping)
    ->setCustomer($customer)
    ->getRequest()
    ->send()
    ->getRedirectUrl();

echo $redirectUrl;
