<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('title'),
            Field::new('pitch'),
            Field::new('description'),
            Field::new('illustration'),
            Field::new('github_link'),
            Field::new('website_link'),
        ];
    }
}
