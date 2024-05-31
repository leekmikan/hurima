<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>ユーザー情報</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../main.css">
	<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
	</head>
		<body>
			<?php
			session_start();
				if (isset($_SESSION['id']) && isset($_GET['id'])) {
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_GET['id'].'" LIMIT 1;');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
				}else{
					header('Location:../../../index.php');exit;
				}
			?>
			<header>
				<h1 id="title">ユーザー情報</h1>
			</header>
			<div class="main">
			<?php
				if(mysqli_num_rows($stmt) == 0){
					echo '<div class="ct">';
					echo '<h2>アカウントが見つかりません</h2>';
					echo '</div>';
				}else{
					echo '<h2>ユーザー名</h2>';
					echo $data['user_name'];
					echo '<h2>誕生日</h2>';
					echo $data['birth'];
					echo '<h2>コメント</h2>';
					echo nl2br($data['msg']);
				}
			?>
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