<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>トップ</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="img/icon.jpg">
	<link rel="stylesheet" href="main.css">
	<script src="main.js"></script>
	</head>
		<body>
			<header>
				<a href="index.php"><img class="logo" src="img/logo.jpg"></a>
					<form id="myForm" name="myForm" method="get" action="items/index.php">
						<a>　　</a>
						<input class="search" type="search" id="site-search" name="key_word">
						<input type="submit" id="sb" value="検索">
						<button type="button" onclick="location.href='put/index.php'">出品</button>
						<button type="button" onclick="location.href='cart/index.php'">カート</button>
						<button type="button" onclick="location.href='login/index.php'">ログイン新規会員登録</button>
						<button type="button" onclick="location.href='opinion/index.php'">意見箱</button>
						<input type="hidden" name="genre" id="genre" value="-1">
						<div class="ct tab">
							<ul>
								<?php
									require_once 'server/const.php';
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
			<p>1.0.0α</p>
				<div class="main ct">
					<div class="article">
					<br>
					<a href="articles/quiz.php"><img src="img/quiz.jpg" ></a>
						<p>クイズ<br>正解した人の中から抽選で1名様に1000Pプレゼント</p>
					</div>
					<div class="article">
					<br>
					<a href="articles/want.php"><img src="img/default_user.jpg" ></a>
						<p>ほしいもの<br>買い取りテストを兼ねた開発者が購入したいもの一覧</p>
					</div>
					<h2>今月の支援者リスト(定員<?php echo $SUPPORT_LIMIT ?>名)</h2>
						<?php
						$mysqli = new mysqli("localhost", "root", "", "hurima_data");
						$stmt = $mysqli->query('SELECT * FROM users WHERE frag & 32 = 32;');
						while($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
							$url = 'items/index.php?id='.$row['id'];
							echo '<p><a href="'.$url.'">'.$row['user_name'].'</a></p>';
						}
						?>
					<h2>評価の高い人(上位<?php echo $SUPPORT_LIMIT ?>名)</h2>
						<?php
						$stmt = $mysqli->query('SELECT * FROM items WHERE judge IS NOT NULL');
						$judges = [];
						while($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
							if(!array_key_exists($row['user_id'] , $judges)){
								$judges[$row['user_id']] = ['len' => 1, 'judge' => $row['judge']];
							}else{
								$judges[$row['user_id']]['len']++;
								$judges[$row['user_id']]['judge'] += $row['judge'];
							}
						}
						$top_judge = [];
						for($i = 0;$i < $SUPPORT_LIMIT;$i++){
							$top_judge[$i] = ['judge' => 0, 'id' => 0];
						}
						foreach ($judges as $id => $judge){
							for($i = 0;$i < $SUPPORT_LIMIT;$i++){
								if($judge['judge'] / $judge['len'] > $top_judge[$i]['judge']){
									for($j = $SUPPORT_LIMIT - 2;$j >= $i;$j--){
										$top_judge[$j + 1] = $top_judge[$j];
									}
									$top_judge[$i] = ['judge' => $judge['judge'] / $judge['len'], 'id' => $id];
									break;
								}
							}
						}
						foreach ($top_judge as $key => $value) {
							if($value['id'] != 0){
							$stmt = $mysqli->query('SELECT * FROM users WHERE id = '.$value['id'].' LIMIT 1;');
							while($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
								$url = 'items/index.php?id='.$row['id'];
								echo '<p><a href="'.$url.'">'.$row['user_name'].'</a>　(平均評価：'.round($value['judge'],2).')</p>';
							}
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