<?php

namespace App\Services\ProductPriceCalculators;

use App\Dto\ProductPaymentDto;
use App\Repository\CountryTaxInfoRepository;
use App\Services\Interfaces\CalculatorInterface;

class TaxCalculator implements CalculatorInterface
{
    public function __construct(
        protected readonly CountryTaxInfoRepository $country_tax_info_repository,
    ) {}

    public function calculate(ProductPaymentDto $dto, int $amount): int
    {
        $countries_tax_info = $this->country_tax_info_repository->findAll();
        $tax_info = null;

        foreach ($countries_tax_info as $country_tax_info) {
            if (preg_match($country_tax_info->getFormatRegex(), $dto->getTaxNumber())) {
                $tax_info = $country_tax_info;
                break;
            }
        }
        if ($tax_info && $amount > $tax_info->getAmountThreshold()) {
            return $amount - ($amount * ($tax_info->getRatePercent() / 100));
        }

        return $amount;
    }
}