<?php


namespace App\Form;


use App\Entity\CartStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', EntityType::class, [
                'class' => CartStatus::class,
                'choice_label' => 'name'
            ])
            ->add('submit', SubmitType::class);
    }
}