<?php

namespace App\my\example;

use App\phpappbuilder\router\RouteCollection;
use App\my\example\TestController;

class Route extends RouteCollection
{
    protected $NamePrefix = 'MyExample';
    public function FirstRoute()
        {
            $this->_route = '';
            $this->_controller = TestController::class;
            $this->_action = 'pt';
        }
}