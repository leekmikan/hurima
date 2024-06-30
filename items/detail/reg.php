<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>カート追加</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../img/icon.jpg">
	<link rel="stylesheet" href="../main.css">
	<link rel="stylesheet" href="login.css">
	<script src="main.js"></script>
	</head>
		<body>
			<header>
				<a href="../index.php"><img class="logo" src="../img/logo.jpg"></a>
			</header>
            <?php
            if (isset($_POST['cart'])) {
                session_start();
                $token = isset($_POST["token"]) ? $_POST["token"] : "";
                $session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
                unset($_SESSION["token"]);
                if($token != "" && $token == $session_token) {
                    if(!isset($_SESSION['id'])){
                        header('Location:../../login/index.php');exit;
                    }else{
                        $stmt = $mysqli->query('SELECT * FROM items WHERE id = "'.$_POST['cart'].'" LIMIT 1;');
                        if(mysqli_num_rows($stmt) != 0){
                            $mysqli->query('UPDATE users SET cart = IFNULL(json_array_append(cart, "$", "'.$_POST['cart'].'"), json_array("'.$_GET['cart'].'")) WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
                        }
                    }
                }
            }
            header('Location:../index.php');exit;
            ?>
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