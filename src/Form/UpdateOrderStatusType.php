<?php
/**
 * Created by PhpStorm.
 * User: MUD0
 * Date: 28/11/2019
 * Time: 14:43
 */

namespace App\Form;


use App\Entity\OrderStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class UpdateOrderStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderStatus', EntityType::class, [
                'class'     => OrderStatus::class,
                'required'  => true,
            ])
            ->add('submit', SubmitType::class);
    }
}