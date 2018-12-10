<?php

namespace App\Form;

use App\Entity\Cart;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints as Assert;

class CartNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observation', TextType::class, [
                'required' => false,
            ])
            ->add('observationExtra', TextType::class, [
                'required' => false,
            ])
            ->add('useObservationExtra', CheckboxType::class, [
                'required' => false,
                'mapped' => false
            ])
            ->add('items', CollectionType::class, [
                'required' => false,
                'entry_type' => ItemNewType::class,
                'by_reference' => false,
                'entry_options' => [
                    'constraints' => [new Assert\Valid(
                        ['groups' => 
                            [
                                //'InformationExtra',
                                'CountryValid',
                                'Information',
                            ]
                        ]
                    )],
                ]
            ])
            ->add('save', SubmitType::class)
            ;

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cart::class,
            'validation_groups' => function (FormInterface $form) {
                $groups = ['observation'];
                $useObservationExtra = $form->get('useObservationExtra')->getData();
                if (true == $useObservationExtra) {
                    $groups[] = 'observationExtra';
                }
                return $groups;
            }
        ]);
    }
}