<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/2/24
 * Time: 下午5:25
 */
namespace Pingqu\OpenApiSdk\Model;

use Pingqu\OpenApiSdk\Core\Exceptions\ClientException;

class VideoPresetModel
{

    private $name;
    public function __construct()
    {
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }


}