<?php

declare(strict_types=1);

namespace App\Types;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, [
               'choices' => array_combine(Order::STATUSES, Order::STATUSES)
            ]);
            // selection
    }
}
