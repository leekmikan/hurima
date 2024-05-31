<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>登録処理</title>
	</head>
		<body>
        <script>
            var same = false;
        </script>
            <?php
                $mysqli = new mysqli("localhost", "root", "", "hurima_data");  
                $stmt = $mysqli->query('SELECT * FROM users WHERE mail = "'.$_POST['email'].'" AND pass = "'.$_POST['password'].'" LIMIT 1;');
                if(mysqli_num_rows($stmt) >= 1){
                    echo '<script>same = true;</script>';
                }else{
                    session_start();
                    $token = isset($_POST["token"]) ? $_POST["token"] : "";
                    $session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
                    unset($_SESSION["token"]);
                    if($token != "" && $token == $session_token) {
                        $mysqli->query('INSERT INTO users (user_name, sei, mei, mail, pass, history, adress_num, adress, birth, msg, cart, points, hidden_id,s_id,tmp) VALUES ("'.$_POST['user_name'].'","'.$_POST['user_sei'].'","'.$_POST['user_mei'].'","'.$_POST['email'].'","'.$_POST['password'].'","[]","'.$_POST['adress_number'].'","'.$_POST['adress'].'","'.$_POST['birth'].'",NULL,"[]",0,"[]",NULL,NULL)');
                    }
                }
            ?>
        </body>
        <script>
            if(same){
                alert("同じアカウントが存在します");
                location.href='../index.php';
            }else{
                alert("完了しました。");
                location.href='../../index.php';
            }
        </script>
    </head>
</html>