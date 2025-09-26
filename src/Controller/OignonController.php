<?php

namespace App\Controller;

use App\Entity\Oignon;
use App\Repository\OignonRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OignonController extends AbstractController
{
    #[Route('/oignon', name: 'index')]
    public function index(OignonRepository $oignonRepository): Response
    {
        $oignon = $oignonRepository->findAll();
        return $this->render('oignon/index.html.twig', [
            'oignon' => $oignon,
        ]);
    }

    #[Route('/oignon/create', name: 'oignon_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $oignon = new Oignon();
        $oignon->setNom('Oignon rouge');
    
        // Persister et sauvegarder le nouveau burger
        $entityManager->persist($oignon);
        $entityManager->flush();
    
        return new Response('Oignon créé avec succès !');
    }

    #[Route('/remove/{id}', name: 'oignon_remove')]
    public function delete(EntityManager $entityManager, Oignon $oignon){
        $entityManager->remove($oignon);
        $entityManager->flush();
    }

    #[Route('/update/{id}', name: 'oignon_update')]
    public function update(EntityManagerInterface $entityManager, Oignon $oignon){
        $oignon->setNom('Oignon caramélisé');
        $entityManager->persist($oignon);
        $entityManager->flush();

        return new Response('Oignon modifié avec succès avec succès');
    }
}
