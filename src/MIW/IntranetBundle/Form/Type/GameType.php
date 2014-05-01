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
        $now=new \DateTime('now');
         $builder
            ->add('gameDate', 'date', array(
                'label' => 'Fecha',
                'widget' => 'single_text',
                'format' => 'd/M/y',
                'data' => $now,
                'attr' => array('class' => 'datepicker')))
            ->add('gameTime', 'time', array(
                'label' => 'Hora',
                'widget' => 'single_text',
                'data' => $now,
                'mapped' => false,
                'attr' => array('class' => 'timepicker')))
            ->add('limitDate', 'date', array(
                'label' => 'Fecha Límite de Baja',
                'widget' => 'single_text',
                'format' => 'd/M/y',
                'data' => $now,
                'attr' => array('class' => 'datepicker')))
            ->add('limitTime', 'time', array(
                'label' => 'Hora',
                'widget' => 'single_text',
                'data' => $now,
                'mapped' => false,
                'attr' => array('class' => 'timepicker')))
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
                'label' => 'Nº Jugadores',
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