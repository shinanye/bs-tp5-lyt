<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Pay extends Model{

    public function pay($order,$trains){//将购票信息分别添加到order trains两个数据库表中
        Db::startTrans();
        try{
            $data1 = Db::table('lyt_order')
                ->insert($order);

            $info = array();
            foreach($trains as $items){
//                var_dump($items);
                $info['uid'] = $items['uid'];
                $info['oid'] = $items['oid'];
                $info['trainNum'] = $items['trainNum'];
                $info['trainType'] = $items['trainType'];
                $info['startStation'] = $items['startStation'];
                $info['endStation'] = $items['endStation'];
                $info['uidCard'] = $items['uidCard'];//idcard
                $info['uidName'] = $items['uidName'];//gname
                $info['oStatus'] = $items['oStatus'];
                $info['time'] = $items['time'];
                $info['longTime'] = $items['longTime'];
                $info['startTime'] = $items['startTime'];
                $info['endTime'] = $items['endTime'];
                $info['seatType'] = $items['seatType'];
                $info['outTrickType'] = $items['outTrickType'];
                $info['cash'] = $items['cash'];

                $data = db('trains')
                        ->insert($info);
            }
            // 提交事务
            Db::commit();
            return 1;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
    }

    public function alipaypc(){
        global $alipay_config;

//        print_r($alipay_config);
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $_POST['WIDout_trade_no'];
        //订单名称，必填
        $subject = $_POST['WIDsubject'];
        //付款金额，必填
        $total_fee = $_POST['WIDtotal_fee'];
        //商品描述，可空
        $body = $_POST['WIDbody'];

        /************************************************************/

    //构造要请求的参数数组，无需改动
        $parameter = array(
            "service"       => $alipay_config['service'],
            "partner"       => $alipay_config['partner'],
            "seller_id"  => $alipay_config['seller_id'],
            "payment_type"	=> $alipay_config['payment_type'],
            "notify_url"	=> $alipay_config['notify_url'],
            "return_url"	=> $alipay_config['return_url'],

            "anti_phishing_key"=>$alipay_config['anti_phishing_key'],
            "exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "body"	=> $body,
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
            //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
            //如"参数名"=>"参数值"
        );
//建立请求

        $alipaySubmit = new \AlipaySubmit($alipay_config);

        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
    }

    public function alipayphone(){
        global $alipay_config;
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $_POST['WIDout_trade_no'];
        //订单名称，必填
        $subject = $_POST['WIDsubject'];
        //付款金额，必填
        $total_fee = $_POST['WIDtotal_fee'];
        //收银台页面上，商品展示的超链接，必填
        $show_url = $_POST['WIDshow_url'];
        //商品描述，可空
        $body = $_POST['WIDbody'];
//构造要请求的参数数组，无需改动
        $parameter = array(
            "service"       => $alipay_config['service'],
            "partner"       => $alipay_config['partner'],
            "seller_id"  => $alipay_config['seller_id'],
            "payment_type"	=> $alipay_config['payment_type'],
            "notify_url"	=> $alipay_config['notify_url'],
            "return_url"	=> $alipay_config['return_url'],
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "show_url"	=> $show_url,
            //"app_pay"	=> "Y",//启用此参数能唤起钱包APP支付宝
            "body"	=> $body,
            //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.2Z6TSk&treeId=60&articleId=103693&docType=1
            //如"参数名"	=> "参数值"   注：上一个参数末尾需要“,”逗号。

        );

//建立请求
        $alipaySubmit =new \AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
    }


    public function returnurl(){
        //商户订单号
//        $out_trade_no = $_GET['out_trade_no'];
        $out_trade_no = request()->param('out_trade_no');
        Db::startTrans();
        try{
            Db::table('lyt_order')
                ->where('oid',$out_trade_no)
                ->update(['orderStatus'=>2]);

            Db::table('lyt_trains')
                ->where('oid',$out_trade_no)
                ->update(['oStatus'=>2]);
            Db::commit();
            return 1;
        }catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
    }

}