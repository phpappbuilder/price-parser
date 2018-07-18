<?php
namespace App\phpappbuilder\controller;

use App\phpappbuilder\controller\Response as Resp;

class Controller
{
    public $request;
    public $response;
    public $arg;
    public $route;
    public $controller;
    public $action;

    function __construct($args, $request)
        {
            $this->route = $args['_route']; unset($args['_route']);
            $this->controller = $args['_controller']; unset($args['_controller']);
            if (isset($args['_action']) && $args['_action']!=''){$this->action = $args['_action']; unset($args['_action']);}
            else {$this->action = 'index';}
            $this->arg = $args; unset($args);
            $this->request = $request;
            $this->response = new Resp();
        }

}