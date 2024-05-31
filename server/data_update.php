<?php
//ジャンルを追加したら実行 $x...何番目に追加したか(先頭0番目).
function Add_genre($i){
    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
    $stmt = $mysqli->query('UPDATE items SET genre = genre + 1 WHERE genre >= "'.$i.'";');
}

//完了した取引を削除 $M...期限(月).
function Delete_items($M){
    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
    $stmt = $mysqli->query('SELECT * FROM items WHERE MONTH(TIMEDIFF(NOW(),buy_time)) >= "'.$M.'" AND buy_time IS NOT NULL;');
    if(!mysqli_num_rows($stmt) == 0){
        while($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
            for($i = 0;$i < 5;$i++){
                if($row['src'.$i] != '0'){
                    if(!unlink('../user_img/'.$row['src'.$i].'.dat')){
                        echo 'ERROR:　../user_img/'.$row['src'.$i].'.dat';
                    }
                }
            }
            $stmt = $mysqli->query('DELETE FROM msg WHERE item_id = "'.$row['id'].'";');
        }
        $mysqli->query('DELETE FROM items WHERE MONTH(TIMEDIFF(NOW(),buy_time)) >= "'.$M.'" AND buy_time IS NOT NULL;');
    }
}
function Check_report($cons){
    $list = [];
    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
    $stmt = $mysqli->query('SELECT * FROM report;');
    if(!mysqli_num_rows($stmt) == 0){
        while($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
            $stmt2 = $mysqli->query('SELECT * FROM items WHERE id = "'.$row['item_id'].'" LIMIT 1;');
            $item_data = $stmt2->fetch_array(MYSQLI_ASSOC);
            if(isset($list[strval($item_data['user_id'])])){
                $list[strval($item_data['user_id'])]++;
            }else{
                $list[strval($item_data['user_id'])] = 1;
            }
        }
    }
    foreach ($list as $key => $value) {
        echo $key."：".$value."\n";
    }
}
//フラグ操作　$id...ユーザーID   $after_val 1...凍結 2...公式 4...管理者 8...クイズ正解者 16...メール受信拒否 32...支援者 64...- 128...-  .
function Change_frag($id,$after_val){
    $msg = ['凍結','公式','管理者','クイズ正解者','メール受信拒否','支援者'];
    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
    $stmt = $mysqli->query('UPDATE users SET frag = "'.$after_val.'" WHERE id = "'.$id.'";');
    for($i = 0;$i < count($msg);$i++){
        switch(($after_val >> $i) % 2){
            case 0: echo $msg[$i].'：OFF'."\n"; break;
            case 1: echo $msg[$i].'：ON'."\n"; break;
        }
    }
}
//クイズの当選処理+当選者への通知(月1回) サイト名未入力.
function Quiz_Reward(){
    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
    $hit = mysqli_num_rows($mysqli->query("SELECT id FROM users WHERE (frag >> 3) % 2 = 1;")) ;
    if($hit == 0){
        echo 'ERROR:正解者なし';
    }else{
        $rand = mt_rand(0,$hit - 1);
        $stmt = $mysqli->query('SELECT * FROM users WHERE (frag >> 3) % 2 = 1 LIMIT '.$rand.','.($rand + 1).';');
        $data = $stmt->fetch_array(MYSQLI_ASSOC);
        echo '当選者ID:'.$data['id'];
        $mysqli->query('UPDATE users SET frag = frag - 8 WHERE id = "'.$data['id'].'";');
        $mysqli->query('UPDATE users SET points = points + 1000 WHERE id = "'.$data['id'].'";');
        require_once 'mail.php';
        Send_mail($data['mail'],"ポイント当選のお知らせ",'<html><body><h2>'.$data['user_name'].'様</h2><p>[サイト名]におきまして、1000ポイントが当選されましたことをお知らせします。</p></body></html>');
    }
}
//$title...タイトル  $html...送信するHTML  $all...true->メール受信拒否者にも送信
function Send_mail_all($title,$html,$all){
    require_once 'mail.php';
    $contents = file_get_contents($html);
    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
    $req = "";
    if(!$all){
        $req = " WHERE frag & 16 = 16";
    }
    $stmt = $mysqli->query('SELECT sei,mei,mail FROM users'.$req.';');
    while($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
        $rt = mb_ereg_replace('{USER_NAME}', $row['sei'].'　'.$row['mei'].'様', $contents);
        Send_mail($row['mail'],$title,$rt);
    }
}
function Support_reset(){
    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
    $mysqli->query('UPDATE users SET frag = frag - (frag & 32);');
}
//Add_genre();
//Delete_items(0);
//Check_report();
//Change_frag(9,6);
//Send_mail_all("お知らせ","mail_msg.html",false);

//月1.
//Quiz_Reward();
//Support_reset();
?>