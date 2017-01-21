<?php
// src/OCROnline/Form/RecognizeType.php
namespace OCROnline\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RecognizeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lang', ChoiceType::class, array(
                'choices' => array(
                    'Afrikaans' => 'afr',
                    'Amharic' => 'amh',
                    'Arabic' => 'ara',
                    'Assamese' => 'asm',
                    'Azerbaijani' => 'aze',
                    'Azerbaijani - Cyrilic' => 'aze_cyrl',
                    'Belarusian' => 'bel',
                    'Bengali' => 'ben',
                    'Tibetan' => 'bod',
                    'Bosnian' => 'bos',
                    'Bulgarian' => 'bul',
                    'Catalan; Valencian' => 'cat',
                    'Cebuano' => 'ceb',
                    'Czech' => 'ces',
                    'Chinese - Simplified' => 'chi_sim',
                    'Chinese - Traditional' => 'chi_tra',
                    'Cherokee' => 'chr',
                    'Welsh' => 'cym',
                    'Danish' => 'dan',
                    'German' => 'deu',
                    'Dzongkha' => 'dzo',
                    'Greek, Modern (1453-)' => 'ell',
                    'English' => 'eng',
                    'English, Middle (1100-1500)' => 'enm, ',
                    'Esperanto' => 'epo',
                    'Estonian' => 'est',
                    'Basque' => 'eus',
                    'Persian' => 'fas',
                    'Finnish' => 'fin',
                    'French' => 'fra',
                    'Frankish' => 'frk',
                    'French, Middle (ca. 1400-1600)' => 'frm',
                    'Irish' => 'gle',
                    'Galician' => 'glg',
                    'Greek, Ancient (-1453)' => 'grc',
                    'Gujarati' => 'guj',
                    'Haitian;' => 'hat',
                    'Hebrew' => 'heb',
                    'Hindi' => 'hin',
                    'Croatian' => 'hrv',
                    'Hungarian' => 'hun',
                    'Inuktitut' => 'iku',
                    'Indonesian' => 'ind',
                    'Icelandic' => 'isl',
                    'Italian' => 'ita',
                    'Italian - Old' => 'ita_old',
                    'Javanese' => 'jav',
                    'Japanese' => 'jpn',
                    'Kannada' => 'kan',
                    'Georgian' => 'kat',
                    'Georgian' => 'kat_old',
                    'Kazakh' => 'kaz',
                    'Central' => 'khm',
                    'Kirghiz; Kyrgyz' => 'kir',
                    'Korean' => 'kor',
                    'Kurdish' => 'kur',
                    'Lao' => 'lao',
                    'Latin' => 'lat',
                    'Latvian' => 'lav',
                    'Lithuanian' => 'lit',
                    'Malayalam' => 'mal',
                    'Marathi' => 'mar',
                    'Macedonian' => 'mkd',
                    'Maltese' => 'mlt',
                    'Malay' => 'msa',
                    'Burmese' => 'mya',
                    'Nepali' => 'nep',
                    'Dutch; Flemish' => 'nld',
                    'Norwegian' => 'nor',
                    'Oriya' => 'ori',
                    'Panjabi;' => 'pan',
                    'Polish' => 'pol',
                    'Portuguese' => 'por',
                    'Pushto; Pashto' => 'pus',
                    'Romanian; Moldavian; Moldovan' => 'ron',
                    'Russian' => 'rus',
                    'Sanskrit' => 'san',
                    'Sinhala;' => 'sin',
                    'Slovak' => 'slk',
                    'Slovenian' => 'slv',
                    'Spanish; Castilian' => 'spa',
                    'Spanish; Castilian - Old' => 'spa_old',
                    'Albanian' => 'sqi',
                    'Serbian' => 'srp',
                    'Serbian' => 'srp_latn',
                    'Swahili' => 'swa',
                    'Swedish' => 'swe',
                    'Syriac' => 'syr',
                    'Tamil' => 'tam',
                    'Telugu' => 'tel',
                    'Tajik' => 'tgk',
                    'Tagalog' => 'tgl',
                    'Thai' => 'tha',
                    'Tigrinya' => 'tir',
                    'Turkish' => 'tur',
                    'Uighur; Uyghur' => 'uig',
                    'Ukrainian' => 'ukr',
                    'Urdu' => 'urd',
                    'Uzbek' => 'uzb',
                    'Uzbek - Cyrilic' => 'uzb_cyrl',
                    'Vietnamese' => 'vie',
                    'Yiddish' => 'yid',

                ),
            ))
            ->add('recognize', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OCROnline\Entity\Document',
        ));
    }
}