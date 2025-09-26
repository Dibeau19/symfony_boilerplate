<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Repository\BurgerRepository;
use App\Repository\CommentaireRepository;
use App\Repository\ImageRepository;
use App\Repository\OignonRepository;
use App\Repository\PainRepository;
use App\Repository\SauceRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/burger', name: 'burger_')]

final class BurgerController extends AbstractController
{
    
    #[Route('/', name: 'index')]

    public function index(BurgerRepository $burgerRepository): Response 
    {
        $burgers = $burgerRepository->findAll();
        return $this->render('burger/index.html.twig', [
            'burgers' => $burgers,
        ]);
    }
    
    #[Route('/vue/{id}', name: 'id')]

    public function show(int $id, Burger $burger): Response
    {
        return $this->render('burger/show.html.twig', parameters:[
            'burger' => $burger
        ]);
    }

    #[Route('/create', name: 'burger_create')]
    public function create(EntityManagerInterface $entityManager, PainRepository $painRepository, OignonRepository $oignonRepository, ImageRepository $imageRepository, SauceRepository $sauceRepository, CommentaireRepository $commentaireRepository): Response
    {
        $pain = $painRepository->find(1);
        $oignon = $oignonRepository->find(1);
        $image = $imageRepository->find(1);
        $commentaire = $commentaireRepository->find(1);
        $sauce = $sauceRepository->find(1);


        $burger = new Burger();
        $burger->setNom('Krabby Patty');
        $burger->setPrix(4.99);
        $burger->setPain($pain);
        $burger->setImage($image);
        $burger->addOignon($oignon);
        $burger->addSauce($sauce);
        
    
        // Persister et sauvegarder le nouveau burger
        $entityManager->persist($burger);
        $entityManager->flush();
    
        return new Response('Burger créé avec succès !');
    }

    #[Route('/remove/{id}', name: 'burger_remove')]
    public function delete(EntityManagerInterface $entityManager, Burger $burger){
        $entityManager->remove($burger);
        $entityManager->flush();

        return new Response('Burger suppimé avec succès');
    }

    #[Route('/update/{id}', name: 'burger_update')]
    public function update(EntityManagerInterface $entityManager, Burger $burger){
        $burger->setNom('Krabby Patty');
        $entityManager->persist($burger);
        $entityManager->flush();

        return new Response('Burger modifié avec succès avec succès');
    }
}
