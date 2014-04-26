<?php

namespace MIW\IntranetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GameType extends AbstractType
{
    public function __construct()
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
            ->add('gameDate', 'date', array(
                'label' => 'Día del Partido',
                'data' => new \DateTime('now'),
                'attr' => array('class' => 'datepicker')))
            ->add('gameTime', 'time', array(
                'label' => 'Hora del Partido',
                'data' => new \DateTime('now'),
                'mapped' => false,
                'attr' => array('class' => 'datepicker')))
            ->add('limitDate', 'date', array(
                'label' => 'Día límite de desinscripción',
                'data' => new \DateTime('now'),
                'attr' => array('class' => 'datepicker')))
            ->add('limitTime', 'time', array(
                'label' => 'Hora límite de desinscripción',
                'data' => new \DateTime('now'),
                'mapped' => false,
                'attr' => array('class' => 'datepicker')))
            ->add('sport', 'document', array(
                'class' => 'MIWDataAccessBundle:Sport',
                'property' => 'name',
            ))
            ->add('price', 'money', array(
                'divisor' => 1,
            ))
            ->add('numPlayers', 'integer', array(
                'label' => 'Número de jugadores a inscribirse',
            ))
            ->add('description', 'textarea', array(
                'label' => 'Descripción del evento',
            ))
            ->add('center', new CenterType(),array('data_class'=>'MIW\DataAccessBundle\Document\Center'));
           
    }

    public function getDefaultOptions(array $options)
    {
        return array();
    }

    public function getName()
    {
        return 'game';
    }
}