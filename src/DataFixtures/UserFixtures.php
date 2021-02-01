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
            $this->setReference('user_'.$i, $user);
            $manager->persist($user);
        }

        $user = new User();
        $user->setEmail('user@wildxmas.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'user'));
        $user->setBirthdate($faker->dateTimeThisCentury);
        $manager->persist($user);

        $elve = new User();
        $elve->setEmail('elve@wildxmas.com');
        $elve->setPassword($this->passwordEncoder->encodePassword($user, 'elve'));
        $elve->setBirthdate($faker->dateTimeThisCentury);
        $elve->setRoles(['ROLE_ELVE']);
        $manager->persist($elve);

        $santa = new User();
        $santa->setEmail('santa@wildxmas.com');
        $santa->setPassword($this->passwordEncoder->encodePassword($user, 'santa'));
        $santa->setBirthdate($faker->dateTimeThisCentury);
        $santa->setRoles(['ROLE_SANTA']);
        $manager->persist($santa);

        $manager->flush();
    }
}
