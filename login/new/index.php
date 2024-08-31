<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>新規会員登録</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../img/icon.jpg">
	<link rel="stylesheet" href="../../main.css">
	<link rel="stylesheet" href="../login.css">
	<link rel="stylesheet" href="new.css">
	<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
	<script src="main.js"></script>
	</head>
		<body>
			<header>
				<h1 id="title">新規会員登録</h1>
			</header>
			<div class="form">
			    <!--いろいろ情報入力欄-->
				<form name="myForm" action="confirm/index.php" method="post" onsubmit="return check()">
				<label for="user_name">ニックネーム　</label>
				<input type="text" id="user_name" name="user_name" placeholder="名前を入力" ><br>
				<label for="user_sei">姓　　　　　　</label>
				<input type="text" id="user_sei" name="user_sei" placeholder="姓" ><br>
				<label for="user_mei">名　　　　　　</label>
				<input type="text" id="user_mei" name="user_mei" placeholder="名" ><br>
				<label for="email">メールアドレス</label>
				<input type="email" id="email" name="email" placeholder="メールアドレスを入力" ><br>
				<label for="password">パスワード　　</label>
				<input type="password" id="password" name="password" placeholder="パスワードを入力(半角英数字8文字以上)" ><br>
				<label for="password2">再確認　　　　</label>
				<input type="password" id="password2" name="password2" placeholder="パスワードを入力" ><br>
				<label for="adress_number">住所　　　　　</label>
				<input type="text" id="adress_number" name="adress_number" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','adress','adress');"><br>　　　　　　　
				<input type="text" id="adress" name="adress"><br>
				<label for="birth">生年月日　　　</label>
				<input type="date" id="birth" name="birth"><br>
				<div class="div_button">
					<input type="submit" value="確認画面へ">
				</div>
				</form>
			</div>
			<footer>
				<?php require_once '../../server/init.php'; Footer();?>
			</footer>
		</body>
	</head>
</html>