<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Figure;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 01/02/2017
 * Time: 13:34
 */
class LoadFigure extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $figure1 = new Figure();
        $figure1->setName("Pendule");
        $figure1->setContent("La technique de la feuille morte est une alternative au virage, plus sécurisante pour les débutants, ou sur
             les pistes vraiment difficiles. Il s'agit de rester en appui sur un côté de la planche, et de porter son 
             poids alternativement sur un pied puis sur l'autre. Cela permet de descendre doucement la piste en dérapant
              vers la gauche, puis vers la droite, et ainsi de suite. La trajectoire ressemble ainsi à celle d'une 
              feuille morte qui tombe.");
        $figure1->setRating(2);
        $figure1->setGroupFigure("Groupe 1");


        $figure2 = new Figure();
        $figure2->setName("Traversée");
        $figure2->setContent("Comme en ski, il s'agit d'un déplacement du snowboarder et de sa planche dans une 
              direction transversale à l'inclinaison de la pente. Contrairement au ski il existe deux types de traversées 
               selon que l'on soit en appui frontside ou backside. On les appelle simplement « traversée frontside » ou « 
               traversée backside ».");
        $figure2->setRating(1);
        $figure2->setGroupFigure("Groupe 2");


        $figure3 = new Figure();
        $figure3->setName("Virage de base");
        $figure3->setContent("Il s'agit simplement d'un pivotement de la planche en dérapant sur la neige d'une position en appui sur un
             côté de la planche à l'autre. Au cours du virage, l'appui se fera sur le côté de la planche intérieur au 
             virage. Il est donc nécessairement accompagné d'une inclinaison plus ou moins forte du snowboarder vers ce 
             côté. La position du snowboarder n'étant pas de face sur la planche, les virages simples sont asymétriques,
              c’est-à-dire que le virage de base à gauche est différent du virage de base à droite. L'un des deux sera 
              dit « virage frontside », il se fera en position frontside (en appui orteils), l'autre sera dit virage 
              backside, il se fera en position backside (en appui talons). On ne peut pas faire de rapport direct avec 
              la gauche et la droite car cela change selon la position que l'on a sur la planche. Par exemple, un virage
               de base frontside se fera à droite pour un regular alors qu'il se fera à gauche pour un goofy. Il existe 
               de nombreuses techniques de virages. Le virage de base, lui-même, varie d'une école à une autre. Nous ne 
               détaillerons donc pas la technique du virage de base dans cette section. Dans tous les cas les deux 
               virages de bases se faisant avec des appuis différents, il est courant de constater chez le snowboarder 
               un fort décalage entre sa maîtrise technique des deux virages.");
        $figure3->setRating(1);
        $figure3->setGroupFigure("Groupe 3");


        $manager->persist($figure1);
        $manager->persist($figure2);
        $manager->persist($figure3);


        $manager->flush();

        $this->addReference('figure1', $figure1);
        $this->addReference('figure2', $figure2);
        $this->addReference('figure3', $figure3);

    }

    public function getOrder()
    {
        return 1;
    }

}