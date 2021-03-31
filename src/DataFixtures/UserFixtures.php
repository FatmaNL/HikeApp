<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture    
{   

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
         $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        
        $user = new User();
        
        $user->setCin('15015411');
        $user->setEmail('test@gmail.com');
        $user->setNom('test');
        $user->setPrenom('test');
        $user->setAge(22);
        $user->setSexe('test');
        $user->setAdresse('test adresse');
        $user->setTel(52252525);
        $user->setPassword($this->encoder->encodePassword($user,'achref123'));
        
        $manager->persist($user);
        $manager->flush();
    }
}
