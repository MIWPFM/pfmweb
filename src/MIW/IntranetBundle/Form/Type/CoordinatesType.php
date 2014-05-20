<?php

namespace MIW\IntranetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CoordinatesType extends AbstractType
{
    public function __construct()
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('x', 'hidden', array( ))
            ->add('y', 'hidden', array( ));           
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'MIW\DataAccessBundle\Document\Coordinates',
        );
    }

    public function getName()
    {
        return 'coordinates';
    }
}