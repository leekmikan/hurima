<?php
session_start();
if(isset($_SESSION['id']) && isset($_SESSION['sub'])){
    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
    $mysqli->query('UPDATE users SET sub = "'.$_SESSION['sub'].'" WHERE id = "'.$_SESSION['id'].'";');
    unset($_SESSION['sub']);
}
header('Location:../../../../index.php');exit;
?>