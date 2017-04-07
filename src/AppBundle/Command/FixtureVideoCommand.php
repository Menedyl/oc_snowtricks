<?php

namespace AppBundle\Command;


use AppBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class FixtureVideoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:create-fixture-video');
        $this->setDescription('Créer les videos');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $fixturesVideo = Yaml::parse(file_get_contents(__DIR__ . '/Fixtures/fixturesVideo.yml'));

        foreach ($fixturesVideo as $fixture){
            $video = new Video();

            $video->setHost($fixture['host']);
            $video->setIdentifier($fixture['identifier']);
            $video->setAlt($fixture['alt']);

            $this->getContainer()->get('app.video_manager')->add($video);
        }

        $output->writeln('Ajout des videos');

    }

}