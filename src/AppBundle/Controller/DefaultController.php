<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Figure;
use AppBundle\Entity\Comment;
use AppBundle\Form\FigureType;
use AppBundle\Form\CommentType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    const NB_FIGURE_PER_PAGE = 8;
    const NB_MESSAGE_PER_PAGE = 10;
    const MAX_NEWS = 5;

    /**
     * @Route("/figure/{id}/comment/{page}", name="comment", defaults={"page" : 1}, requirements={"id" : "\d+", "page" : "\d+"})
     * @ParamConverter("figure")
     */
    public function messageAction(Request $request, Figure $figure, $page)
    {
        /** @var Comment $comment */
        $comment = new Comment();

        /** @var Form $formComment */
        $formComment = $this->createForm(CommentType::class, $comment);


        if ($request->isMethod('POST') && $formComment->handleRequest($request)->isValid()) {
            $figure->addComment($comment);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        $listComments = $this->getDoctrine()->getRepository("AppBundle:Comment")
            ->findByFigureWithOrderByDateCreate($figure->getId(), $page, self::NB_MESSAGE_PER_PAGE);

        $nbPages = ceil(count($listComments) / self::NB_MESSAGE_PER_PAGE);

        // if ($page > $nbPages) {
        //    throw new NotFoundHttpException("La page demandé n'existe pas.");
        // }

        return $this->render("comment.html.twig", array(
            'listComments' => $listComments,
            'nbPages' => $nbPages,
            'page' => $page,
            'formComment' => $formComment->createView()
        ));
    }

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
     * @Route("/home/{page}", name="home", defaults={"page" : 1}, requirements={"page" : "\d+"})
     */
    public function homeAction($page)
    {
        if ($page < 1) {
            throw new NotFoundHttpException("La page demandé n'existe pas.");
        }


        $listFigure = $this->getDoctrine()->getManager()
            ->getRepository("AppBundle:Figure")
            ->getForPagination($page, self::NB_FIGURE_PER_PAGE);

        $nbPages = ceil(count($listFigure) / self::NB_FIGURE_PER_PAGE);

        if ($page > $nbPages) {
            throw new NotFoundHttpException("La page demandé n'existe pas.");
        }


        return $this->render("home.html.twig", array(
            "figures" => $listFigure,
            "nbPages" => $nbPages,
            "page" => $page));
    }

    /**
     * @Route("/delete/{id}", name="delete_figure", requirements={"id" : "\d+"})
     * @ParamConverter("figure")
     */
    public function deleteAction(Figure $figure)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($figure);
        $em->flush();

        return $this->redirectToRoute("home");
    }

    public function newsAction()
    {

        $em = $this->getDoctrine()->getManager();

        $recentImages = $em->getRepository("AppBundle:Image")->findLast(self::MAX_NEWS);
        $recentVideos = $em->getRepository("AppBundle:Video")->findLast(self::MAX_NEWS);
        $recentComments = $em->getRepository("AppBundle:Comment")->findLast(self::MAX_NEWS);

        return $this->render("::news.html.twig", array(
            'recentImages' => $recentImages,
            'recentVideos' => $recentVideos,
            'recentComments' => $recentComments
        ));
    }
}
