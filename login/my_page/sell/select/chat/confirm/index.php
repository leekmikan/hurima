<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>メッセージの内容を確認</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../../../../main.css">
	<link rel="stylesheet" href="../../../../../../login/login.css">	
	</head>
		<body>
			<?php
				session_start();
				if (isset($_SESSION['id']) && isset($_POST['msg']) && isset($_POST['detail'])) {
					$token = uniqid('', true);
					$_SESSION['token'] = $token;
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'";');
					$user_data = $stmt->fetch_array(MYSQLI_ASSOC);
					$stmt2 = $mysqli->query('SELECT * FROM items WHERE id = "'.$_POST['detail'].'" LIMIT 1;');
					$item_data = $stmt2->fetch_array(MYSQLI_ASSOC);
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$item_data['user_id'].'" LIMIT 1;');
					$sell_data = $stmt->fetch_array(MYSQLI_ASSOC);
				}
				else if(isset($_SESSION['id'])){
					header('Location:../index.php');exit;
				}else{
					header('Location:../../../../index.php');exit;
				}
			?>
			<header>
				<h1 id="title">メッセージの内容を確認</h1>
			</header>
			<?php
				if(isset($user_data) && isset($sell_data)){
					echo '<h2><span>'.$user_data['user_name'].'</span>　さんから　<span>'.$sell_data['user_name'].'</span>　さんへのメッセージ</h2>';
				}
			?>
			<div class="div_button">
				<p>以下の内容で質問者にメッセージを送ります</p>
			</div>
			<div class="form">
				<?php 
					if(isset($_POST['msg'])){
						echo '<p>'.nl2br($_POST['msg']).'</p>';
					}
				?>
			</div>
			<div class="ct">
			<form name="myForm" method="post" action="../index.php">
				<input type="submit" value="送信する">
				<?php 
					if(isset($_POST['msg']) && isset($_POST['detail'])){
						echo '<input type="hidden" name="pos" value="'.$_POST['msg'].'">';
						echo '<input type="hidden" name="detail" value="'.$_POST['detail'].'">';
						echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
						echo '<input type="hidden" name="token" value="'.$token.'">';
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