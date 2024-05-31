<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>マイページ</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../img/icon.jpg">
	<link rel="stylesheet" href="../../main.css">
	<link rel="stylesheet" href="my_page.css">
	<script src="main.js"></script>
	</head>
		<body>
			<header>
			<a href="../../index.php"><img class="logo" src="../../img/logo.jpg"></a>
				<?php
				session_start();
				if (isset($_SESSION['id'])) {
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'";');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
				}else{
					header('Location:../index.php');exit;
				}
				?>
				<form id="myForm" name="myForm" method="get" action="../../items/index.php">
				<input class="search" type="search" id="site-search" name="key_word">
						<input type="submit" id="sb" value="検索">
						<button type="button" onclick="location.href='../../put/index.php'">出品</button>
						<button type="button" onclick="location.href='../../cart/index.php'">カート</button>
						<button type="button" onclick="location.href='../index.php'">ログイン新規会員登録</button>
						<button type="button" onclick="location.href='../../opinion/index.php'">意見箱</button>
						<input type="hidden" name="genre" id="genre" value="-1">
						<div class="ct tab">
							<ul>
								<?php
									require_once '../../server/const.php';
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
				<div class="ct">
				<?php
				if (isset($_SESSION['id'])) {
					echo '<h2>現在のポイント: <span>'.$data['points'].'</span> P</h2>';
				}
				?>
				</div>
				<table class="tb">
					<tr>
						<td><button onclick="location.href='history/index.php'">閲覧履歴</button></td>
						<td><button onclick="location.href='sell/index.php'">出品した商品</button></td>
						<td><button onclick="location.href='bought/index.php'">購入した商品</button></td>
						<td><button onclick="location.href='../../put/index.php'">下書き</button></td>
					</tr>
					<tr>
						<td><button onclick="location.href='settings/index.php'">アカウント管理</button></td>
						<td><button onclick="location.href='../../items/index.php'">商品検索へ</button></td>
						<td><button onclick="location.href='sub/index.php'">課金</button></td>
						<td><button onclick="location.href='judges/index.php'">自分の評価</button></td>
					</tr>
				</table>
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
		<script src="../../main.js"></script>
	</head>
</html>