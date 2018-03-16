<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/2/23
 * Time: 下午7:09
 */
namespace Pingqu\OpenApiSdk\Transcode\Live;

use App\Exceptions\ApiException;
use Pingqu\OpenApiSdk\Core\Auth\Signature;
use Pingqu\OpenApiSdk\Core\Exceptions\ClientException;
use Pingqu\OpenApiSdk\Core\Http\HttpBase;
use Pingqu\OpenApiSdk\Core\Http\Request;
use Pingqu\OpenApiSdk\Transcode\Client;

class Job
{
    private $upload_path;
    private $preset_id_arr;
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->domain = $client->getDomain();
    }

    public function setUploadPath($path){
        if (substr($path,0,1) != '/'||!is_string($path)){
            throw new ClientException('路径不符合规则');
        }
        $this->upload_path = rtrim($path);
        return $this;
    }

    private function getUploadPath(){
        if (empty($this->upload_path)){
            throw new ClientException('请设置上传路径');
        }
        return $this->upload_path;
    }


    public function add(array $preset_id,$oss_id){
        if (!is_array($preset_id)||!is_integer($oss_id)){
            throw new ClientException('参数类型错误');
        }
        $request = new Request();
        $postParams = array(
            'preset_id'=>$preset_id,
            'oss_id'=>$oss_id,
            'path'=>$this->getUploadPath()
        );
        $query = ['access_key_id'=>$this->client->getAccessKeyId()];
        $signature = Signature::getSign($postParams,$query,'POST',$this->client->getAccessKeySecret());
        $request->setParams($postParams);
        $request->setHeader(['Authorization'=>$signature,'Is-Open-Api'=>1,'Open_Api_Type'=>'transcode']);
        $request->setRequestUrl($this->domain.'/open_api/v1/live/job');
        $request->setQuery($query);
        $request->setMethod('POST');
        $response = HttpBase::curl($request);
        return $response->getBody();
    }


}