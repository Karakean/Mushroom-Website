<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<link rel="stylesheet" href="static/css/style.css" />
<script src="static/jquery.js"></script>
<script src="static/js.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap" rel='stylesheet' type='text/css'>
</head>
<body>
<div id="wrapper">
<div class="header">
<div class="logo">
<a href="#odsylacz"><img src="static/img/120199.png" height="100" width="100" alt="logo" /></a>
Grzybobranie
</div>
</div>
<div id="nav">
	<ol>
		<li><a href="gallery">Grzybowa galeria</a></li>
		<li><a href="login">Logowanie</a></li>
		<li><a href="register">Rejestracja</a></li>
	</ol>
</div>
<h1>Grzybowa galeria</h1>
<h3>Prześlij swoje zdjęcie do grzybowej galerii!</h3>
<form method="post" enctype="multipart/form-data">
Wybierz zdjęcie: <input type="file" name="zdjecie"/><br/>
Znak wodny: <input type="text" name="znak"/><br/>
Tytuł:<input type="text" name="title"/><br/>
<?php if(isset($_SESSION['id_uzytkownika'])): ?>
Autor: <?=$autor ?>
<br/><input type="radio" name="prywatnosc" value="publiczne">Publiczne</br>
<input type="radio" name="prywatnosc" value="prywatne">Prywatne</br>
<?php else:?>
Autor:<input type="text" name="author"/><br/>
<?php endif;?>
<input type="submit" value="Wyślij" name="send"/>
</form>
<?= isset($gallery)? $gallery:""?>
<div id="galeria">
<?php require 'wyswietlacz.php';?>
</div>
<div id="paging"><?php for($j=1;$j<=$liczba_kart;$j++) echo '<a href="/gallery?karta='.$j.'">'.$j.'</a> ';?></div>
<div id="footer">
<a id="odsylacz"></a>
<i>Grzybobranie-moje hobby </i><br/>
<a href="#">go top</a>
</div>
</div>
</body>
</html>