<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>ログイン</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../img/icon.jpg">
	<link rel="stylesheet" href="../main.css">
	<link rel="stylesheet" href="login.css">
	<script src="main.js"></script>
	</head>
		<body>
			<header>
				<a href="../index.php"><img class="logo" src="../img/logo.jpg"></a>
			</header>
			<?php
				session_start();
				if (isset($_POST['out'])) {
					session_destroy();
					header('Location:index.php');
				}
				if(isset($_POST["email"]) && isset($_POST["password"])){
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
                	$stmt = $mysqli->query('SELECT * FROM users WHERE mail = "'.$_POST['email'].'" AND pass = "'.$_POST['password'].'" LIMIT 1;');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
					if(!mysqli_num_rows($stmt) == 0){
						if($data['frag'] % 2 == 1){
							echo '<div class="ct"><p style="color: red;">このアカウントは凍結されています。</p></div>';
						}else{
							$_SESSION['id'] = $data['id'];
							if(isset($_SESSION['loc'])){
								header('Location:'.$_SESSION['loc']); exit;
							}else{
								header('Location:my_page/index.php'); exit;
							}
						}
					}else{
						echo '<div class="ct"><p style="color: red;">メールアドレスまたはパスワードが違います</p></div>';
					}
				}
			?>
			<br>
			<div class="ct"><h1 id="title">ログイン</h1></div>
			<div class="form">
			<form name="myForm" method="post" action="index.php">
				<?php
				if(!isset($_SESSION['id'])){
					echo '<label for="email">メールアドレス</label>';
					echo '<input type="email" name="email" placeholder="メールアドレスを入力" ><br>';
					echo '<label for="password">パスワード　　</label>';
					echo '<input type="password" name="password" placeholder="パスワードを入力" ><br>';
					echo '<div class="div_button">';
						echo '<input type="submit" value="ログイン"></input><br>';
						echo '<button  type="button" onclick="location.href=\'new/index.php\'">新規会員登録</button>';
						echo '<p><a href="forget_pass/index.php">パスワードを忘れた方はこちら</a></p>';
					echo '</div>';
				}else{
					header('Location:my_page/index.php'); exit;
				}
				if(isset($_POST['cart'])){
					echo '<input type="hidden" name="cart" value="'.$_POST['cart'].'">';
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
	</head>
</html>