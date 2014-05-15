<?php

namespace MIW\IntranetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of SportType
 *
 * 
 */
class SportType extends AbstractType {
    
    public function __construct()
    {
    }
    
    public function getName() 
    {
        return 'sport';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sports', 'document', array(
                'class' => 'MIWDataAccessBundle:Sport',
                'property' => 'name',
                'label' => 'Elige un Deporte',
            ))
            ->add('idSport', 'hidden', array( ));           
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'MIW\DataAccessBundle\Document\Sport',
        );
    }
    
}
