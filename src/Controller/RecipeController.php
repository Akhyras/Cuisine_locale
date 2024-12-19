<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class RecipeController extends AbstractController
{
    #[Route('/recipe/new', name: 'recipe_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, LoggerInterface $logger): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                
                // $user = $this->getUser();
                // if ($user instanceof \App\Entity\User) {
                //    $logger->info('User associated with recipe');
                    // $recipe->setOwner($user);
                // }

                $entityManager->persist($recipe);
                $entityManager->flush();

                return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
            } else {
                foreach ($form->getErrors(true) as $error) {
                    $logger->error('Form error: ' . $error->getMessage(), [
                        'field' => $error->getOrigin()->getName(),
                        'class' => get_class($error->getOrigin()->getParent()->getData())
                    ]);
                }
            }
        } else {
            $logger->info('Form is not submitted');
        }

        return $this->render('recipe/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
