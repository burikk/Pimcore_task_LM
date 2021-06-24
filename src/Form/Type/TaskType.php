<?php
namespace App\Form\Type;

use Carbon\Carbon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use \Pimcore\Model\DataObject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', TextType::class, [
                'label' => 'Flight number: ',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('from', TextType::class, [
                'label' => 'From: ',
                'constraints' => [new NotBlank()],
                'attr' => ['class' => 'form-control']
            ])
            ->add('to', TextType::class, [
                'label' => 'To: ',
                'constraints' => [new NotBlank()],
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateFlight', DateType::class, [
                'label' => 'Flight date: ',
                'constraints' => [new NotBlank()],
                'attr' => ['class' => ''],
            ])
            ->add('plane', ChoiceType::class, [
                'label' => 'Choose plane: ',
                'attr' => ['class' => 'form-select'],
                'choices' => [
                    'Airbus' => DataObject\Plane::getById(6),
                    'Boeing' => DataObject\Plane::getById(7),
                    'Embraer' => DataObject\Plane::getById(8),
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }
}
