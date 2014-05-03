<?php

namespace MIW\IntranetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of UserType
 *
 * 
 */
class UserType extends AbstractType {
    
    public function __construct()
    {
    }
    
    public function getName() {
        return 'user';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label' => 'Nickname',
                'read_only' => 'true'))
            ->add('name', 'text', array(
                'label' => 'Nombre'))
            ->add('email', 'email', array(
                'label' => 'Email'))
            ->add('birthday', 'date', array(
                'label' => 'Fecha de Nacimiento',
                'widget' => 'single_text',
                'format' => 'd/M/y',
                'attr' => array('class' => 'datepicker')));    
    }
    
    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'MIW\DataAccessBundle\Document\User',
        );
    }
    
}
