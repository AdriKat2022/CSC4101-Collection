<?php

namespace App\Form;

use App\Entity\Hthcard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HthcardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder/* 
            ->add('hearthstoneCardbook', null, [
                'disabled'   => true,
        ]) */
            ->add('name')
            ->add('description')
            ->add('manacost')
            ->add('isminion')
            ->add('atk')
            ->add('hp')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hthcard::class,
        ]);
    }
}
