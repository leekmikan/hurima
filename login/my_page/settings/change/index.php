<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>プロフィール変更</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../../main.css">
	<link rel="stylesheet" href="../../../../login/login.css">
	<link rel="stylesheet" href="../../../../login/new/new.css">
	<link rel="stylesheet" href="change.css">
	<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
	</head>
		<body>
			<?php
				session_start();
				if(isset($_POST['out'])){
					session_destroy();
					header('Location:../../index.php');exit;
				}
				if (isset($_SESSION['id'])) {
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
				}else{
					header('Location:../../index.php');exit;
				}
			?>
			<header>
				<h1 id="title">プロフィール変更</h1>
			</header>
			<form name="myForm" action="confirm/index.php" method="post" onsubmit="return check()">
			<div class="main">
				<div class="contentA">
				<label for="user_name">ニックネーム　</label>
				<?php
					echo '<input type="text" id="user_name" name="user_name" placeholder="名前を入力" value="'.$data['user_name'].'"><br>'
				?>
				<label for="user_sei">姓　　　　　　</label>
				<?php
					echo '<input type="text" id="user_sei" name="user_sei" placeholder="姓" value="'.$data['sei'].'"><br>'
				?>
				<label for="user_mei">名　　　　　　</label>
				<?php
					echo '<input type="text" id="user_mei" name="user_mei" placeholder="名" value="'.$data['mei'].'"><br>'
				?>
				<label for="email">メールアドレス</label>
				<?php
					echo '<input type="email" id="email" name="email" placeholder="メールアドレスを入力" value="'.$data['mail'].'"><br>'
				?>
				<label for="password">パスワード　　</label>
				<?php
					echo '<input type="password" id="password" name="password" placeholder="パスワードを入力(半角英数字8文字以上)" value="'.$data['pass'].'"><br>'
				?>
				<label for="password2">再確認　　　　</label>
				<input type="password" id="password2" name="password2" placeholder="パスワードを入力" ><br>
				<label for="adress_number">住所　　　　　</label>
				<?php
					echo '<input type="text" id="adress_number" name="adress_number" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,\'\',\'adress\',\'adress\');" value="'.$data['adress_num'].'"><br>';
					echo '　　　　　　 　<input type="text" id="adress" name="adress" value="'.$data['adress'].'"><br>';
				?>
				<label for="birth">生年月日　　　</label>
				<?php
					echo '<input type="date" id="birth" name="birth" value="'.$data['birth'].'"><br>'
				?>
			
			</div>
			<div class="contentB">
			<p>コメント</p>
				<?php
					echo '<textarea id="msg" name="msg" cols="40" rows="4" placeholder="160字以内" maxlength="160" value="'.$data['msg'].'"></textarea><br>'
				?>
			</div>
			</div><br>
			<div class="div_button">
				<input type="submit" value="確認画面へ">
			</div><br><br>
			</form>
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