<?php

namespace AppBundle\Command;


use AppBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class FixtureImageCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:create-fixture-image');
        $this->setDescription('Créer les images');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $fixturesImage = Yaml::parse(file_get_contents(__DIR__ . '/Fixtures/fixturesImage.yml'));

        $addImage = $this->getContainer()->get('app.image_manager');

        foreach ($fixturesImage as $fixture) {
            $image = new Image();

            $image->setUrl($fixture['url']);
            $image->setAlt($fixture['alt']);

            $addImage->add($image);
        }

        $output->writeln('Ajout des images');

    }

}
