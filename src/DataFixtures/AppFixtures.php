<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder= $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($u=0;$u<10;$u++)
        {
            $user = new  User();
            $passHash =$this->encoder->encodePassword($user, 'password');
            $user->setEmail($faker->email)
                 ->setPassword($passHash);
            $manager->persist($user);
            for ($j=0;$j<random_int(5,15);$j++)
            {
                $article =(new Article())->setAuthor($user)
                        ->setContent($faker->text(300))
                        ->setName($faker->firstName);
                $manager->persist($article);

            }
        }
        $manager->flush();
    }
}
