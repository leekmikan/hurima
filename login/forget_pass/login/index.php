<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>コード入力</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../main.css">
	<link rel="stylesheet" href="../../login.css">
	<script src="main.js"></script>
	</head>
		<body>
			<?php
			$err = false;
				if(isset($_POST["code"])){
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT * FROM forget WHERE pass = "'.$_POST['code'].'" LIMIT 1;');
					if(mysqli_num_rows($stmt) != 0){
						$data = $stmt->fetch_array(MYSQLI_ASSOC);
						if(strtotime(date("Y-m-d H:i:s")) - strtotime($data['tm']) < 1800){
							require_once '../../../server/mail.php';
							$mysqli->query('DELETE FROM forget WHERE id = "'.$data['id'].'";');
							$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$data['id'].'" LIMIT 1;');
							$data = $stmt->fetch_array(MYSQLI_ASSOC);
							//HTMLメールを送信
							Send_mail($data['mail'], "パスワード", "<html><body><p>パスワード:</p><h1>".$data['pass']."</h1></body></html>");
							header('Location:../../index.php');exit;
						}else{
							$err = true;
						}
					}else{
						$err = true;
					}
				}
			?>
			<header>
				<h1 id="title">コード入力</h1>
			</header>
			<div class="form">
				<div class="ct">
				<?php
					if($err){
						echo '<p class="err">コードがまちがえているか、期限が切れています。</p>';
					}
				?>
				<p>メールに送信されたコードを入力してください。</p>
				</div>
				<form name="myForm" method="post" action="index.php">
				<label for="num">コード　</label>
					<input type="number" name="code" placeholder="コードを入力" ><br>
					<div class="ct">
						<input type="submit" value="送信">
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