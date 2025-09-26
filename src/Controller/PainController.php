<?php

namespace App\Controller;

use App\Entity\Pain;
use App\Repository\PainRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PainController extends AbstractController
{
    #[Route('/pain', name: 'index')]
    public function index(PainRepository $painRepository): Response
    {
        $pain = $painRepository->findAll();
        return $this->render('pain/index.html.twig', [
            'pain' => $pain,
        ]);
    }

    #[Route('/pain/create', name: 'pain_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $pain = new Pain();
        $pain->setNom('Pain brioché');
    
        // Persister et sauvegarder le nouveau burger
        $entityManager->persist($pain);
        $entityManager->flush();
    
        return new Response('Pain créé avec succès !');
    }

    #[Route('/remove/{id}', name: 'pain_remove')]
    public function delete(EntityManager $entityManager, Pain $pain){
        $entityManager->remove($pain);
        $entityManager->flush();
    }

    #[Route('/update/{id}', name: 'pain_update')]
    public function update(EntityManagerInterface $entityManager, Pain $pain){
        $pain->setNom('Pain aux céréales');
        $entityManager->persist($pain);
        $entityManager->flush();

        return new Response('Pain modifié avec succès avec succès');
    }
}
