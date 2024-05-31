<?php
session_start();
if(isset($_SESSION['id']) && isset($_SESSION['sub'])){
    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
    $mysqli->query('UPDATE users SET frag = (frag + 32 - (frag & 32)) WHERE id = "'.$_SESSION['id'].'";');
    unset($_SESSION['sub']);
}
header('Location:../../index.php');exit;
?>