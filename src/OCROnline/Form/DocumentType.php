<?php
// src/OCROnline/Form/DocumentType.php
namespace OCROnline\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('fileupload', FileType::class, array(
                'constraints' => array(new Assert\File(array(
                    'maxSize' => '10m',
                    'mimeTypes' => array(
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                    ),
                    'mimeTypesMessage' => 'Nieprawidłowy format pliku. Dozwolone jedynie JPG, PNG, GIF.',
                )))
            ))
            ->add('privacy', ChoiceType::class, array(
                'choices' => array(
                    'Publiczny' => 0,
                    'Niepubliczny' => 1,
                    'Tylko ja' => 2,
                ),
            ))
            ->add('doupload', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OCROnline\Entity\Document',
        ));
    }
}