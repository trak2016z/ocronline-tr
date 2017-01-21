<?php
// src/OCROnline/Form/DocumentEditType.php
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

class DocumentEditType extends DocumentType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        DocumentType::buildForm($builder, $options);
        $builder
            ->add('doedit', SubmitType::class)
        ;
    }
}