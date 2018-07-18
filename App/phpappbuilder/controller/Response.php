<?php
/**
 * Created by PhpStorm.
 * User: server
 * Date: 30.06.18
 * Time: 14:16
 */

namespace App\phpappbuilder\controller;

use \Symfony\Component\HttpFoundation\Response as Resp;
//use Tracy\Debugger;

class Response extends Resp
{
    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }
}