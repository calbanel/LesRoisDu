<?php

namespace App\Form;

use App\Entity\Partie;
use App\Entity\Plateau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PartieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class)
            ->add('description',TextareaType::class)
            ->add('nbPlateaux',IntegerType::class,['data' => '1', 'attr'=> ['readonly'=> true ]])
            ->add('nbPionParPlateau',IntegerType::class,['data' => '1', 'attr'=> ['readonly'=> true ]])
            ->add('nbFacesDe',IntegerType::class,['data' => '4', 'attr'=> ['readonly'=> true ]])
            ->add('plateau', EntityType::class, ['class' => Plateau::class,
                                                    'choice_label' => 'nom',
                                                    'multiple' => false,
                                                    'expanded' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Partie::class,
        ]);
    }
}
