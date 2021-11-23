<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Review;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $reviews = $this->getDoctrine()->getRepository(Review::class)->findAll();
        return $this->render('home/index.html.twig', [
            'title' => 'Reviews',
            'reviews' => $reviews,
        ]);
    }
}
