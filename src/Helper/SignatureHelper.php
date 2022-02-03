<?php

namespace Nikidze\Webpay\Helper;

class SignatureHelper
{

    private const REQUEST_FIELDS = [
        'wsb_seed',
        'wsb_storeid',
        'wsb_order_num',
        'wsb_test',
        'wsb_currency_id',
        'wsb_total',
        'secret_key',
    ];

    private const RESPONSE_FIELDS = [
        'batch_timestamp',
        'currency_id',
        'amount',
        'payment_method',
        'order_id',
        'site_order_id',
        'transaction_id',
        'payment_type',
        'rrn',
        'secret_key',
    ];

    public const REQUEST = "request";
    public const RESPONSE = "response";

    /**
     * @throws \InvalidArgumentException
     */
    public static function mathSignature(array $fields, string $type): string
    {
        $missed = [];
        $signature = "";
        $signature_fileds = $type == self::REQUEST ? self::REQUEST_FIELDS : self::RESPONSE_FIELDS;
        foreach ($signature_fileds as $field) {
            if (!array_key_exists($field, $fields)) {
                $missed[] = $field;
                continue;
            }
            $signature .= $fields[$field];
        }
        if ($missed) {
            throw new \InvalidArgumentException(
                'Some arguments missed: ' . implode(', ', $missed)
            );
        }
        if ($type == self::REQUEST) {
            return sha1($signature);
        }
        return md5($signature);
    }

}
