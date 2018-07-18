<?php

namespace App\phpappbuilder\router;

use Symfony\Component\Routing\RouteCollection as RC;
use Symfony\Component\Routing\Route as RouteObject;

class RouteCollection
{
    protected $collection;

    protected $RoutePrefix = '';
    protected $NamePrefix = '';

    protected $_route;
    protected $_controller;
    protected $_action;
    protected $requirements;
    protected $options;
    protected $host;
    protected $schemes;
    protected $methods;
    protected $condition;

    function __construct()
    {
        $this->__before();
        $this->collection = new RC();
        foreach (get_class_methods($this) as $key => $value)
            {
                if ($value!='__construct' && $value!='__collection' && $value!='__after' && $value!='__before' && $value!='__return') {
                    $this->_route = '';
                    $this->_controller = '';
                    $this->_action = '';
                    $this->requirements = [];
                    $this->options = [];
                    $this->host = '';
                    $this->schemes = [];
                    $this->methods = [];
                    $this->condition = '';

                    $this->$value();
                    $default['_controller'] = $this->_controller;
                    if (isset($this->_action) && $this->_action != '') {
                        $default['_action'] = $this->_action;
                    }
                    $object = new RouteObject($this->_route, $default);
                    $object->addRequirements($this->requirements);
                    $object->setOptions($this->options);
                    $object->setHost($this->host);
                    $object->setSchemes($this->schemes);
                    $object->setMethods($this->methods);
                    $object->setCondition($this->condition);
                    $this->collection->add($value, $object);
                }
             }
    }

    public function __before(){

    }

    public function __after(){

    }

    public function __collection()
        {
            if ($this->NamePrefix != '') {$this->collection->addNamePrefix($this->NamePrefix);}
            if ($this->RoutePrefix != '') {$this->collection->addPrefix($this->RoutePrefix);}
        }

    public function __return()
        {
            $this->__after();
            $this->__collection();
            return $this->collection;
        }
}