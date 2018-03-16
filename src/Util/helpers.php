<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/2/28
 * Time: 上午10:56
 */
if (!function_exists('checkExtension')){
    function checkExtension($enabled_extension){
        $extensions = get_loaded_extensions();
        if ($extensions) {
            foreach ($enabled_extension as $item) {
                if (!in_array($item, $extensions)) {
                    throw new \Pingqu\OpenApiSdk\Core\Exceptions\ClientException("Extension {" . $item . "} is not installed or not enabled, please check your php env.");
                }
            }
        }
        return true;
    }
}