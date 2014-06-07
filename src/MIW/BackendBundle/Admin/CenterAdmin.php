<?php

namespace MIW\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CenterAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name',null, array('label' => 'Nombre'))
            ->add('address.address',null, array('label' => 'Dirección'))
            ->add('address.province',null, array('label' => 'Provincia'))
            ->add('address.city',null, array('label' => 'Ciudad'))
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
            ->add('address.address',null, array('label' => 'Dirección'))
            ->add('address.province',null, array('label' => 'Provincia'))
            ->add('address.city',null, array('label' => 'Ciudad'))
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
            ->add('name',null, array('label' => 'Nombre'))
            ->add('description',null, array('label' => 'Descripción'))

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
            ->add('address.address',null, array('label' => 'Dirección'))
            ->add('address.city',null, array('label' => 'Ciudad'))
            ->add('address.province',null, array('label' => 'Provincia'))
            ->add('address.community',null, array('label' => 'Comunidad'))
            ->add('address.coordinates.x',null, array('label' => 'Latitud'))
            ->add('address.coordinates.y',null, array('label' => 'Longitud'))
        ;
    }
}
