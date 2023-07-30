<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Entity\Enums\CouponDiscountTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class CouponFixtures extends Fixture
{
    private Generator $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = (new Factory())->create();

        for ($i = 0; $i < 10; $i++) {
            $discount_type = CouponDiscountTypeEnum::cases()[array_rand(CouponDiscountTypeEnum::cases())];
            $code = strtoupper($this->faker->randomLetter) . $this->faker->numberBetween(10, 100);

            $coupon = new Coupon();
            $coupon->setDiscountAmount($this->faker->numberBetween(10, 100));
            $coupon->setDiscountType($discount_type->value);
            $coupon->setCode($code);
            $coupon->setIsUsed(false);
            $coupon->setValidUntil((new \DateTime())->modify('+' . random_int(1, 5) . ' days'));

            $manager->persist($coupon);
        }

        $manager->flush();
    }
}