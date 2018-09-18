<?php
/**
 * Created by PhpStorm.
 * User: yuelin
 * Date: 2018/2/23
 * Time: 下午6:51
 */
namespace Pingqu\OpenApiSdk\Transcode;


use Pingqu\OpenApiSdk\Core\Exceptions\ClientException;
use Pingqu\OpenApiSdk\Core\Middleware\CheckExtensionMiddleware;
use Pingqu\OpenApiSdk\Core\Middleware\MiddlewareStock;
use Pingqu\OpenApiSdk\Core\Middleware\ResponseMiddleware;
use Pingqu\OpenApiSdk\Transcode\File\Job as FileJob;
use Pingqu\OpenApiSdk\Transcode\Video\Job as VideoJob;
use Pingqu\OpenApiSdk\Transcode\Video\Preset;
use Pingqu\OpenApiSdk\Transcode\Live\Job as LiveJob;

class Client
{
    private $accessKeyId;
    private $accessKeySecret;
    //private static $domain = 'http://yun.linyue.hznwce.com';
    private static $requireExtension = ['curl'];
    private static $domain = 'http://service.cloud.ping-qu.com';
    public function __construct($accessKeyId,$accessKeySecret)
    {
        if (!is_string($accessKeyId) || !is_string($accessKeySecret)) {
            throw new ClientException("Invalid appKey or masterSecret");
        }
        $this->accessKeyId = trim($accessKeyId);
        $this->accessKeySecret = trim($accessKeySecret);
        //checkExtension(self::$requireExtension);
        $middlewareStock = new MiddlewareStock();
        $middlewareStock->push(new CheckExtensionMiddleware(),'check_extension');

    }

    public function VideoJob(){
        return new VideoJob($this);
    }

    public function LiveJob(){
        return new LiveJob($this);
    }

    public function FileJob(){
        return new FileJob($this);
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