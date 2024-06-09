<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>メッセージ</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../../../main.css">
	<link rel="stylesheet" href="../../../../../items/detail/chat/chat.css">
	</head>
		<body>
			<?php
				//他ページのchatディレクトリーの内容と同じ
				session_start();
				$bk = false;
				$mysqli = new mysqli("localhost", "root", "", "hurima_data");
				if (isset($_SESSION['id']) && isset($_POST['detail'])) {
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = '.$_POST['id'].' LIMIT 1;');
					$user_data = $stmt->fetch_array(MYSQLI_ASSOC);
					$stmt2 = $mysqli->query('SELECT * FROM items WHERE id = '.$_POST['detail'].' LIMIT 1;');
					$item_data = $stmt2->fetch_array(MYSQLI_ASSOC);
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = '.$item_data['user_id'].' LIMIT 1;');
					$sell_data = $stmt->fetch_array(MYSQLI_ASSOC);
					$ar = json_decode($user_data['hidden_id']);
					if(isset($_POST['pos'])){
						$token = isset($_POST["token"]) ? $_POST["token"] : "";
						$session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
						unset($_SESSION["token"]);
						if($token != "" && $token == $session_token) {
							$mysqli->query('INSERT INTO msg (buy_id, item_id, send_id, txt, rd, tm) VALUES ('.$_POST['id'].','.$_POST['detail'].','.$_SESSION['id'].',"'.$_POST['pos'].'",false,"'.date("Y-m-d H:i:s").'");');
						}
					}
					if(in_array($sell_data['id'],$ar)){
						$bk = true;
					}
					$ar = json_decode($sell_data['hidden_id']);
					if(in_array($user_data['id'],$ar)){
						$bk = true;
					}
				}
				else if(isset($_SESSION['id']) && isset($_POST['hidden_id'])){
					$mysqli->query('UPDATE users SET hidden_id = IFNULL(json_array_append(hidden_id, "$", "'.$_POST['hidden_id'].'"), json_array("'.$_POST['hidden_id'].'")) WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
					header('Location:../../index.php');exit;
				}
				else if(isset($_SESSION['id'])){
					header('Location:../index.php');exit;
				} 
				else{
					header('Location:../../../../index.php');exit;
				}
			?>
			<header>
				<?php
					if(!is_null($item_data) && !is_null($user_data)){
						echo '<h1 id="title">'.$user_data['user_name'].'さんとのメッセージ</h1>';
					}else{
						echo '<h1 id="title">エラー</h1>';
					}
				?>
			</header>
			<div class="main">
				<div class="chat">
					<?php
						if(is_null($item_data)){
							echo '<h1>商品が存在しません</h1>';
						}
						else if(is_null($user_data)){
							echo '<h1>質問者のアカウントが存在しません</h1>';
						}
						else if($bk){
							echo '<div class="ct">';
							echo '<h1>ブロックしているかされています。</h1>';
							echo '</div>';
						}
						else{
							$stmt3 = $mysqli->query('SELECT * FROM msg WHERE item_id = '.$_POST['detail'].' AND buy_id = '.$_POST['id'].' ORDER BY tm;');
							while($row = $stmt3->fetch_array(MYSQLI_ASSOC)) {
								if($row['buy_id'] != $row['send_id']){
									echo '<div class="I">';
									echo '<p>'.nl2br($row['txt']).'</p>';
									if($row['rd']){
										echo '<p class="stat">'.$row['tm'].'　既読</p>';
									}else{
										echo '<p class="stat">'.$row['tm'].'</p>';
									}
								}else{
									echo '<div class="you">';
									echo '<p>'.nl2br($row['txt']).'</p>';
									echo '<p class="stat">'.$row['tm'].'</p>';
								}
								echo '</div>';
							}
							$mysqli->query('UPDATE msg SET rd = 1 WHERE item_id = "'.$_POST['detail'].'" AND NOT send_id = "'.$_SESSION['id'].'" AND rd = 0;');
						}
					?>
				</div>
				<div class="msg">
					<form name="myForm" method="post" action="confirm/index.php">
						<?php
							if(isset($_POST['detail'])){
								echo '<textarea name="msg" cols="40" rows="8"></textarea><br>';
								echo '<input type="submit" value="メッセージの内容を確認">';
								echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
								echo '<input name="detail" type="hidden" value="'.$_POST['detail'].'">';
							}
						?>
					</form>
					<form onsubmit="return confirm('ブロックしますか？')" name="myForm2" method="post" action="index.php">
						<?php
							if(!$bk && isset($_POST['detail'])){
								echo '<br>';
								echo '<input type="submit" value="ブロック">';
								echo '<input name="hidden_id" type="hidden" value="'.$user_data['id'].'">';
							}
						?>
					</form>
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
		<script src="main.js"></script>
	</head>
</html>