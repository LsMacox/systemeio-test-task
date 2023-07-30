<?php

namespace App\Services\PaymentProcessor;

interface PaymentProcessorInterface
{
    public function process(int $price): bool;
}