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
        $this->api_url_withdraw    = $api_url . 'withdraw';
    }

    public function newAddress(array $data)
    {
        $this->url = $this->api_url_gerAddress;
        return $this->post($data);
    }

    public function checkrecharge(array $data)
    {
        $this->url = $this->api_url_checkrecharge;
        return $this->post($data);
    }

    public function withdraw(array $data){
        $this->url = $this->api_url_withdraw;
        return $this->post($data);
    }

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

