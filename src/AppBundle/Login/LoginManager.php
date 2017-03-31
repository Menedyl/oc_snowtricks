<?php

namespace AppBundle\Login;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class LoginManager
{

    protected $em;
    protected $encoder;

    /**
     * LoginManager constructor.
     * @param EntityManager $em
     * @param UserPasswordEncoder $encoder
     */
    public function __construct(EntityManager $em, UserPasswordEncoder $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    /**
     * @param User $user
     */
    public function registration(User $user)
    {

        $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param User $user
     */
    public function account(User $user)
    {

        $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));

        $this->em->flush();
    }
}