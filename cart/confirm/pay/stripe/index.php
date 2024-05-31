<?php
require_once('../../../../server/const.php');
require_once('../../../../server/stripe-php-13.10.0-beta.3/stripe-php-13.10.0-beta.3/init.php');
\Stripe\Stripe::setApiKey($SECRET);
session_start();
				if (isset($_SESSION['id'])) {
					$session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
					unset($_SESSION["token"]);
					$pt = 0;
					if(isset($_SESSION['points'])){
						$pt = intval($_SESSION['points']);
						unset($_SESSION['points']);
					}
					if($session_token != "") {
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
					$ar = json_decode($data['cart']);
					$cart = $ar;
					$stripe = new \Stripe\StripeClient($SECRET);
					if(count($ar) == 0){
						header('Location:../index.php');exit;
					}else{
						echo '<form id="myForm" name="myForm" method="post" action="finish/index.php">';
						$sum = 0;
						foreach($ar as $id){
							$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$id.'" LIMIT 1;');
							$item_data = $stmt->fetch_array(MYSQLI_ASSOC);
							if(mysqli_num_rows($stmt) != 0){
								$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$item_data['user_id'].'" LIMIT 1;');
								$sell_data = $stmt->fetch_array(MYSQLI_ASSOC);
								if(!is_null($item_data['buy_id'])){
									echo '<input type="hidden" name="sold_out[]" value="'.$item_data['id'].'">';
								}
								else if(!is_null($sell_data['s_id'])){
								try {
									if(!is_null($sell_data['sub'])){
										$sub = $stripe->subscriptions->retrieve($sell_data['sub'], []);
										if($sub['status'] == 'active'){
											$stripe->transfers->create([
												'amount' => round($item_data['price']), //サブスク用
												'currency' => 'jpy',
												'destination' => $sell_data['s_id'],
												'transfer_group' => 'TEST',
											]);
										}else{
											$stripe->transfers->create([
												'amount' => round($item_data['price'] * (1 - $FEE)), //手数料ひく
												'currency' => 'jpy',
												'destination' => $sell_data['s_id'],
												'transfer_group' => 'TEST',
											  ]);
										}
									}else{
									$stripe->transfers->create([
										'amount' => round($item_data['price'] * (1 - $FEE)), //手数料ひく
										'currency' => 'jpy',
										'destination' => $sell_data['s_id'],
										'transfer_group' => 'TEST',
									  ]);
									}
									$sum += intval($item_data['price']);
									require_once '../../../../server/mail.php';
									Send_mail($sell_data['mail'],"購入されました","商品名:<br>".$item_data['item_name']."<br><br>住所:<br>".$data['adress_num']."<br>".$data['adress']);
									echo '<input type="hidden" name="bought[]" value="'.$item_data['id'].'">';
									$mysqli->query('UPDATE items SET buy_id = "'.$_SESSION['id'].'", buy_time = "'.date("Y-m-d H:i:s").'" WHERE id = "'.$id.'" LIMIT 1;');
									$cart = array_diff($cart,[$id]);
								} catch (Error $e) {
									echo $e->getMessage();
								}
								}else{

								}
							}
						}
						$cart = array_values($cart);
						$tmp = "";
						$len = count($cart);
						for($i = 0;$i < $len;$i++){
							$tmp .= '"'.$cart[$i].'"';
							if($i + 1 < $len){
								$tmp .= ",";
							}
						}
						$mysqli->query('UPDATE users SET cart = JSON_REMOVE(cart, "$") WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
						$mysqli->query('UPDATE users SET cart = JSON_ARRAY('.$tmp.') WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
						$get_points = round(($sum - $pt) * $POINT);
						$mysqli->query('UPDATE users SET points = '.(intval($data['points']) + $get_points).' WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
						echo '</form>';
						echo '<script>var target = document.getElementById("myForm");target.method = "post";target.submit();</script>';
					}
					}else{
						header('Location:../../../index.php');exit;
					}
				}else{
					header('Location:../../../../login/index.php');exit;
				}