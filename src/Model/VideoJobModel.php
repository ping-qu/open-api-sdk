<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/2/24
 * Time: 下午5:25
 * 参数类型的校验在model层完成
 */
namespace Pingqu\OpenApiSdk\Model;

use Pingqu\OpenApiSdk\Core\Exceptions\ClientException;

class VideoJobModel
{
    private $pipeline_id;
    private $input_file;
    private $output_file;
    private $preset_id;
    private $callback_url;
    private $type = 'video';
    private $job_id;
    public function __construct($job_id = null)
    {
        if ($job_id !== null && (!is_integer($job_id) || $job_id<=0)){
            throw new ClientException('job_id不合法');
        }
        $this->job_id = $job_id;
    }

    public function setInputFile($input_file){
        if (!is_string($input_file)){
            throw new ClientException('input_file参数格式不正确');
        }
        if (substr($input_file, 0, 1) === '/') {
            $input_file = substr($input_file, 1);
        }
        $this->input_file = $input_file;
    }

    public function setOutputFile($output_file){
        if (!is_string($output_file)){
            throw new ClientException('output_file参数格式不正确');
        }
        if (substr($output_file, 0, 1) === '/') {
            $output_file = substr($output_file, 1);
        }
        $this->output_file = $output_file;
    }

    public function setPresetId($preset_id){
        if (!is_integer($preset_id)){
            throw new ClientException('模板id必须为整数');
        }
    }

    public function setPipelineId($pipeline_id){
        if (!is_integer($pipeline_id)){
            throw new ClientException('队列id必须为整数');
        }
    }

    public function getCallbackUrl(){
        return $this->callback_url;
    }

    public function getInputFile(){
        return $this->input_file;
    }

    public function getOutputFile(){
        return $this->output_file;
    }

    public function getType(){
        return $this->type;
    }

    public function getPresetId(){
        return $this->preset_id;
    }

    public function getPipelineId(){
        return $this->pipeline_id;
    }
}