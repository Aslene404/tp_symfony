<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController implements UserInterface
{
    #[Route('/security', name: 'app_security')]
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
    #[Route('/inscription', name: 'security_registration')] 
    public function registration(Request $request,EntityManagerInterface $manager,UserPasswordHasherInterface $passwordHasher) { 
        $user = new User(); 
        $form=$this->createForm(UserType::class, $user); 
        $form->handleRequest($request); 
        if($form->IsSubmitted() && $form->IsValid() ) {
             $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $manager->persist($user); $manager->flush();
            return $this->redirectToRoute('login_user'); }
             
        return $this->render('security/registration.html.twig', ['form'=>$form->createView()]); }
        #[Route('/login', name : 'login_user')] 
        public function login(Request $request, UserInterface $user) { 
            return $this->render('security/login.html.twig',['user'=>$user->getUsername()]); }
}
