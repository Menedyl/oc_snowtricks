<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Figure;
use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use AppBundle\Form\CommentType;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    const NB_FIGURE_PER_PAGE = 8;
    const NB_COMMENT_PER_PAGE = 10;
    const MAX_NEWS = 5;

    /**
     * @Route("/figure/{id}/comment/{page}",
     *      name="comment",
     *      defaults={"page" : 1},
     *      requirements={"id" : "\d+", "page" : "\d+"}),
     *      options={"expose" = true}
     */
    public function commentAction(Request $request, Figure $figure, $page)
    {
        /** @var Comment $comment */
        $comment = new Comment();

        /** @var Form $formComment */
        $formComment = $this->createForm(CommentType::class, $comment);

        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {

            $this->get('app.comment')->add($comment, $figure, $this->getUser());
        }

        $listComments = $this->getDoctrine()->getRepository("AppBundle:Comment")
            ->findByFigureWithOrderByDateCreate($figure->getId(), $page, self::NB_COMMENT_PER_PAGE);

        $nbPages = ceil(count($listComments) / self::NB_COMMENT_PER_PAGE);

        return $this->render(":figure:comment.html.twig", array(
            'listComments' => $listComments,
            'nbPages' => $nbPages,
            'page' => $page,
            'formComment' => $formComment->createView()
        ));
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

    public function menuAction(){

        $em = $this->getDoctrine()->getManager();

        $groupsFigure = $em->getRepository("AppBundle:GroupFigure")->findAll();

        return $this->render("menu.html.twig", array(
            'groupsFigure' => $groupsFigure
        ));
    }
}
