<?php

namespace AppBundle\Form;

use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class ActType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('stage', ChoiceType::class, [
                'choices' => [
                    'Alpha'     =>  'alpha',
                    'Bravo'     =>  'bravo',
                    'Heineken'  =>  'heineken',
                    'Lima'      =>  'lima',
                    'India'     =>  'india',
                    'X-Ray'     =>  'x-ray',
                    'Hacienda'  =>  'hacienda',
                    'Juliet'    =>  'juliet',
                    'Echo'      =>  'echo',
                    'Helga\'s'  =>  'helgas'
                ]
            ]);

        $builder
            ->add('name', TextType::class);

        $builder
            ->add('starttime', DateTimeType::class, [
                'data' => new DateTime('2017-08-18 12:00:00')
            ]);

        $builder
            ->add('endtime', DateTimeType::class, [
                'data' => new DateTime('2017-08-18 12:00:00')
            ]);

        $builder
            ->add('description', TextareaType::class);


        $builder
            ->add('save', SubmitType::class);
    }


}