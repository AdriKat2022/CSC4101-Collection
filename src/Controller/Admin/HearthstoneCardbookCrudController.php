<?php

namespace App\Controller\Admin;

use App\Entity\HearthstoneCardbook;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HearthstoneCardbookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HearthstoneCardbook::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            TextField::new('description'),
            AssociationField::new('[inventaire]')
        ];
    }
    */
}
