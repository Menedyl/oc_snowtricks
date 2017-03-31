<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Figure;
use AppBundle\Entity\GroupFigure;
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
     */
    public function figureAction(Figure $figure)
    {
        return $this->render('figure/figure.html.twig', array(
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

        $addForm->handleRequest($request);

        if ($addForm->isSubmitted() && $addForm->isValid()) {

            $this->get('app.figure')->add($figure, $this->getUser());

            $this->addFlash('info', 'FigureManager enregistré avec succès');

            return $this->redirectToRoute("figure", array('id' => $figure->getId()));
        }


        return $this->render(":figure:form_figure.html.twig", array("form" => $addForm->createView()));
    }

    /**
     * @Route("/edit/{id}", name="edit_figure", requirements={"id" : "\d+"})
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Request $request, Figure $figure)
    {

        $ancientImages = $this->get('app.figure')->saveTemp($figure->getImages());
        $ancientVideos = $this->get('app.figure')->saveTemp($figure->getVideos());

        /** @var Form $form */
        $editForm = $this->createForm(FigureType::class, $figure);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->get('app.figure')->edit($figure, $ancientImages, $ancientVideos);

            return $this->redirectToRoute("figure", array("id" => $figure->getId()));
        }

        return $this->render(":figure:form_figure.html.twig", array("form" => $editForm->CreateView()));
    }

    /**
     * @Route("/delete/{id}", name="delete_figure", requirements={"id" : "\d+"})
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Figure $figure)
    {

        $this->get('app.figure')->delete($figure);

        return $this->redirectToRoute("home");
    }

    /**
     * @Route("/group/{id}", name="group_figure", requirements={"id" : "\d+"})
     */
    public function figureByGroupFigureAction(GroupFigure $groupFigure)
    {

        $figures = $this->getDoctrine()->getManager()->getRepository("AppBundle:Figure")->findByGroupFigure($groupFigure);

        return $this->render("home.html.twig", array(
            'figures' => $figures
        ));

    }


}