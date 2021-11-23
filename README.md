# 功能列表:

```
newAddres             获取充值地址
checkrecharge         主动获取某一个订单是否充值到账
```

## newAddres:

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

 表头  | 表头  | 表头
 ---- | ----- | ------  
 单元格内容  | 单元格内容 | 单元格内容 
 单元格内容  | 单元格内容 | 单元格内容  
