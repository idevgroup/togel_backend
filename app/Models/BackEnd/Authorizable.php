<?php

namespace App\Models\BackEnd;
use Config;
trait Authorizable
{
    /**
     * Abilities
     *
     * @var array
     */
    private $abilities = [
        'index' => 'view',
        'edit' => 'edit',
        'show' => 'view',
        'update' => 'edit',
        'create' => 'add',
        'store' => 'add',
        'destroy' => 'delete',
        'status' => 'edit',
        'multstatus' => 'edit'
    ];

    /**
     * Override of callAction to perform the authorization before it calls the action
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function callAction($method, $parameters)
    {

        if( $ability = $this->getAbility($method) ) {
            $this->authorize($ability);
        }

        return parent::callAction($method, $parameters);
    }

    /**
     * Get ability
     *
     * @param $method
     * @return null|string
     */
    public function getAbility($method)
    {
        $routeName = explode('.', \Request::route()->getName());
        $action = array_get($this->getAbilities(), $method);
        $prefix = Config::get('sysconfig.prefix');
        $len = strlen($prefix);
        $str = substr($routeName[0], $len);
        return $action ? $action . '_' . $str : null;
    }

    /**
     * @return array
     */
    private function getAbilities()
    {

        return $this->abilities;
    }

    /**
     * @param array $abilities
     */
    public function setAbilities($abilities)
    {

        $this->abilities = $abilities;
    }
}
