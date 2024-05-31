<?php
session_start();
if (isset($_SESSION['id'])) {
    require_once '../../../server/const.php';
    require_once '../../../server/'.$STRIPE_API;
    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
    $stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'";');
    $data = $stmt->fetch_array(MYSQLI_ASSOC);
    $stripe = new \Stripe\StripeClient($SECRET);
    $stripe->subscriptions->update($data['sub'], ['cancel_at_period_end' => false]);
}
header('Location:index.php');
?>