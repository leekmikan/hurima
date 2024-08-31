<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>登録確認</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../main.css">
	<link rel="stylesheet" href="../../login.css">
	<link rel="stylesheet" href="../new.css">
	<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
	</head>
		<body>
			<header>
				<h1 id="title">登録確認</h1>
			</header>
			<div class="form">
			<form name="myForm" action="reg.php" method="post">
				<p>以下の情報でよろしいでしょうか。</p>
				<p>ニックネーム</p>
				<?php
				session_start();
				$token = uniqid('', true);
                $_SESSION['token'] = $token;
                //入力されたものを全部表示 hiddenは送信用
				echo '<input type="hidden" name="token" value="'.$token.'">';
				echo $_POST['user_name'];
				echo '<input name="user_name" type="hidden" value="'.$_POST['user_name'].'"/input>';
				?><br>
				<p>姓</p>
				<?php
				echo $_POST['user_sei'];
				echo '<input name="user_sei" type="hidden" value="'.$_POST['user_sei'].'"/input>';
				?><br>
				<p>名</p>
				<?php
				echo $_POST['user_mei'];
				echo '<input name="user_mei" type="hidden" value="'.$_POST['user_mei'].'"/input>';
				?><br>
				<p>メールアドレス</p>
				<?php
				echo $_POST['email'];
				echo '<input name="email" type="hidden" value="'.$_POST['email'].'"/input>';
				?><br>
				<p>パスワード</p>
				<?php
				echo "---";
				echo '<input name="password" type="hidden" value="'.$_POST['password'].'"/input>';
				?><br>
				<p>住所</p>
				<?php
				echo $_POST['adress_number'];
				echo $_POST['adress'];
				echo '<input name="adress_number" type="hidden" value="'.$_POST['adress_number'].'"/input>';
				echo '<input name="adress" type="hidden" value="'.$_POST['adress'].'"/input>';
				?><br>
				<p>生年月日</p>
				<?php
				echo $_POST['birth'];
				echo '<input name="birth" type="hidden" value="'.$_POST['birth'].'"/input>';
				?><br>
				<div class="div_button">
				<input type="submit" value="登録">
				</div>
			</form>
			</div>
			<footer>
				<?php require_once '../../../server/init.php'; Footer();?>
			</footer>
		</body>
	</head>
</html>