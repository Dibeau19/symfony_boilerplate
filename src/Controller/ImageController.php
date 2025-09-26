<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ImageController extends AbstractController
{
    #[Route('/image', name: 'index')]
    public function index(ImageRepository $imageRepository): Response
    {
        $image = $imageRepository->findAll();
        return $this->render('image/index.html.twig', [
            'image' => $image,
        ]);
    }

    #[Route('/image/create', name: 'image_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $image = new Image();
        $image->setNom('Image 1');

    
        // Persister et sauvegarder le nouveau burger
        $entityManager->persist($image);
        $entityManager->flush();
    
        return new Response('Image créé avec succès !');
    }

    #[Route('/remove/{id}', name: 'image_remove')]
    public function delete(EntityManager $entityManager, Image $image){
        $entityManager->remove($image);
        $entityManager->flush();
    }

    #[Route('/update/{id}', name: 'commentaire_update')]
    public function update(EntityManagerInterface $entityManager, Image $image){
        $image->setNom('Nouvelle image');
        $entityManager->persist($image);
        $entityManager->flush();

        return new Response('Commentaire modifié avec succès avec succès');
    }
}
