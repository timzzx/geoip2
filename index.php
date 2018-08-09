<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once __DIR__ . '/vendor/autoload.php';
use Workerman\Worker;
use GeoIp2\Database\Reader;

// 创建一个Worker监听2345端口，使用http协议通讯
$http_worker = new Worker("http://0.0.0.0:2345");

// 启动4个进程对外提供服务
$http_worker->count = 4;

// 接收到浏览器发送的数据时回复hello world给浏览器
$http_worker->onMessage = function($connection, $data)
{
    $ip = "";
    if(!empty($data['get']['ip'])) {
        $ip = $data['get']['ip'];
    }
    
    if(!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        $datas['errno'] = 500;
        $datas['msg'] = "ip error";
        return $connection->send(json_encode($datas));
    }
    
    $reader = new Reader(dirname(__FILE__).'/GeoLite2-City.mmdb');
    $record = $reader->city($ip);

    $datas['errno'] = 200;
    $datas['isoCode'] = $record->country->isoCode;
    $datas['country_name'] = $record->country->name;
    $datas['country_name_zh'] = $record->country->names['zh-CN'];
    $datas['mostSpecificSubdivisionname'] = $record->mostSpecificSubdivision->name;
    $datas['mostSpecificSubdivisionisoCode'] = $record->mostSpecificSubdivision->isoCode;
    $datas['city_name'] = $record->city->name;
    $datas['city_name_zh'] = @$record->city->names['zh-CN'];
    $datas['postal_code'] = $record->postal->code;
    $datas['latitude'] = $record->location->latitude;
    $datas['longitude'] = $record->location->longitude;
    
    // 向浏览器发送hello world
    return $connection->send(json_encode($datas));
};

// 运行worker
Worker::runAll();