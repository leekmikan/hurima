<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>通報</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../main.css">
	<link rel="stylesheet" href="../chat/chat.css">
	<script src="main.js"></script>
	</head>
		<body>
			<header>
				<a href="index.php"><img class="logo" src="../../../img/logo.jpg"></a>
					<form id="myForm" name="myForm" method="get" action="items/index.php">
						<a>　　</a>
						<input class="search" type="search" id="site-search" name="key_word">
						<input type="submit" id="sb" value="検索">
						<button type="button" onclick="location.href='../../../put/index.php'">出品</button>
						<button type="button" onclick="location.href='../../../cart/index.php'">カート</button>
						<button type="button" onclick="location.href='../../../login/my_page/msg/index.php'">新着メッセージ</button>
						<button type="button" onclick="location.href='../../../login/index.php'">ログイン新規会員登録</button>
						<input type="hidden" name="genre" id="genre" value="-1">
						<div class="ct tab">
							<ul>
								<?php
									require_once '../../../server/const.php';
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
				<div class="main ct">
				<?php
				session_start();
				if(isset($_SESSION['id'])){
					if(!isset($_POST['detail'])){
						header('Location:../index.php');exit;
					}else if(isset($_POST['reason'])){
						$mysqli = new mysqli("localhost", "root", "", "hurima_data");
						$mysqli->query('INSERT INTO report (who, item_id, reason) VALUES ("'.$_SESSION['id'].'", "'.$_POST['detail'].'", "'.$_POST['reason'].'");');
						header('Location:../../index.php');exit;
					}
				}else{
					header('Location:../../../login/index.php');exit;
				}
				?>
			<p>通報理由を入力してください</p>
			<form name="myForm" method="post" action="index.php">
				<textarea name="reason" cols="40" rows="8"></textarea>
				<?php
					echo '<input name="detail" type="hidden" value="'.$_POST['detail'].'">';
				?>
				<br><br>
				<input type="submit" value="送信">
			</form>
				</div>
			<footer>
				<?php require_once '../../../server/init.php'; Footer();?>
			</footer>
		</body>
	</head>
</html>