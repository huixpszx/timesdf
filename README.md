使用说明

## ConfigChid
    配置整个ConfigTimes

## SdkDf
    balance方法为查询商户余额，只允许5分钟查询一次

    order方法为申请下发，需要传入1.订单号，2.订单金额，3.姓名，4.卡号

## 下发结果，以平台通知为主，禁止频繁主动查询！！！
    order_query方法为下发后，主动查询，需要传入，商户自己的订单号。

## CallBack
    注意，下发成功或者失败，均会有平台回调通知，使用PayCallBack进行验证平台签名