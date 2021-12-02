<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Category;
use App\Entity\Review;
use App\Entity\Tag;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(CategoryCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SYMFONY-WEB-APP  admin-dashboard');
    }

    public function configureMenuItems(): iterable
    {
//        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
//        yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'home');
        yield MenuItem::linkToCrud('Categories', 'fas fa-map-marker-alt', Category::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-map-marker-tags', Tag::class);
//        yield MenuItem::linkToCrud('Comments', 'fas fa-comments', Comment::class);
//        yield MenuItem::linkToCrud('Reviews', 'fas fa-comments', Review::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
    }
}
