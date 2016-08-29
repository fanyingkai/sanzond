#sanzond
订单系统实施简易步骤

1.将 zy_sys2_cgdw , zy_sys2_fpxm , zy_sys2_ygbm , zy_sys2_ypzdk, zy_yp1_yksz
同步至对应的order数据库所在位置即可

根据对接系统的不同，修改视图，默认对接为太阳升


2.订单信息获取接口
  所有与外部系统交互都通过 Wys 进行服务

  订单信息获取接口  例: jf.sanzond.com/Wys/Order/getorder ,获取最新未曾获取过的订单，返回为
  json格式数据  json 格式  {'status':1(0),'info':'通知的消息','data':数据体}

  
3.订单状态更新接口  例：jf.sanzond.com/Wys/Order/ustatus/o/订单号/s/订单状态（订单状态说明如下）
/**
 * 订单状态说明
 * G为下单，C为总部确认，S为总部发货，R为收货，O为任何异常取消状态
 * 例子：GCS 为已经下单并且总部确认过，且已经发货的订单，GCO为总部确认后异常情况取消
 * @param: $o:订单编号 ， $s:订单状态
 * @return: 失败json  ,json 格式  {'status':1(0),'info':'通知的消息','data':数据体}
 */
