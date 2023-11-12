<?php

namespace App\Controller\Admin;

use App\Entity\Hthcard;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HthcardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Hthcard::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('description'),
            IntegerField::new('manacost'),
            BooleanField::new('isminion'),
            AssociationField::new('hearthstoneCardbook'),
            AssociationField::new('decks')
            //->onlyOnForms()
            ->hideOnIndex()
            ->setTemplatePath('admin/fields/decks.html.twig')
        ];
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }
}
