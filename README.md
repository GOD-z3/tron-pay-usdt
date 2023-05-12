# 说明(必看):
接口申请 URL : [跳转](https://t.me/Tigerbuhu)

## 功能新增:

[多签提现](https://github.com/GOD-z3/tron-pay-usdt#multsignWithdraw)  
[存款回调增加参数](https://github.com/GOD-z3/tron-pay-usdt#trx-usdt-到账回调)  

## 功能列表:

 方法名  | 功能  | 跳转详情
 ---- | ----- | ------  
 newAddres  | 获取充值地址 | [on newAddres](https://github.com/GOD-z3/tron-pay-usdt#newaddres)
 usdtWithdraw  | USDT 提现 | [on usdtWithdraw](https://github.com/GOD-z3/tron-pay-usdt#usdtWithdraw)
 trxWithdraw  | TRX 提现 | [on trxWithdraw](https://github.com/GOD-z3/tron-pay-usdt#trxWithdraw)  
 usdWithdraw  | USD 提现 | [on usdWithdraw](https://github.com/GOD-z3/tron-pay-usdt#usdWithdraw)  
 multsignWithdraw  | 多签提现 | [on multsignWithdraw](https://github.com/GOD-z3/tron-pay-usdt#multsignWithdraw)  
 censorTxid  | 检查收款BY TXID | [on censorTxid](https://github.com/GOD-z3/tron-pay-usdt#censorTxid)  
 isAddress  | 检查地址是否合法 | [on isAddress](https://github.com/GOD-z3/tron-pay-usdt#isAddress)  
 censorUserByTG  | 检查用户 BY Telegram ID | [on censorUserByTG](https://github.com/GOD-z3/tron-pay-usdt#censorUserByTG)  
 payLink  | 获取钱包充值链接 | [on payLink](https://github.com/GOD-z3/tron-pay-usdt#payLink)  
 shopInfo  | 获取商铺信息 | [on shopInfo](https://github.com/GOD-z3/tron-pay-usdt#shopInfo)  
 getBalanceByAddress  | 获取地址上线余额(TRX & USDT) | [on payLink](https://github.com/GOD-z3/tron-pay-usdt#getBalanceByAddress)  

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
 10002  | usd提现(usdWithdraw)，没有找到对应的用户(telegramID 没有创建钱包) | 否
 10003  | 提现,余额不足 | 否
 10004  | 提现,tron地址不合法 | 否
 10005  | 检查订单(censorTxid), txid 不合法 | 否
 10006  | 检查订单(censorTxid), 没有检测到入款信息 | 否
 10007  | 检查用户(censorUserByTG), telegram ID 未注册钱包 | 否
 10008  | 提现订单号已处理过一次, 不可以重复处理 | 否
 11111  | 特殊错误 | 是


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

## TRX USDT 到账回调:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 id  | Y | 商户id
 type  | Y | 固定为 deposit, 用于区分是提现还是存款
 data[]  | Y | 返回数据的数组
 data['api_order]  | Y | 创建地址时生成的api_order
 data['order]  | Y | 创建地址是用户传入的order
 data['address]  | Y | 收款地址
 data['amount]  | Y | 本次收款金额 
 data['txid]  | Y | 本次交易txid(唯一)
 data['datas]  | Y | 本地交易详情
 data['coin_type]  | Y | 本次充值的币种(TRX,USDT)
 sign  | Y | 数据签名

## USD 到账回调 (已废弃):
**USD 回调跟 TRX USDT 不同,需要单独处理,api_order是唯一值可以用于判断是否已处理**
 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 id  | Y | 商户id
 data[]  | Y | 返回数据的数组
 data['api_order]  | Y | 本站创建的 api_order 是唯一值
 data['order]  | Y | 用户传入的order
 data['address]  | Y | 打款用户的TelegramID
 data['amount]  | Y | 本次收款金额 
 data['txid]  | Y | 本站创建的 api_order 是唯一值
 data['datas]  | Y | 本站创建的 api_order 是唯一值
 data['coin_type]  | Y | USD
 sign  | Y | 数据签名



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
 code  | Y | 请求状态码 [10004,10003]  [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['api_order']  | Y | 接口返回的订单号(用户其他功能，建议记录) 
 data['order']  | Y | 用户传入的订单号
 data['txid']  | Y | 区块订单唯一表示
 data['address']  | Y | 提现地址  
 data['amount']  | Y | 提现金额  
 data['current_usdt']  | Y | USDT 剩余余额  
 data['coin_type']  | Y | 币种(USDT)  
 data['fee']  | Y | 手续费  
 sign  | Y | 数据签名


 # trxWithdraw:

 ## 示例:
```
// trx 提现
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
 code  | Y | 请求状态码 [10004,10003]  [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['api_order']  | Y | 接口返回的订单号(用户其他功能，建议记录) 
 data['order']  | Y | 用户传入的订单号
 data['txid']  | Y | 区块订单唯一表示
 data['address']  | Y | 提现地址  
 data['amount']  | Y | 提现金额  
 data['current_trx']  | Y | TRX 剩余余额  
 data['coin_type']  | Y | 币种(TRX)  
 data['fee']  | Y | 手续费  
 sign  | Y | 数据签名



 # usdWithdraw:

 ## 示例:
```
// usd 提现
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
 message | N | 订单备注消息
 id  | Y | 商户ID(sdk内部处理)
 sign  | Y | 数据签名(sdk内部处理)

#### 返回参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 status  | Y | [on status](https://github.com/GOD-z3/tron-pay-usdt#%E8%BF%94%E5%9B%9E%E7%8A%B6%E6%80%81) 
 id  | Y | 商户ID 
 code  | Y | 请求状态码 [10002,10003]  [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['api_order']  | Y | 接口返回的订单号(用户其他功能，建议记录) 
 data['order']  | Y | 用户传入的订单号
 data['telegramID']  | Y | 用户传入的telegramID  
 data['amount']  | Y | 提现金额  
 data['current_usd']  | Y | USD 剩余余额  
 data['coin_type']  | Y | 币种(USD)  
 data['fee']  | Y | 手续费  
 sign  | Y | 数据签名

 # multsignWithdraw:
**多签提现需要二次审核，提现结果会通过回调接口通知商户**

 ## 示例:
```
// usdt 提现
$api = new Troner('商户ID','商户TOKEN');
// **案例** $api = new Troner('20000','token');
$data = [
    'address' => '合法的 tron 地址',
    'amount' => '1',
    'order' => '可选',
    'coin_type' => 'USDT',
];
$result = $api->multsignWithdraw($data);
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
 code  | Y | 请求状态码 [10004,10003]  [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['api_order']  | Y | 接口返回的订单号(用户其他功能，建议记录) 
 data['order']  | Y | 用户传入的订单号
 data['address']  | Y | 提现地址  
 data['amount']  | Y | 提现金额  
 data['coin_type']  | Y | 币种(USDT)  
 data['fee']  | Y | 手续费  
 sign  | Y | 数据签名

## 提现回调:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 id  | Y | 商户id
 type  | Y | 此结果固定为 multsignWithdraw, 用于区分回调的是提现还是存款
 data[]  | Y | 返回数据的数组
 data['status]  | Y | pass 或 reject
 data['api_order]  | Y | api接口生成的订单
 data['order]  | Y | 传入的订单
 data['to_address]  | Y | 提现地址
 data['amount]  | Y | 本次收款金额 
 data['txid]  | Y | 交易id(status为pass时存在)
 data['datas]  | Y | 具体交易信息(status为pass时存在)
 data['coin_type]  | Y | 币种(目前只有USDT)
 data['fee]  | Y | 手续费(status为pass时存在)
 sign  | Y | 数据签名


 # censorTxid:
**查询订单返回的交易信息很有可能是你已经处理过的，所以请先判断交易是否处理过**

 ## 示例:
```
// 通过 txid 检查收款情况
$api = new Troner('商户ID','商户TOKEN');
// **案例** $api = new Troner('20000','token');
$data = [
    'txid' => '必须'
];
$result = $api->censorTxid($data);
```

## 请求与返回参数:

#### 请求参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 txid | Y | 交易的txid
 id  | Y | 商户ID(sdk内部处理)
 sign  | Y | 数据签名(sdk内部处理)

#### 返回参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 status  | Y | [on status](https://github.com/GOD-z3/tron-pay-usdt#%E8%BF%94%E5%9B%9E%E7%8A%B6%E6%80%81) 
 id  | Y | 商户ID 
 code  | Y | 请求状态码  [10005,10006] [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['api_order]  | Y | 创建地址时生成的api_order
 data['order]  | Y | 创建地址是用户传入的order
 data['address]  | Y | 收款地址
 data['amount]  | Y | 本次收款金额 
 data['txid]  | Y | 本次交易txid(唯一)
 data['datas]  | Y | 本地交易详情
 data['coin_type]  | Y | 本次充值的币种(TRX,USDT)
 sign  | Y | 数据签名


 # isAddress:

 ## 示例:
```
// 通过 txid 检查收款情况
$api = new Troner('商户ID','商户TOKEN');
// **案例** $api = new Troner('20000','token');
$data = [
    'address' => '必须'
];
$result = $api->isAddress($data);
```

## 请求与返回参数:

#### 请求参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 address | Y | tron 地址
 id  | Y | 商户ID(sdk内部处理)
 sign  | Y | 数据签名(sdk内部处理)

#### 返回参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 status  | Y | [on status](https://github.com/GOD-z3/tron-pay-usdt#%E8%BF%94%E5%9B%9E%E7%8A%B6%E6%80%81) 
 id  | Y | 商户ID 
 code  | Y | 请求状态码  [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['address]  | Y | 地址
 data['isAddress]  | Y | 地址是否合法(True or False)
 sign  | Y | 数据签名

 # getBalanceByAddress:

 ## 示例:
```
// 查看 address 线上余额 (TRX & USDT)
$api = new Troner('商户ID','商户TOKEN');
// **案例** $api = new Troner('20000','token');
$data = [
    'address' => '必须'
];
$result = $api->getBalanceByAddress($data);
```

## 请求与返回参数:

#### 请求参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 address | Y | tron 地址
 id  | Y | 商户ID(sdk内部处理)
 sign  | Y | 数据签名(sdk内部处理)

#### 返回参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 status  | Y | [on status](https://github.com/GOD-z3/tron-pay-usdt#%E8%BF%94%E5%9B%9E%E7%8A%B6%E6%80%81) 
 id  | Y | 商户ID 
 code  | Y | 请求状态码  [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['address]  | Y | 地址
 data['trx]  | Y | trx 余额
 data['usdt]  | Y | usdt 余额
 sign  | Y | 数据签名



 # censorUserByTG:

 ## 示例:
```
// 通过 txid 检查收款情况
$api = new Troner('商户ID','商户TOKEN');
// **案例** $api = new Troner('20000','token');
$data = [
    'telegramID' => '必须'
];
$result = $api->censorUserByTG($data);
```

## 请求与返回参数:

#### 请求参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 telegramID | Y | Telegram ID
 id  | Y | 商户ID(sdk内部处理)
 sign  | Y | 数据签名(sdk内部处理)

#### 返回参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 status  | Y | [on status](https://github.com/GOD-z3/tron-pay-usdt#%E8%BF%94%E5%9B%9E%E7%8A%B6%E6%80%81) 
 id  | Y | 商户ID 
 code  | Y | 请求状态码 [10007] [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['telegramID]  | Y | 传入的ID
 data['username]  | N | 用户名
 data['nickname]  | N | 昵称
 data['avatar]  | N | 头像
 sign  | Y | 数据签名



 # payLink:

## 示例:
```
// 获取地址
$api = new Troner('商户ID','商户TOKEN');
// **案例** $api = new Troner('20000','token');

$data = [
    'order' => '123',
    'amount' => '0.1',
    'message' => '发大财',
];

$result = $api->payLink($data);
```

## 请求与返回参数:

#### 请求参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 amount  | Y | 充值金额
 order  | N | 订单号 (充值成功后回调)
 message  | N | 消息
 back_url  | N | 付款成功后返回按钮链接
 id  | Y | 商户ID(sdk内部处理)
 sign  | Y | 数据签名(sdk内部处理)

#### 返回参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 status  | Y | [on status](https://github.com/GOD-z3/tron-pay-usdt#%E8%BF%94%E5%9B%9E%E7%8A%B6%E6%80%81) 
 id  | Y | 商户ID 
 code  | Y | 请求状态码  [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['pay_url']  | Y | 充值链接(https://t.me/TronlinkWalletBot?start=xxxx)
 data['api_order']  | Y | 接口生成的订单号
 sign  | Y | 数据签名

## 到账回调:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 id  | Y | 商户id
 data[]  | Y | 返回数据的数组
 data['api_order]  | Y | 创建充值链接时生成的订单号
 data['order]  | Y | 传入的order
 data['tg_id]  | Y | 充值用户的 Telegram ID
 data['amount]  | Y | 本次收款金额 
 data['message]  | Y | 传入的 message
 data['coin_type]  | Y | USD
 sign  | Y | 数据签名


 # shopInfo:

## 示例:
```
// 获取地址
$api = new Troner('商户ID','商户TOKEN');
// **案例** $api = new Troner('20000','token');

$data = [
    
];

$result = $api->shopInfo($data);
```

## 请求与返回参数:

#### 请求参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 id  | Y | 商户ID(sdk内部处理)
 sign  | Y | 数据签名(sdk内部处理)

#### 返回参数:

 参数名  | 必选项  | 解释
 ---- | ----- | ------  
 status  | Y | [on status](https://github.com/GOD-z3/tron-pay-usdt#%E8%BF%94%E5%9B%9E%E7%8A%B6%E6%80%81) 
 id  | Y | 商户ID 
 code  | Y | 请求状态码  [on code](https://github.com/GOD-z3/tron-pay-usdt#%E7%8A%B6%E6%80%81%E7%A0%81%E8%AF%B4%E6%98%8E)
 data[]  | Y | 返回数据的数组
 data['id']  | Y | 商户id
 data['name']  | Y | 商户名
 data['usd']  | Y | USD 余额
 data['usdt']  | Y | USDT 余额
 data['trx']  | Y | TRX 余额
 sign  | Y | 数据签名
