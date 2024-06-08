<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>カート</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../img/icon.jpg">
	<link rel="stylesheet" href="../main.css">
	<link rel="stylesheet" href="cart.css">
	</head>
		<body>
			<?php
			session_start();
				if (isset($_SESSION['id'])) {
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
				}else{
					$_SESSION['loc'] = "../cart/index.php";
					header('Location:../login/index.php');exit;
				}
			?>
			<header>
			<a href="index.php"><img class="logo" src="../img/logo.jpg"></a>
				<form id="myForm" name="myForm" method="get" action="../items/index.php">
						<a>　　</a>
						<input class="search" type="search" id="site-search" name="key_word">
						<input type="submit" id="sb" value="検索">
						<button type="button" onclick="location.href='../put/index.php'">出品</button>
						<button type="button" onclick="location.href='index.php'">カート</button>
						<button type="button" onclick="location.href='../login/index.php'">ログイン新規会員登録</button>
						<button type="button" onclick="location.href='../opinion/index.php'">意見箱</button>
						<input type="hidden" name="genre" id="genre" value="-1">
						<div class="ct tab">
							<ul>
								<?php
									require_once '../server/const.php';
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
			<form name="myForm" method="post" action="confirm/index.php">
			<?php
			    //カート表示 なければ空と表示
				if (isset($_SESSION['id'])) {
						$ar = json_decode($data['cart']);
						$found = false;
						if(count($ar) == 0){
							echo '<h2>カートは空です</h2>';
						}else{
							foreach($ar as $id){
								$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$id.'" LIMIT 1;');
								$item_data = $stmt->fetch_array(MYSQLI_ASSOC);
								$sum = 0;
								if($item_data != NULL){
									if(!$found){
										$found = true;
										echo '<h2>カートの中身</h2>';
										echo '<table border="1">';
										echo '<tr>';
										echo '<td>商品名</td>';
										echo '<td>画像</td>';
										echo '<td>詳細</td>';
										echo '<td>小計</td>';
										echo '<td>取消</td>';
										echo '</tr>';
									}
									echo '<tr>';
									echo '<td>'.$item_data['item_name'].'</td>';
									if($item_data['src0'] == "0"){
										echo '<td><img type="image" class="item_img" src="test.jpg"></td>';
									}else{
										$img = file_get_contents('../user_img/'.$item_data['src0'].'.dat');
										echo '<td><img type="image" class="item_img" src="'.$img.'"></td>';
									}
									echo '<td>'.nl2br($item_data['exp']).'</td>';
									echo '<td><span name="price">'.$item_data['price'].'</span>円</td>';
									echo '<td><input type="checkbox" name="cancel[]" value="'.$item_data['id'].'"></input></td>';
									echo '</tr>';
									$sum += intval($item_data['price']);
								}
							}
							echo '</table>';
							if(!$found){
								echo '<h2>カートは空です</h2>';
							}else{
								echo '<div>';
								echo '<h1>合計金額　<span id="sum">0</span>円</h1><br>';
								if(isset($_SESSION['id'])){
									echo '<label for="email">ポイントを使う　(現在のポイント: '.$data['points'].'P)</label><br>';
									$max_p = min(intval($data['points']),$sum);
									echo '<input type="number" name="points" id="points" value="0" min="0" max="'.$max_p.'">';
									echo '<p>'.$max_p.'Pまで使えます</p>';
								}
								echo '<input type="submit" value="購入する(確認画面へ)">';
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
		<script src="../main.js"></script>
	</head>
</html>