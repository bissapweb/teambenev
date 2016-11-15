<?php

namespace BISSAP\UserBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use BISSAP\CoreBundle\Entity\Regions;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use BISSAP\CoreBundle\Form\TypeEventsType as TypeEventsType;
use BISSAP\CoreBundle\Form\GenreEventsType as GenreEventsType;


class UserType extends AbstractType
{

    protected $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('tel')
            ->add('presentation')
            ->add('typeE', 'entity', array(
                'class' => 'BISSAPCoreBundle:typeEvents',
                'multiple' => 'true',
                'by_reference' => false,
                'expanded' => 'true'))
            ->add('genreE', 'entity', array(
                'class' => 'BISSAPCoreBundle:genreEvents',
                'multiple' => 'true',
                'by_reference' => false,
                'expanded' => 'true'))
            //->add('typeE', new TypeEventsType(), array('data_class' => null))
            //->add('genreE', new GenreEventsType(), array('data_class' => null))


        ;
        $builder->add('save', 'submit');

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));

    }

    

    protected function addElements(FormInterface $form, Regions $region = null) {
        // Remove the submit button, we will place this at the end of the form later
        $submit = $form->get('save');
        $form->remove('save');


        // Add the regions element
        $form->add('regions', 'entity', array(
            'data' => $region,
            'empty_value' => 'Toutes Regions',
            'class' => 'BISSAPCoreBundle:Regions',
            'mapped' => false,
            'required' => false,
            )
        );

        // Cities are empty, unless we actually supplied a province
        $deps = array();
        if ($region) {
            // Fetch the cities from specified province
            $repo = $this->em->getRepository('BISSAPCoreBundle:Departements');
            $deps = $repo->findByRegions($region, array('name' => 'asc'));
        }


        // Add the city element
        $form->add('departements', 'entity', array(
            'empty_value' => '-- Select a region first --',
            'class' => 'BISSAPCoreBundle:Departements',
            'choices' => $deps,
            'mapped' => false,
            'multiple'=> true,
            'expanded' => true,
        ));

        // Add submit button again, this time, it's back at the end of the form
        $form->add($submit);
    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        // Note that the data is not yet hydrated into the entity.
        $regions = $this->em->getRepository('BISSAPCoreBundle:Regions')->find($data['regions']);
        $this->addElements($form, $regions);
    }


    function onPreSetData(FormEvent $event) {
        $user = $event->getData();
        $form = $event->getForm();

        // We might have an empty account (when we insert a new account, for instance)
        //$region = $user->getDepartements() ? $user->getDepartements()->getRegions() : null;
        $this->addElements($form, null);
    }



    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BISSAP\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bissap_userbundle_user';
    }
}
