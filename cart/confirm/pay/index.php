<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>支払い情報入力</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../main.css">
	<link rel="stylesheet" href="pay.css">
	<script src="https://js.stripe.com/v3/"></script>
	</head>
		<body>
			<header>
				<h1 id="title">支払い情報入力</h1>
			</header>
			<div class="main ct">
			<?php
				session_start();
				if (isset($_SESSION['id'])) {
					require_once 'create.php';
					echo '<h2>請求額：'.$sum.'円</h2>';
				}else{
					header('Location:../../../login/index.php');exit;
				}
			?>
			<div id="payment-element"></div>
			<br><br>
			<div id="card-errors"></div>
			<br><br>
			<div class="ct">
    			<button onclick="pay()">支払い</button>
			</div>
			</div>
			<br>
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
		<script src="main2.js"></script>
	</head>
</html>