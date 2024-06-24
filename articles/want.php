<!DOCTYPE html>
<html lang="ja">
	<head>
	<meta charset="uft-8">
	<title>積極的に購入する商品一覧</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/jpg" href="../img/icon.jpg">
	<link rel="apple-touch-icon" sizes="180x180" href="../img/icon.jpg">
	<link rel="stylesheet" href="../main.css">
	<script src="../main.js"></script>
	</head>
		<body>
			<header>
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
				<div class="main dot">
				    <!--欲しいものがあれば提案-->
                    <p>買い取りテストを兼ねた開発者が購入したいもの一覧です。</p>
                    <p>可能であれば出品お願いいたします。</p>
                    <p>形式：[種類]商品(買い取り予定価格　?...適正価格不明、適当)</p>
                    <ol>
						<li>優先度高</li>
                        <li>[CD]初音ミク Project mirai こんぷりーと(6,000)</li>
						<li>[その他]寝そべりぬいぐるみ　ビビバスミク,ダショミク以外の4人(1,500?)</li>
						<li>[CD]股関節脱臼(1,000)</li>
						<li>[CD]トラボティック・シンフォニー(1,000)</li>
						<li>[CD]マジカルミライのCD 2017,2018,2020,2021,2023以外(2,000～7,000　　年によって全然違うみたい)</li>
                        <li>[CD]トランジスタの道化師～Heartsnative3～(1,000)</li>
						<li>[CD]ELECTLOID feat.初音ミク(1,000)</li>
						<li>[CD]初音ミク -Project DIVA-X Complete Collection(2,800)</li>
                        <li>[CD]EXIT TUNES PRESENTS VOCALOFANTASYより後のCD (1,000～4,000)</li>
                        <li>[その他]ペンライト(1,000～?)</li>
						<li>優先度低</li>
                    </ol>
					<p>※上記以外でも、初音ミクかつ商品に重大な欠陥がなければできる限り購入します</p>
					<p>※同時に大量出品されると買いきれないかも(学部2年のアルバイトなので)</p>
					<p>※ちょくちょく変更されるかも</p>
					<p>※プロセカなど、ボカロ以外がメインに含まれているCD不可(ボーナストラック除く)</p>
					<p>※<a href="songs.xlsx">購入済みCD一覧</a></p>
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