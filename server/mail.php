<?php
function Send_mail($to,$subject,$message){
    
    $headers = "From:" . $to;
    $headers .= "\r\n";
    if((strpos($to, "docomo.ne.jp") !== false) || true){ //文字化け条件確認中
        $headers .= "MIME-Version: 1.0\r\n"
         . "Content-Transfer-Encoding: 7bit\r\n"
         . "Content-Type: text/html; charset=ISO-2022-JP\r\n";
        mb_internal_encoding("UTF-8");
    }else{
        $headers .= "Content-type: text/html; charset=UTF-8";
        mb_internal_encoding("UTF-8");
    }
    mb_language("Japanese");
    mb_send_mail($to, $subject, $message, $headers);
}
//メールアドレスを隠しました.
//Send_mail("sample@docomo.ne.jp","タイトル","<html><body><h1>本文</h1></body></html>");
?>
