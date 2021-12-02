<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReviewRepository;

class ReviewController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private ReviewRepository $reviewRepository,
    ) {
    }

    #[Route('review/', name: 'review_index')]
    public function index(): Response
    {
        $reviews = $this->getDoctrine()->getRepository(Review::class)->findBy([], ['create_at' => 'DESC']);
        return $this->render('review/index.html.twig', [
            'title' => 'Reviews',
            'reviews' => $reviews,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('review/{id}', name: 'review')]
    public function showReview($id): Response
    {
        $review = $this->reviewRepository->find($id);
        $comments = $review->getComments();
        return $this->render('review/show.html.twig', [
            'review' => $review,
            'comments' => $comments,
        ]);
    }

    #[Route('user/review/create', name: 'review_create', methods: ['GET','POST'])]
    public function createReview(Request $request,): Response
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $review
                ->setUser($this->getUser())
                ->setCreateAt(new \DateTimeImmutable())
            ;
            $this->em->persist($review);
            $this->em->flush();
            return $this->redirectToRoute('user_reviews');
        }
        return $this->render('user/review/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('user/update/{id}', name: 'review_update')]
    public function updateReview(Request $request, $id,): Response
    {
        $review = $this->reviewRepository->find($id);
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setUpdateAt(new \DateTimeImmutable);
            $this->em->flush();

            return $this->redirectToRoute('show_user_review', ['id' => $review->getId()]);
        }
        return $this->render('user/review/edit_form.html.twig', [
            'form' => $form->createView(),
            'review' => $review,
        ]);
    }

    #[Route('user/delete/{id}', name: 'review_delete')]
    public function deleteReview($id): Response
    {
        $review = $this->reviewRepository->find($id);
        $this->em->remove($review);
        $this->em->flush();

            return $this->redirectToRoute('user_reviews', );
    }
}
