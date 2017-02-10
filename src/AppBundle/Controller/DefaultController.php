<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Figure;
use AppBundle\Form\FigureType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
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
         * @var Figure $figure
         */
        $figure = $em->getRepository("AppBundle:Figure")->findWithImages($id);

        if ($figure === null) {
            throw new NotFoundHttpException("La figure demandé n'existe pas.");
        }

        return $this->render('view.html.twig', array('figure' => $figure));
    }

    /**
     * @Route("/add", name="add_figure")
     */
    public function addAction(Request $request)
    {

        /**
         * @var Figure $figure
         */
        $figure = new Figure();

        /**
         * @var Form $form
         */
        $form = $this->createForm(FigureType::class, $figure);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            if (count($figure->getImages()) > 0) {
                foreach ($figure->getImages() as $image) {
                    $figure->addImage($image);
                }
            }

            if (count($figure->getVideos()) > 0){
                foreach ($figure->getVideos() as $video){
                    $figure->addVideo($video);
                }
            }


            $em = $this->getDoctrine()->getManager();
            $em->persist($figure);


            $em->flush();

            $this->addFlash('info', 'Figure enregistré avec succès');

            return $this->redirectToRoute("figure", array('id' => $figure->getId()));

        }

        return $this->render("add_figure.hmlt.twig", array("form" => $form->createView()));


    }
}
