<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'app_evenement')]
    public function index(EvenementRepository $evenementRepository): Response
    { $events =$evenementRepository->findAll();
        return $this->render('evenement/index.html.twig', [
           "evenements" => $events,
        ]);
    }
    #[Route('/evenement/new', name:'new_evenet')]
    public function new(Request $request, EntityManagerInterface $entityManager){
        $evenement = new Evenement();
         $form = $this->createForm(EvenementType::class,$evenement);
         $form->handleRequest($request);
         if($form->isSubmitted()&& $form->isValid()){
            $evenement->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($evenement);
            $entityManager->flush();
            return $this->redirectToRoute('app_evenement');
                     }
                return $this->render('evenement/new.html.twig',[
                    'formevement' => $form
                                    ]);
    }
    #[Route('/evenement/{id}', name:'affiche_event')]
    public function show(Evenement $event){
      
            return $this->render('evenement/show.html.twig',[
                'evenement' => $event
            ]);
    }

    #[Route('/evenement/{id}/edit', name: 'edit_evenet')]
    public function edit(Request $request, EntityManagerInterface $entityManager, Evenement $evenement)
    {
        // $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($evenement);
            $entityManager->flush();
            return $this->redirectToRoute('app_evenement');
        }
        return $this->render('evenement/edit.html.twig', [
            'formevement' => $form
        ]);

       

    }


    #[Route('evenement/{id}/delete', name: 'delete_event')]
    public function delete(EntityManagerInterface $entityManager, Evenement $evenement)
    {
        $entityManager->remove($evenement);
        $entityManager->flush();
        return $this->redirectToRoute('app_evenement');
    }

}
