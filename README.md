# 说明(必看):
接口 URL : [跳转](https://pay.anonymousalliance.com)

## 功能列表:

 方法名  | 功能  | 跳转详情
 ---- | ----- | ------  
 newAddres  | 获取充值地址 | [on newAddres](https://github.com/GOD-z3/tron-pay-usdt#newaddres)
 checkrecharge  | 主动获取某一个订单是否充值到账 | [on checkrecharge](https://github.com/GOD-z3/tron-pay-usdt#checkrecharge)  

## 返回状态:

 参数  | 状态  | 解释
 ---- | ----- | ------  
 status  | success | 成功
 status  | warning | 传入数据不合法或错误
 status  | error | api 接口出错联系管理员

## 支持的币种:

 1. usdt
 2. trx


## 接口调用完整示例:

```
// 初始化数据
$api = new Troner('你的用户名','你的token','要使用的币种'); // **案例** $api = new Troner('test','token','usdt');
// 构建参数
$data = [
    'order' => 'yourorder',
    'amount' => '1',
    'call_back' => 'call_back_url'
];
// 调用接口
$result = $api->newAddress($data);
// 检验返回数据并处理
if($result['status'] != 'success'){
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
$api = new Troner('你的用户名','你的token','要使用的币种');
// **案例** $api = new Troner('test','token','usdt');
$data = [
    'order' => 'yourorder',
    'amount' => '1',
    'call_back' => 'call_back_url'
];
$result = $api->newAddress($data);
```

## 请求与返回参数:

#### 请求参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 order  | Y | 你订单号(最好唯一) 
 amount  | Y | 充值的金额  
 call_back  | Y | 回调链接(必须可访问)  
 name  | Y | 用户名(sdk内部处理)
 sign  | Y | 数据签名(sdk内部处理)

#### 返回参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 status  | Y | [on status](https://github.com/GOD-z3/tron-pay-usdt#%E8%BF%94%E5%9B%9E%E7%8A%B6%E6%80%81) 
 api_order  | Y | 接口返回的订单号(用户其他功能，建议记录) 
 order  | Y | 传入的订单  
 base58  | Y | 充值地址  
 amount  | Y | 传入的金额  
 coin_type  | Y | 币种  
 call_back  | Y | 传入的回调链接  
 sign  | Y | 数据签名

## newAddres 回调:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 api_order  | Y | 接口返回的订单号(用户其他功能，建议记录) 
 order  | Y | 传入的订单  
 base58  | Y | 充值地址  
 amount  | Y | 传入的金额  
 coin_type  | Y | 币种  
 recharge  | Y | 充值状态 true:到账 false:未到账(没有BUG，未到账不会触发回调)
 sign  | Y | 数据签名

## newAddres 回调返回:
**回调状态接口会记录，所以回调返回必须按指定格式返回**
 ```
 // json 格式
 {"status":"success"}
 ```



 # checkrecharge:

 ## 示例:
```
// 获取地址
$api = new Troner('你的用户名','你的token','要使用的币种');
// **案例** $api = new Troner('test','token','usdt');
$data = [
    'order' => 'yourorder',
    'amount' => '1',
    'call_back' => 'call_back_url'
];
$result = $api->newAddress($data);
```

## 请求与返回参数:

#### 请求参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 api_order : 接口订单号
 name  | Y | 用户名(sdk内部处理)
 sign  | Y | 数据签名(sdk内部处理)

#### 返回参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 status  | Y | [on status](https://github.com/GOD-z3/tron-pay-usdt#%E8%BF%94%E5%9B%9E%E7%8A%B6%E6%80%81) 
 api_order  | Y | 接口返回的订单号(用户其他功能，建议记录) 
 order  | Y | 传入的订单  
 base58  | Y | 充值地址  
 amount  | Y | 传入的金额  
 coin_type  | Y | 币种  
 recharge  | Y | 充值状态 true:到账 false:未到账  
 sign  | Y | 数据签名