<?php

namespace App\Controller\Admin;

use App\Entity\Deck;

use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DeckCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Deck::class;
    }

    public function configureFields(string $pageName): iterable
    {
        
        return [
            IdField::new('id')
                ->hideOnForm(),
                
            AssociationField::new('member'),

            BooleanField::new('public')
                ->onlyOnForms(),

            TextField::new('description'),

            AssociationField::new('cards')
                ->onlyOnForms()
                // on ne souhaite pas gérer l'association entre les
                // [objets] et la Deck dès la crétion de la
                // Deck
                ->hideWhenCreating()
                ->setTemplatePath('admin/fields/hthcard.html.twig')
                // Ajout possible seulement pour des [objets] qui
                // appartiennent même propriétaire de l'[inventaire]
                // que le member de la Deck
                ->setQueryBuilder(
                    function (QueryBuilder $queryBuilder) {
                        // récupération de l'instance courante de Deck
                        $currentDeck = $this->getContext()->getEntity()->getInstance();
                        $member = $currentDeck->getMember();
                        $memberId = $member->getId();
                        // charge les seuls [objets] dont le 'owner' de l'[inventaire] est le member de la galerie
                        $queryBuilder->leftJoin('entity.hearthstoneCardbook', 'i')
                            ->leftJoin('i.member', 'm')
                            ->andWhere('m.id = :member_id')
                            ->setParameter('member_id', $memberId);    
                        return $queryBuilder;
                    }
                   )
        ];
        
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }
}
