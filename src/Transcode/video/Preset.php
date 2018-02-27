<?php
namespace Pingqu\OpenApiSdk\Transcode\Video;
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/2/23
 * Time: 下午7:09
 */
use Pingqu\OpenApiSdk\Core\Exceptions\ClientException;
use Pingqu\OpenApiSdk\Core\Http\Request;
use Pingqu\OpenApiSdk\Core\Auth\Signature;
use Pingqu\OpenApiSdk\Transcode\Client;
use Pingqu\OpenApiSdk\Core\Http\HttpBase;

class Preset
{


    private $client;
    private $name;
    private $container;
    private $rate = 800;//视频比特率
    private $domain;
    private static $supportContainer = ['HLS','MP4'];
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->domain = $client->getDomain();
    }

    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function setContainer($container){
        if (!in_array($container,self::$supportContainer)){
            $constr = '';
            foreach (self::$supportContainer as $key=>$item) {
                $constr=$constr.$item.',';
            }
            throw new ClientException('目前仅支持'.trim($constr,',').'视频容器');
        }
        $this->container = $container;
        return $this;
    }

    public function setBitRateBps($rate){
        $this->rate = $rate;
        return $this;
    }

    public function getName(){
        if (empty($this->name)){
            throw new ClientException('必须设置模板名称');
        }
        return $this->name;
    }

    public function getContainer(){
        if (empty($this->container)){
            throw new ClientException('必须设置视频容器类型');
        }
        return $this->container;
    }

    public  function add(){
        $request = new Request();
        $postParams = array(
            'name' => $this->getName(),
            'container'=>$this->getContainer(),
            'bit_rate'=>$this->rate
        );
        $query = ['access_key_id'=>$this->client->getAccessKeyId()];
        $signature = Signature::getSign($postParams,$query,'POST',$this->client->getAccessKeySecret());
        $request->setParams($postParams);
        $request->setHeader(['Authorization'=>$signature,'Is-Open-Api'=>1,'Open_Api_Type'=>'transcode']);
        $request->setRequestUrl($this->domain.'/open_api/v1/video/preset');
        $request->setQuery($query);
        $request->setMethod('POST');
        $response = HttpBase::curl($request);
        return $response->getBody();
    }
}