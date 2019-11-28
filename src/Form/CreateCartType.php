<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Cart;
use App\Entity\Status;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $cart = $options['currentCart'];
        dump($cart);
        $builder
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'query_builder' => function (EntityRepository $er) use ($cart) {

                    return $er->createQueryBuilder('c')
                        ->where('c.value >= :current')
                        ->orderBy('c.value', 'ASC')
                        ->setParameter('current', $cart->getStatus()->getValue())
                        ->setMaxResults(2);
                },
                'choice_label' => 'name'
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'currentCart' => null
        ]);
    }


}
