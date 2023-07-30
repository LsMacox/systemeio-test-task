<?php

namespace App\Services\Interfaces;

use App\Dto\ProductPaymentDto;

interface CalculatorInterface
{
    public function calculate(ProductPaymentDto $dto, int $amount): int;
}