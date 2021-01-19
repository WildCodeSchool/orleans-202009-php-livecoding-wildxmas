<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Gift;
use App\Entity\Universe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UniverseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $universe = new Universe();
        $universe->setName('enfant');
        $manager->persist($universe);
        $this->addReference('universe_0', $universe);

        $manager->persist($universe);

        $universe = new Universe();
        $universe->setName('adulte');
        $manager->persist($universe);
        $this->addReference('universe_1', $universe);

        $manager->persist($universe);

        $manager->flush();
    }
}
