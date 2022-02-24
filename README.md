# 说明(必看):
接口申请 URL : [跳转](https://t.me/Tigerbuhu)

## 功能列表:

 方法名  | 功能  | 跳转详情
 ---- | ----- | ------  
 newAddres  | 获取充值地址 | [on newAddres](https://github.com/GOD-z3/tron-pay-usdt#newaddres)
 usdtWithdraw  | USDT 提现 | [on usdtWithdraw](https://github.com/GOD-z3/tron-pay-usdt#usdtWithdraw)
 trxWithdraw  | TRX 提现 | [on trxWithdraw](https://github.com/GOD-z3/tron-pay-usdt#trxWithdraw)  
 usdWithdraw  | USD 提现 | [on usdWithdraw](https://github.com/GOD-z3/tron-pay-usdt#usdWithdraw)  

## 返回状态:

 参数  | 状态  | 解释
 ---- | ----- | ------  
 status  | success | 成功
 status  | warning | 传入数据不合法或错误
 status  | error | 系统错误，根据code(状态码)查看原因

## 状态码说明:

 状态码  | 说明  | 是否需要联系管理员
 ---- | ----- | ------  
 10000  | 请求成功 | 否
 10001  | 系统错误，请重新请求 | 否
 10002  | usd提现，没有找到对应的用户(telegramID 没有创建钱包) | 否
 10003  | u提现,余额不足 | 否
 10004  | 提现,tron地址不合法 | 否
 11111  | 危险系统错误 | 是


## 接口调用完整示例:

```
// 初始化数据
$api = new Troner('商户ID','商户TOKEN'); // **案例** $api = new Troner('20000','token');

// 构建参数
$data = [
    'order' => 'yourorder',
];

// 调用接口
$result = $api->newAddress($data);

// 检查是否返回成功，如果没有返回成功则做出相应处理
if(!isset($result['status']) && $result['status'] != 'success'){
    echo '接口请求出错或接口出错';
}

// 验证签名 
if($api->checkSign($result)){
    // 成功的逻辑代码
}else{
    // 失败的逻辑代码
}
```


# newAddres:

## 示例:
```
// 获取地址
$api = new Troner('商户ID','商户TOKEN');
// **案例** $api = new Troner('20000','token');

$data = [
    'order' => 'yourorder',
];

$result = $api->newAddress($data);
```

## 请求与返回参数:

#### 请求参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 order  | Y | 订单号,order相同地址不变(唯一) 
 id  | Y | 商户ID(sdk内部处理)
 sign  | Y | 数据签名(sdk内部处理)

#### 返回参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 status  | Y | [on status](https://github.com/GOD-z3/tron-pay-usdt#%E8%BF%94%E5%9B%9E%E7%8A%B6%E6%80%81) 
 id  | Y | 商户ID 
 code  | Y | 请求状态码  [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['api_order']  | Y | 接口返回的订单号(用户其他功能，建议记录) 
 data['order']  | Y | 用户传入的订单号
 data['address']  | Y | 充值接收地址  
 sign  | Y | 数据签名

## newAddres 到账回调:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 id  | Y | 商户id
 data[]  | Y | 返回数据的数组
 data['api_order]  | Y | 创建地址时生成的api_order
 data['order]  | Y | 创建地址是用户传入的order
 data['address]  | Y | 收款地址
 data['amount]  | Y | 本次收款金额 
 data['txid]  | Y | 本次交易txid(唯一)
 data['datas]  | Y | 本地交易详情
 data['coin_type]  | Y | 本次充值的币种(TRX,USDT)
 sign  | Y | 数据签名

## newAddres 到账回调返回:
**回调状态接口会记录，所以回调返回必须按指定格式返回**
 ```
 // json 格式
 {"status":"success"}
 ```



 # usdtWithdraw:

 ## 示例:
```
// usdt 提现
$api = new Troner('商户ID','商户TOKEN');
// **案例** $api = new Troner('20000','token');
$data = [
    'address' => '合法的 tron 地址',
    'amount' => '1',
    'order' => '可选'
];
$result = $api->usdtWithdraw($data);
```

## 请求与返回参数:

#### 请求参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 address | Y | 提现地址
 amount | Y | 提现金额
 order | N | 订单号
 id  | Y | 商户ID(sdk内部处理)
 sign  | Y | 数据签名(sdk内部处理)

#### 返回参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 status  | Y | [on status](https://github.com/GOD-z3/tron-pay-usdt#%E8%BF%94%E5%9B%9E%E7%8A%B6%E6%80%81) 
 id  | Y | 商户ID 
 code  | Y | 请求状态码  [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['api_order']  | Y | 接口返回的订单号(用户其他功能，建议记录) 
 data['order']  | Y | 用户传入的订单号
 data['address']  | Y | 提现地址  
 data['amount']  | Y | 提现金额  
 data['current_usdt']  | Y | USDT 剩余余额  
 data['coin_type']  | Y | 币种(USDT)  
 data['fee']  | Y | 手续费  
 sign  | Y | 数据签名


 # trxWithdraw:

 ## 示例:
```
// usdt 提现
$api = new Troner('商户ID','商户TOKEN');
// **案例** $api = new Troner('20000','token');
$data = [
    'address' => '合法的 tron 地址',
    'amount' => '1',
    'order' => '可选'
];
$result = $api->trxWithdraw($data);
```

## 请求与返回参数:

#### 请求参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 address | Y | 提现地址
 amount | Y | 提现金额
 order | N | 订单号
 id  | Y | 商户ID(sdk内部处理)
 sign  | Y | 数据签名(sdk内部处理)

#### 返回参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 status  | Y | [on status](https://github.com/GOD-z3/tron-pay-usdt#%E8%BF%94%E5%9B%9E%E7%8A%B6%E6%80%81) 
 id  | Y | 商户ID 
 code  | Y | 请求状态码  [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['api_order']  | Y | 接口返回的订单号(用户其他功能，建议记录) 
 data['order']  | Y | 用户传入的订单号
 data['address']  | Y | 提现地址  
 data['amount']  | Y | 提现金额  
 data['current_trx']  | Y | TRX 剩余余额  
 data['coin_type']  | Y | 币种(TRX)  
 data['fee']  | Y | 手续费  
 sign  | Y | 数据签名



 # usdWithdraw:

 ## 示例:
```
// usdt 提现
$api = new Troner('商户ID','商户TOKEN');
// **案例** $api = new Troner('20000','token');
$data = [
    'telegramID' => 'telegramID',
    'amount' => '1',
    'order' => '可选'
];
$result = $api->usdWithdraw($data);
```

## 请求与返回参数:

#### 请求参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 telegramID | Y | 用户的 telegramID，如果用户不存在返回 code:10002
 amount | Y | 提现金额
 order | N | 订单号
 id  | Y | 商户ID(sdk内部处理)
 sign  | Y | 数据签名(sdk内部处理)

#### 返回参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 status  | Y | [on status](https://github.com/GOD-z3/tron-pay-usdt#%E8%BF%94%E5%9B%9E%E7%8A%B6%E6%80%81) 
 id  | Y | 商户ID 
 code  | Y | 请求状态码  [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['api_order']  | Y | 接口返回的订单号(用户其他功能，建议记录) 
 data['order']  | Y | 用户传入的订单号
 data['telegramID']  | Y | 用户传入的telegramID  
 data['amount']  | Y | 提现金额  
 data['current_usd']  | Y | USD 剩余余额  
 data['coin_type']  | Y | 币种(USD)  
 data['fee']  | Y | 手续费  
 sign  | Y | 数据签名