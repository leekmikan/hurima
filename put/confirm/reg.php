<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>登録処理</title>
	</head>
		<body>
            <?php
                require_once('../../server/const.php');
                require_once('../../server/stripe-php-13.10.0-beta.3/stripe-php-13.10.0-beta.3/init.php');
                \Stripe\Stripe::setApiKey($SECRET);
                session_start();
                $token = isset($_POST["token"]) ? $_POST["token"] : "";
                $session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
                unset($_SESSION["token"]);
                if($token != "" && $token == $session_token) {
                $file_list = glob("../../user_img/*.*");
                $j = 0;
                $srcs = [0,0,0,0,0];
                for($i = 0;$i < 5;$i++){
                    if($_POST[strval($i)] != "http://localhost/PHP/hurima/img/noimage.jpg" && $_POST[strval($i)] != "noimage.jpg" ){
                        $found = true;
                        while($found){
                            $j++;
                            $found = in_array('../../user_img/' .strval($j). '.dat', $file_list);
                        }
                        $srcs[$i] = $j;
                        $upload_file = '../../user_img/' . strval($j) . '.dat';
                        touch($upload_file);
                        file_put_contents($upload_file, $_POST[strval($i)]);
                    }
                }
				if (isset($_SESSION['id'])) {
                    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
                    $stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
                    $data = $stmt->fetch_array(MYSQLI_ASSOC);
                    require_once '../../server/const.php';
                    $stripe = new \Stripe\StripeClient($SECRET);
                    if(is_null($data['s_id'])){
                        $account = $stripe->accounts->create([
                            'type' => 'custom',
                            'country' => 'JP',
                            'default_currency' => 'jpy',
                            'email' => $data['mail'],
                            'capabilities' => [
                                'card_payments' => ['requested' => true],
                                'transfers' => ['requested' => true],
                              ],
                        ]);
                        $link = $stripe->accountLinks->create([
                            'account' => $account['id'],
                            'refresh_url' => 'http://localhost/PHP/hurima/put/confirm/failed.php',
                            'return_url' => 'http://localhost/PHP/hurima/index.php',
                            'type' => 'account_onboarding'
                        ]);
                        $mysqli->query('INSERT INTO items (item_name, price, src0, src1, src2, src3, src4, exp, genre, stat, hsend, user_id,buy_id,judge,reason) VALUES ("'.$_POST['name'].'","'.$_POST['price'].'","'.$srcs[0].'","'.$srcs[1].'","'.$srcs[2].'","'.$srcs[3].'","'.$srcs[4].'","'.$_POST['exp'].'","'.$_POST['genre'].'","'.$_POST['stat'].'","'.$_POST['send'].'","'.$_SESSION['id'].'",NULL,NULL,NULL)');
                        $mysqli->query('UPDATE users SET s_id = "'.$account['id'].'" WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
                        header('Location:'.$link['url']);
                    }else{
                        $mysqli->query('INSERT INTO items (item_name, price, src0, src1, src2, src3, src4, exp, genre, stat, hsend, user_id,buy_id,judge,reason) VALUES ("'.$_POST['name'].'","'.$_POST['price'].'","'.$srcs[0].'","'.$srcs[1].'","'.$srcs[2].'","'.$srcs[3].'","'.$srcs[4].'","'.$_POST['exp'].'","'.$_POST['genre'].'","'.$_POST['stat'].'","'.$_POST['send'].'","'.$_SESSION['id'].'",NULL,NULL,NULL)');
                        header('Location:../../index.php');
                    }
				}else{
					header('Location:../../login/index.php');
				}
                }else{
                    header('Location:../../login/index.php');
                }
            ?>
        </body>
    </head>
</html>