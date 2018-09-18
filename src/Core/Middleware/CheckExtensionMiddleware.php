<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/6/7
 * Time: 下午5:55
 */
namespace Pingqu\OpenApiSdk\Core\Middleware;

class CheckExtensionMiddleware implements Middleware
{
//    public function handle(){
//        return function() {
//            $needExtension = ['curl'];
//            foreach ($needExtension as $key=>$item) {
//                if (!extension_loaded($item)){
//                    throw new \Exception('缺少扩展'.$item);
//                }
//            }
//            return true;
//        };
//    }

    public function handle()
    {
        $closure = function($handler){
            return function($name)use($handler){
                echo 'test2'."\n";
                return $handler($name); // weather_return_handler行
            };
        };
        return $closure;
    }
}