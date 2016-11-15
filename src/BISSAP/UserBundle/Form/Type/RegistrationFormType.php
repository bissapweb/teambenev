<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BISSAP\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType
{

    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;

    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array('validation_groups' => array('registration'), 
						'label' => 'form.email',
						'translation_domain' => 'FOSUserBundle',
						'attr' => array('class' => 'input__registerbox')))
            ->setMethod('POST')
            ->add('username', null, array('validation_groups' => array('registration'),
						'label' => 'form.username',
						'translation_domain' => 'FOSUserBundle',
						'attr' => array('class' => 'input__registerbox')))
            ->add('plainPassword', 'repeated', array(
		'validation_groups' => array('registration'),
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password', 'attr' => array('class' => 'input__registerbox')),
                'second_options' => array('label' => 'form.password_confirmation', 'attr' => array('class' => 'input__registerbox')),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            
            //can't use this
            //->setAction($this->generateUrl('fos_user_registration_register', array('type' => 'agent'),true));

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention'  => 'registration',
        ));
    }

    // BC for SF < 2.7
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    public function getName()
    {
        return 'bissap_user_registration';
    }
}
