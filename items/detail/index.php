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
				if (isset($_GET['detail'])) {
					$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$_GET['detail'].'" LIMIT 1;');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
					$stmt2 = $mysqli->query('SELECT * FROM users WHERE id = "'.$data['user_id'].'" LIMIT 1;');
					$user_data = $stmt2->fetch_array(MYSQLI_ASSOC);
					$mysqli->query('UPDATE items SET click = click + 1 WHERE id = "'.$_GET['detail'].'" LIMIT 1;');
					//データベースのfragの下位1ビットから凍結判定
					if($user_data['frag'] % 2 == 1){
						echo '<div class="ct"><p style="color: red;">凍結されているアカウントの商品です。</p></div>';
					}
					//左側
					echo '<div class="contentA">';
					//画像があればbase64からデコードして張り付け　なければnoimage.jpg
					for ($i = 0;$i < 5;$i++){
					    //通常画像クラス
						$class = "sel";
						if($i == 0){
						    //サムネclass
							$class = "pic";
						}
						if($data['src'. strval($i)] == "0"){
							echo '<img class="'.$class.'" src="../../img/noimage.jpg">';
						}else{
							$img = file_get_contents('../../user_img/'.$data['src'. strval($i)].'.dat');
							echo '<img class="'.$class.'" src="'.$img.'">';
						}
					}
					//商品状態　発送元などの情報
					echo '<div class="info">';
					require_once '../../server/const.php';
					$add_image = '';
					//公式
					if(($user_data['frag'] >> 1) % 2 == 1){
						$add_image .= '<img class="sp_icon" src="../../img/offical.jpg">';
					}
					//管理者
					if(($user_data['frag'] >> 2) % 2 == 1){
						$add_image .= '<img class="sp_icon" src="../../img/administrator.jpg">';
					}
					//ユーザー情報へのリンク
					echo '<a href="user_info/index.php?id='.$user_data['id'].'">出品者:　'.$user_data['user_name'].'</a>'.$add_image.'<br>';
					echo '<p>カテゴリー:　'.$GENRE[$data['genre']].'</p>';
					echo '<p>状態:　'.$STAT[$data['stat']].'</p>';
					echo '<p>配送方法:　'.$HSEND[$data['hsend']].'</p>';
					echo '<p>配送元:　'.$user_data['adress'].'</p>';
					echo '</div>';
					echo '</div>';
					//右側
					echo '<div class="contentB">';
					echo '<div class="big_info">';
					//商品名　価格　説明
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
					//カートの中に同じ商品が入っていないかつ自身の商品でなければ「カートに入れる」を表示
					if(isset($_GET['detail']) && isset($_SESSION['id'])){
						$stmt2 = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
						$user_data = $stmt2->fetch_array(MYSQLI_ASSOC);
						$array = json_decode($user_data['cart']);
						if(!is_null($array)){
							if(!in_array($_GET['detail'], $array)){
								$token = uniqid('', true);
								$_SESSION['token'] = $token;
								echo '<form name="myForm" method="post" action="reg.php">';
								echo '<input type="hidden" name="token" value="'.$token.'">';
								echo '<input class="cB_button" type="submit" value="カートに入れる">';
								echo '<input type="hidden" name="cart" value="'.$_GET['detail'].'">';
								echo '</form>';
							}
						}
					}else if(!isset($_SESSION['id'])){
						$token = uniqid('', true);
						$_SESSION['token'] = $token;
						$_SESSION['loc'] = $_SERVER['REQUEST_URI'];
						echo '<form name="myForm" method="post" action="reg.php">';
						echo '<input type="hidden" name="token" value="'.$token.'">';
						echo '<input class="cB_button" type="submit" value="カートに入れる(要ログイン)">';
						echo '<input type="hidden" name="cart" value="'.$_GET['detail'].'">';
						echo '</form>';
					}
					?>
					<br>
					<form name="myForm" method="post" action="chat/index.php">
						<?php
						//自分の商品でなければ「メッセージを送る」を表示
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
						//通報していないかつ自身でなければ「通報」を表示
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
				<?php require_once '../../server/init.php'; Footer();?>
			</footer>
		</body>
		<script src="../../main.js"></script>
	</head>
</html>