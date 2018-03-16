<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/2/23
 * Time: 下午7:08
 */
namespace Pingqu\OpenApiSdk\Transcode\Video;

use Pingqu\OpenApiSdk\Core\Exceptions\ClientException;
use Pingqu\OpenApiSdk\Core\Http\Request;
use Pingqu\OpenApiSdk\Model\VideoJobModel;
use Pingqu\OpenApiSdk\Transcode\Client;
use Pingqu\OpenApiSdk\Core\Http\HttpBase;
use Pingqu\OpenApiSdk\Core\Auth\Signature;

class Job
{
    private $client;

    private $callback_url;
    private $callback_params;


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


    public function add($inputFile, $outputFile,$presetId, $pipelineId){
        if (!is_string($inputFile)||!is_string($outputFile)||!is_integer($presetId)||!is_integer($pipelineId)){
            throw new ClientException('添加视频转码任务参数类型错误');
        }
        $job = new VideoJobModel();
        $job->setInputFile($inputFile);
        $job->setOutputFile($outputFile);
        $job->setPresetId($presetId);
        $job->setPipelineId($pipelineId);
        $request = new Request();
        $postParams = array(
            'input_file'=>$job->getInputFile(),
            'output_file'=>$job->getOutputFile(),
            'file_type'=>$job->getType(),
            'preset_id'=>$job->getPresetId(),
            'pipeline_id'=>$job->getPipelineId(),
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
        $request->setRequestUrl($this->domain.'/open_api/v1/video/job');
        $request->setQuery($query);
        $request->setMethod('POST');
        $response = HttpBase::curl($request);
        return $response->getBody();
    }

    public function delete($job_id){
        if (!is_integer($job_id)){
            throw new ClientException('job_id必须为整型');
        }
        $request = new Request();
        $query = ['access_key_id'=>$this->client->getAccessKeyId()];
        $signature = Signature::getSign([],$query,'DELETE',$this->client->getAccessKeySecret());
        $request->setHeader(['Authorization'=>$signature,'Is-Open-Api'=>1,'Open_Api_Type'=>'transcode']);
        $request->setRequestUrl($this->domain.'/open_api/v1/video/job/'.$job_id);
        $request->setQuery($query);
        $request->setMethod('DELETE');
        $response = HttpBase::curl($request);
        return $response->getBody();
    }


    public function get($pipeline_id){
        if (!is_integer($pipeline_id)){
            throw new ClientException('job_id必须为整型');
        }
        $request = new Request();
        $query = ['access_key_id'=>$this->client->getAccessKeyId(),'pipeline_id'=>$pipeline_id];
        $signature = Signature::getSign([],$query,'GET',$this->client->getAccessKeySecret());
        $request->setHeader(['Authorization'=>$signature,'Is-Open-Api'=>1,'Open_Api_Type'=>'transcode']);
        $request->setRequestUrl($this->domain.'/open_api/v1/video/job');
        $request->setQuery($query);
        $request->setMethod('GET');
        $response = HttpBase::curl($request);
        return $response->getBody();
    }
    //更新并重新转码
    public function tryAgain($id,array $data){
        $job = new VideoJobModel($id);
        $job->setInputFile(isset($data['input_file'])?$data['input_file']:'');
        $job->setOutputFile(isset($data['output_file'])?$data['output_file']:'');
        $job->setPresetId(isset($data['preset_id'])?$data['preset_id']:'');
        $job->setPipelineId(isset($data['pipeline_id'])?$data['pipeline_id']:'');
        $postData = array();
        if (!empty($job->getInputFile())){
            $postData['input_file'] = $job->getInputFile();
        }
        !empty($job->getOutputFile())?$postData['output_file'] = $job->getOutputFile():null;
        !empty($job->getPresetId())?$postData['preset_id'] = $job->getPresetId():null;
        !empty($job->getPipelineId())?$postData['pipeline_id'] = $job->getPipelineId():null;
        $request = new Request();
        $query = ['access_key_id'=>$this->client->getAccessKeyId()];
        $signature = Signature::getSign($data,$query,'PUT',$this->client->getAccessKeySecret());
        $request->setHeader(['Authorization'=>$signature,'Is-Open-Api'=>1,'Open_Api_Type'=>'transcode']);
        $request->setRequestUrl($this->domain.'/open_api/v1/video/job/'.$id);
        $request->setParams($postData);
        $request->setQuery($query);
        $request->setMethod('PUT');
        $response = HttpBase::curl($request);
        return $response->getBody();
    }
}