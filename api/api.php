<?php
class Troner
{
    protected $name;
    protected $token;
    protected $api_url_gerAddress;


    public function __construct($name, $token, $type)
    {
        $this->name = $name;
        $this->token = $token;
        $this->coin_type = $type;

        $api_url = 'https://pay.anonymousalliance.com/api/'.$this->coin_type.'/';
        $this->api_url_gerAddress    = $api_url . 'getaddress';
        $this->api_url_checkrecharge    = $api_url . 'checkrecharge';
    }

    /**
     * 获取充值地址
     * 请求参数：
     *      order : 订单号(唯一)
     *      amount : 充值数
     *      call_back : 回调地址(为空则不会调)
     * 
     * 返回：
     *      api_order : api接口生成的订单
     *      order : 传入的订单
     *      base58 : 充值接收地址
     *      amount : 传入的金额
     *      coin_type : 币种
     *      call_back : 传入的回调链接
     *      sign : 签名
     */
    public function newAddress(array $data)
    {
        $this->url = $this->api_url_gerAddress;
        return $this->post($data);
    }

    /**
     * 检查是否充值成功
     * 请求参数：
     *      name : 用户本站的用户名
     *      api_order : 本站订单号(用于查询数据库订单)
     *      sign : 签名
     * 返回：
     *      status : success请求成功 error请求异常(参数错误)
     *      api_order : api接口生成的订单
     *      order : 订单
     *      base58 : 充值接收地址
     *      amount : 金额
     *      coin_type : 币种
     *      recharge : 充值状态 true:充值成功 false:充值失败
     *      sign : 签名
     */
    public function checkrecharge(array $data)
    {
        $this->url = $this->api_url_checkrecharge;
        return $this->post($data);
    }

    /*
     *  异步接受通知：
     *      api_order : api接口生成的订单
     *      order : 订单
     *      base58 : 充值接收地址
     *      amount : 金额
     *      coin_type : 币种
     *      recharge : 充值状态 true:充值成功 false:充值失败
     *      sign : 签名
     * 
     *  按json格式返回：
     *      [
     *          'status' => 'success',
     *      ]
    */
    public function notify()
    {
        $data = $_POST;
        if ($this->checkSign($data) === true) {
            return $data;
        } else {
            return '验签失败';
        }
    }

    // 数据签名
    public function sign(array $data)
    {
        $data['name'] = $this->name;
        $data = array_filter($data);
        ksort($data);
        $data['sign'] = strtoupper(md5(urldecode(http_build_query($data) . '&token=' . $this->token)));
        return $data;
    }

    // 校验数据签名
    public function checkSign($data)
    {
        $in_sign = $data['sign'];
        unset($data['sign']);
        $data = array_filter($data);
        ksort($data);
        $sign = strtoupper(md5(urldecode(http_build_query($data) . '&token=' . $this->token)));
        return $in_sign == $sign ? true : false;
    }

    // 数据发送
    public function post($data)
    {
        $data   = $this->sign($data);
        // exit(json_encode($data));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'HTTP CLIENT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, true);
    }
}

// 获取地址
$api = new Troner('admin','jmADKNQSUWX03678','usdt');
$data = [
    'order' => '123',
    'amount' => '1',
    'call_back' => 'call_back_url'
];

$result = $api->newAddress($data);
if($result['status'] != 'success'){
    echo '接口请求出错或接口出错';
}
// 验证签名 
if($api->checkSign($result)){
    echo '成功';
}else{
    echo '失败';
}
echo json_encode($result);

