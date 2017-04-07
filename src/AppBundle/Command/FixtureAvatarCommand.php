<?php

namespace AppBundle\Command;


use AppBundle\Entity\Avatar;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixtureAvatarCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:create-fixture-avatar');
        $this->setDescription('Créer les avatars');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('app.avatar_manager')->add(new Avatar());

        $output->writeln('Ajout des avatars');

    }

}