<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    public function index(Request $id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render('base.html.twig', [
            'user' => $user,
        ]);
    }
}
