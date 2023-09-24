<?php

namespace App\Controller\Admin;

use App\Entity\Hthcard;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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
            IdField::new('id'),
            TextField::new('name'),
            TextField::new('description'),
            //TextField::new('manacost'),
            TextField::new('hearthstoneCardbook')
        ];
    }
}
