<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>ログイン</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../img/icon.jpg">
	<link rel="stylesheet" href="../../main.css">
	<link rel="stylesheet" href="../../login/login.css">
	<link rel="stylesheet" href="search.css">
	<script src="main.js"></script>
	</head>
		<body>
			<header>
				<h1 id="title">詳細検索</h1>
			</header>
			<div class="form">
				<form name="myForm" method="get" action="../index.php">
				<br>
				<label for="key_word">　キーワード</label><br>
				<input type="text" name="key_word" placeholder="キーワードを入力" ><br>
				<label for="genre">　カテゴリー</label><br>
				<select name="genre">
					<option value="-1">---</option>
					<?php
						require_once '../../server/const.php';
						for($i = 0;$i < count($GENRE);$i++){
							echo '<option value="'.$i.'">'.$GENRE[$i].'</option>';
						}
					?>
				</select><br>
				<label for="price_min">　価格帯</label><br>
				<div class="range">
					<input min="0" max="1000000" name="price_min" id="price_min" type="number" value="0" onchange="max_change()">
					<p>～</p>
					<input min="0" max="1000000" name="price_max" id="price_max" type="number" value="10000" onchange="min_change()">
				</div><br>
				<label for="stat">状態</label><br>
				<select name="stat">
					<option value="-1">---</option>
					<?php
						for($i = 0;$i < count($STAT);$i++){
							echo '<option value="'.$i.'">'.$STAT[$i].'</option>';
						}
					?>
				</select><br>
				<div class="div_button">
					<input type="submit" value="検索">
				</div>
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