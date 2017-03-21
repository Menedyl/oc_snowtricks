<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Figure;
use AppBundle\Form\FigureType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class FigureController extends Controller
{
    /**
     * @Route("/figure/{id}", name="figure", requirements={"id" : "\d+"})
     * @ParamConverter("figure")
     */
    public function figureAction(Figure $figure)
    {
        return $this->render('figure.html.twig', array(
            'figure' => $figure
        ));
    }

    /**
     * @Route("/add", name="add_figure")
     * @Security("has_role('ROLE_USER')")
     */
    public function addAction(Request $request)
    {
        /** @var Figure $figure */
        $figure = new Figure();

        /** @var Form $form */
        $addForm = $this->createForm(FigureType::class, $figure);

        if ($request->isMethod('POST') && $addForm->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($figure);
            $em->flush();
            $this->addFlash('info', 'Figure enregistré avec succès');

            return $this->redirectToRoute("figure", array('id' => $figure->getId()));
        }


        return $this->render("add_figure.html.twig", array("form" => $addForm->createView()));
    }

    /**
     * @Route("/edit/{id}", name="edit_figure", requirements={"id" : "\d+"})
     * @ParamConverter("figure")
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Request $request, Figure $figure)
    {

        $em = $this->getDoctrine()->getManager();

        $originalImages = new ArrayCollection();

        foreach ($figure->getImages() as $image) {
            $originalImages->add($image);
        }

        $originalVideos = new ArrayCollection();

        foreach ($figure->getVideos() as $video) {
            $originalVideos->add($video);
        }

        /** @var Form $form */
        $editForm = $this->createForm(FigureType::class, $figure);

        if ($request->isMethod("POST") && $editForm->handleRequest($request)->isValid()) {

            foreach ($originalImages as $image) {
                if (!$figure->getImages()->contains($image)) {
                    $em->remove($image);
                }
            }

            foreach ($originalVideos as $video) {
                if (!$figure->getVideos()->contains($video)) {
                    $em->remove($video);
                }
            }

            $em->persist($figure);
            $em->flush();

            return $this->redirectToRoute("figure", array("id" => $figure->getId()));
        }

        return $this->render("edit_figure.html.twig", array("form" => $editForm->CreateView()));
    }

    /**
     * @Route("/delete/{id}", name="delete_figure", requirements={"id" : "\d+"})
     * @ParamConverter("figure")
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Figure $figure)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($figure);
        $em->flush();

        return $this->redirectToRoute("home");
    }


}