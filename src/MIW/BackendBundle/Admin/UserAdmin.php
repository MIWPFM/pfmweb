<?php

namespace MIW\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('username', null, array('label' => 'Nombre de Usuario'))
                ->add('email', null, array('label' => 'Email'))
                ->add('enabled', null, array('label' => 'Activado'))
                ->add('name', null, array('label' => 'Nombre'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('username', null, array('label' => 'Nombre de Usuario'))
                ->add('email', null, array('label' => 'Email'))
                ->add('enabled', null, array('label' => 'Activado', 'editable' => true))
                ->add('lastLogin', 'date', array('format' => 'd/m/Y H:i', 'label' => 'Última Conexión '))
                ->add('created', 'date', array('format' => 'd/m/Y H:i', 'label' => 'Fecha Creación'))
                ->add('_action', 'actions', array(
                    'label' => 'Acciones',
                    'actions' => array(
                        'show' => array(),
                        'edit' => array()
                    )
                ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('Datos Genéricos')
                    ->add('username', null, array('label' => 'Usuario'))
                    ->add('email', null, array('label' => 'Email'))
                    ->add('enabled', null, array('label' => 'Activado'))
                ->with('Cambiar contraseña')
                     ->add('plainPassword', 'password', array('label' => 'Contaseña','required'=>false))

        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->with('Datos Genéricos')
                ->add('id', null, array('label' => 'MongoID'))
                ->add('username', null, array('label' => 'Nombre de Usuario'))
                ->add('email', null, array('label' => 'Email'))
                ->add('enabled', null, array('label' => 'Activado'))
                ->add('salt', null, array('label' => 'Salt'))
                ->add('password', null, array('label' => 'Contraseña'))
                ->add('lastLogin', 'date', array('format' => 'd/m/Y H:i', 'label' => 'Última Conexión'))
                ->add('created', 'date', array('format' => 'd/m/Y H:i', 'label' => 'Fecha Creación'))
                ->add('roles', null, array('label' => 'Roles'))
                ->with('Datos Personales')
                ->add('name', null, array('label' => 'Nombre'))
                ->add('birthday', 'date', array('format' => 'd/m/Y', 'label' => 'Fecha de Nacimiento'))
                ->add('address.address', null, array('label' => 'Dirección'))
                ->add('address.province', null, array('label' => 'Provincia'))
        ;
    }

    public function prePersist($user) {
        if($user->getPlainPassword()){
            $this->encodeUserPassword($user);
        }
    }

    public function preUpdate($user) {
        if($user->getPlainPassword()){
            $this->encodeUserPassword($user);
        }
    }

    private function encodeUserPassword($user) {
        $container=$this->getConfigurationPool()->getContainer();
        $encoder = $container->get('security.encoder_factory')->getEncoder($user);
        $cryptedPassword = $encoder->encodePassword($user->getPlainPassword(), $user->getSalt());
        $user->setPassword($cryptedPassword);
    }

}
