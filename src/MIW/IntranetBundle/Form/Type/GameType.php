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
                'label' => 'Fecha',
                'data' => new \DateTime('now'),
                'attr' => array('class' => 'datepicker')))
            ->add('gameTime', 'time', array(
                'label' => 'Hora',
                'data' => new \DateTime('now'),
                'mapped' => false,
                'attr' => array('class' => 'datepicker')))
            ->add('limitDate', 'date', array(
                'label' => 'Fecha Límite de Baja',
                'data' => new \DateTime('now'),
                'attr' => array('class' => 'datepicker')))
            ->add('limitTime', 'time', array(
                'label' => 'Hora',
                'data' => new \DateTime('now'),
                'mapped' => false,
                'attr' => array('class' => 'datepicker')))
            ->add('sport', 'document', array(
                'class' => 'MIWDataAccessBundle:Sport',
                'property' => 'name',
                'label' => 'Deporte',
            ))
            ->add('price', 'money', array(
                'divisor' => 1,
                'label' => 'Precio',
                'currency' => 'false',
            ))
            ->add('numPlayers', 'integer', array(
                'label' => 'Máx. Jugadores',
            ))
            ->add('description', 'textarea', array(
                'label' => 'Descripción',
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