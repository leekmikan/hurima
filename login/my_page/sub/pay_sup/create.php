<?php

require_once '../../../../server/const.php';
require_once '../../../../server/'.$STRIPE_API;

$stripe = new \Stripe\StripeClient($SECRET);

try {
    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
	$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'";');
	$data = $stmt->fetch_array(MYSQLI_ASSOC);
    if(($data['frag'] & 32) == 32){
        header('Location:../index.php');exit;
    }
    $customer = $stripe->customers->create([
            'name' => $data['user_name'],
            'email' => $data['mail'],
          ]);
    $subscription = $stripe->subscriptions->create([
            'customer' => $customer['id'],
            'items' => [[
                'price' => 'price_1PAktVBl4em3MIGo5uNe1zsd',
            ]],
            'payment_behavior' => 'default_incomplete',
            'payment_settings' => ['save_default_payment_method' => 'off'],
            'expand' => ['latest_invoice.payment_intent'],
        ]);
    $_SESSION['sub'] = $subscription['id'];
    $output = [
        'clientSecret' => $subscription->latest_invoice->payment_intent->client_secret,
    ];
    $mysqli->query('UPDATE users SET tmp = "'.$subscription->latest_invoice->payment_intent->client_secret.'" WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
    echo '<script>var items = '.json_encode($output).';</script>';
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}