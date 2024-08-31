<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>意見箱</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../img/icon.jpg">
	<link rel="stylesheet" href="../main.css">
	<link rel="stylesheet" href="../items/detail/chat/chat.css">
	</head>
		<body>
			<?php
				session_start();
				if (isset($_POST['msg'])) {
					$token = isset($_POST["token"]) ? $_POST["token"] : "";
					$session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
					unset($_SESSION["token"]);
					if($token != "" && $token == $session_token) {
						$mysqli = new mysqli("localhost", "root", "", "hurima_data");
						if(isset($_SESSION['id'])){
							$mysqli->query('INSERT INTO opinion (user_id, opinion, tm) VALUES ("'.$_SESSION['id'].'","'.$_POST['msg'].'","'.date("Y-m-d H:i:s").'")');
						}else{
							$mysqli->query('INSERT INTO opinion (user_id, opinion, tm) VALUES (NULL,"'.$_POST['msg'].'","'.date("Y-m-d H:i:s").'")');
						}
					}
					header('Location:../index.php');exit;
				}else{
					$token = uniqid('', true);
					$_SESSION['token'] = $token;
				}
			?>
			<header>
				<h1 id="title">意見箱</h1>
			</header>
			<div class="main">
				<p>バグなど開発者に伝えたいことがあればここで文章を送ってください。</p>
				<p>アカウント特定のため、自身のアカウントについて記入する場合はログインした後にしてください。</p>
				<!--誰か確認できる人がいれば　日時を追加-->
				<p>確認可能日時(2年春学期)</p>
				<table border=1>
					<tr>
						<td>曜日</td>
						<td>時間帯</td>
						<td>回数</td>
					</tr>
					<tr>
						<td>日</td>
						<td>終日</td>
						<td>2</td>
					</tr>
					<tr>
						<td>月</td>
						<td>×</td>
						<td>0</td>
					</tr>
					<tr>
						<td>火</td>
						<td>×</td>
						<td>0</td>
					</tr>
					<tr>
						<td>水</td>
						<td>16:00～</td>
						<td>0～1</td>
					</tr>
					<tr>
						<td>木</td>
						<td>16:00～</td>
						<td>0～1</td>
					</tr>
					<tr>
						<td>金</td>
						<td>×</td>
						<td>0</td>
					</tr>
					<tr>
						<td>土</td>
						<td>終日</td>
						<td>2</td>
					</tr>
				</table>
				<!-- 意見入力フォーム-->
				<p>400字以内</p>
				<div class="msg">
					<form name="myForm" method="post" action="index.php">
						<?php
							echo '<input type="hidden" name="token" value="'.$token.'">';
						?>
						<textarea name="msg" cols="40" rows="10"></textarea><br>
						<input type="submit" value="送信">
					</form>
				</div>
			</div>
			<footer>
				<?php require_once '../server/init.php'; Footer();?>
			</footer>
		</body>
		<script src="main.js"></script>
	</head>
</html>