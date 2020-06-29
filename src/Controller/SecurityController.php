<?php

namespace App\Controller;

use App\Entity\EtapeCircuit;
use App\Entity\User;
use App\Form\EtapeCircuitType;
use App\Form\RegistrationType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {   $manager = $this->getDoctrine()->getManager();
        $lasetusername=$authenticationUtils->getLastUsername();
        $error=$authenticationUtils->getLastAuthenticationError();
        return $this->render('security/login.html.twig',['lastUser'=>$lasetusername,'error'=>$error]);

    }

    /**
     * @Route("/logout", name="deconnexion")
     */
    public function log()
    {

    }

    /**
     * @Route("/register", name="registerSecurity")
     */
    public function register(\Symfony\Component\HttpFoundation\Request $request,UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $user= new User();
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password=$userPasswordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('login');
        }
        return $this->render('security/registration.html.twig', ['form' => $form->createView()]);
    }
}
