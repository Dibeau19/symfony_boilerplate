<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CommentaireController extends AbstractController
{
    #[Route('/commentaire', name: 'index')]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = $commentaireRepository->findAll();
        return $this->render('commentaire/index.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/commentaire/create', name: 'commentaire_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $commentaire->setNom('A base de pater de crabe, quelle frappe !');
    
        // Persister et sauvegarder le nouveau burger
        $entityManager->persist($commentaire);
        $entityManager->flush();
    
        return new Response('Commentaire créé avec succès !');
    }

    #[Route('/remove/{id}', name: 'commentaire_remove')]
    public function delete(EntityManager $entityManager, Commentaire $commentaire){
        $entityManager->remove($commentaire);
        $entityManager->flush();
    }

    #[Route('/update/{id}', name: 'commentaire_update')]
    public function update(EntityManagerInterface $entityManager, Commentaire $commentaire){
        $commentaire->setNom('Nouveau commentaire');
        $entityManager->persist($commentaire);
        $entityManager->flush();

        return new Response('Commentaire modifié avec succès avec succès');
    }
}
