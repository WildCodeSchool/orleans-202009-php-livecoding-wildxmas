<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Gift;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName($faker->word);
            $category->setUniverse($this->getReference('universe_'. rand(0,1)));
            $manager->persist($category);
            $this->setReference('category_' . $i, $category);
            $manager->persist($category);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UniverseFixtures::class,
        ];

    }
}
