<?php

namespace Pay\Service;

use Pay\Config\Alipay;
/*
 * 验证支付宝基本的客户端类
 *
 * 支持AopClient的方式
 *
 * @date 17/05/18 15:24:03
 */
class ActionAbstract
{
    protected $config;
    protected $aopclient;
    
    public function __construct($app = [], $debug = true)
    {
        $this->config = (new Alipay())->config();
        if (!$debug) {
            $this->config['app'] = $this->paramsFormat($app);
        }
        $this->baseAop();
    }

    /*
     * 支付宝支付网关基类
     *
     * @return bool
     */
    protected function baseAop()
    {
        $aop = $this->config['type'];
        $app = $this->config['app'];
        $base = realpath(__DIR__ . '/../Alipay/aop/' . $aop . '.php');
        if (!is_file($base)) {
            throw new \Exception('支付宝AOP文件丢失！');
        }
        require_once($base);
        $this->aopclient = new \AopClient();
        $this->aopclient->gatewayUrl = $app['gateWay'];
        $this->aopclient->appId = $app['appid'];
        $this->aopclient->rsaPrivateKey = $app['privateKey'];
        $this->aopclient->format = $this->config['params']['format'];
        $this->aopclient->charset= $this->config['params']['charset'];
        $this->aopclient->signType= $this->config['params']['signType'];
        $this->aopclient->alipayrsaPublicKey = $app['publicKey'];
    }

    /*
     * 校验一些公共参数
     *
     * @return array
     */
    protected function paramsFormat($app)
    {
        $config = [];
        if (!$app['appid']) {
            throw new \Exception('appid不能为空!');
        }
        if (!$app['publicKey'] || !$app['privateKey']) {
            throw new \Exception('key不能为空!');
        }
        if (!$app['gateWay']) {
            throw new \Exception('gateWay不能为空!');
        }
        $config = [
            'appid' => $app['appid'],
            'publicKey' => $app['publicKey'],
            'privateKey' => $app['privateKey'],
            'gateWay' => $app['gateWay'],
        ];
        return $config;
    }
}

?>
