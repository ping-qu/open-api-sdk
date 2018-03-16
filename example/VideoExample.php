<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/2/23
 * Time: 下午6:55
 */

class VideoExample
{
    public function addVideoJob(){
        $client = new \Pingqu\OpenApiSdk\Transcode\Client('access_key_id','access_key_secret');
        $res = $client->VideoJob()
            ->setCallbackUrl(\Request::getSchemeAndHttpHost().'/api/callback')  //设置回调地址
            ->setCallbackParams('ddddd')//设置回调参数
            ->add('source/video/00b284a6a24577daa500d46e401d0c13.mp4','source/video/test/00b284a6a24577daa500d46e401d0c13.m3u8',5,7);
        var_dump(json_decode($res,true));
    }

    //删除未开始转码的任务
    public function deleteVideoJob(){
        $client = new \Pingqu\OpenApiSdk\Transcode\Client('access_key_id','access_key_secret');
        $res = $client->VideoJob()->delete(2901);
        var_dump(json_decode($res,true));
    }
    //修改任务参数并重新转码,$update里面的参数选
    public function update(){
        $client = new \Pingqu\OpenApiSdk\Transcode\Client('access_key_id','access_key_secret');
        $update = [
            'input_file'=>'video/source/video/178f7cd1d5e3d98434a3c1e639535b2e.mp4',
            'output_file'=>'source/video/test/178f7cd1d5e3d98434a3c1e639535b2e1.m3u8',
            'preset_id'=>1,
            'pipeline_id'=>2
        ];
        $res = $client->VideoJob()->tryAgain(2901,$update);
        var_dump(json_decode($res,true));
    }

    public function addVideoPreset(){
        $client = new \Pingqu\OpenApiSdk\Transcode\Client('access_key_id','access_key_secret');
        $res = $client->VideoPreset()
            //必须设置
            ->setName('test')
            ->setContainer('HLS')
            //可选设置
            ->setVideoBitRateBps(800)
            ->setAudioBitRateBps(192)
            ->setVideoProfile('Main')
            ->setFrameRate(30) //帧率
            ->setAudioChannel(1) //设置声道数，1为单声道，2为双声道，0表示保持与输入一致，默认为0
            ->setPixel(360,720) //设置分辨率，默认为原宽高
            ->add();
        var_dump(json_decode($res,true));
    }
}