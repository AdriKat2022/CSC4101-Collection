<?php

namespace App\Controller\Admin;

use App\Entity\Member;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Member::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('nom'),
            TextField::new('description'),
            AssociationField::new('hearthstoneCardbooks')
            ->hideOnForm()
            ->onlyOnDetail()
            ->setTemplatePath('admin/fields/hearthstonecardbooks.html.twig'),
            AssociationField::new('decks')
            //->onlyOnForms()
            ->hideOnForm()
            ->hideOnIndex()
            ->setTemplatePath('admin/fields/decks.html.twig'),
            AssociationField::new('user')
        ];
    }
    

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }
}
