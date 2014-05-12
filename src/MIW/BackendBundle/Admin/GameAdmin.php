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
            ->add('name')
            ->add('description')
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
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('description')
            ->add('gameDate')
            ->add('limitDate')
            ->add('created')
            ->add('numPlayers')
            ->add('price')
            ->add('center')
            ->add('admin')
            ->add('sport')
            ->add('players')
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
            ->add('name')
            ->add('description')
            ->add('gameDate')
            ->add('limitDate')
            ->add('created')
            ->add('numPlayers')
            ->add('price')
            ->add('center.name')
            ->add('admin')
            ->add('sport.name')
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
            ->add('name')
            ->add('description')
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
}
