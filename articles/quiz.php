<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>クイズ</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../img/icon.jpg">
	<link rel="stylesheet" href="../main.css">
	<script src="../main.js"></script>
	</head>
		<body>
			<header>
				<?php
				session_start();
				if (isset($_SESSION['id'])) {
					if(isset($_POST['ans'])){
						require_once '../server/const.php';
						$mysqli = new mysqli("localhost", "root", "", "hurima_data");
						if($_POST['ans'] == $QUIZ_ANS){
							$stmt = $mysqli->query('UPDATE users SET frag = frag + 8 - 8 * ((frag >> 3) % 2) WHERE id = "'.$_SESSION['id'].'";');
						}else{
							$stmt = $mysqli->query('UPDATE users SET frag = frag - 8 * ((frag >> 3) % 2) WHERE id = "'.$_SESSION['id'].'";');
						}
						echo "<script type='text/javascript'>alert('回答を更新しました。');location.href='../index.php';</script>";
					}
				}else{
					$_SESSION['loc'] = '../articles/quiz.php';
					header('Location:../login/index.php');exit;
				}
				?>
				<a href="../index.php"><img class="logo" src="../img/logo.jpg"></a>
					<form id="myForm" name="myForm" method="get" action="../items/index.php">
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
					<h1>クイズ</h1>
					<p>ジャンルは高校までの科目、一般常識、ひらめき問題、推測問題、検索問題など<br>正解した人の中から抽選で1名様に1000Pプレゼント<br>問題は月初めに更新</p>
					<img src="quiz.png">
					<form id="myForm" name="myForm" method="post" action="index.php">
						<input class="search" type="text" name="ans" placeholder="答えを入力" ><br><br>
						<input type="submit" value="答える"></input><br>
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