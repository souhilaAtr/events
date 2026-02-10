<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index( CategorieRepository $repo): Response
    {    $catgories = $repo->findAll();
    //  dd($catgories);
        return $this->render('categorie/index.html.twig', [
           
            "categories" => $catgories
          
        ]);
    }
    #[Route('/categorie/new', name: 'new_categorie')]
    public function new(Request $req, EntityManagerInterface $em){
        $cateogrie = new Categorie();
        $form = $this->createForm(CategorieType::class, $cateogrie);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $cateogrie->setCreatedAt(new \DateTimeImmutable());
            $em->persist($cateogrie);
            $em->flush();
            return $this->redirectToRoute('new_evenet');
        }
        return $this->render('Categorie/new.html.twig',[
            'form' =>$form->createView()
        ]);

    }
}
