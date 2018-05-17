<?php
namespace Pay\Service\Alipay;

use Pay\Service\ActionAbstract;
use Mx\Rest\Curl;
/*
 * 支付宝转账接口
 *
 * date 16/05/18 23:53:55 
 *
 * @songmingshuo
 *
 */
class Transfer extends ActionAbstract
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 进行转账接口
     *
     * @return mix
     */
    public function doTransfer($params)
    {
        try {
            $transferFile = realpath(__DIR__ . '/../../Alipay/aop/request/AlipayFundTransToaccountTransferRequest.php');
            require_once($transferFile);

            $request = new \AlipayFundTransToaccountTransferRequest();
            $bizcontent = json_encode($this->paramsTransfer($params));
            $request->setBizContent($bizcontent);
            $response= $this->aopclient->sdkExecute($request);
            $url = $this->config['app']['gateWay'] . '?' . $response;
            $curl = new Curl($url);
            $data = $curl->exec();
            if ($data) {
                return json_decode($data,true);
            }
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    /*
     * 转账业务的参数
     *
     * @return array
     */
    protected function paramsTransfer($params)
    {
        $data = [];
        if (!$params['out_biz_no']) {
            throw new \Exception('订单号不能为空!');
        }
        if (!$params['payee_type'] || !$params['payee_account']) {
            throw new \Exception('缺少收款账号!');
        }
        if (!$params['amount']) {
            throw new \Exception('缺少金额信息!');
        }
        $data = [
            'out_biz_no' => $params['out_biz_no'],
            'payee_type' => $params['payee_type'],
            'payee_account' => $params['payee_account'],
            'amount' => $params['amount'],
            'remark' => '刻间提现红包',
        ];
        return $data;
    }
}
?>
