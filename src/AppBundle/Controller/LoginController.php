<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class LoginController extends Controller
{
    /**
     * @Route("/signup", name="signup")
     */
    public function signupAction(Request $request)
    {
        /** @var User $user */
        $user = new User();

        $formUser = $this->createForm(UserType::class, $user, array(
            'attr' => array('id' => 'form_signup'),
        ));

        if ($request->IsMethod("POST") && $formUser->handleRequest($request)->isValid()) {
            $encoder = $this->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

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

}