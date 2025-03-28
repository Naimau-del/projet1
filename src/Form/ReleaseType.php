<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Release;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\ArtistRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReleaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('releasedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('title', null, [
                'label' => 'Release Title',
                'attr' => [
                    'placeholder' => 'Enter the release title',
                ],
            ])
            ->add('thumbnailUrl', null, [
                'label' => 'Thumbnail URL',
                'attr' => [
                    'placeholder' => 'Enter the thumbnail URL',
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'release type',
                'choices'  => [
                    'EP' => Release::EP,
                    'Album' => Release::ALBUM,
                    'Single' => Release::SINGLE,
                ],
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => 'name',
                'query_builder' => function (ArtistRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Release::class,
        ]);
    }
}
