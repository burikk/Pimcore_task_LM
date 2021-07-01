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
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
        $cargos = [];
        $cargosObjects = new DataObject\Cargo\Listing();
            foreach($cargosObjects as $cargoObject) {
                $cargos[$cargoObject->getTypeCargo()] = $cargoObject;
            }
        $builder
            ->add('number', TextType::class, [
                'label' => 'Flight number: ',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                ],
            ])
            ->add('from', TextType::class, [
                'label' => 'From: ',
                'required' => true,
                'constraints' => [new NotBlank()],
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
            ->add('cargo', ChoiceType::class, [
                'label' => 'Choose cargo type: ',
                'required' => true,
                'attr' => ['class' => ''],
                'choices' => $cargos,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('waybill', FileType::class, [
                'label' => 'Put your waybill image here: ',
                'required' => true,
                'multiple' => false,

            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }
}
