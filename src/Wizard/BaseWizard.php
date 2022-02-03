<?php

namespace Nikidze\Webpay\Wizard;

abstract class BaseWizard
{
    protected array $propertyRequired = [];

    /**
     * @throws \InvalidArgumentException
     */
    protected function check()
    {
        $missed = [];
        $calls = [];

        foreach ($this->propertyRequired as $property) {
            if (!isset($this->$property) || empty($this->$property)) {
                $missed[] = $property;
                $calls[] = 'set' . ucfirst($property) . '(...)';
            }
        }

        if ($missed) {
            throw new \InvalidArgumentException(
                'Some arguments missed: ' . implode(', ', $missed) .
                '. Check next methods are called: ' . PHP_EOL . PHP_EOL . implode(PHP_EOL, $calls)
            );
        }
    }
}