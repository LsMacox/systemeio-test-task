<?php

namespace App\Services\ProductPriceCalculators;

use App\Dto\ProductPaymentDto;
use App\Entity\Enums\CouponDiscountTypeEnum;
use App\Repository\CouponRepository;
use App\Services\Interfaces\CalculatorInterface;

class CouponCalculator implements CalculatorInterface
{
    public function __construct(
        protected readonly CouponRepository $coupon_repository,
    ) {}

    public function calculate(ProductPaymentDto $dto, int $amount): int
    {
        /* Скорее всего был более элегантный способ */
        if (property_exists($dto, 'couponCode')) {
            $coupon = $this->coupon_repository->findOneBy(['code' => $dto->getCouponCode()]);

            if ($coupon) {
                switch ($coupon->getDiscountType()) {
                    case CouponDiscountTypeEnum::FIX:
                        $amount = $amount - $coupon->getDiscountAmount();
                        break;
                    case CouponDiscountTypeEnum::PERCENT:
                        $amount = $amount - ($amount * ($coupon->getDiscountAmount() / 100));
                        break;
                }
            }
        }

        return $amount;
    }
}