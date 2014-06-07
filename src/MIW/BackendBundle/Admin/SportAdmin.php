<?php

namespace MIW\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SportAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id',null, array('label' => 'Id'))
            ->add('name',null, array('label' => 'Nombre'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name',null, array('label' => 'Nombre'))
            ->add('description',null, array('label' => 'Descripción'))
            ->add('minPlayers',null, array('label' => 'Jugadores Recomendados'))
 
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
            ->add('name',null, array('label' => 'Nombre'))
            ->add('description',null, array('label' => 'Descripción'))
            ->add('minPlayers',null, array('label' => 'Jugadores Recomendados'))

        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name',null, array('label' => 'Nombre'))
            ->add('description',null, array('label' => 'Descripción'))
            ->add('minPlayers',null, array('label' => 'Jugadores Recomendados'))
    
        ;
    }
}
