<?php
class Troner
{
    protected $id;
    protected $token;
    protected $api_url_gerAddress;


    public function __construct($id, $token)
    {
        $this->id = $id;
        $this->token = $token;

        $api_url = 'xxxx/';
        $this->api_url_gerAddress    = $api_url . 'newAddress';
        $this->api_url_usdtWithdraw    = $api_url . 'withdraw/usdt';
        $this->api_url_trxWithdraw    = $api_url . 'withdraw/trx';
        $this->api_url_usdWithdraw    = $api_url . 'withdraw/usd';
        $this->api_url_censorTxid    = $api_url . 'censorTxid';
        $this->api_url_isAddress    = $api_url . 'isAddress';
        $this->api_url_censorUserByTG    = $api_url . 'censorUserByTG';
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
     * usdt 提现
     * 请求参数：
     *      id : 商户id
     *      address : 合法的 tron 地址, 地址不合法返回 10004
     *      amount : 金额
     *      order : 可选参数
     *      sign : 签名
     * 返回：
     *      status : success 请求成功; error 请求异常; warning 请求参数不对
     *      id : 商户id
     *      sign : 签名
     *      code : 请求状态码
     *      data : {
     *              address : 用户传入的 address
     *              amount : 用户传入的金额
     *              current_usdt : 用户当前剩余的 usdt
     *              order : 用户传入的 order
     *              api_order : api订单号
     *              coin_type : 提现的币种
     *              fee : 手续费
     *          }
     */
    public function usdtWithdraw(array $data)
    {
        $this->url = $this->api_url_usdtWithdraw;
        return $this->post($data);
    }

    /**
     * trx 提现
     * 请求参数：
     *      id : 商户id
     *      address : 合法的 tron 地址, 地址不合法返回 10004
     *      amount : 金额
     *      order : 可选参数
     *      sign : 签名
     * 返回：
     *      status : success 请求成功; error 请求异常; warning 请求参数不对
     *      id : 商户id
     *      sign : 签名
     *      code : 请求状态码
     *      data : {
     *              address : 用户传入的 address
     *              amount : 用户传入的金额
     *              current_trx : 用户当前剩余的 trx
     *              order : 用户传入的 order
     *              api_order : api订单号
     *              coin_type : 提现的币种
     *              fee : 手续费
     *          }
     */
    public function trxWithdraw(array $data)
    {
        $this->url = $this->api_url_trxWithdraw;
        return $this->post($data);
    }

    /**
     * usd 提现
     * 请求参数：
     *      id : 商户id
     *      telegramID : 要给哪个用户提现 如果用户不存在返回 10002
     *      amount : 金额
     *      order : 可选参数
     *      sign : 签名
     * 返回：
     *      status : success 请求成功; error 请求异常; warning 请求参数不对
     *      id : 商户id
     *      sign : 签名
     *      code : 请求状态码
     *      data : {
     *              telegramID : 用户传入的telegramID
     *              amount : 用户传入的金额
     *              current_usd : 用户当前剩余的 usd
     *              order : 用户传入的order
     *              api_order : api订单号
     *              coin_type : 提现的币种
     *              fee : 手续费
     *          }
     */
    public function usdWithdraw(array $data)
    {
        $this->url = $this->api_url_usdWithdraw;
        return $this->post($data);
    }

    /**
     * 检查订单 BY TXID
     * 请求参数：
     *      id : 商户id
     *      txid : 合法的 txid, txid 不合法返回 10005
     *      sign : 签名
     * 返回：
     *      status : success 请求成功; error 请求异常; warning 请求参数不对
     *      id : 商户id
     *      sign : 签名
     *      code : 请求状态码
     *      data : {
     *              api_order : api接口生成的订单
     *              order : 传入的订单
     *              address : 充值接收地址
     *              amount : 充值金额
     *              txid : 交易id，可以用于判断是否已处理
     *              datas : 具体交易信息
     *              coin_type : 币种
     *          }
     */
    public function censorTxid(array $data){
        $this->url = $this->api_url_censorTxid;
        return $this->post($data);
    }

    /**
     * 检查地址是否合法
     * 请求参数：
     *      id : 商户id
     *      address : 合法的 tron 地址
     *      sign : 签名
     * 返回：
     *      status : success 请求成功; error 请求异常; warning 请求参数不对
     *      id : 商户id
     *      sign : 签名
     *      code : 请求状态码
     *      data : {
     *              address : 传入的地址
     *              isAddress : 是否合法
     *          }
     */
    public function isAddress(array $data){
        $this->url = $this->api_url_isAddress;
        return $this->post($data);
    }

    /**
     * 检查用户是否存在 通过 Telegram ID
     * 请求参数：
     *      id : 商户id
     *      telegramID : telegramID
     *      sign : 签名
     * 返回：
     *      status : success 请求成功; error 请求异常; warning 请求参数不对
     *      id : 商户id
     *      sign : 签名
     *      code : 请求状态码  用户存在:10000; 不存在:10007;
     *      data : {
     *              telegramID : 传入的ID
     *              username : 用户名
     *              nickname : 昵称
     *              avatar : 头像
     *          }
     */
    public function censorUserByTG(array $data){
        $this->url = $this->api_url_censorUserByTG;
        return $this->post($data);
    }

    /*
     *  异步接受通知：
     *      id : 商户id
     *      sign : 签名
     *      data : {
     *              api_order : api接口生成的订单
     *              order : 传入的订单
     *              address : 充值接收地址
     *              amount : 充值金额
     *              txid : 交易id，可以用于判断是否已处理
     *              datas : 具体交易信息
     *              coin_type : 币种
     *         }
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
        $data['id'] = $this->id;
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
        // echo $this->url;
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
