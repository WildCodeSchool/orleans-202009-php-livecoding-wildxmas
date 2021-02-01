<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Gift;
use App\Entity\GiftList;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class GiftListFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 25; $i++) {
            $list = new GiftList();
            $list->setYear($faker->year);
            $list->setUser($this->getReference('user_'.rand(0,9)));
            $list->addGift($this->getReference('gift_'.rand(0,24)));
            $list->addGift($this->getReference('gift_'.rand(0,24)));
            $list->addGift($this->getReference('gift_'.rand(0,24)));
            $manager->persist($list);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            GiftFixtures::class,
        ];
    }
}
