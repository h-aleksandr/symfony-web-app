<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\User;
use App\Form\ReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    #[Route('/review/create', name: 'create_review')]
    public function index(Request $request): Response
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

//        $user = new User();
//        $userId = $user->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $review
                ->setTitle($review->getTitle())
                ->setText($review->getText())
                ->setAssessment($review->getAssessment())
                ->setCreatedAt(new \DateTime())
//                ->setUserId($review->getUserId())
//                ->setUser($userId)
            ;

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('user');
        }


        return $this->render('review/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
