<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{

    /**
     * get the basic form config
     * @param $label
     * @param $placeholder
     * @return array
     */
    private function getConfiguration($label, $placeholder)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Ecrivez un titre pour votre annonce"))
            ->add('slug', TextType::class, $this->getConfiguration("Url", 'Adresse de votre annonce (automatique si vide)'))
            ->add('coverImage', UrlType::class, $this->getConfiguration("Url de l'image principale", "Donnez l'addresse d'une image qui donne envie"))
            ->add('introduction', TextType::class, $this->getConfiguration('Introduction', 'Donnez une description globable de l\'annonce'))
            ->add('content', TextareaType::class, $this->getConfiguration("Description detaillée", "Tapez une description qui donne envie de venir chez vous"))
            ->add('rooms', IntegerType::class, $this->getConfiguration("Nombre de chambres", "Le nombre de chambres disponibles"))
            ->add('price', MoneyType::class, $this->getConfiguration('Prix / Nuit', 'Indiquez le prix pour une nuit'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
