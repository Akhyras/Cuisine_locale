<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/admin/recipe', name: 'app_admin_recipe')]
    public function index(): Response
    {
        return $this->render('admin/recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }
}
