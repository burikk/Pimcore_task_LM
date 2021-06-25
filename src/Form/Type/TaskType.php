<?php
namespace App\Form\Type;

use Carbon\Carbon;
use Pimcore\Model\Asset\MetaData\ClassDefinition\Data\Data;
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
use Symfony\Component\Validator\Constraints\IsTrue;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $planes = [];
        $planesObjects = new DataObject\Plane\Listing();
            foreach($planesObjects as $planeObject) {
                $planes[$planeObject->getName()] = $planeObject;
            }
            
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
                'required' => true,
                'constraints' => [new NotBlank()],
                'attr' => ['class' => 'form-control']
            ])
            ->add('to', TextType::class, [
                'label' => 'To: ',
                'required' => true,
                'constraints' => [new NotBlank()],
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateFlight', DateType::class, [
                'label' => 'Flight date: ',
                'required' => true,
                'constraints' => [new NotBlank()],
                'attr' => ['class' => ''],
            ])
            ->add('plane', ChoiceType::class, [
                'label' => 'Choose plane: ',
                'required' => true,
                'attr' => ['class' => 'form-select'],
                'choices' => $planes,
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }
}
