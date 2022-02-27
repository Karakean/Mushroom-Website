<?php
require_once 'business.php';

function gallery(&$model)
{
	if (isset($_SESSION['id_uzytkownika'])){
	$autor=author(); 
	$model['autor']=$autor;
	$id_autora=authors_id($autor);
	}
	if(isset($_FILES['zdjecie'],$_POST['znak'])){
	if($_POST['title']!=NULL)$tytul=$_POST['title'];
	else $tytul='nienazwany';
	if(!isset($_SESSION['id_uzytkownika'])){
	if($_POST['author']!=NULL){$autor=$_POST['author'];$id_autora=authors_id($autor);}
	else if($_POST['author']==NULL){$autor='nieznany';$id_autora=NULL;}}
	if(isset($_POST['prywatnosc']))$prywatnosc=privacy($_POST['prywatnosc']);
	else if((!isset($_POST['prywatnosc']))&&(isset($_SESSION['id_uzytkownika'])))$prywatnosc=2;
	else $prywatnosc=0;
	$gallery=upload_image($_FILES['zdjecie'],$_POST['znak'],$tytul,$autor,$prywatnosc,$id_autora);
	$model['gallery']=$gallery;}
	licznik($model);
	szukacz($model);
	require 'karta.php';
	return 'gallery_view';
}
function register(&$model){
	if(isset($_POST['email'],$_POST['login'],$_POST['haslo'],$_POST['haslo2'])){
	$email=$_POST['email'];
	$login=$_POST['login'];
	$haslo=$_POST['haslo'];
	$haslo2=$_POST['haslo2'];
	$register=registration($email,$login,$haslo,$haslo2);
	$model['register']=$register;}
	return 'register_view';
}
function login(&$model){
	if(isset($_POST['login'],$_POST['haslo'])){
	$nazwa_uzytkownika=$_POST['login'];
	$haslo=$_POST['haslo'];
	$login=to_login($nazwa_uzytkownika,$haslo);
	$model['login']=$login;}
	if(isset($_POST['wyloguj']))$_SESSION['id_uzytkownika'] = NULL;
	return 'login_view';
}

