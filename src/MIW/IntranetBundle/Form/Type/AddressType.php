<?php

namespace MIW\IntranetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddressType extends AbstractType
{
    public function __construct()
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('address', 'text', array(
                'label' => 'Dirección',
                'attr' => array('class' => 'address')))
            ->add('community', 'text', array(
                'label' => 'Comunidad Autónoma',
                'attr' => array('class' => 'community')))
            ->add('province', 'text', array(
                'label' => 'Provincia',
            ))
            ->add('city', 'text', array(
                'label' => 'Localidad',
            ))
            ->add('zipcode', 'hidden', array( ))
            ->add('lat', 'hidden', array( ))
            ->add('long', 'hidden', array( ));
           
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'MIW\DataAccessBundle\Document\Address',
        );
    }

    public function getName()
    {
        return 'address';
    }
}