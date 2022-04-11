<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article; 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Repository\ArticleRepository; 
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class Controller1Controller extends AbstractController
{
    #[Route('/controller1', name: 'controller1')]
    public function index(ManagerRegistry $doctrine, ArticleRepository $repo): Response
    {
        $articles=$repo->findBy([],['CreatedAt' => 'DESC']);
        Return $this->render('controller1/index.html.twig', ['controller_name' => 'BlogController','articles'=>$articles,]);
    }
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('controller1/home.html.twig', [
            'name' => 'fia2',
            'x' => 404,

        ]);
    }
    #[Route('/blog/new', name: 'blog_create')] public function create(Request $request, EntityManagerInterface $manager) { if($request->request->count()>0) { $article = new Article(); $article->setTitre($request->request->get('title')) ->setContenu($request->request->get('content')) ->setImage($request->request->get('image')) ->setCreatedAt(new \DateTimeImmutable()); $manager->persist($article); $manager->flush(); return $this->redirectToRoute('blog_show',['id'=>$article->getId()]); } return $this->render('controller1/create.html.twig'); }
    #[Route('/blog/newsy', name: 'blog_create_sy')] 
    public function create_sy(Request $request, EntityManagerInterface $manager) { 
        $article = new Article(); $form =$this->createFormBuilder($article) 
        ->add('titre',TextType::class,[ 'attr'=>['placeholder'=>'Titre de l\'article'] ]) 
        ->add('contenu',TextareaType::class,[ 'attr'=>['placeholder'=>'Contenu de l\'article'] ]) 
        ->add('image',TextType::class,[ 'attr'=>['placeholder'=>'Image de l\'article'] ])
        ->add('save',SubmitType::class,[
            'attr' => ['class' => 'save'] ])  
        ->getForm(); 
        $form->handleRequest($request); if($form->isSubmitted()&&$form->isValid()) { $article->setCreatedAt(new \DateTimeImmutable()); $manager->persist($article); $manager->flush(); return $this->redirectToRoute('blog_show',['id'=>$article->getId()]); }
        dump($article);
        return $this->render('controller1/createsy.html.twig',['formArticle'=>$form->createView()]); } 
    #[Route('/blog/{id}', name: 'blog_show')] public function show($id,ManagerRegistry $doctrine, ArticleRepository $repo) { $article = $repo->find($id); return $this->render('controller1/show.html.twig',['article'=>$article]); }
    #[Route('/blog/edit/{id}', name: 'blog_edit')] 
    public function edit(Request $request, EntityManagerInterface $manager,$id,ArticleRepository $repo) { 

        $article = new Article();
        $article = $repo->find($id);
         $form =$this->createFormBuilder($article) 
        ->add('titre',TextType::class,[ 'attr'=>['placeholder'=>'Titre de l\'article'] ]) 
        ->add('contenu',TextareaType::class,[ 'attr'=>['placeholder'=>'Contenu de l\'article'] ]) 
        ->add('image',TextType::class,[ 'attr'=>['placeholder'=>'Image de l\'article'] ])
        ->add('save',SubmitType::class,[
            'attr' => ['class' => 'save'] ])  
        ->getForm(); 
        $form->handleRequest($request); 
        if($form->isSubmitted()&&$form->isValid()) { 
            $manager->persist($article); 
            $manager->flush(); 
            return $this->redirectToRoute('blog_show',['id'=>$article->getId()]); }
            
        dump($article);
        return $this->render('controller1/edit.html.twig',['formArticle'=>$form->createView()]); }
}
