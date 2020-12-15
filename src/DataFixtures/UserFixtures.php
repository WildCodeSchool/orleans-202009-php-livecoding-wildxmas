<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'azerty'));
            $user->setBirthdate($faker->dateTimeThisCentury);

            $manager->persist($user);
        }

        $user = new User();
        $user->setEmail('user@wildxmas.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'user'));
        $user->setBirthdate($faker->dateTimeThisCentury);
        $manager->persist($user);


        $manager->flush();
    }
}
