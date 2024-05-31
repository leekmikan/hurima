<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>商品一覧</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../img/icon.jpg">
	<link rel="stylesheet" href="../main.css">
	<link rel="stylesheet" href="items.css">
	</head>
		<body>
			<header>
				<a href="../index.php"><img class="logo" src="../img/logo.jpg"></a>
				<form name="myForm" id="myForm" method="get" action="index.php">
						<a>　　</a>
						<input class="search" type="search" id="site-search" name="key_word">
						<input type="submit" id="sb" value="検索">
						<button type="button" onclick="location.href='../put/index.php'">出品</button>
						<button type="button" onclick="location.href='../cart/index.php'">カート</button>
						<button type="button" onclick="location.href='../login/index.php'">ログイン新規会員登録</button>
						<button type="button" onclick="location.href='../opinion/index.php'">意見箱</button>
						<input type="hidden" name="genre" id="genre" value="-1">
						<div class="ct tab">
							<ul>
								<?php
									require_once '../server/const.php';
									for($i = 0;$i < count($GENRE);$i++){
										echo '<li>';
										echo '<a class="tabt" onclick="set_ip('.$i.')">'.$GENRE[$i].'</a>';
										echo '</li>';
									}
								?>
							</ul>
						</div>
					</form>
			</header>
			<div class="main ct">
				<table class="items">
				<?php
				require_once '../server/const.php';
				session_start();
				$query = " FROM items WHERE buy_id IS NULL";
				$mysqli = new mysqli("localhost", "root", "", "hurima_data");
				$vp = 0;
				if(isset($_GET["query"])){
					$query = $_GET["query"];
				}
				if(isset($_GET["page"])){
					$vp = intval($_GET["page"]);
				}
				$lim = " LIMIT ".($vp * $LIMIT).", ".(($vp + 1) * $LIMIT);
				if(isset($_GET["key_word"])){
					if($_GET["key_word"] != -1){
						$query .= " AND item_name like '" .$_GET["key_word"]. "%'";
					}
				}
				if(isset($_GET["id"])){
					if($_GET["id"] != -1){
						$query .= " AND user_id = " . $_GET["id"];
					}
				}
				if(isset($_GET["genre"])){
					if($_GET["genre"] != -1){
						$query .= " AND genre = " . $_GET["genre"];
					}
				}
				if(isset($_GET["price_min"])){
					if($_GET["price_min"] != -1){
						$query .= " AND price >= " . $_GET["price_min"];
					}
				}
				if(isset($_GET["price_max"])){
					if($_GET["price_max"] != -1){
						$query .= " AND price <= " . $_GET["price_max"];
					}
				}
				if(isset($_SESSION['id'])){
                	$query .= " AND NOT user_id = ".$_SESSION['id'];
				}
				$stmt = $mysqli->query("SELECT *" . $query . $lim . ";");
				$hit = mysqli_num_rows($mysqli->query("SELECT id" . $query . ";")) ;
				$i=0;
				if(mysqli_num_rows($stmt) == 0){
					echo '<h2>お探しの商品は見つかりませんでした</h2>';
				}else{
					echo '<p>'.($vp * $LIMIT + 1).'～'.min(($vp + 1) * $LIMIT,mysqli_num_rows($stmt)).'件を表示　(全'.$hit.'件)</p>';
				}
    			while($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
					if($i % 5 == 0){
						echo '<tr>';
					}
					echo '<td>';
					echo '<form name="myForm" method="get" action="detail/index.php">';
					echo '<input type="hidden" name="detail" value="'.$row['id'].'">';
					if($row['src0'] == "0"){
						echo '<input type="image" class="item_img" src="../img/noimage.jpg">';
					}else{
						$img = file_get_contents('../user_img/'.$row['src0'].'.dat');
						echo '<input type="image" class="item_img" src="'.$img.'">';
					}
					echo '<p>'.$row['item_name'].'</p>';
					echo '<p><span name="price">'.$row['price'].'</span>円</p>';
					echo '</form>';
					echo '</td>';
					if($i % 5 == 4){
						echo '</tr>';
					}
    				$i++;
    			}
				if(($i - 1) % 5 != 4){
					echo '</tr>';
				}
				?>
				</table>
			<br><br>
			<button onclick="location.href='search/index.php'">詳細検索</button>
			<br><br>
			<?php
				echo '<form id="pgForm" name="pgForm" method="get" action="index.php">';
				echo '<input type="hidden" name="query" value="'.$query.'">';
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
		</body>
		<script src="main.js"></script>
		<script src="../main.js"></script>
	</head>
</html>