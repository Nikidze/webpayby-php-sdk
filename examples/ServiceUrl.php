<?php

use Nikidze\Webpay\Credential\AccountCredential;
use Nikidze\Webpay\Handler\ServiceUrlHandler;

require_once __DIR__ . '/../vendor/autoload.php';

$credentials = new AccountCredential("login", "secret");

try {
    
    $handler = new ServiceUrlHandler($credentials);
    $data = $_POST;
    $response = $handler->parseRequestFromObject((object)$data);

    http_response_code(200);
} catch (\InvalidArgumentException $e) {
    echo "Invalid argument exception: " . $e->getMessage();
}