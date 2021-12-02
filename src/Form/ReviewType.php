<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Review;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, array(
                'label' => 'Category: ',
                'class' => Category::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ]
            ))
//            ->add('tag', EntityType::class,[
//                'label' => 'Tag: ',
//                'class' => Tag::class,
//                'choice_label' => 'name',
//                'attr' => [
//                    'class' => 'form-control'
//                ]
//            ])
            ->add('title', TextType::class,[
                'label' => 'Title: ',
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Print the title please',
                    ]),
                ],
            ])
            ->add('text', TextareaType::class, [
                'label' => "Text: ",
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Print the text please',
                    ]),
                ],
            ])
            ->add('assessment', NumberType::class, [
                'label' => 'Author`s assessment: ',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
                'constraints' => [
                    new Length(['min' => 1, 'max' => 10]
                    )],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'form-control btn-block btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
