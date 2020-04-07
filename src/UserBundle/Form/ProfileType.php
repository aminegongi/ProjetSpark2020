<?php


namespace UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    $builder->add("yessine");
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }


}