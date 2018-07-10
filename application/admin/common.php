<?php
    function sendSMS($tel){
        //个人发信息
        require(EXTEND_PATH.'/sms/YunpianAutoload.php');

        $randStr = str_shuffle('1234567890');//产生6位随机验证码数字
        $rand = substr($randStr,0,6);
        setcookie("code",$rand, time()+3600,"/");
        $smsOperator = new SmsOperator();
        $data['mobile'] = $tel;   //发送的电话号码
        $data['text'] = '【云片网】您的验证码是'.$rand;
        $result = $smsOperator->single_send($data);
        return retuanData(1,"短信验证发送成功");
    }

