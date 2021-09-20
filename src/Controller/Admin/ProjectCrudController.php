<?php

namespace App\Controller\Admin;

use App\Entity\Contributor;
use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Form\PictureFormType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [];
        if ($pageName === Crud::PAGE_INDEX) {
            array_push(
                $fields,
                IdField::new('id', 'Référence'),
                TextField::new('title', 'Titre'),
                DateField::new('createdAt', 'Créé le'),
                /* ImageField::new('image', 'Image')->setBasePath('/uploads/images/articles'), */
            );
        }
        if ($pageName === Crud::PAGE_DETAIL) {
            array_push(
                $fields,
                IdField::new('id', 'Référence'),
                TextField::new('title', 'Titre'),
                DateField::new('createdAt', 'Créé le'),
                ImageField::new('illustration', 'illustration')->setBasePath('/uploads/images/articles'),
                AssociationField::new('contributors', 'contributors'),
                AssociationField::new('technos', 'technos'),
                AssociationField::new('gallery', 'gallery'),
            );
        }
        if ($pageName === Crud::PAGE_EDIT || $pageName === Crud::PAGE_NEW) {
            array_push(
                $fields,
                TextField::new('title', 'Titre'),
                TextEditorField::new('description', 'description'),
                AssociationField::new('contributors', 'contributeurs')->setFormTypeOptions([
                    'by_reference' => false,
                ]),
                AssociationField::new('technos', 'technos')->setFormTypeOptions([
                    'by_reference' => false,
                ]),
                TextField::new('illustration', 'illustration principal'),
                CollectionField::new('gallery', 'gallery'),
            );
        }

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Add Project');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fas fa-pencil-alt')->setLabel(false);
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fas fa-eye')->setLabel(false);
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fas fa-trash')->setLabel(false);
            });
    }
}
