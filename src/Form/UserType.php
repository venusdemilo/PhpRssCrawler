<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('firstName')
            ->add('lastName')
        ;


    $builder->get('roles')
         ->addModelTransformer(new CallbackTransformer(
             function ($json) {
                 // transform the json to a string

                 $str = json_encode($json);
                 $str = strtr($str,array(
                   "["=>"",
                   "]"=>"",
                   "\""=>"",
                 ));
                 return $str;

             },
             function ($str) {
                 // transform the string back to an array
                 return explode(',', $str);

             }
         ))
     ;
}


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
