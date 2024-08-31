<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>アカウント管理</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../main.css">
	<link rel="stylesheet" href="../my_page.css">
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
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					if(isset($_POST['mail_change'])){
						if($_POST['mail_change'] == '0'){
							$mysqli->query('UPDATE users SET frag = frag - (((frag >> 4) % 2) << 4) WHERE id = "'.$_SESSION['id'].'";');
						}else{
							$mysqli->query('UPDATE users SET frag = frag + 16 - (((frag >> 4) % 2) << 4)WHERE id = "'.$_SESSION['id'].'";');
						}
					}
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
				}else{
					header('Location:../../index.php');exit;
				}
			?>
			<header>
				<h1 id="title">アカウント管理</h1>
			</header>
				<table class="tb">
					<tr>
						<td><button onclick="location.href='change/index.php'">プロフィール変更</button></td>
						<td><button onclick="location.href='list/index.php'">ブロックリスト</button></td>
						<form name="myForm" method="post" action="index.php">
							<?php
								if(($data['frag'] >> 4) % 2 == 1){
									echo '<input name="mail_change" type="hidden" value="0"></input>';
									echo '<input class="dis" type="submit" value="お知らせを受け取る"></input>';
								}else{
									echo '<input name="mail_change" type="hidden" value="1"></input>';
									echo '<input class="dis" type="submit" value="お知らせを受け取らない"></input>';
								}
							?>
						</form>
					</tr>
					<tr>
						<td><button onclick="location.href='../index.php'">マイページへ</button></td>
						<td>
						<form name="myForm" method="post" action="index.php">
							<input name="out" type="hidden" value="1"></input>
							<input class="dis" type="submit" value="ログアウト"></input>
						</form>
						</td>
					</tr>
				</table>
				<footer>
				<?php require_once '../../../server/init.php'; Footer();?>
			</footer>
		</body>
	</head>
</html>