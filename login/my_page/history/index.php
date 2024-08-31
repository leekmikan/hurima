<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>閲覧履歴</title>
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
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
				}else{
					header('Location:../../../login/index.php');exit;
				}
			?>
			<header>
				<h1 id="title">閲覧履歴</h1>
			</header>
			<div class="main">
					<?php
					//履歴情報整理
					if (isset($_SESSION['id'])) {
						$ar = array_merge(array_unique(json_decode($data['history'])));
						$tmp = "";
						$len = count($ar);
						for($i = 0;$i < $len;$i++){
							if(mysqli_num_rows($mysqli->query('SELECT * FROM items WHERE id = "'.$ar[$i].'" LIMIT 1;')) == 0){
								unset($ar[$i]);
							}
						}
						$ar = array_values($ar);
						$len = count($ar);
						for($i = 0;$i < $len;$i++){
							$tmp .= '"'.$ar[$i].'"';
							if($i + 1 < $len){
								$tmp .= ",";
							}
						}
						$mysqli->query('UPDATE users SET history = JSON_REMOVE(history, "$") WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
						$mysqli->query('UPDATE users SET history = JSON_ARRAY('.$tmp.') WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
						$vp = 0;
						require_once '../../../server/const.php';
						if(isset($_GET["page"])){
							$vp = intval($_GET["page"]);
						}
						$hit = count($ar);
						$ar = array_slice($ar, $vp * $LIMIT, min($hit,(($vp + 1) * $LIMIT)));
						if(count($ar) == 0){
							echo '<h2>閲覧した商品はありません</h2>';
						}else{
							//履歴表示
							echo '<p>'.($vp * $LIMIT + 1).'～'.min(($vp + 1) * $LIMIT,mysqli_num_rows($stmt)).'件を表示　(全'.$hit.'件)</p>';
							echo '<table border="1">';
							echo '<tr>';
							echo '<td>商品名</td>';
							echo '<td>画像</td>';
							echo '<td>詳細</td>';
							echo '<td>小計</td>';
							echo '<td>メッセージ</td>';
							echo '</tr>';
							$i = 0;
							$len = mysqli_num_rows($stmt);
							foreach($ar as $id){
								$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$id.'" LIMIT 1;');
								$data = $stmt->fetch_array(MYSQLI_ASSOC);
								if($data != NULL){
									echo '<tr>';
									echo '<td>';
									echo '<form method="get" name="myForm" action="../../../items/detail/index.php">';
									echo '<input type="hidden" name="detail" value="'.$data['id'].'">';
									if(count($ar) == 1){
										echo '<a href="javascript:myForm.submit()">'.$data['item_name'].'</a>';
									}else{
										echo '<a href="javascript:myForm['.$i.'].submit()">'.$data['item_name'].'</a>';
									}
									echo '</form>';
									echo '</td>';
									if($data['src0'] == "0"){
										echo '<td><img class="item_img" src="test.jpg"</img></td>';
									}else{
										$img = file_get_contents('../../../user_img/'.$data['src0'].'.dat');
										echo '<td><img class="item_img" src="'.$img.'"</img></td>';
									}
									echo '<td>'.nl2br($data['exp']).'</td>';
									echo '<td><span name="price">'.$data['price'].'</span>円</td>';
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
									echo '</tr>';
									$i++;
								}
							}
							echo '</table>';
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
					}
					?>
			</div>
			<footer>
				<?php require_once '../../../server/init.php'; Footer();?>
			</footer>
			<script src="main.js"></script>
			<script src="../../../main.js"></script>
		</body>
	</head>
</html>