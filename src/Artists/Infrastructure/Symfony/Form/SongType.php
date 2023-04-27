<?php

namespace App\Artists\Infrastructure\Symfony\Form;

use App\Artists\Domain\Entity\Album;
use App\Artists\Domain\Entity\Artist;
use App\Artists\Domain\Entity\Song;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SongType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('duration')
            ->add('filePath')
            ->add('album', EntityType::class, [
                'class' => Album::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    $artists = $options['user']->getArtists();
                    $ids = array_map(fn (Artist $artist) => $artist->getId(), $artists->toArray());

                    $qb = $er->createQueryBuilder('a');
                    $qb
                        ->andWhere($qb->expr()->in('a.artist', $ids))
                        ->orderBy('a.name', 'ASC')
                        ->getQuery()
                        ->getResult()
                    ;
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Song::class,
            'user' => null
        ]);
    }
}
