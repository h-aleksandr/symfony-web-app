<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Review;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/comment')]
class CommentController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private CommentRepository $commentRepository,
    ) {
    }

    #[Route('/', name: 'comment_index', methods: ['GET'])]
    public function index(): Response
    {
        $comments = $this->commentRepository->findBy(['user' => $this->getUser()], ['create_at' => 'DESC'],);
        return $this->render('user/comment/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/new/{id}', name: 'comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Review $review): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('comment_new', [
                'id' => $review->getId()
            ]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment
                ->setReview($review)
                ->setUser($this->getUser())
            ;
            $this->em->persist($comment);
            $this->em->flush();

            return $this->redirectToRoute('review', [ 'id' => $review->getId(),], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('user/comment/_form.html.twig', [
            'form' => $form,
            'comment' => $comment,
            'review' => $review,
        ]);
    }

    #[Route('/{id}/edit', name: 'comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment,): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'comment_delete', methods: ['GET','POST'])]
    public function delete($id): Response
    {
        $comment = $this->commentRepository->find($id);
        $this->em->remove($comment);
        $this->em->flush();

        return $this->redirectToRoute('comment_index', [
            'comment' => $comment,
        ]);
    }
}
