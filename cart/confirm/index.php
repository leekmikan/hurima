<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>購入確認</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../img/icon.jpg">
	<link rel="stylesheet" href="../../main.css">
	<link rel="stylesheet" href="../cart.css">
	</head>
		<body>
		<?php
			session_start();
			$mysqli = new mysqli("localhost", "root", "", "hurima_data");
				if (isset($_SESSION['id'])) {
					$token = isset($_POST["token"]) ? $_POST["token"] : "";
					$session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
					unset($_SESSION["token"]);
					if($token != "" && $token == $session_token) {
						$token = uniqid('', true);
						$_SESSION['token'] = $token;
						if (isset($_POST['cancel'])){
							$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
							$data = $stmt->fetch_array(MYSQLI_ASSOC);
							$ar = json_decode($data['cart']);
							$ar = array_diff($ar, $_POST['cancel']);
							$ar = array_values($ar);
							$tmp = "";
							$len = count($ar);
							for($i = 0;$i < $len;$i++){
								$tmp .= '"'.$ar[$i].'"';
								if($i + 1 < $len){
									$tmp .= ",";
								}
							}
							$mysqli->query('UPDATE users SET cart = JSON_REMOVE(cart, "$") WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
							$mysqli->query('UPDATE users SET cart = JSON_ARRAY('.$tmp.') WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
						}
						$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
						$data = $stmt->fetch_array(MYSQLI_ASSOC);
						if(isset($_SESSION['points'])){
							$mysqli->query('UPDATE users SET points = '.(intval($_SESSION['points']) + intval($data['points'])).' WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
						}
					}else{
						header('Location:../../index.php');exit;
					}
				}else{
					header('Location:../login/index.php');exit;
				}
			?>
			<div class="main">
				<br>
				<?php
				$sell_money = false;
				if(!is_null($_POST['sell_money'])){
					if($_POST['sell_money'] == 1){
						$sell_money = true;
					}
				}
				if($sell_money){
					echo '<form name="myForm" method="post" action="pay2/index.php">';
				}else{
					echo '<form name="myForm" method="post" action="pay/index.php">';
				}
				//カート表示 なければ前のページに戻る
				if (isset($_SESSION['id'])) {
						$ar = json_decode($data['cart']);
						$found = false;
						$token = uniqid('', true);
						$_SESSION['token'] = $token;
						echo '<input type="hidden" name="token" value="'.$token.'">';
						if(count($ar) == 0){
							header('Location:../index.php');exit;
						}else{
							$sum = 0;
							foreach($ar as $id){
								$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$id.'" LIMIT 1;');
								$data = $stmt->fetch_array(MYSQLI_ASSOC);
								if($data != NULL){
									if(!$found){
										$found = true;
										echo '<table border="1">';
										echo '<tr>';
										echo '<td>商品名</td>';
										echo '<td>画像</td>';
										echo '<td>詳細</td>';
										echo '<td>小計</td>';
										echo '</tr>';
									}
									echo '<tr>';
									echo '<td>'.$data['item_name'].'</td>';
									if($data['src0'] == "0"){
										echo '<td><img type="image" class="item_img" src="test.jpg"></td>';
									}else{
										$img = file_get_contents('../../user_img/'.$data['src0'].'.dat');
										echo '<td><img type="image" class="item_img" src="'.$img.'"></td>';
									}
									echo '<td>'.nl2br($data['exp']).'</td>';
									echo '<td><span name="price">'.$data['price'].'</span>円</td>';
									echo '</tr>';
									$sum += intval($data['price']);
								}
								echo '<input type="hidden" name="price_sum" value="'.$sum.'">';
							}
							echo '</table>';
							if(!$found){
								header('Location:../index.php');exit;
							}else{
								echo '<div>';
								echo '<h1>合計金額　<span id="sum">0</span>円</h1>';
								if($sell_money){
									echo '<p>売上から支払い</p>';
								}else{
									echo '<p>消費ポイント:　'.$_POST['points'].'P</p>';
									echo '<input type="hidden" name="points" value="'.$_POST['points'].'">';
								}
								echo '<p>上記の商品を本当に購入してよろしいでしょうか。</p>';
								echo '<input type="hidden" name="token" value="'.$token.'">';
								echo '<input type="submit" value="購入する">';
								echo '</div>';
							}
						}	
					}
					?>
				</form>
			</div>
			<footer>
				<table>
					<tr>
						<td>
							<h2>会社概要</h2>
							<p>ああああ</p>
						</td>
						<td>
							<h2>利用ガイドライン</h2>
							<p>ああああ</p>
						</td>
						<td>
							<h2>利用規約</h2>
							<p>ああああ</p>
						</td>
						<td>
							<button>リンク1</button><br>
							<button>リンク2</button>
						</td>
					</tr>
				</table>
			</footer>
		</body>
		<script src="main.js"></script>
	</head>
</html>