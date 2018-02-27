<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/2/23
 * Time: 下午6:51
 */
namespace Pingqu\OpenApiSdk\Transcode;


use Pingqu\OpenApiSdk\Core\Exceptions\ClientException;
use Pingqu\OpenApiSdk\Transcode\Video\Job;
use Pingqu\OpenApiSdk\Transcode\Video\Preset;

class Client
{
    private $accessKeyId;
    private $accessKeySecret;
    private static $domain = 'http://service.cloud.ping-qu.com';
    public function __construct($accessKeyId,$accessKeySecret)
    {
        if (!is_string($accessKeyId) || !is_string($accessKeySecret)) {
            throw new ClientException("Invalid appKey or masterSecret");
        }
        $this->accessKeyId = trim($accessKeyId);
        $this->accessKeySecret = trim($accessKeySecret);
    }

    public function VideoJob(){
        return new Job($this);
    }

    public function VideoPreset(){
        return new Preset($this);
    }

    public function getAccessKeyId(){
        return $this->accessKeyId;
    }

    public function getAccessKeySecret(){
        return $this->accessKeySecret;
    }

    public function getDomain(){
        return self::$domain;
    }
}