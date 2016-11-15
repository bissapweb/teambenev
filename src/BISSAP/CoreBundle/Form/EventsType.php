<?php

namespace BISSAP\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('typeEvents', 'entity', array(
                'class' => 'BISSAPCoreBundle:typeEvents',
                'multiple' => 'true',
                'by_reference' => false,
                'expanded' => 'true'))

            ->add('genreEvents', 'entity', array(
                'class' => 'BISSAPISSAPCoreBundle:genreEvents',
                'multiple' => 'true',
                'by_reference' => false,
                'expanded' => 'true'))
            // ->add('typeEvents')
            // ->add('genreEvents')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BISSAP\CoreBundle\Entity\Events'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bissap_corebundle_events';
    }
}
