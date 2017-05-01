<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends Controller
{
    /**
     * @Route("/signup", name="signup")
     */
    public function createAction(Request $request)
    {
        /** @var User $user */
        $user = new User();

        $formUser = $this->createForm(UserType::class, $user);

        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) {

            $this->get('app.user_manager')->create($user);

            $this->addFlash('info', 'Inscription réussit');

            return $this->redirectToRoute("home");
        }

        return $this->render(":login:signup.html.twig", array(
            'formUser' => $formUser->createView()
        ));
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(':login:login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error
        ));
    }

    /**
     * @Route("/logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/account", name="account")
     */
    public function editAction(Request $request)
    {

        /** @var User $user */
        $user = $this->getUser();

        $formUser = $this->createForm(UserType::class, $user);

        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) {

            $this->get('app.user_manager')->edit($user);

            $this->addFlash('info', 'Modification du compte validé');

            $this->redirectToRoute("account");
        }

        return $this->render(":login:account.html.twig", array(
            'user' => $user,
            'formUser' => $formUser->createView()
        ));
    }
}
