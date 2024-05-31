<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>変更確認</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../../../main.css">
	<link rel="stylesheet" href="../../../../../login/login.css">
	<link rel="stylesheet" href="../../../../../login/new/new.css">
	</head>
		<body>
			<?php
			session_start();
				if (isset($_SESSION['id'])) {
					$mysqli = new mysqli("localhost", "root", "", "users");
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
					$data = $stmt->fetch_array(PDO::FETCH_ASSOC);
				}else{
					header('Location:../../index.php');exit;
				}
			?>
			<header>
				<h1 id="title">変更確認</h1>
			</header>
			<div class="form">
			<form name="myForm" action="reg.php" method="post">
				<?php
				if(isset($_POST['loc'])){
					echo '<input type="hidden" name="loc" value="'.$_POST['loc'].'">';
				}
				?>
				<p>以下の情報でよろしいでしょうか。</p>
				<p>番号</p>
				<?php
				echo $_POST['pay'];
				echo '<input name="user_sei" type="hidden" value="'.$_POST['pay'].'"/input>';
				?><br>
				<p>番号</p>
				<?php
				echo "---";
				echo '<input name="password" type="hidden" value="'.$_POST['password'].'"/input>';
				?><br>
				<div class="div_button">
				<input type="submit" value="変更">
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