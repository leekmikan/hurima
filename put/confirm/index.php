<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>出品確認</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../img/icon.jpg">
	<link rel="stylesheet" href="../../main.css">
	<link rel="stylesheet" href="../../login/login.css">
	<link rel="stylesheet" href="../put.css">
	</head>
		<body>
		<?php
			session_start();
				if (isset($_SESSION['id'])) {
					$token = isset($_POST["token"]) ? $_POST["token"] : "";
					$session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
					unset($_SESSION["token"]);
					if($token != "" && $token == $session_token) {
						
					}else{
						header('Location:../index.php');exit;
					}
				}else{
					header('Location:../../login/index.php');exit;
				}
			?>
			<header>
				<h1 id="title">出品確認</h1>
			</header>
			<p class="err">初回出品者は次のファイルを読むことを推奨します<br>初回のみ出品後にStripeの連携があります</p>
			<p><a href="reg.pdf" download="Stripeの連携方法.pdf">Stripeの連携方法</a></p>
			<!--入力した内容を確認 <input type="hidden"...>はすべて送信用-->
			<div class="form">
			<form name="myForm" method="post" action="reg.php">
				<p>商品名</p>
				<?php 
				echo $_POST['name'];
				echo '<input type="hidden" name="name" value="'.$_POST['name'].'"><br>';
				 ?>
				<p>価格</p>
				<?php 
				echo $_POST['price'];
				echo '<input type="hidden" name="price" value="'.$_POST['price'].'"><br>';
				 ?>
				<p>画像</p>
				<?php
				$first = TRUE;
				for ( $i = 0;$i < 5;$i++) {
					if($first){
						echo '<img class="sam" src="'.$_POST[strval($i)].'">';
					}else{
						echo '<img src="'.$_POST[strval($i)].'">';
					}
					echo '<input type="hidden" name="'.strval($i).'" value="'.$_POST[strval($i)].'">';
					$first = FALSE;
				}
				?><br>
				<p>商品説明</p>
				<?php 
				echo nl2br($_POST['exp']);
				echo '<input type="hidden" name="exp" value="'.$_POST['exp'].'"><br>';
				 ?>
				<p>カテゴリー</p>
				<?php 
				require_once '../../server/const.php';
				echo $GENRE[$_POST['genre']];
				echo '<input type="hidden" name="genre" value="'.$_POST['genre'].'"><br>';
				 ?>
				<p>状態</p>
				<?php 
				echo $STAT[$_POST['stat']];
				echo '<input type="hidden" name="stat" value="'.$_POST['stat'].'"><br>';
				 ?>
				<p>配送方法</p>
				<?php 
				echo $HSEND[$_POST['send']];
				echo '<input type="hidden" name="send" value="'.$_POST['send'].'"><br>';
				$token = uniqid('', true);
				$_SESSION['token'] = $token;
				echo '<input type="hidden" name="token" value="'.$token.'">';
				 ?>
				<!--出品ボタン-->
				<div class="ct">
				<input type="submit" value="出品する">
				</div>
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
	</head>
</html>