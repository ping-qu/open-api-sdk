<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/9/18
 * Time: 下午2:37
 */

namespace Pingqu\OpenApiSdk\Transcode;


use Pingqu\OpenApiSdk\Core\Exceptions\ClientException;

abstract class abstractClass
{

    protected $client;

    protected $callback_url;
    protected $callback_params;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->domain = $client->getDomain();
    }

    public function setCallbackUrl($url){
        $this->callback_url = $url;
        return $this;
    }

    public function setCallbackParams($params){
        if (!is_string($params)){
            throw new ClientException('自定义回调参数只能是字符串类型');
        }
        $this->callback_params = $params;
        return $this;
    }

}