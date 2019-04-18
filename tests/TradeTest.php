<?php
/**
 * Created by zed.
 */

class TradeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function testTrade1() {
        $str = '{"code":200,"data":{"delivery_order":[{"pk_id":1507387369604518000,"express_state":1,"oids":[{"oid":"1507387350277163963"},{"oid":"1507387350277163964"}],"express_type":0,"dists":[{"dist_id":"201903261017110000060006","create_time":"2019-03-26 10:17:11","express_info":{"express_id":0,"express_no":""}}]}],"order_promotion":{"item":null,"order_discount_fee":"0.20","adjust_fee":"0.00","item_discount_fee":null,"order":[{"promotion_type":"meetReduce","sub_promotion_type":"","coupon_id":"","promotion_title":"牵牛花满减测试勿删","promotion_condition":"","promotion_type_name":"满减送","promotion_content":"","promotion_id":4295457682,"promotion_type_id":101,"discount_fee":"0.20"}]},"qr_info":null,"refund_order":[{"refund_type":1,"refund_fee":"0.50","refund_id":"201903261025110000010006","refund_state":60,"oids":[{"oid":"1507387350277163963"}]},{"refund_type":1,"refund_fee":"0.50","refund_id":"201903261026430000030006","refund_state":60,"oids":[{"oid":"1507387350277163964"}]}],"full_order_info":{"child_info":null,"address_info":{"self_fetch_info":"","delivery_address":"成都天府软件园","delivery_start_time":null,"delivery_end_time":null,"delivery_postal_code":"","receiver_name":"yht测试","delivery_province":"四川省","delivery_city":"成都市","delivery_district":"高新区","address_extra":"{\"areaCode\":\"510191\",\"lon\":104.07857367314094,\"lat\":30.55420680074888}","receiver_tel":"13618649324"},"remark_info":{"buyer_message":"","star":null,"trade_memo":null},"pay_info":{"outer_transactions":["4200000264201903261946969850"],"post_fee":"0.00","phase_payments":[],"total_fee":"1.20","payment":"1.00","transaction":["190326101704000046"]},"buyer_info":{"outer_user_id":"oHIuujjq9q4n0oxoyfTskwyP6hbk","buyer_phone":"13618649324","fans_type":9,"buyer_id":1266262022,"fans_id":814710568,"fans_nickname":"一笑而过"},"orders":[{"is_cross_border":"null","outer_item_id":"8002","discount_price":"0.30","item_type":0,"num":2,"oid":"1507387350277163963","title":"测试002","fenxiao_payment":"0.00","buyer_messages":"","is_present":false,"cross_border_trade_mode":"null","price":"0.30","sub_order_no":"null","biz_item_attribute":"{\"EXTERNAL_TICKET\":\"0\"}","fenxiao_price":"0.00","total_fee":"0.60","alias":"3f59qbxc8jsds","payment":"0.50","is_pre_sale":"null","outer_sku_id":"8002","sku_unique_code":"","goods_url":"https://h5.youzan.com/v2/showcase/goods?alias=3f59qbxc8jsds","customs_code":"null","item_id":457846930,"sku_id":0,"sku_properties_name":"[]","pic_path":"https://img.yzcdn.cn/upload_files/2019/03/25/FqMXNLvzdruTrK9VRqjxg_N14chC.jpg","pre_sale_type":"null","points_price":"0","seller_nick":null},{"is_cross_border":"null","outer_item_id":"8001","discount_price":"0.20","item_type":0,"num":3,"oid":"1507387350277163964","title":"测试001","fenxiao_payment":"0.00","buyer_messages":"","is_present":false,"cross_border_trade_mode":"null","price":"0.20","sub_order_no":"null","biz_item_attribute":"{\"EXTERNAL_TICKET\":\"0\"}","fenxiao_price":"0.00","total_fee":"0.60","alias":"2fz29mulo249s","payment":"0.50","is_pre_sale":"null","outer_sku_id":"8001","sku_unique_code":"","goods_url":"https://h5.youzan.com/v2/showcase/goods?alias=2fz29mulo249s","customs_code":"null","item_id":457842156,"sku_id":0,"sku_properties_name":"[]","pic_path":"https://img.yzcdn.cn/upload_files/2019/03/25/Ftj3ZtJtqnocbi_IN1BA4b_weGE6.jpg","pre_sale_type":"null","points_price":"0","seller_nick":null}],"source_info":{"is_offline_order":false,"book_key":"4ce28484-9b41-4613-b06d-cbf975d117c3","biz_source":"null","source":{"platform":"wx","wx_entrance":"direct_buy"},"order_mark":null},"order_info":{"consign_time":"2019-03-26 10:17:11","order_extra":{"tm_cash":null,"t_cash":null,"fx_inner_transaction_no":null,"invoice_title":null,"buyer_name":"一笑而过","cashier_name":null,"kdt_dimension_combine_id":null,"is_offline":"0","daogou":null,"fx_order_no":null,"retail_pick_up_code":null,"cash":null,"create_device_id":null,"promotion_combine_id":null,"extra_charge":null,"tex_no":null,"is_from_cart":"true","cashier_id":null,"fx_kdt_id":null,"id_card_name":null,"orders_combine_id":null,"is_member":"true","supplier_kdt_id":null,"is_sub_order":null,"retail_site_no":null,"is_points_order":"0","settle_time":null,"fx_outer_transaction_no":null,"is_parent_order":null,"id_card_number":null,"dept_id":null,"parent_order_no":null,"purchase_order_no":null},"created":"2019-03-26 10:17:02","offline_id":57694718,"status_str":"已关闭","expired_time":"2019-03-26 11:17:02","success_time":"","is_multi_store":true,"type":0,"tid":"E20190326101702000600011","confirm_time":"","pay_time":"2019-03-26 10:17:08","update_time":"2019-03-26 10:29:56","pay_type_str":"WEIXIN_DAIXIAO","is_retail_order":false,"activity_type":1,"pay_type":10,"team_type":9,"refund_state":12,"close_type":2,"status":"TRADE_CLOSED","express_type":2,"order_tags":{"is_virtual":null,"is_purchase_order":null,"is_member":true,"is_message_notify":true,"is_preorder":null,"is_offline_order":null,"is_multi_store":true,"is_settle":null,"is_payed":true,"is_use_coupon":null,"is_use_ump":null,"is_secured_transactions":true,"is_postage_free":true,"is_down_payment_pre":null,"is_feedback":true,"is_fenxiao_order":null,"is_refund":true}}}},"success":true,"requestId":null,"message":"successful"}';
        $data = \GuzzleHttp\json_decode($str, true);
        $trade = new \Dezsidog\Youzanphp\Api\Models\Trade($data['data']);
        $this->assertTrue(true);
    }

    /**
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function testTrade2() {
        $str = '{
    "order_promotion": {
      "adjust_fee": "0.00"
    },
    "refund_order": [],
    "full_order_info": {
      "address_info": {
        "self_fetch_info": "",
        "delivery_address": "",
        "delivery_postal_code": "",
        "receiver_name": "张哲",
        "delivery_province": "",
        "delivery_city": "",
        "delivery_district": "",
        "address_extra": "{}",
        "receiver_tel": "15281009123"
      },
      "remark_info": {
        "buyer_message": ""
      },
      "pay_info": {
        "outer_transactions": [
          "4200000262201901186832052769"
        ],
        "post_fee": "0.00",
        "phase_payments": [],
        "total_fee": "0.01",
        "payment": "0.01",
        "transaction": [
          "190118092305000045"
        ]
      },
      "buyer_info": {
        "outer_user_id": "oaePdw8j7mWPM-tEJ13T7xFPQ2Oc",
        "buyer_phone": "15281009123",
        "fans_type": 1,
        "buyer_id": 695120984,
        "fans_id": 4851134360,
        "fans_nickname": "z🤡"
      },
      "orders": [
        {
          "outer_sku_id": "",
          "sku_unique_code": "",
          "goods_url": "https://h5.youzan.com/v2/showcase/goods?alias=3f44wdts1wkqn",
          "item_id": 450996611,
          "outer_item_id": "",
          "discount_price": "0.01",
          "item_type": 183,
          "num": 1,
          "sku_id": 0,
          "sku_properties_name": "[]",
          "pic_path": "https://img.yzcdn.cn/upload_files/2018/11/01/936643b60bccde7e6e2ee181f135de64.jpg",
          "oid": "1494948796465942441",
          "title": "畅游通门票测试商品",
          "buyer_messages": "{\"身份证\":\"510184199011160039\",\"游玩日期\":\"2019-01-19\"}",
          "is_present": false,
          "pre_sale_type": "null",
          "points_price": "0",
          "price": "0.01",
          "total_fee": "0.01",
          "alias": "3f44wdts1wkqn",
          "payment": "0.01",
          "is_pre_sale": "null"
        }
      ],
      "source_info": {
        "is_offline_order": false,
        "book_key": "201901180921025c4129fe71f8c23524",
        "biz_source": "null",
        "source": {
          "platform": "wx",
          "wx_entrance": "direct_buy"
        }
      },
      "order_info": {
        "consign_time": "",
        "order_extra": {
          "buyer_name": "z🤡",
          "is_offline": "0",
          "is_from_cart": "false",
          "is_member": "true",
          "is_points_order": "0"
        },
        "created": "2019-01-18 09:21:09",
        "status_str": "待发货",
        "expired_time": "2019-01-18 10:21:09",
        "success_time": "",
        "type": 0,
        "tid": "E20190118092109008800023",
        "confirm_time": "",
        "pay_time": "2019-01-18 09:25:06",
        "update_time": "2019-01-18 09:25:06",
        "pay_type_str": "WEIXIN_DAIXIAO",
        "is_retail_order": false,
        "activity_type": 1,
        "pay_type": 10,
        "team_type": 0,
        "refund_state": 0,
        "close_type": 0,
        "status": "WAIT_SELLER_SEND_GOODS",
        "express_type": 9,
        "order_tags": {
          "is_virtual": true,
          "is_member": true,
          "is_message_notify": true,
          "is_payed": true,
          "is_secured_transactions": true
        }
      }
    }
  }';
        $data = \GuzzleHttp\json_decode($str, true);
        $trade = new \Dezsidog\Youzanphp\Api\Models\Trade($data);
        $this->assertTrue(true);
    }
}