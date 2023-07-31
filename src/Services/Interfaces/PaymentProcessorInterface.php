<?php

namespace App\Services\Interfaces;

interface PaymentProcessorInterface
{
    public function process(int $price): bool;
}