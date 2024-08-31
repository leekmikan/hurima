<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>課金</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../main.css">
	<link rel="stylesheet" href="../my_page.css">
	<script src="main.js"></script>
	</head>
		<body>
			<header>
				<?php
				session_start();
				if (isset($_SESSION['id'])) {
				}else{
					header('Location:../../index.php');exit;
				}
				?>
                <h1 id="title">手数料パスの購入</h1>
			</header>
				<div class="main ct">
					<?php
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'";');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
					require_once '../../../server/const.php';
					if(is_null($data['sub'])){
						echo '<button style="width: 20vw;height: 20vh" onclick="location.href=\'pay/index.php\'">手数料パス(550円/月)<br>売上の手数料が0円になります。</button><br>';
					}else{
						require_once '../../../server/'.$STRIPE_API;
						$stripe = new \Stripe\StripeClient($SECRET);
						$sub = $stripe->subscriptions->retrieve($data['sub'], []);
						if($sub['status'] == 'active' && !$sub['cancel_at_period_end']){
							echo '<button style="width: 20vw;height: 20vh" onclick="location.href=\'confirm/index.php\'">解約</button><p>定期購入を解約できます。</p>';
							echo '<p>次の登録更新日時: '.date('Y-m-d H:i:s',$sub['current_period_end']).'</p>';
						}else if($sub['cancel_at_period_end']){
							echo '<button style="width: 20vw;height: 20vh" onclick="location.href=\'cancel.php\'">解約を取り消し</p></button>';
							echo '<p>'.date('Y-m-d H:i:s',$sub['current_period_end']).'まで取り消し可能</p>';
						}
						else{
							echo '<button style="width: 20vw;height: 20vh" onclick="location.href=\'pay/index.php\'">手数料パス(550円/月)</button><p>売上の手数料が0円になります。</p>';
						}
					}
					echo '<br>';
					$hit = mysqli_num_rows($mysqli->query("SELECT id FROM users WHERE frag & 32 = 32;")) ;
					if(($data['frag'] & 32) == 0 && $hit < $SUPPORT_LIMIT){
						echo '<button style="width: 20vw;height: 20vh" onclick="location.href=\'pay_sup/index.php\'">支援者登録(500円/月)<br>ホームに名前<br>ユーザーで商品検索出来るURL<br>が表示されます</button>';
					}else{
						echo '<h2>支援者登録済み</h2>';
					}
				?>
				<br><br>
				<button onclick="location.href='../index.php'">戻る</button>
                </div>
				<footer>
				<?php require_once '../../../server/init.php'; Footer();?>
			</footer>
		</body>
		<script src="../../../main.js"></script>
	</head>
</html>