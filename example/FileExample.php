<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/3/16
 * Time: 下午4:50
 */

class FileExample
{
    public function addLive(){
        $access_key_id = 'S2s8dh9tcs2e1ueB';
        $access_key_secret = 'dfd2ern2dD2KFSd2f3krn3fafd33sSf';
        $client = new \Pingqu\OpenApiSdk\Transcode\Client($access_key_id,$access_key_secret);
        $res = $client->FileJob()
            ->setCallbackUrl(\Request::getSchemeAndHttpHost().'/api/callback')  //设置回调地址
            ->add('ppt/dfaldfj232l.pdf','ppt/output',1);
    }
}