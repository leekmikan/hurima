<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>出品</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../img/icon.jpg">
	<link rel="stylesheet" href="../main.css">
	<link rel="stylesheet" href="../login/login.css">
	<link rel="stylesheet" href="put.css">
	<script src="../main.js"></script>
	</head>
		<body>
			<?php
			session_start();
				if (isset($_SESSION['id'])) {

				}else{
					$_SESSION['loc'] = "../put/index.php";
					header('Location:../login/index.php'); exit;
				}
			?>
			<header>
				<h1 id="title">出品</h1>
			</header>
			<!--商品名　価格などの入力欄 <input type="hidden"...>はすべて送信用-->
			<div class="form">
				<form name="myForm" method="post" action="confirm/index.php" onsubmit="return check()">
				<label for="name">商品名</label>
				<input type="text" name="name" id="name" placeholder="商品名" maxlength="40"><br>
				<label for="price">価格</label>
				<input type="number" name="price" id="price" placeholder="価格" pattern="\d+" min="1" step="1" max="1000000"><br>
				<label for="images">画像</label><br>
				<input name="images[]" id="images" type="file" multiple="multiple" accept="image/*"><br>
				<!--1枚目(id="0")は大きく表示-->
				<img class="sam" id="0"src="../img/noimage.jpg">
				<img id="1" src="../img/noimage.jpg">
				<img id="2" src="../img/noimage.jpg">
				<img id="3" src="../img/noimage.jpg">
				<img id="4" src="../img/noimage.jpg"><br>
				<input type="hidden" name="0" id="0x" value="../img/noimage.jpg">
				<input type="hidden" name="1" id="1x" value="../img/noimage.jpg">
				<input type="hidden" name="2" id="2x" value="../img/noimage.jpg">
				<input type="hidden" name="3" id="3x" value="../img/noimage.jpg">
				<input type="hidden" name="4" id="4x" value="../img/noimage.jpg">
				<button type="button" onclick="reset_img()" data-action="">画像をリセット</button><br>
				<label for="exp">商品説明</label><br>
				<?php
					$mobile_ck = false;
					$user_agent = $_SERVER['HTTP_USER_AGENT'];
					$mobile_agents = array('Mobile', 'Android', 'Silk/', 'Kindle', 'BlackBerry', 'Opera Mini', 'Opera Mobi');
					foreach ($mobile_agents as $agent) {
						if (strpos($user_agent, $agent) !== false) {
							$mobile_ck = true;
							break;
						}
					}
					//スマホは入力を縦長にする
					if($mobile_ck){
						echo '<textarea name="exp" id="exp" cols="40" rows="16"></textarea>';
					}else{
						echo '<textarea name="exp" id="exp" cols="80" rows="8"></textarea>';
					}
				?>
				<br>
				<!--カテゴリー　状態　配達方法　の種類はserver/const.phpで設定-->
				<label for="genre">カテゴリー</label>
				<select id="genre" name="genre">
					<?php
						require_once '../server/const.php';
						for($i = 0;$i < count($GENRE);$i++){
							echo '<option value="'.$i.'">'.$GENRE[$i].'</option>';
						}
					?>
				</select><br>
				<label for="stat">状態</label>
				<select id="stat" name="stat">
					<?php
						for($i = 0;$i < count($STAT);$i++){
							echo '<option value="'.$i.'">'.$STAT[$i].'</option>';
						}
					?>
				</select><br>
				<label for="send">配送方法</label>
				<select id="send" name="send">
					<?php
						for($i = 0;$i < count($HSEND);$i++){
							echo '<option value="'.$i.'">'.$HSEND[$i].'</option>';
						}
						echo '<input type="hidden" name="token" value="'.$token.'">';
					?>
				</select><br>
				<!--一時保存　確認ボタン-->
				<div class="cf">
					<button type="button" onclick="save_data(); counter = 60; document.getElementById('saved').style.display = 'block';">下書き保存</button>
					<input type="submit" value="確認画面へ">
				</div>
				<p>60秒ごとに自動保存されます。</p>
				<!--保存時に5秒間表示-->
				<p id="saved" style="display:none;">保存しました。</p>
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
		<script src="main.js"></script>
	</head>
</html>