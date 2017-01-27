<?php

namespace Menedyl\SnowtricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function viewAction()
    {
        return $this->render('MenedylSnowtricksBundle:Figure:view.html.twig');
    }
}
