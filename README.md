屏趣云SDK
======================

简介
----------------------
接入屏趣云开发接口官方sdk，现阶段包括视频转码，直播推流、转码等，使用需要在屏趣云后台申请
access_key_id和access_key_secret

## 一、安装
```angular2html
composer require ping-qu/open-api-sdk
```

## 二、接入
### 1、转码
转码包括视频转码和直播转码

#### 1、视频转码

#####


##### 添加转码任务
```angular2html
$client = new Client($access_key_id,$access_key_secret);
$res = $client
          ->VideoJob()
          ->setCallbackUrl($callback_url) //设置转码结果通知url
          ->setCallbackParams('test')
          ->add($input_path,$output_file,$preset_id,$pipeline_id);
```


