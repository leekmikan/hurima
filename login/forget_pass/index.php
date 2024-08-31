<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>パスワード忘れ</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../img/icon.jpg">
	<link rel="stylesheet" href="../../main.css">
	<link rel="stylesheet" href="../login.css">
	<script src="main.js"></script>
	</head>
		<body>
			<?php
			$err = 0;
				if(isset($_POST["email"])){
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT * FROM users WHERE mail = "'.$_POST['email'].'" LIMIT 1;');
					if(mysqli_num_rows($stmt) != 0){
						$data = $stmt->fetch_array(MYSQLI_ASSOC);
						$rnd = "";
						$j = 0;
						while(1){
							for($i = 0;$i < 12;$i++){
								$rnd .= rand(0, 9);
							}
							$check = $mysqli->query('SELECT * FROM forget WHERE pass = "'.$rnd.'" LIMIT 1;');
							if(mysqli_num_rows($check) == 0){
								break;
							}else{
								$rnd = "";
							}
							$j++;
							if($j >= 5){
								$err = 2;
							}
						}
						if($err == 0){
							$mysqli->query('DELETE FROM forget WHERE id = "'.$data['id'].'";');
							$mysqli->query('INSERT INTO forget (id, pass, tm) VALUES ("'.$data['id'].'","'.$rnd.'","'.date("Y-m-d H:i:s").'")');
							require_once '../../server/mail.php';
							Send_mail($data['mail'], "認証コード", "<html><body>認証コード:".$rnd."<br>期限:30分</body></html>", $headers);
							header('Location:login/index.php');exit;
						}
					}else{
						$err = 1;
					}
				}
			?>
			<header>
				<h1 id="title">パスワード忘れ</h1>
			</header>
			<div class="form">
				<div class="ct">
					<p>あなたのメールアドレス宛にログイン方法を送信します。</p>
				</div>
				<?php
					switch($err){
						case 1:
							echo '<p class="err">メールアドレスが間違えています</p>';
						break;
						case 2:
							echo '<p class="err">時間をおいてから再度入力してください</p>';
						break;
					}
				?>
				<!--ニックネーム　アドレス入力欄-->
				<form name="myForm" method="post" action="index.php">
					<label for="nick">ニックネーム　　</label>
					<input type="text" name="nick" placeholder="ニックネーム" ><br>
					<label for="email">メールアドレス　</label>
					<input type="email" name="email" placeholder="メールアドレスを入力" ><br>
					<div class="ct">
						<input type="submit" value="送信">
					</div>
				</form>
			</div>
			<footer>
				<?php require_once '../../server/init.php'; Footer();?>
			</footer>
		</body>
	</head>
</html>