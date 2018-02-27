<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/2/23
 * Time: 下午6:55
 */

class Example
{
    public function addVideoJob(){
        $access_key_id = 'S2s8dh9tcs2e1ueB';
        $access_key_secret = 'dfd2ern2dD2KFSd2f3krn3fafd33sSf';
        $client = new \Pingqu\OpenApiSdk\Transcode\Client($access_key_id,$access_key_secret);
        $res = $client->VideoJob()
            ->setCallbackUrl(\Request::getSchemeAndHttpHost().'/api/callback')
            ->add('source/video/00b284a6a24577daa500d46e401d0c13.mp4','source/video/test/00b284a6a24577daa500d46e401d0c13.m3u8',5,7);
        var_dump($res);
    }
}