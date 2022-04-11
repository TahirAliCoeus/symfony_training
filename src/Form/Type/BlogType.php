<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("title", TextType::class, ["label" => "Add title of blog"])
            ->add("content", TextareaType::class)
            ->add("thumbnail",FileType::class,["mapped" => false,"required" => false,
                'label' => "Please upload thumbnail of blog",
                "constraints" => [
                    new File([
                        "mimeTypes" => [
                            "image/jpeg",
                            "image/png",
                            "image/jpg",
                        ],
                        "mimeTypesMessage" => "Please enter a valid image"
                    ])
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, ['mapped' => false, "label" => "Do you agree to terms and services?"])
            ->add("save", SubmitType::class);
    }
}