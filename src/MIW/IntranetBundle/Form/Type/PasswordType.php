<?php

namespace MIW\IntranetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of PasswordType
 *
 * 
 */
class PasswordType extends AbstractType {
    
    public function __construct()
    {
    }
    
    public function getName() {
         return 'password';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('passwordOld', 'password', array(
                'label' => 'Antigua Contraseña'))
            ->add('passwordNew', 'password', array(
                'label' => 'Nueva Contraseña'))
            ->add('passwordConfirmNew', 'password', array(
                'label' => 'Repetir Contraseña'));    
    }
    
}
