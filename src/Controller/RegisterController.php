<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/register/new', name: 'user_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {// Créer une nouvelle instance de Recipe
        $User = new User();

        // Créer un formulaire pour l'entité Recipe
        $form = $this->createForm(UserType::class, $User);
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
        
            // Enregistrer la recette dans la base de données
            $entityManager->persist($User);
            $entityManager->flush();

            // Rediriger après la création
            return $this->redirectToRoute('app_main'); // Change la route selon ton besoin
        }

        return $this->render('register/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
