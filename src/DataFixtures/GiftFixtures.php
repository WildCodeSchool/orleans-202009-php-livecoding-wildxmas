<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Gift;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class GiftFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $gift = new Gift();
            $gift->setName($faker->word);
            $gift->setUrl('https://via.placeholder.com/300');
            $gift->setDescription($faker->text);

            $gift->setCategory($this->getReference('category_' . rand(0, 9)));

            $manager->persist($gift);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
