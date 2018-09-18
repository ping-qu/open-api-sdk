<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/2/23
 * Time: 下午7:08
 */
namespace Pingqu\OpenApiSdk\Transcode\File;

use Pingqu\OpenApiSdk\Core\Exceptions\ClientException;
use Pingqu\OpenApiSdk\Core\Http\Request;
use Pingqu\OpenApiSdk\Model\VideoJobModel;
use Pingqu\OpenApiSdk\Transcode\abstractClass;
use Pingqu\OpenApiSdk\Transcode\Client;
use Pingqu\OpenApiSdk\Core\Http\HttpBase;
use Pingqu\OpenApiSdk\Core\Auth\Signature;

class Job extends abstractClass
{

    public function add($inputFile,$output_path,$pipeline_id){

        $request = new Request();
        $postParams = array(
            'input_file'=>$inputFile,
            'output_path'=>$output_path,
            'pipeline_id'=>$pipeline_id,
        );
        if (isset($this->callback_url)){
            $postParams['callback_url'] = $this->callback_url;
        }
        if (isset($this->callback_params)){
            $postParams['callback_params'] = $this->callback_params;
        }
        $query = ['access_key_id'=>$this->client->getAccessKeyId()];
        $signature = Signature::getSign($postParams,$query,'POST',$this->client->getAccessKeySecret());
        $request->setParams($postParams);
        $request->setHeader(['Authorization'=>$signature,'Is-Open-Api'=>1,'Open_Api_Type'=>'transcode']);
        $request->setRequestUrl($this->domain.'/open_api/v1/file/job');
        $request->setQuery($query);
        $request->setMethod('POST');
        $response = HttpBase::curl($request);
        return $response->getBody();
    }

}