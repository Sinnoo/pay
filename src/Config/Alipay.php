<?php
namespace Pay\Config;

/*
 * 支付宝的相关配置
 *
 * date 16/05/18 20:53:59
 *
 * @songmingshuo
 */

class Alipay
{

    public function config()
    {
        $config = require_once __DIR__ . '/Config.php';
        return $config;
    }
}
?>
