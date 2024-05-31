<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>商品詳細</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../img/icon.jpg">
	<link rel="stylesheet" href="../../main.css">
	<link rel="stylesheet" href="../items.css">
	<link rel="stylesheet" href="detail.css">
	</head>
		<body>
			<header>
				<a href="../../index.php"><img class="logo" src="../../img/logo.jpg"></a>
				<form id="myForm" name="myForm" method="get" action="../index.php">
						<a>　　</a>
						<input class="search" type="search" id="site-search" name="key_word">
						<input type="submit" id="sb" value="検索">
						<button type="button" onclick="location.href='../../put/index.php'">出品</button>
						<button type="button" onclick="location.href='../../cart/index.php'">カート</button>
						<button type="button" onclick="location.href='../../login/index.php'">ログイン新規会員登録</button>
						<button type="button" onclick="location.href='../../opinion/index.php'">意見箱</button>
						<input type="hidden" name="genre" id="genre" value="-1">
						<div class="ct tab">
							<ul>
								<?php
									require_once '../../server/const.php';
									for($i = 0;$i < count($GENRE);$i++){
										echo '<li>';
										echo '<a class="tabt" onclick="set_ip('.$i.')">'.$GENRE[$i].'</a>';
										echo '</li>';
									}
								?>
							</ul>
						</div>
					</form>
			</header>
			<div class="main">
				<?php
				$mysqli = new mysqli("localhost", "root", "", "hurima_data");
				session_start();
				if (isset($_GET['cart'])) {
					if(!isset($_SESSION['id'])){
						$_SESSION['loc'] = "../cart/index.php";
						echo '<input type="hidden" name="cart" value="'.$_GET['cart'].'">';
						header('Location:../login/index.php');exit;
					}else{
						$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$_GET['cart'].'" LIMIT 1;');
						if(mysqli_num_rows($stmt) != 0){
							$mysqli->query('UPDATE users SET cart = IFNULL(json_array_append(cart, "$", "'.$_GET['cart'].'"), json_array("'.$_GET['cart'].'")) WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
						}
						header('Location:../index.php');exit;
					}
				}
				else if (isset($_GET['detail'])) {
					$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$_GET['detail'].'" LIMIT 1;');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
					$stmt2 = $mysqli->query('SELECT * FROM users WHERE id = "'.$data['user_id'].'" LIMIT 1;');
					$user_data = $stmt2->fetch_array(MYSQLI_ASSOC);
					if($user_data['frag'] % 2 == 1){
						echo '<div class="ct"><p style="color: red;">凍結されているアカウントの商品です。</p></div>';
					}
					echo '<div class="contentA">';
					for ($i = 0;$i < 5;$i++){
						$class = "sel";
						if($i == 0){
							$class = "pic";
						}
						if($data['src'. strval($i)] == "0"){
							echo '<img class="'.$class.'" src="../../img/noimage.jpg">';
						}else{
							$img = file_get_contents('../../user_img/'.$data['src'. strval($i)].'.dat');
							echo '<img class="'.$class.'" src="'.$img.'">';
						}
					}
					echo '<div class="info">';
					require_once '../../server/const.php';
					$add_image = '';
					if(($user_data['frag'] >> 1) % 2 == 1){
						$add_image .= '<img class="sp_icon" src="../../img/offical.jpg">';
					}
					if(($user_data['frag'] >> 2) % 2 == 1){
						$add_image .= '<img class="sp_icon" src="../../img/administrator.jpg">';
					}
					echo '<a href="user_info/index.php?id='.$user_data['id'].'">出品者:　'.$user_data['user_name'].'</a>'.$add_image.'<br>';
					echo '<p>カテゴリー:　'.$GENRE[$data['genre']].'</p>';
					echo '<p>状態:　'.$STAT[$data['stat']].'</p>';
					echo '<p>配送方法:　'.$HSEND[$data['hsend']].'</p>';
					echo '<p>配送元:　'.$user_data['adress'].'</p>';
					echo '</div>';
					echo '</div>';
					echo '<div class="contentB">';
					echo '<div class="big_info">';
					echo '<h1>'.$data['item_name'].'</h1>';
					echo '<h2><span name="price">'.$data['price'].'</span>円</h2><br>';
					echo '<p>商品説明</p>';
					echo '<p>'.nl2br($data['exp']).'</p>';
					echo '</div>';
					if(isset($_SESSION['id'])){
						$mysqli->query('UPDATE users SET history = IFNULL(json_array_append(history, "$", "'.$_GET['detail'].'"), json_array("'.$_GET['detail'].'")) WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
					}
				}else{
					header('Location:../index.php');exit;
				}
				?>
				<br>
					<?php
					if(isset($_GET['detail']) && isset($_SESSION['id'])){
						$stmt2 = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
						$user_data = $stmt2->fetch_array(MYSQLI_ASSOC);
						$array = json_decode($user_data['cart']);
						if(!is_null($array)){
							if(!in_array($_GET['detail'], $array)){
								echo '<form name="myForm" method="get" action="index.php">';
								echo '<input class="cB_button" type="submit" value="カートに入れる">';
								echo '<input type="hidden" name="cart" value="'.$_GET['detail'].'">';
								echo '</form>';
							}
						}
					}
					?>
					<br>
					<form name="myForm" method="post" action="chat/index.php">
						<?php
						if(isset($_SESSION['id']) && isset($data['user_id']) && isset($_GET['detail'])){
							if($_SESSION['id'] != $data['user_id']){
								echo '<input type="submit" value="メッセージを送る">';
								echo '<input name="detail" type="hidden" value="'.$_GET['detail'].'">';
							}
						}
						?>
					</form>
					<br>
					<form name="myForm" method="post" action="report/index.php">
						<?php
						if(isset($_SESSION['id']) && isset($data['user_id']) && isset($_GET['detail'])){
							$stmt2 = $mysqli->query('SELECT * FROM report WHERE who = "'.$_SESSION['id'].'" AND item_id = "'.$_GET['detail'].'" LIMIT 1;');
							if($_SESSION['id'] != $data['user_id'] && mysqli_num_rows($stmt2) == 0){
								echo '<input type="submit" value="通報">';
								echo '<input name="detail" type="hidden" value="'.$_GET['detail'].'">';
							}
						}
						?>
					</form>
				</div>
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
		<script src="../main.js"></script>
	</head>
</html>