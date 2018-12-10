<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Country;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints as Assert;

class ItemNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('useItem', CheckboxType::class, [
                'required' => false,
                'mapped' => false
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
            ])
            ->add('info', TextType::class)
            ->add('informationExtra', TextType::class, [
                'required' => false,
                'mapped' => false,
                    'constraints' => [
                        new Assert\NotBlank(
                            ['groups' => ['InformationExtra']]),
                        new Assert\Regex([
                            'pattern' => "/^([a-z0-9]{4, 8})$/",
                            'groups' => ['InformationExtra'],
                            'message' => "Only alpha numeric characters (4 - 8 characters)"
                        ]),
                    ],
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
            'validation_groups' => function (FormInterface $form) {
                $useItem = $form->get('useItem')->getData();
                $groups = [];
                if (true == $useItem) {
                    $groups[] = 'InformationExtra';
                    $groups[] = 'CountryValid';
                    $groups[] = 'Information';
                }
                return $groups;
            }
        ]);
    }

}