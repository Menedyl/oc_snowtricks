<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Figure;
use AppBundle\Form\FigureType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/figure/{id}", name="figure")
     */
    public function viewAction($id)
    {

        $em = $this->getDoctrine();

        /**
         * @var Figure
         */
        $figure = $em->getRepository("AppBundle:Figure")->find($id);

        if ($figure === null){
            throw new NotFoundHttpException("La figure demandé n'existe pas.");
        }


        return $this->render('view.html.twig', array('figure' => $figure));
    }

    /**
     * @Route("/add", name="add_figure")
     */
    public function addAction(Request $request)
    {

        $figure = new Figure();

        $form = $this->createForm(FigureType::class, $figure);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($figure);
            $em->flush();

            $this->addFlash('info', 'Figure enregistré avec succès');

            return $this->redirectToRoute("figure", array('id' => $figure->getId()));

        }

        return $this->render("add_figure.hmlt.twig", array("form" => $form->createView()));


    }
}
