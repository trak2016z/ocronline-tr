<?php
// src/OCROnline/Form/DocumentUploadType.php
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

class DocumentUploadType extends DocumentType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        DocumentType::buildForm($builder, $options);
        $builder
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
            ->add('doupload', SubmitType::class)
        ;
    }
}