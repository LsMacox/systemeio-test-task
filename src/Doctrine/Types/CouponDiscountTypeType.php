<?php

namespace App\Doctrine\Types;

use App\Entity\Enums\CouponDiscountTypeEnum;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class CouponDiscountTypeType extends IntegerType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value !== null ? CouponDiscountTypeEnum::from($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof CouponDiscountTypeEnum ? $value->value : $value;
    }

    public function getName(): string
    {
        return 'coupon_discount_type';
    }
}
