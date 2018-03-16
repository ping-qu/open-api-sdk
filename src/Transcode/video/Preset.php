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

    private $video_rate_bps = 800;//视频比特率

    private $audio_rate_bps = 128;

    private $domain;

    private $frame_rate = 'Auto';

    private $video_profile;

    private $video_width_in_pixel = 'Auto';

    private $video_height_in_pixel = 'Auto';

    private $audio_channels = 0; //声道数，常用值为1或2；0表示保持与输入一致，若指定声道数大于输入声道数，则使用输入声道数
    private static $supportContainer = ['HLS','MP4'];
    private static $supportVideoProfile  = ['Baseline', 'Main', 'High'];
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

    public function setVideoBitRateBps($rate){
        if (!is_integer($rate)||!($rate<=1200&&$rate>=200)){
            throw new ClientException('视频码率必须是整数并且大于200小于1200');
        }
        $this->video_rate_bps = $rate;
        return $this;
    }

    public function setAudioBitRateBps($rate){
        if (!is_integer($rate)||!($rate<=192&&$rate>=40)){
            throw new ClientException('视频码率必须是整数并且大于200小于1200');
        }
        $this->audio_rate_bps = $rate;
        return $this;
    }

    public function setFrameRate($rate){
        if (!is_integer($rate)||!($rate<=60&&$rate>=10)){
            throw new ClientException('视频帧率必须是整数并且大于10小于60');
        }
        $this->frame_rate = $rate;
        return $this;
    }
    //编码规格
    public function setVideoProfile($profile){
        if (!in_array($profile,self::$supportVideoProfile)){
            $constr = '';
            foreach (self::$supportVideoProfile as $key=>$item) {
                $constr=$constr.$item.',';
            }
            throw new ClientException('编码规格仅支持'.trim($constr,','));
        }
        $this->video_profile = $profile;
        return $this;
    }
    //声道
    public function setAudioChannel($channels){
        if (!is_integer($channels)||$channels>3){
            throw new ClientException('声道数必须为整数并且不能大于2');
        }
        return $this;
    }
    //分辨率
    public function setPixel($width,$height){
        if (!is_integer($width)||!is_integer($height)){
            throw new ClientException('分辨率的宽高必须是整数');
        }
        $this->video_width_in_pixel = $width;
        $this->video_height_in_pixel = $height;
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
            'preset_name' => $this->getName(),
            'preset_container'=>$this->getContainer(),
            'video_bit_rate_in_bps'=>$this->video_rate_bps,
            'audio_bit_rate_in_bps'=>$this->audio_rate_bps,
            'video_max_frame_rate'=>$this->frame_rate,
            'video_profile'=>$this->video_profile,
            'video_max_width_in_pixel'=>$this->video_width_in_pixel,
            'video_max_height_in_pixel'=>$this->video_height_in_pixel,
            'audio_channels'=>$this->audio_channels
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