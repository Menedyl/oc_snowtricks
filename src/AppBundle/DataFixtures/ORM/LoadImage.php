<?php
/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 01/02/2017
 * Time: 16:07
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Figure;
use AppBundle\Entity\Image;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadImage extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /**
         * @var Image $image1
         */
        $image1 = new Image();
        $image1->setUrl("https://i.ytimg.com/vi/73WMfG5Stqw/maxresdefault.jpg");
        $image1->setAlt("Pendule");
        $image1->setFigure($this->getReference('figure1'));

        /**
         * @var Image $image2
         */
        $image2 = new Image();
        $image2->setUrl("https://www.weareucpa.com/wp-content/uploads/2016/01/trajectoire-traversee-ski-snowboard-e1452771097618.jpg");
        $image2->setAlt("Traversée");

        /** @var Figure $figure2 */
        $figure2 = $this->getReference('figure2');
        $image2->setFigure($figure2);

        /**
         * @var Image $image3
         */
        $image3 = new Image();
        $image3->setUrl("http://static10.gestionaweb.cat/803/pwimg-1024/marc-pladebaqueira.jpg");
        $image3->setAlt("Virage de base");
        $image3->setFigure($this->getReference('figure3'));


        $manager->persist($image1);
        $manager->persist($image2);
        $manager->persist($image3);

        $manager->flush();



    }

    public function getOrder()
    {
        return 2;
    }

}