<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>支払方法変更</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../../main.css">
	<link rel="stylesheet" href="../../../../login/login.css">
	<link rel="stylesheet" href="../../../../put/put.css">
	<script src="main.js"></script>
	</head>
		<body>
			<?php
				session_start();
				if(isset($_POST['out'])){
					session_destroy();
					header('Location:../../index.php');exit;
				}
				if (isset($_SESSION['id'])) {
					$mysqli = new mysqli("localhost", "root", "", "users");
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
					$data = $stmt->fetch_array(PDO::FETCH_ASSOC);
				}else{
					header('Location:../../index.php');exit;
				}
			?>
			<header>
				<h1 id="title">支払方法変更</h1>
			</header>
			<div class="form">
				<form name="myForm" action="confirm/index.php" method="post" onsubmit="return check()">
				<?php
				if(isset($_POST['loc'])){
					echo '<input type="hidden" name="loc" value="'.$_POST['loc'].'">';
				}
				?>
				<label for="pay">支払方法　</label>
				<select id="pay" name="pay">
					<option value="0">リスト1</option>
					<option value="1">リスト2</option>
					<option value="2">リスト3</option>
				</select><br>
				<label for="password">番号　　</label>
				<input type="password" id="password" name="password" placeholder="パスワードを入力" ><br>
				<div class="div_button">
					<input type="submit" value="確認画面へ">
				</div>
			</form>
			</div>
			<footer>
				<?php require_once '../../../../server/init.php'; Footer();?>
			</footer>
		</body>
	</head>
</html>