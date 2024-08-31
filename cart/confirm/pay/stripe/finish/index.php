<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>購入完了</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../../../../../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../../../../../img/icon.jpg">
	<link rel="stylesheet" href="../../../../../main.css">
	<link rel="stylesheet" href="../../../../../cart/cart.css">
	</head>
		<body>
			<?php
				session_start();
				if (isset($_SESSION['id'])) {
					$mysqli = new mysqli("localhost", "root", "", "hurima_data");
					$stmt = $mysqli->query('SELECT * FROM users WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
					$data = $stmt->fetch_array(MYSQLI_ASSOC);
				}else{
					header('Location:../../../../../login/index.php');exit;
				}
			?>
			<header>
				<h1 id="title">購入完了</h1>
			</header>
			<div class="main">
					<?php
					$err = false;
					if (isset($_SESSION['id'])) {
                        $ar = [];
                        if(isset($_POST['bought'])){
                            $ar = $_POST['bought'];
                        }
						if(count($ar) == 0){
							echo '<h2 class="err">商品を購入できませんでした。</h2>';
                            echo '<p class="err">他の人が先に購入した可能性があります</p>';
							$err = true;
						}else{
							echo '<h2>購入できた商品</h2>';
							echo '<table border="1">';
							echo '<tr>';
							echo '<td>商品名</td>';
							echo '<td>画像</td>';
							echo '<td>詳細</td>';
							echo '<td>小計</td>';
							echo '</tr>';
							foreach($ar as $id){
								$mysqli->query('UPDATE items SET buy_id = "'.$_SESSION['id'].'" WHERE id = "'.$id.'" LIMIT 1;');
								$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$id.'" LIMIT 1;');
								$data = $stmt->fetch_array(MYSQLI_ASSOC);
								if($data != NULL){
									echo '<tr>';
									echo '<td>';
									echo '<input type="hidden" name="detail" value="'.$data['id'].'">';
									echo '<a>'.$data['item_name'].'</a>';
									echo '</td>';
									if($data['src0'] == "0"){
										echo '<td><img type="image" class="item_img" src="test.jpg"></td>';
									}else{
										$img = file_get_contents('../../../../../user_img/'.$data['src0'].'.dat');
										echo '<td><img type="image" class="item_img" src="'.$img.'"></td>';
									}
									echo '<td>'.nl2br($data['exp']).'</td>';
									echo '<td><span name="price">'.$data['price'].'</span>円</td>';
									echo '</tr>';
								}
							}
							echo '</table>';
						}
						$ar = [];
                        if(isset($_POST['sold_out'])){
                            $ar = $_POST['sold_out'];
                        }
                        if(count($ar) != 0){
							if(!$err){
                            	echo '<h2 class="err">購入できなかった商品</h2>';
                            	echo '<p class="err">他の人が先に購入した可能性があります</p>';
							}else{
								echo '<br><p>購入できなかった商品</p>';
							}
                            echo '<table border="1">';
						    echo '<tr>';
						    echo '<td>商品名</td>';
						    echo '<td>画像</td>';
						    echo '<td>詳細</td>';
						    echo '</tr>';
						    foreach($ar as $id){
						    	$stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$id.'" LIMIT 1;');
						    	$data = $stmt->fetch_array(MYSQLI_ASSOC);
						    	if($data != NULL){
						    		echo '<tr>';
						    		echo '<td>';
						    		echo '<input type="hidden" name="detail" value="'.$data['id'].'">';
						    		echo '<a>'.$data['item_name'].'</a>';
						    		echo '</td>';
						    		if($data['src0'] == "0"){
										echo '<td><img type="image" class="item_img" src="test.jpg"></td>';
									}else{
										$img = file_get_contents('../../../../../user_img/'.$data['src0'].'.dat');
										echo '<td><img type="image" class="item_img" src="'.$img.'"></td>';
									}
						    		echo '<td>'.nl2br($data['exp']).'</td>';
						    		echo '</tr>';
						    	}
						    }
						    echo '</table>';
                        }
						if(!$err){
                        	echo '<br><br><button onclick="location.href=\'../../../../../login/my_page/bought/judge/index.php\'">評価する</button>';
						}
                        echo '<br><br><button onclick="location.href=\'../../../../../index.php\'">ホームへ</button>';
					}
					?>
			</div>
			<footer>
				<?php require_once '../../../../../server/init.php'; Footer();?>
			</footer>
			<script src="main.js"></script>
		</body>
	</head>
</html>