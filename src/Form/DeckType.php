<?php

namespace App\Form;

use App\Entity\Deck;
use App\Entity\Hthcard;
use App\Repository\HthcardRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $deck = $options['data'] ?? null;
        $member = $deck->getMember();


        $builder
            ->add('member', null, [
                'disabled'   => true,
        ])
            ->add('description')
            ->add('public')
            ->add('cards', null, [
                'query_builder' => function (HthcardRepository $er) use ($member) {
                                return $er->createQueryBuilder('o')
                                ->leftJoin('o.hearthstoneCardbook', 'i')
                                ->andWhere('i.member = :member')
                                ->setParameter('member', $member)
                                ;
                        },
                // avec 'by_reference' => false, sauvegarde les modifications
                'by_reference' => false,
                // classe pas obligatoire
                //'class' => [Object]::class,
                // permet sélection multiple
                'multiple' => true,
                // affiche sous forme de checkboxes
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Deck::class,
        ]);
    }
}
