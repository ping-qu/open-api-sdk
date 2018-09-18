<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/6/8
 * Time: 上午10:51
 */

namespace Pingqu\OpenApiSdk\Core\Middleware;


class ResponseMiddleware implements Middleware
{
    public function handle(){
        function($handler){
            return function($name)use($handler){
                $return = $handler($name);
                echo "test1?\n";
                return $return;
            };
        };
    }
}