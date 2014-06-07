<?php

namespace MIW\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class GameAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('numPlayers',null, array('label' => 'Número de jugadores'))
            ->add('price',null, array('label' => 'Precio'))
            ->add('center',null, array('label' => 'Instalación'))
            ->add('admin',null, array('label' => 'Creador'))
            ->add('sport',null, array('label' => 'Deporte'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('gameDate','date', array('format' => 'd/m/Y H:i', 'label' => 'Fecha del Partido'))
           
            ->add('created','date', array('format' => 'd/m/Y H:i', 'label' => 'Fecha Creación'))
            ->add('numPlayers',null, array('label' => 'Número de Jugadores'))
            ->add('price',null, array('label' => 'Precio'))
            ->add('center',null, array('label' => 'Instalación'))
            ->add('admin',null, array('label' => 'Creador'))
            ->add('sport',null, array('label' => 'Deporte'))  
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id')
            ->add('description',null, array('label' => 'Descripcion'))
            ->add('gameDate')
            ->add('limitDate')
            ->add('created')
            ->add('numPlayers')
            ->add('price')
            ->add('center')
            ->add('admin')
            ->add('sport')
            ->add('players')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
             ->add('description',null, array('label' => 'Descripcion'))
            ->add('gameDate',null, array('label' => 'Fecha del Partido'))
            ->add('limitDate',null, array('label' => 'Fecha límite de Baja'))
            ->add('created',null, array('label' => 'Fecha de Creacion'))
            ->add('numPlayers',null, array('label' => 'Número de jugadores'))
            ->add('price',null, array('label' => 'Precio'))
            ->add('center',null, array('label' => 'Instalación'))
            ->add('admin',null, array('label' => 'Creador'))
            ->add('sport',null, array('label' => 'Deporte'))
            ->add('players',null, array('label' => 'Jugadores'))
        ;
    }
    
    protected $datagridValues = array(
        '_page'       => 1,
        '_sort_order' => 'DESC', // sort direction
        '_sort_by' => 'gameDate' // field name
    );
}
