<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PredictionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('genre', ChoiceType::class, [
                'choices'  => [
                    'M' => 'M',
                    'F' => 'F',
                    'Autre' => 'Autre',
                ]])
            ->add('age', IntegerType::class)
            ->add('age_mois', IntegerType::class)
            ->add('age_jour', IntegerType::class)
            ->add('zodiaque_chinois', ChoiceType::class, [
                'choices'  => [
                    'Rat' => 'Rat',
                    'Bœuf' => 'Bœuf',
                    'Tigre' => 'Tigre',
                    'Lapin' => 'Lapin',
                    'Dragon' => 'Dragon',
                    'Serpent' => 'Serpent',
                    'Cheval' => 'Cheval',
                    'Chèvre' => 'Chèvre',
                    'Singe' => 'Singe',
                    'Coq' => 'Coq',
                    'Chien' => 'Chien',
                    'Cochon' => 'Cochon',
                ]])
            ->add('zodiaque_astrologique', ChoiceType::class, [
                'choices'  => [
                    'Bélier' => 'Bélier',
                    'Taureau' => 'Taureau',
                    'Gémeaux' => 'Gémeaux',
                    'Cancer' => 'Cancer',
                    'Lion' => 'Lion',
                    'Vierge' => 'Vierge',
                    'Balance' => 'Balance',
                    'Scorpion' => 'Scorpion',
                    'Sagittaire' => 'Sagittaire',
                    'Capricorne' => 'Capricorne',
                    'Verseau' => 'Verseau',
                    'Poissons' => 'Poissons',
                    ]])
            ->add('zodiaque_emissaire', ChoiceType::class, [
                'choices' => [
                    'Casserole' => 'Casserole',
                    'Poirier' => 'Poirier',
                    'Somnambule' => 'Somnambule',
                    'Ciseaux' => 'Ciseaux',
                    'Invitation' => 'Invitation',
                    'Rotule' => 'Rotule',
                    'Niveau' => 'Niveau',
                    'Boulangerie' => 'Boulangerie',
                    'Pinceau' => 'Pinceau',
                    'Collision' => 'Collision',
                    'Cascade' => 'Cascade',
                    'Cannibale' => 'Cannibale'
                ]
            ])
            ->add('pays', TextType::class)
            ->add('ville', TextType::class)
            ->add('rue', TextType::class)
            ->add('etage', IntegerType::class)
            ->add('vert')
            ->add('repas', TextType::class)
            ->add('boisson', TextType::class)
            ->add('plat_prefere', TextType::class)
            ->add('sang', IntegerType::class)
            ->add('anxiete1')
            ->add('anxiete2')
            ->add('anxiete3')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
