<?php
namespace Pay;

$config = [];

#请求方式，目前常用的是AopClient
$config['type'] = 'AopClient';
#一些基本的参数格式
$config['params'] = [
    'format' => 'json',
    'charset' => 'GBK',
    'signType' => 'RSA2',
];
#一些APP参数，sign和appid
#如果业务开启测试模式，则使用这里的默认沙箱环境，否则必须业务放传递相关参数
$config['app'] = [
    'appid' => '2016091500518317',
    'privateKey' => '',
    'publicKey' => '',
    'gateWay' => 'https://openapi.alipaydev.com/gateway.do',
];
return $config;

?>
