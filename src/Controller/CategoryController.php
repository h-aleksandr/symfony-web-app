<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/category', requirements: ["_locale" => "en|ru"])]
class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    ) {
    }

    #[Route('/', name: 'categories')]
    public function index(): Response
    {
        $categories = $this->categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/{id}', name: 'category')]
    public function showCategory($id): Response
    {
        $category = $this->categoryRepository->find($id);
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

}