<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:create-all-fixtures')
            ->setDescription('Créer un jeux de données complet');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->getApplication()->find('app:create-fixture-avatar')->run($input, $output);

        $this->getApplication()->find('app:create-fixture-user')->run($input, $output);

        $this->getApplication()->find('app:create-fixture-groupFigure')->run($input, $output);

        $this->getApplication()->find('app:create-fixture-image')->run($input, $output);

        $this->getApplication()->find('app:create-fixture-video')->run($input, $output);

        $this->getApplication()->find('app:create-fixture-figure')->run($input, $output);


    }
}