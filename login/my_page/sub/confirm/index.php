<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>手数料パスの解約</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../../main.css">
	<link rel="stylesheet" href="../../my_page.css">
	<script src="main.js"></script>
	</head>
		<body>
			<header>
				<?php
				session_start();
				if (isset($_SESSION['id'])) {
				}else{
					header('Location:../../../index.php');exit;
				}
				?>
                <h1 id="title">手数料パスの解約</h1>
			</header>
				<div class="main ct">
					<?php
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'";');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
                    if(!is_null($data['sub'])){
					    require_once '../../../../server/const.php';
					    require_once '../../../../server/'.$STRIPE_API;
					    $stripe = new \Stripe\StripeClient($SECRET);
					    $sub = $stripe->subscriptions->retrieve($data['sub'], []);
					    echo '<p>解約しますか？</p>';
					    echo '<button style="width: 20vw;height: 20vh" onclick="location.href=\'del.php\'">解約</button>';
					    echo '<p>'.date('Y-m-d H:i:s',$sub['current_period_end']).'までは登録時と同様のサービスを受けられます。</p>';
                    }else{
                        header('Location:../../../index.php');exit;
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
		<script src="../../../main.js"></script>
	</head>
</html>