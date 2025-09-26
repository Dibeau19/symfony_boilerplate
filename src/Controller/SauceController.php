<?php

namespace App\Controller;

use App\Entity\Sauce;
use App\Repository\SauceRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SauceController extends AbstractController
{
    #[Route('/sauce', name: 'index')]
    public function index(SauceRepository $sauceRepository): Response
    {
        $sauce = $sauceRepository->findAll();
        return $this->render('sauce/index.html.twig', [
            'sauce' => $sauce,
        ]);
    }

    #[Route('/sauce/create', name: 'sauce_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $sauce = new Sauce();
        $sauce->setNom('Ketchup');
    
        // Persister et sauvegarder le nouveau burger
        $entityManager->persist($sauce);
        $entityManager->flush();
    
        return new Response('Sauce créé avec succès !');
    }

    #[Route('/remove/{id}', name: 'sauce_remove')]
    public function delete(EntityManager $entityManager, Sauce $sauce){
        $entityManager->remove($sauce);
        $entityManager->flush();
    }

    #[Route('/update/{id}', name: 'sauce_update')]
    public function update(EntityManagerInterface $entityManager, Sauce $sauce){
        $sauce->setNom('Mayo');
        $entityManager->persist($sauce);
        $entityManager->flush();

        return new Response('Sauce modifié avec succès avec succès');
    }
}
