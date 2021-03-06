<?php

namespace App\Controller\Admin;

use App\Entity\AboutMe;
use App\Entity\Contact;
use App\Entity\Education;
use App\Entity\Illustration;
use App\Entity\ProfessionalExperience;
use App\Entity\Project;
use App\Entity\Techno;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder =$this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(ProjectCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Portfolio');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Menu');
        yield MenuItem::linkToCrud('Projets', '', Project::class);
        yield MenuItem::linkToCrud('About Me', '', AboutMe::class);
        yield MenuItem::linkToCrud('Education', '', Education::class);
        yield MenuItem::linkToCrud('Experience', '', ProfessionalExperience::class);
        yield MenuItem::linkToCrud('Technos', '', Techno::class);
        yield MenuItem::linkToCrud('Contact', '', Contact::class);
        yield MenuItem::linkToCrud('Illustration', '', Illustration::class);
    }
}
