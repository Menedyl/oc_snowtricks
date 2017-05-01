<?php

namespace AppBundle\Services;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $encoder;

    /**
     * UserManager constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    /**
     * @param User $user
     */
    public function create(User $user)
    {

        $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param User $user
     */
    public function edit(User $user)
    {

        $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));

        $this->em->flush();
    }
}
