<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/2/24
 * Time: 下午5:25
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

    public function __construct($input_file,$output_file,$preset_id,$pipeline_id)
    {
        if (substr($input_file, 0, 1) === '/') {
            $input_file = substr($input_file, 1);
        }
        if (substr($output_file, 0, 1) === '/') {
            $output_file = substr($output_file, 1);
        }
        $this->input_file = $input_file;
        $this->output_file = $output_file;
        $this->preset_id = $preset_id;
        $this->pipeline_id = $pipeline_id;
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
}