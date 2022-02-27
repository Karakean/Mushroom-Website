<?php


use MongoDB\BSON\ObjectID;


function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);

    $db = $mongo->wai;

    return $db;
}
function check($mime_type,$file_size,$string,$prywatnosc){
	if (($mime_type!=='image/jpeg'&&$mime_type!=='image/png')&&$file_size<=1024*1024)
		return "Nieprawidłowy format pliku. Obsługiwane typy to JPG i PNG.";
	else if (($mime_type==='image/jpeg'||$mime_type==='image/png')&&$file_size>1024*1024)
		return "Przesłany plik jest zbyt duży. Maksymalny dopuszczalny rozmiar to 1MB.";
	else if(($mime_type!=='image/jpeg'&&$mime_type!=='image/png')&&$file_size>1024*1024) return "Nieprawidłowy format i rozmiar pliku. Obsługiwane typy to JPG i PNG, a maksymalny dopuszczalny rozmiar to 1MB.";
	else if(empty(($string))) return "Proszę wprowadzić znak wodny.";
	else if($prywatnosc==2)return "Proszę wybrać prywatność zdjęcia.";
	else return NULL;
}
function upload_image($file,$string,$tytul,$autor,$prywatnosc,$id_autora){
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	if(empty($file['name']))
		return"Brak przesłanego zdjęcia";
	$file_name=$file['tmp_name'];
	$file_size=$file['size'];
	$mime_type=finfo_file($finfo,$file_name);
	$check=check($mime_type,$file_size,$string,$prywatnosc);
	if($check!==NULL)return $check;
	$data=date("Y_m_d_H_i_s");
	$upload_dir='/var/www/prod/src/web/static/images/';
	$nazwa_pliku=$data.basename($file['name']);
	$target=$upload_dir.'originals/'.$nazwa_pliku;
	$tmp_path=$file['tmp_name'];
	move_uploaded_file($tmp_path,$target);
	
	$font = 25;
    $znak = imagecreate(strlen($string) * $font / 2.66, $font);
    $white = imagecolorallocate($znak, 255, 255, 255);
    $grey = imagecolorallocate($znak, 128, 128, 128);
    imagestring($znak, $font, 0, 0, $string, $grey);
	
	if($mime_type==='image/jpeg')$img=imagecreatefromjpeg($target);
	else $img=imagecreatefrompng($target);
	$width=imagesx($img);
	$height=imagesy($img);
	
	$mini_width=240;
	$mini_height=180;
	$miniatura=imagecreatetruecolor($mini_width,$mini_height);
	imagecopyresampled($miniatura,$img,0,0,0,0,$mini_width,$mini_height,$width,$height);
	//$min_nazwa="min-".$nazwa_pliku;
	imagejpeg($miniatura,$upload_dir.'thumbnails/'.$nazwa_pliku,100);
	
	$szerokosc_znaku=imagesx($znak);
	$wysokosc_znaku=imagesy($znak);
	$x=$width-$szerokosc_znaku;
	$y=$height-$wysokosc_znaku;
	imagecopy($img,$znak,$x,$y,0,0,$szerokosc_znaku,$wysokosc_znaku);
	//$znw_nazwa="znw-".$nazwa_pliku;
	imagejpeg($img,$upload_dir.'watermarked/'.$nazwa_pliku,100);
	
	$db=get_db();
	$informacja=[
	'nazwa'=>$nazwa_pliku,
	'sciezka_miniaturki'=>'static/images/thumbnails/'.$nazwa_pliku,
	'wodna_sciezka'=>'static/images/watermarked/'.$nazwa_pliku,
	'tytul'=>$tytul,
	'autor'=>$autor,
	'id_autora'=>$id_autora,
	'prywatnosc'=>$prywatnosc
	];
	$db->informacje->insertOne($informacja);
	
	imagedestroy($img);
	imagedestroy($miniatura);
}
function licznik(&$model){
$i=0;
$photos_per_card=5;
$miniaturki=array();
$z = opendir('static/images/thumbnails');
while ( $file = readdir( $z ) )
{
$parts = pathinfo( 'static/images/thumbnails/' . $file );
  if (( $parts['extension']  == 'jpg' )||( $parts['extension']  == 'png' ))
  {
	$miniaturki[]=$parts['basename'];
	$i++;
  }
}
closedir($z);
$liczba_kart=ceil($i/$photos_per_card);
$model['liczba_kart']=$liczba_kart;
$model['photos_per_card']=$photos_per_card;
$model['miniaturki']=$miniaturki;
}
function szukacz(&$model){
	$db=get_db();
	$info=$db->informacje->find();
	$model['info']=$info->toArray();
}
function author(){
	$db=get_db();
	$user=$db->uzytkownicy->findOne([
	'_id'=>$_SESSION['id_uzytkownika']]);
	$autor=$user['login'];
	return $autor;
}
function privacy($isprivate){
	if($isprivate=='prywatne')return 1;
	else return 0;
}
function authors_id($autor){
	$db=get_db();
	$autorek=$db->uzytkownicy->findOne(['login'=>$autor]);
	$id_autora=$autorek['_id'];
	return $id_autora;
}
function registration($email,$login,$haslo,$haslo2){
	if (empty($email)||empty($login)||empty($haslo)||empty($haslo2))return "Proszę uzupełnić wszystkie pola.";
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL))return "Podany adres e-mail nie jest poprawny.";
	else if($haslo!==$haslo2)return "Podane hasla nie są jednakowe.";
	else if($login=='nieznany')return "Proszę wprowadzić inną nazwę użytkownika.";
	$db=get_db();
	$emaile = $db->uzytkownicy->find(["email" => $email])->toArray();
    $loginy = $db->uzytkownicy->find(["login" => $login])->toArray();
	if(count($emaile)>0)return"Podany adres e-mail jest już zajęty.";
	else if(count($loginy)>0)return"Podany login jest już zajęty.";
	else{
		$uzytkownik=[
		'email'=>$email,
		'login'=>$login,
		'haslo'=>hash("sha256",$haslo)
		];
	$db->uzytkownicy->insertOne($uzytkownik);
	return header('Location:login');
	}
}
function to_login($login,$haslo){
	if(empty($login)||empty($haslo))return"Proszę uzupełnić wszystkie pola.";
	$db = get_db();
    $uzytkownik = $db->uzytkownicy->find([
        "login" => $login,
        "haslo" => hash("sha256", $haslo)
    ])->toArray();
	if(count($uzytkownik)===0)return "Błędny login lub hasło.";
	else{ $_SESSION['id_uzytkownika']=$uzytkownik[0]['_id'];}
}
