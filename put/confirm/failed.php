<?php
//登録キャンセル
session_start();
if(isset($_SESSION['id'])){
    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
    $mysqli->query('UPDATE users SET s_id = NULL WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
    $mysqli->query('DELETE FROM items WHERE user_id = "'.$_SESSION['id'].'";');
}
echo '<script>alert("登録をキャンセルしました。");</script>';
header('Location:../../index.php');
?>