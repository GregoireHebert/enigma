<?php

namespace App\Artists\Infrastructure\Symfony\Form;

use App\Artists\Infrastructure\Model\Album;
use App\Artists\Infrastructure\Model\Artist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $choices = [];
        foreach ($options['user']->getArtists() as $artist) {
            $choices[] = Artist::fromDomain($artist);
        }

        $builder
            ->add('name')
            ->add('artist', ChoiceType::class, [
                'choice_label' => 'name',
                'choices' => $choices,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
            'user' => null
        ]);
    }
}
