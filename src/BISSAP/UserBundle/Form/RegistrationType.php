<?php
// src/UserBundle/Form/RegistrationType.php

namespace BISSAP\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class RegistrationType extends AbstractType
{

 
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        
        $builder->add('sex', 'choice', array(
            'choices'  => array(
                'Homme' => 'Homme',
                'Femme' => 'Femme',
                'Unknow' => 'Unknow',
            ),'expanded' => true,
              'multiple' => false 
           ));
        
        $builder->add('Enregistrer', 'submit', array(
                'attr' => array(
                'class' => 'registerbox__submit bc-btn',)));
                //'action' => $this->generateUrl('fos_user_registration_register', array('type' => 'agent')))));
        //$builder->setAction($this->router->generate('fos_user_registration_register', array('type' => 'agent')));

    }

    public function getDefaultOptions()
    {
        return array(
            'validation_groups' => array('registration', 'Default')
        );
    }
 
 
   
    public function getParent()
    {
        //return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
         return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'fos_user_registration_form';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }


}
