<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>購入履歴</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../main.css">
	<link rel="stylesheet" href="../../../cart/cart.css">
	</head>
		<body>
			<?php
				session_start();
				if (isset($_SESSION['id'])) {
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					require_once '../../../server/const.php';
					$vp = 0;
					$lim = " LIMIT ".($vp * $LIMIT).", ".(($vp + 1) * $LIMIT);
					if(isset($_GET["page"])){
						$vp = intval($_GET["page"]);
					}
					$stmt = $mysqli->query('SELECT * FROM items WHERE buy_id = "'.$_SESSION['id'].'"'.$lim.';');
					$hit = mysqli_num_rows($mysqli->query('SELECT id FROM items WHERE buy_id = "'.$_SESSION['id'].'";')) ;
				}else{
					header('Location:../../../login/index.php');exit;
				}
			?>
			<header>
				<h1 id="title">購入履歴</h1>
			</header>
			<div class="main">
					<?php
					//購入済み商品表示　メッセージと評価はクリックするとページ移動する
					if (isset($_SESSION['id'])) {
						if(mysqli_num_rows($stmt) != 0){
							echo '<p>'.($vp * $LIMIT + 1).'～'.min(($vp + 1) * $LIMIT,mysqli_num_rows($stmt)).'件を表示　(全'.$hit.'件)</p>';
							echo '<table border="1">';
							echo '<tr>';
								echo '<td>商品名</td>';
								echo '<td>画像</td>';
								echo '<td>詳細</td>';
								echo '<td>価格</td>';
								echo '<td>メッセージ</td>';
								echo '<td>評価</td>';
							echo '</tr>';
							$i = 0;
							$len = mysqli_num_rows($stmt);
							while($data = $stmt->fetch_array(MYSQLI_ASSOC)) {
								echo '<tr>';
								echo '<td>'.$data['item_name'].'</td>';
								if($data['src0'] == "0"){
									echo '<td><img class="item_img" src="test.jpg"</img></td>';
								}else{
									$img = file_get_contents('../../../user_img/'.$data['src0'].'.dat');
									echo '<td><img class="item_img" src="'.$img.'"</img></td>';
								}
								echo '<td>'.nl2br($data['exp']).'</td>';
								echo '<td>';
								echo '<p><span name="price">'.$data['price'].'</span>円</p>';
								echo '</td>';
								echo '<td>';
								echo '<form method="post" name="msg" action="../../../items/detail/chat/index.php">';
								echo '<input type="hidden" name="detail" value="'.$data["id"].'">';
								$read = "メッセージ";
								$stmt2 = $mysqli->query('SELECT * FROM msg WHERE item_id = '.$data["id"].' AND rd = 0 AND NOT send_id = '.$_SESSION['id'].' LIMIT 1;');
								$tmp = $stmt2->fetch_array(MYSQLI_NUM);
								if(!is_null($tmp)){
									$read = "メッセージ(未読あり)";
								}
								if($len == 1){
									echo '<a href="javascript:msg.submit()">'.$read.'</a>';
								}else{
									echo '<a href="javascript:msg['.$i.'].submit()">'.$read.'</a>';
								}
								echo '</form>';
								echo '</td>';
								echo '<td>';
								echo '<form method="post" name="judge" action="judge/index.php">';
								echo '<input type="hidden" name="detail" value="'.$data["id"].'">';
								$stmt2 = $mysqli->query('SELECT * FROM items WHERE id = '.$data["id"].' LIMIT 1;');
								$tmp = $stmt2->fetch_array(MYSQLI_ASSOC);
								//評価済みならページ推移不可
								if(is_null($tmp['judge'])){
									if($len == 1){
										echo '<a href="javascript:judge.submit()">未評価</a>';
									}else{
										echo '<a href="javascript:judge['.$i.'].submit()">未評価</a>';
									}
								}else{
									echo '<a>評価済</a>';
								}
								echo '</form>';
								echo '</td>';
								echo '</tr>';
								$i++;
							}
							echo '</table>';
						}else{
							echo '<h2>購入済みの商品はありません</h2>';
						}
					}
					echo '<form id="pgForm" name="pgForm" method="get" action="index.php">';
					echo '<input type="hidden" id="page" name="page" value="0">';
					if(($vp + 1) * $LIMIT < $hit){
						$max_p = ceil($hit / $LIMIT);
						if($vp >= 5){
							echo '<a href="#" onclick="pg(0)">1</a>・・・';
						}
						for($i = max(1,$vp - 3);$i <= min($vp + 3,$max_p);$i++){
							if($vp == $i){
								echo '<a>'.$i.'</a>　';
							}else{
								echo '<a href="#" onclick="pg("'.($i - 1).'")">'.$i.'</a>　';
							}
						}
						if($max_p - $vp >= 5){
							echo '・・・<a href="#" onclick="pg("'.($max_p - 1).'")">'.$max_p.'</a>';
						}
					}
					echo '</form>';
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
			<script src="main.js"></script>
			<script src="../../../main.js"></script>
		</body>
	</head>
</html>