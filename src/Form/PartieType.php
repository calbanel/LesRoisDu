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
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\PlateauRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class PartieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, ['attr' => ['placeholder' => "Nom de la partie (Il apparaîtra dans l'espace partie des joueurs, veuillez faire attention à ce que vous saisissez)."]])
            ->add('description',TextType::class, ['attr' => ['placeholder' => "Description de la partie (Elle apparaîtra dans l'espace partie des joueurs, veuillez faire attention à ce que vous saisissez)."]])
            ->add('nbPlateaux',IntegerType::class,['data' => '1', 'attr'=> ['readonly'=> true ]])
            ->add('nbPionParPlateau',RangeType::class,['data' => 1, 'attr'=> ['class' => "RangeCSS", 'min'=> 1, 'max'=>4 ]])
            ->add('nbFacesDe',RangeType::class,['data' => 1, 'attr'=> ['class' => "RangeCSS", 'min'=> 1, 'max'=>4 ]])
            ->add('plateau', EntityType::class, [   'class' => Plateau::class,
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
