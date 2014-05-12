<?php

namespace MIW\RestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\Container;

class RestRegistrationFormType extends AbstractType
{
    protected $routeName;
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct(Container $container, $class)
    {
        $request = $container->get('request');
        $this->routeName = $request->get('_route');
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->routeName != "miw_rest_user_newuser")
        {
            $builder
                ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
                ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'form.password'),
                    'second_options' => array('label' => 'form.password_confirmation'),
                    'invalid_message' => 'fos_user.password.mismatch',
                ))
            ;
        }
        else
        {
            $builder
                ->add('email', 'email')
                ->add('username', null)
                ->add('plainPassword', 'password')
            ;        
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        if ($this->routeName != "miw_rest_user_newuser")
        {
            $resolver->setDefaults(array(
                'data_class' => $this->class,
                'intention'  => 'registration',
            ));
        }
        else
        {
            $resolver->setDefaults(array(
                'data_class' => $this->class,
                'intention'  => 'registration',
                'csrf_protection' => false
            ));            
        }
    }

    public function getName()
    {
        return 'fos_user_rest_registration';
    }
}
