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
<h1>Logowanie</h1>
<?php if(isset($login)) echo $login?>
<?php if(!isset($_SESSION['id_uzytkownika']) || $_SESSION['id_uzytkownika'] === NULL):?>
<form method="post">
	Login: <input type="text" name="login"/><br/><br/>
	Hasło: <input type="password" name="haslo"/><br/><br/>
	<input type="submit" value="Zaloguj się"/>
</form>
<div id="linki">Nie masz jeszcze konta? <a href="register">Zarejestruj się</a></div><br/>
<div id="linki">Spragniony zdjęć grzybów? <a href="gallery">Przejdź na stronę galerii</a></div><br/>
<?php else:?>
	<div id="sukces">Zalogowano pomyślnie.</div>
	<div id="linki">Spragniony zdjęć grzybów? <a href="gallery">Przejdź na stronę galerii</a></div><br/>
<?php if(!empty($_SESSION['id_uzytkownika'])): ?>
    <form id="wylogowywanie" method="post"><input type="submit" value="Wyloguj się" name="wyloguj"/></form>
<?php endif;?>
<?php endif;?>
<div id="footer">
<a id="odsylacz"></a>
<i>Grzybobranie-moje hobby </i><br/>
<a href="#">go top</a>
</div>
</div>
</body>
</html>