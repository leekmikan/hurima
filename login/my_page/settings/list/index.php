<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>ブロックリスト</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../../main.css">
	<link rel="stylesheet" href="../../../../cart/cart.css">
	</head>
		<body>
			<?php
				session_start();
				$mysqli = new mysqli("localhost", "root", "", "hurima_data");
				if (isset($_POST['cancel'])){
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
					$ar = json_decode($data['hidden_id']);
					$ar = array_diff($ar, $_POST['cancel']);
					$ar = array_values($ar);
					$tmp = "";
					$len = count($ar);
					for($i = 0;$i < $len;$i++){
						$tmp .= '"'.$ar[$i].'"';
						if($i + 1 < $len){
							$tmp .= ",";
						}
					}
					$mysqli->query('UPDATE users SET hidden_id = JSON_REMOVE(hidden_id, "$") WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
					$mysqli->query('UPDATE users SET hidden_id = JSON_ARRAY('.$tmp.') WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
				}
				if (isset($_SESSION['id'])) {
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = '.$_SESSION['id'].';');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
					$ar = json_decode($data['hidden_id']);
				}
				else{

					header('Location:../../../login/index.php');exit;
				}
			?>
			<header>
				<h1 id="title">ブロックリスト</h1>
			</header>
			<div class="main">
			<form method="post" name="myForm" action="index.php">
					<?php
					if (count($ar) != 0){
					if (isset($_SESSION['id'])) {
							echo '<table border="1">';
							echo '<tr>';
								echo '<td>ユーザー名</td>';
								echo '<td>解除</td>';
							echo '</tr>';
							for($i = 0;$i < count($ar);$i++) {
								$stmt2 = $mysqli->query('SELECT * FROM users WHERE id = '.$ar[$i].' LIMIT 1;');
								$name = $stmt2->fetch_array(MYSQLI_ASSOC);
								echo '<tr>';
								echo '<td>'.$name['user_name'].'</td>';
								echo '<td>';
								echo '<input type="checkbox" name="cancel[]" value="'.$name["id"].'">';
								echo '</td>';
								echo '</tr>';
								$i++;
							}
							echo '</table>';
							echo '<div class="ct">';
							echo '<br>';
							echo '<input type="submit" value="更新">';
						}
					}else{
						echo '<div class="ct">';
						echo '<h2>ブロックしている人はいません</h2>';
					}
					echo '</div>';
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
			<script src="main.js"></script>
		</body>
	</head>
</html>