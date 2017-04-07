<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Figure;
use AppBundle\Entity\GroupFigure;
use AppBundle\Form\FigureType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class FigureController extends Controller
{
    const NB_FIGURE_PER_PAGE = 8;


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

            $this->get('app.figure_manager')->add($figure, $this->getUser());

            $this->addFlash('info', 'Figure enregistré avec succès');

            return $this->redirectToRoute("home");
        }


        return $this->render("figure/form_add_figure.html.twig", array("form" => $addForm->createView()));
    }

    /**
     * @Route("/edit/{id}", name="edit_figure", requirements={"id" : "\d+"})
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Request $request, Figure $figure)
    {

        $ancientImages = $this->get('app.figure_manager')->oldSaveCollection($figure->getImages());
        $ancientVideos = $this->get('app.figure_manager')->oldSaveCollection($figure->getVideos());

        /** @var Form $form */
        $editForm = $this->createForm(FigureType::class, $figure);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->get('app.figure_manager')->edit($figure, $ancientImages, $ancientVideos);

            return $this->redirectToRoute("figure", array("id" => $figure->getId()));
        }

        return $this->render(":figure:form_edit_figure.html.twig", array("form" => $editForm->CreateView()));
    }

    /**
     * @Route("/delete/{id}", name="delete_figure", requirements={"id" : "\d+"})
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Figure $figure)
    {

        $this->get('app.figure_manager')->delete($figure);

        return $this->redirectToRoute("home");
    }

    /**
     * @Route("/group/{id}/{page}", name="group_figure", defaults={"page" : 1}, requirements={"id" : "\d+"})
     */
    public function figureByGroupFigureAction(GroupFigure $groupFigure, $page)
    {
        if ($page < 1) {
            throw new NotFoundHttpException("La page demandé n'existe pas.");
        }


        $figures = $this->getDoctrine()->getManager()->getRepository("AppBundle:Figure")
            ->findByGroupFigure($groupFigure, $page, self::NB_FIGURE_PER_PAGE);

        $nbPages = ceil(count($figures) / self::NB_FIGURE_PER_PAGE);

        if ($page > $nbPages) {
            throw new NotFoundHttpException("La page demandé n'existe pas.");
        }

        return $this->render("home.html.twig", array(
            'figures' => $figures,
            "nbPages" => $nbPages,
            "page" => $page
        ));

    }


}