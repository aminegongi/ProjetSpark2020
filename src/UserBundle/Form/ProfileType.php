<?php
//
//
//namespace UserBundle\Form;
//
//use MaladieBundle\Entity\Maladie;
//use PlatBundle\Repository\UstensilesRepository;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\EmailType;
//use Symfony\Component\Form\Extension\Core\Type\FileType;
//use Symfony\Component\Form\Extension\Core\Type\PasswordType;
//use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
//use Symfony\Component\Form\Extension\Core\Type\TextareaType;
//use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
//use Symfony\Component\Validator\Constraints\NotBlank;
//use UserBundle\Repository\MaladieRepository;
//
//class ProfileType extends AbstractType
//{
//
//
//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//
//
//        $builder->add("nom")->add('prenom')
//            ->add('sexe', ChoiceType::class,
//                ['choices'=>
//                    [
//                        'Masculin'=>'masculin',
//                        'Feminin'=>'feminin'
//                    ],
//                ])
//            ->add('maladie',EntityType::class,array(
//                'class'=>Maladie::class,[
//                'choice_label'=>'nomMaladie',
//                'multiple'=>true,
//                'expanded'=>true,
//                //'query_builder' => function(MaladieRepository $repo){ return $repo->get();}
//
//            ]))
//        ;
//    }
//    public function getBlockPrefix()
//    {
//        return 'app_user_profile';
//    }
//    public function getParent()
//    {
//        return 'FOS\UserBundle\Form\Type\ProfileFormType';
//    }
//
//}