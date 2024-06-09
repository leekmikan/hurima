<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>送信者選択</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../../main.css">
	<link rel="stylesheet" href="../../../../cart/cart.css">
	</head>
		<body>
			<?php
				session_start();
				if (isset($_SESSION['id']) && isset($_POST['detail'])) {
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT DISTINCT buy_id FROM msg WHERE item_id = '.$_POST['detail'].' AND NOT send_id = '.$_SESSION['id'].';');	
				}
				else if(isset($_SESSION['id'])){
					header('Location:../index.php');exit;
				}
				else{

					header('Location:../../../login/index.php');exit;
				}
			?>
			<header>
				<h1 id="title">送信者選択</h1>
			</header>
			<div class="main">
					<?php
					if (isset($_SESSION['id'])) {
						$i = 0;
						$len = mysqli_num_rows($stmt);
						if(!is_null($stmt)){
							echo '<table border="1">';
							echo '<tr>';
								echo '<td>ユーザー名</td>';
								echo '<td>メッセージ</td>';
							echo '</tr>';
							while($data = $stmt->fetch_array(MYSQLI_ASSOC)) {
								//やりとりするユーザー選択
								$stmt2 = $mysqli->query('SELECT * FROM users WHERE id = '.$data["buy_id"].' LIMIT 1;');
								$name = $stmt2->fetch_array(MYSQLI_ASSOC);
								echo '<tr>';
								echo '<td>'.$name['user_name'].'</td>';
								echo '<td>';
								echo '<form method="post" name="myForm" action="chat/index.php">';
								echo '<input type="hidden" name="detail" value="'.$_POST['detail'].'">';
								echo '<input type="hidden" name="id" value="'.$name['id'].'">';
								$read = "メッセージ";
								$stmt3 = $mysqli->query('SELECT * FROM msg WHERE item_id = '.$_POST['detail'].' AND rd = 0 AND buy_id = '.$name['id'].' AND NOT send_id = '.$_SESSION['id'].' LIMIT 1;');
								$tmp = $stmt3->fetch_array(MYSQLI_NUM);
								if(!is_null($tmp)){
									$read = "メッセージ(未読あり)";
								}
								if($len == 1){
									echo '<a href="javascript:myForm.submit()">'.$read.'</a>';
								}else{
									echo '<a href="javascript:myForm['.$i.'].submit()">'.$read.'</a>';
								}
								echo '</form>';
								echo '</td>';
								echo '</tr>';
								$i++;
							}
							echo '</table>';
						}else{
							echo '<h2>出品した商品はありません</h2>';
						}
					}
					?>
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