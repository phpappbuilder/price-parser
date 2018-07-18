<?php
namespace App\phpappbuilder\router;

use Space\Get as Space;
use Symfony\Component\Routing;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Response;


class Router
{
    private $collection;

    public function __construct()
        {
            $this->collection = new RouteCollection();
            $space = Space::Collection('phpappbuilder/router/collection');
            if($space!=NULL && count($space)>0)
            {
                foreach($space as $key => $value)
                {
                    $router = new $value();
                    $this->collection->addCollection($router->__return());
                }
            }
        }

    public function run()
        {

            $request = Request::createFromGlobals();
            $context = new RequestContext();
            $context->fromRequest($request);
            $matcher = new UrlMatcher($this->collection, $context);

            try {

                $info = $matcher->match($request->getPathInfo());

                $controller = $info['_controller'];
                if (!isset($info['_action']) or $info['_action']=='') {$info['action']='index'; $action = 'index';}
                else {$action = $info['_action'];}
                $get = new $controller($info , $request);
                return $get -> $action();

            } catch (Routing\Exception\ResourceNotFoundException $exception) {

                $response = Space::Key('phpappbuilder/router/err404');
                $response -> send();
            } catch (Exception $exception) {
                $response = Space::Key('phpappbuilder/router/err500');
                $response -> send();
            }

        }

    static function url($route_name , $args , $absolute = false)
        {
            $collection = new RouteCollection();
            $space = Space::Collection('phpappbuilder/router/collection');
            if($space!=NULL && count($space)>0)
            {
                foreach($space as $key => $value)
                {
                    $router = new $value();
                    $collection->addCollection($router->__return());
                }
            }
            $context = new RequestContext('');
            $generator = new Routing\Generator\UrlGenerator($collection, $context);
            if (!$absolute){return $generator->generate($route_name, $args);}
            else {return $generator->generate($route_name, $args , UrlGeneratorInterface::ABSOLUTE_URL);}
        }
}