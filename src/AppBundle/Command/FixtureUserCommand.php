<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class FixtureUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:create-fixture-user')
            ->setDescription('Créer les données utilisateurs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fixturesUser = Yaml::parse(file_get_contents(__DIR__ . '/Fixtures/fixturesUser.yml'));
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        foreach ($fixturesUser as $fixture) {
            $user = new User();

            $user->setUsername($fixture['username']);
            $user->setPassword($fixture['password']);
            $user->setEmail($fixture['email']);
            $user->setAvatar($em->getRepository('AppBundle:Avatar')->find(1));

            $this->getContainer()->get('app.user_manager')->create($user);
        }

        $output->writeln('Ajout des utilisateurs');
    }
}