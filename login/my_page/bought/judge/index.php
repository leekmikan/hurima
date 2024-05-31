<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>メッセージ</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../../main.css">
	<link rel="stylesheet" href="../../../../items/detail/chat/chat.css">
	<link rel="stylesheet" href="judge.css">
	</head>
		<body>
			<?php
				session_start();
				$bk = false;
				$mysqli = new mysqli("localhost", "root", "", "hurima_data");
				if (isset($_SESSION['id']) && isset($_POST['detail'])) {
					$stmt = $mysqli->query('SELECT * FROM items WHERE id = '.$_POST['detail'].' LIMIT 1;');
					$item_data = $stmt->fetch_array(MYSQLI_ASSOC);
					if(isset($_POST['judge'])){
						$i = 0;
						for($i = 5;$i >= 2;$i--){
							if(in_array(''.$i, $_POST['judge'])){
								break;
							}
						}
						$mysqli->query('UPDATE items SET judge = "'.$i.'" WHERE id = '.$_POST['detail'].' LIMIT 1;');
						$mysqli->query('UPDATE items SET reason = "'.$_POST['msg'].'" WHERE id = '.$_POST['detail'].' LIMIT 1;');
						header('Location:../../index.php');exit;
					}
				}
				else if(isset($_SESSION['id'])){
					header('Location:../index.php');exit;
				} 
				else{
					header('Location:../../../../index.php');exit;
				}
			?>
			<header>
				<h1 id="title">評価</h1>
			</header>
			<div class="main ct">
				<p>評価</p>
				<form name="myForm" method="post" action="index.php">
					<input type="checkbox" id="0" name="judge[]" value="1">
					<img name="star" class="jt" onclick="ch(0)" src="無題2.png">
					<input type="checkbox" id="1" name="judge[]" value="2">
					<img name="star" class="jt" onclick="ch(1)" src="無題2.png">
					<input type="checkbox" id="2" name="judge[]" value="3">
					<img name="star" class="jt" onclick="ch(2)"  src="無題2.png">
					<input type="checkbox" id="3" name="judge[]" value="4">
					<img name="star" class="jt" onclick="ch(3)"  src="無題2.png">
					<input type="checkbox" id="4" name="judge[]" value="5">
					<img name="star" class="jt" onclick="ch(4)"  src="無題2.png"><br>
					<?php
						if(isset($_POST['detail'])){
							echo '<p>理由/コメント</p>';
							echo '<textarea name="msg" cols="40" rows="8"></textarea><br>';
							echo '<input type="submit" value="送信">';
							echo '<input name="detail" type="hidden" value="'.$_POST['detail'].'">';
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