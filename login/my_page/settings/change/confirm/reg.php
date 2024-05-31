<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>登録処理</title>
	</head>
		<body>
        <script>
            var end = true;
        </script>
            <?php
                session_start();
                if (isset($_SESSION['id'])) {
                    $mysqli = new mysqli("localhost", "root", "", "hurima_data");
                    $stmt = $mysqli->query('SELECT COUNT(*) FROM users WHERE mail = "'.$_POST['email'].'" and pass = "'.$_POST['password'].'" LIMIT 1;');
                    $data = $stmt->fetch_array(PDO::FETCH_ASSOC);
                    if($data >= 1){
                        $mysqli->query('UPDATE users SET user_name = "'.$_POST['user_name'].'",sei = "'.$_POST['user_sei'].'",mei = "'.$_POST['user_mei'].'",mail = "'.$_POST['email'].'",pass = "'.$_POST['password'].'",adress_num = "'.$_POST['adress_number'].'",adress = "'.$_POST['adress'].'",birth = "'.$_POST['birth'].'",msg = "'.$_POST['msg'].'" WHERE id = "'.$_SESSION['id'].'" LIMIT 1;');
                    }else{
                        echo '<script>end = false</script>';
                    }
                }else{
                    header('Location:../../index.php');
                }
            ?>
        </body>
        <script>
            if(!end){
                alert("データが存在しません");
                location.href='../index.php';
            }else{
                alert("完了しました。");
                location.href='../../index.php';
            }
        </script>
    </head>
</html>