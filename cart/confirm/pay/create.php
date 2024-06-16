<?php
//変更いらないはず
require_once '../../../server/const.php';
require_once '../../../server/'.$STRIPE_API;

$stripe = new \Stripe\StripeClient($SECRET);

try {
    $token = isset($_POST["token"]) ? $_POST["token"] : "";
    $session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
    unset($_SESSION["token"]);
    if($token != "" && $token == $session_token) {
    $token = uniqid('', true);
	$_SESSION['token'] = $token;
    $_SESSION['points'] = $_POST['points'];
    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
	    $stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'";');
		$data = $stmt->fetch_array(MYSQLI_ASSOC);
		$ar = json_decode($data['cart']);
		$sum = 0;
		if(count($ar) == 0){
			header('Location:../../index.php');
		}else{
			foreach($ar as $id){
				$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$id.'" LIMIT 1;');
				$data2 = $stmt->fetch_array(MYSQLI_ASSOC);
				if(mysqli_num_rows($stmt) != 0){
                    if(is_null($data2['buy_id'])){
					    $sum += intval($data2['price']);
                    }
				}
			}
        $use_points = min(intval($data['points']),intval($_POST['points']),$sum);
        $sum -= $use_points;
		echo '<script>var price = '.$sum.'</script>';
        if($sum == 0){
            header('Location:stripe/index.php');
        }
		$mysqli->query('UPDATE users SET points = '.(intval($data['points']) - $use_points).' WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
		}
    // Create a PaymentIntent with amount and currency
    $paymentIntent = $stripe->paymentIntents->create([
        'amount' => $sum,
        'currency' => 'jpy',
        // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
        'automatic_payment_methods' => [
            'enabled' => true,
        ],
    ]);

    $output = [
        'clientSecret' => $paymentIntent->client_secret,
    ];
    $mysqli->query('UPDATE users SET tmp = "'.$paymentIntent['id'].'" WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
    echo '<script>var items = '.json_encode($output).';</script>';
    }else{
        header('Location:../../../index.php');
    }
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}