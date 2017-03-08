<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Figure;
use AppBundle\Form\FigureType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    const NB_PER_PAGE = 8;
    const MAX_NEWS = 5;

    /** @Route("/figure/{id}", name="figure", requirements={"id" : "\d+"}) */
    public function viewAction($id)
    {

        $em = $this->getDoctrine();

        /** @var Figure $figure */
        $figure = $em->getRepository("AppBundle:Figure")->findWithAll($id);

        if (!$figure) {
            throw new NotFoundHttpException("La figure demandé n'existe pas.");
        }

        return $this->render('view.html.twig', array('figure' => $figure));
    }

    /** @Route("/add", name="add_figure") */
    public function addAction(Request $request)
    {

        /**
         * @var Figure $figure
         */
        $figure = new Figure();

        /**
         * @var Form $form
         */
        $addForm = $this->createForm(FigureType::class, $figure);

        if ($request->isMethod('POST') && $addForm->handleRequest($request)->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($figure);


            $em->flush();

            $this->addFlash('info', 'Figure enregistré avec succès');

            return $this->redirectToRoute("figure", array('id' => $figure->getId()));

        }

        return $this->render("add_figure.html.twig", array(
            "form" => $addForm->createView()
        ));

    }

    /** @Route("/edit/{id}", name="edit_figure", requirements={"id" : "\d+"}) */
    public function editAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();


        /** @var Figure $figure */
        $figure = $em->getRepository("AppBundle:Figure")->findWithAll($id);


        if (!$figure) {
            throw new NotFoundHttpException("La figure demandé n'existe pas");
        }

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


        return $this->render("edit_figure.html.twig", array(
            "form" => $editForm->CreateView()
        ));


    }

    /** @Route("/home/{page}", name="home", defaults={"page" : 1}, requirements={"page" : "\d+"}) */
    public function homeAction($page)
    {
        if ($page < 1) {
            throw new NotFoundHttpException("La page demandé n'existe pas.");
        }


        $listFigure = $this->getDoctrine()->getEntityManager()
            ->getRepository("AppBundle:Figure")
            ->getForPagination($page, self::NB_PER_PAGE);

        $nbPages = ceil(count($listFigure) / self::NB_PER_PAGE);

        if ($page > $nbPages) {
            throw new NotFoundHttpException("La page demandé n'existe pas.");
        }


        return $this->render("home.html.twig", array(
            "figures" => $listFigure,
            "nbPages" => $nbPages,
            "page" => $page));
    }

    /** @Route("/delete/{id}", name="delete_figure", requirements={"id" : "\d+"}) */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getEntityManager();

        $figure = $em->getRepository("AppBundle:Figure")->findWithAll($id);

        if (!$figure) {
            throw new NotFoundHttpException("La figure demandé n'existe pas");
        }

        $em->remove($figure);
        $em->flush();

        return $this->redirectToRoute("home");
    }

    public function newsAction(){

        $em = $this->getDoctrine()->getEntityManager();

        $recentImages = $em->getRepository("AppBundle:Image")->getForNews(self::MAX_NEWS);
        $recentVideos = $em->getRepository("AppBundle:Video")->getForNews(self::MAX_NEWS);

        return $this->render("::news.html.twig", array(
            'recentImages' => $recentImages,
            'recentVideos' => $recentVideos
        ));

    }
}
