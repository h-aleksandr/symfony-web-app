<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Review;
use App\Entity\User;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private ReviewRepository $reviewRepository,
    ) {
    }

    #[Route('/user', name: 'user')]

    public function index(): Response
    {
        return $this->render('user/index.html.twig',);

    }

    #[Route('/user/reviews', name: 'user_reviews')]

    public function showReviews(): Response
    {
        $reviews = $this->reviewRepository->createQueryBuilder('r')
            ->where('r.user = :user_id')
            ->setParameter('user_id', $this->getUser())
            ->orderBy('r.create_at', 'DESC')
            ->getQuery()
            ->getResult()
        ;
        return $this->render('user/review/user_reviews.html.twig', [
            'reviews' => $reviews,
        ]);
    }

    #[Route('user/review/{id}', name: 'show_user_review')]
    public function showUserReview($id): Response
    {
        $review = $this->reviewRepository->find($id);
        return $this->render('user/review/show_user_review.html.twig', [
            'review' => $review,
        ]);
    }
}
