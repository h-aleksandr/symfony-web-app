<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]

    public function new(): Response
    {
//        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $reviews = $this->getDoctrine()->getRepository(Review::class)->findAll();

//        $review = new Review();
//        $comment = new Comment();
//        $comment->setText('akljf;lja;fja;fja;jf;j');
//        $review->addComment($comment);
//
//        $this->em->persist($review);
//        $this->em->persist($comment);
//        $this->em->flush();

        return $this->render('user/index.html.twig', [
//            'users' => $users,
            'reviews' => $reviews,

        ]);

    }

    #[Route('/user{id}', name: 'userId')]
    public function index(int $id): Response
    {
        $review = $this->em->find(Review::class, 1);

        if (!$comment) {
            throw $this->NotFoundHttpException('aljfldjf;alj;f');
        }
        foreach ($comment->getComments() as $comment) {
            dump($comment);
        }

        return $this->render('user/index.html.twig', [
            'review' => $review,
        ]);
    }
}
