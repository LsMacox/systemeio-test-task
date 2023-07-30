<?php

namespace App\Services\ProductPriceCalculators;

use App\Dto\ProductPaymentDto;
use App\Services\Interfaces\CalculatorInterface;

class Calculator implements CalculatorInterface
{
    protected array $calculators = [];

    public function calculate(ProductPaymentDto $dto, int $amount): int {
        /** @var CalculatorInterface $calculator */
        foreach ($this->calculators as $calculator) {
            $amount = $calculator->calculate($dto, $amount);
        }

        return $amount;
    }

    public function setCalculator(CalculatorInterface $calculator): void
    {
        $this->calculators[] = $calculator;
    }

    public function setCalculators(array $calculators): void
    {
        /** @var Calculator $calculator */
        foreach ($calculators as $calculator) {
            $this->setCalculator($calculator);
        }
    }
}