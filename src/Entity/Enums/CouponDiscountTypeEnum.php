<?php

namespace App\Entity\Enums;

enum CouponDiscountTypeEnum: int
{
    case FIX = 1;
    case PERCENT = 2;
}
