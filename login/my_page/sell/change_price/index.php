<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>価格変更</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../../main.css">
	<link rel="stylesheet" href="../../../../put/put.css">
	<link rel="stylesheet" href="../../../../login/login.css">
	</head>
		<body>
			<?php
				session_start();
				$err = false;
				if(isset($_POST['price'])){
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$_POST['detail'].'";');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
					if(intval($_POST['price']) <= $data['price']){
						$mysqli->query('UPDATE items SET price = "'.$_POST['price'].'" WHERE id = "'.$_POST['detail'].'";');
						header('Location:../index.php');exit;
					}else{
						$err = true;
					}
					
				}
				if (isset($_SESSION['id']) && isset($_POST['detail'])) {
					$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$_POST['detail'].'";');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
				}else if(isset($_SESSION['id'])){
					header('Location:../index.php');exit;
				}else{
					header('Location:../../../login/index.php');exit;
				}
			?>
			<header>
				<h1 id="title">価格変更</h1>
			</header>
			<div class="form">
			<form name="myForm" method="post" action="index.php">
				<?php
					//値上げになる場合は、エラー
					if($err){
						echo '<div class="ct err">';
						echo '<p>値上げはできません</p>';
						echo '</div>';
					}
				?>
				<!--元価格<p>　→　変更後価格<input>-->
				<label for="pri">　価格変更(値下げのみ)</label>
					<?php
						echo '<p>　'.$data['price'].'円→</p>';
					?>
					<input type="number" name="price" id="price" placeholder="価格" pattern="\d+" min="1" step="1" max="1000000"><br>
				<div class="ct">
					<?php 
						echo '<input type="hidden" name="detail" value="'.$_POST['detail'].'">';
					?>
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
			<script src="main.js"></script>
		</body>
	</head>
</html>