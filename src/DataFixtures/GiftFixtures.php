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

        for ($i = 0; $i < 25; $i++) {
            $gift = new Gift();
            $name = $faker->word;
            $gift->setName($name);
            $gift->setMetaphone(metaphone($name));

            // recup l'image, la copier dans uploads/gifts et stocker son nom en bdd
            $image = 'https://loremflickr.com/320/240/gift';
            $path = uniqid() . '.jpg';
            copy($image, __DIR__ . '/../../public/uploads/gifts/' . $path);
            $gift->setPath($path);
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
