<?php

namespace AppBundle\Command;

use AppBundle\Entity\GroupFigure;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class FixtureGroupFigureCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:create-fixture-groupFigure')
            ->setDescription('Créer les groupes de figure');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fixturesGroupFigure = Yaml::parse(file_get_contents(__DIR__ . '/Fixtures/fixturesGroupFigure.yml'));

        $addGroupFigure = $this->getContainer()->get('app.groupfigure_manager');

        foreach($fixturesGroupFigure as $fixture){
            $groupFigure = new GroupFigure();

            $groupFigure->setName($fixture['name']);

            $addGroupFigure->add($groupFigure);
        }

        $output->writeln('Ajout des groupes de figure');
    }
}
