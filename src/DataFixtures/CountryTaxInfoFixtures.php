<?php

namespace App\DataFixtures;

use App\Entity\CountryTaxInfo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class CountryTaxInfoFixtures extends Fixture
{
    private Generator $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = (new Factory())->create();

        $formats = ['DEXXXXXXXXX', 'ITXXXXXXXXXXX', 'GRXXXXXXXXX', 'FRYYXXXXXXXXX'];
        $rate_percents = [19, 22, 20, 24];
        $amount_thresholds = [50, 100, 200, 5];

        for ($i = 0; $i <= 3; $i++) {
            $country_tax_info = new CountryTaxInfo();
            $country_tax_info->setCountryName($this->faker->country);
            $country_tax_info->setCountryCode($this->faker->countryCode);
            $country_tax_info->setFormat($formats[$i]);
            $country_tax_info->setRatePercent($rate_percents[$i]);
            $country_tax_info->setAmountThreshold($amount_thresholds[$i]);

            $manager->persist($country_tax_info);
        }

        $manager->flush();
    }
}