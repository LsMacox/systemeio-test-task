<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $names = ['Iphone', 'Earbuds', 'Holder'];
        $prices = [100, 20, 10];

        // Имя только на английском, в рамках тестового задания, не стал тратиться на работу с транслейтами
        for ($i = 0; $i <= 2; $i++) {
            $product = new Product();
            $product->setName($names[$i]);
            $product->setPrice($prices[$i]);
            $product->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($product);
        }

        $manager->flush();
    }
}
