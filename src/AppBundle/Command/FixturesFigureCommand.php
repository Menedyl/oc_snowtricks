<?php

namespace AppBundle\Command;

use AppBundle\Entity\Figure;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class FixturesFigureCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:create-fixture-figure');
        $this->setDescription('Créer les figures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fixturesFigure = Yaml::parse(file_get_contents(__DIR__ . '/Fixtures/fixturesFigure.yml'));

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $nbImages = 1;

        foreach ($fixturesFigure as $fixture) {
            $figure = new Figure();

            $figure->setName($fixture['name']);
            $figure->setContent($fixture['content']);
            $figure->setRating($fixture['rating']);
            $figure->setGroupFigure(
                $em->getRepository('AppBundle:GroupFigure')->findOneBy(array('name' => $fixture['group_figure']))
            );
            $figure->addVideo(
                $em->getRepository('AppBundle:Video')->find(1));

            for ($i = 0; $i < 3; $i++) {

                $figure->addImage(
                    $em->getRepository('AppBundle:Image')
                        ->find($nbImages));

                $nbImages++;
            }

            $this->getContainer()->get('app.figure_manager')->add(
                $figure,
                $em->getRepository('AppBundle:User')->find(1));
        }

        $output->writeln('Ajout des figures');

    }


}