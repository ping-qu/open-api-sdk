<?php
namespace Pingqu\OpenApiSdk\Core\Middleware;

class MiddlewareStock
{

    public $stock = [];


    public function getStock(){
        return $this->stock;
    }

//    public function push(Middleware $middleware){
//        $this->stock[] = $middleware;
//    }

    public function push(Middleware $middleware, $name = ''){
        $this->stock[$name] = $middleware->handle();
    }

    public function pop($name){
        unset($this->stock[$name]);
    }

    //打包
    public function pack($handler){
        foreach(array_reverse($this->stock) as $key => $fn){
            $handler = $fn($handler);
        }
        return $handler;
    }


}