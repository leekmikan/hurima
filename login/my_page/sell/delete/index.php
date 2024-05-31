<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>商品削除</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../../main.css">
	<link rel="stylesheet" href="../../../../put/put.css">
	</head>
		<body>
			<?php
				session_start();
				if(isset($_POST['delete'])){
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$token = isset($_POST["token"]) ? $_POST["token"] : "";
					$session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
					unset($_SESSION["token"]);
					if($token != "" && $token == $session_token) {
						$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$_POST['detail'].'";');
						$row = $stmt->fetch_array(MYSQLI_ASSOC);
						for($i = 0;$i < 5;$i++){
							if($row['src'.$i] != '0'){
								if(!unlink('../../../../user_img/'.$row['src'.$i].'.dat')){
									echo 'ERROR:　../../../../user_img/'.$row['src'.$i].'.dat';
								}
							}
						}
						$mysqli->query('DELETE FROM items WHERE id = "'.$_POST['detail'].'";');
						$mysqli->query('DELETE FROM msg WHERE item_id = "'.$_POST['detail'].'";');
					}
					header('Location:../index.php');exit;
				}
				if (isset($_SESSION['id']) && isset($_POST['detail'])) {
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$_POST['detail'].'";');
					$token = uniqid('', true);
					$_SESSION['token'] = $token;
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
				}else if(isset($_SESSION['id'])){
					header('Location:../index.php');exit;
				}else{
					header('Location:../../../login/index.php');exit;
				}
			?>
			<header>
				<h1 id="title">商品削除</h1>
			</header>
			<div class="form">
				<h1>本当に削除しますか？</h1>
			<form name="myForm" method="post" action="index.php">
				<p>商品名</p>
				<?php 
				echo $data['item_name'];
				 ?>
				<p>価格</p>
				<?php 
				echo $data['price'];
				 ?>
				<p>画像</p>
				<?php
				$first = TRUE;
				for ( $i = 0;$i < 5;$i++) {
					if($data['src'.strval($i)] == "0"){
						if($first){
							echo '<img class="sam" src="http://localhost/PHP/hurima/put/test.jpg">';
						}else{
							echo '<img src="http://localhost/PHP/hurima/put/test.jpg">';
						}
					}else{
						$img = file_get_contents('../../../../user_img/'.$data['src'.strval($i)].'.dat');
						if($first){
							echo '<img class="sam" src="'.$img.'">';
						}else{
							echo '<img src="'.$img.'">';
						}
					}
					$first = FALSE;
				}
				?><br>
				<p>商品説明</p>
				<?php 
				echo nl2br($data['exp']);
				 ?>
				<p>カテゴリー</p>
				<?php 
				require_once '../../../../server/const.php';
				echo $GENRE[$data['genre']];
				 ?>
				<p>状態</p>
				<?php 
				echo $STAT[$data['stat']];
				 ?>
				<p>配送方法</p>
				<?php 
				echo $HSEND[$data['hsend']];
				?>
				<br><br>
				<div class="ct">
					<?php 
						echo '<input type="hidden" name="detail" value="'.$_POST['detail'].'">';
						echo '<input type="hidden" name="token" value="'.$token.'">';
					?>
					<input type="hidden" name="delete" value="0">
					<input type="submit" value="削除">
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