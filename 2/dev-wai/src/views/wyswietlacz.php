<?php 
for($i=0;$i<$photos_per_card;$i++){$x=($karta-1)*$photos_per_card+$i;
	if(isset($info[$x]))
	{
		if(isset($_SESSION['id_uzytkownika']))
		{
			if($info[$x]['prywatnosc']==0)echo '<div id="zdjecie"><a href="'.$info[$x]['wodna_sciezka'].'" target="_blank"><img src="'.$info[$x]['sciezka_miniaturki'].'"></a><br/>Autor: '.$info[$x]['autor'].'<br/>'.'Tytuł: '.$info[$x]['tytul'].'</div>';
			else if(($info[$x]['prywatnosc']==1)&&($info[$x]['id_autora']==$_SESSION['id_uzytkownika']))echo '<div id="zdjecie"><a href="'.$info[$x]['wodna_sciezka'].'" target="_blank"><img src="'.$info[$x]['sciezka_miniaturki'].'"></a><br/>Autor: '.$info[$x]['autor'].'<br/>'.'Tytuł: '.$info[$x]['tytul'].'<br/>ZDJĘCIE PRYWATNE'.'</div>';
			else if(($info[$x]['prywatnosc']==1)&&($info[$x]['_id']!=$_SESSION['id_uzytkownika']))echo '<div id="zdjecie"><img src=static/private.png /></div>';
		}
		else if (!isset($_SESSION['id_uzytkownika']))
		{
			if($info[$x]['prywatnosc']==0)echo '<div id="zdjecie"><a href="'.$info[($karta-1)*$photos_per_card+$i]['wodna_sciezka'].'" target="_blank"><img src="'.$info[($karta-1)*$photos_per_card+$i]['sciezka_miniaturki'].'"></a><br/>Autor: '.$info[($karta-1)*$photos_per_card+$i]['autor'].'<br/>'.'Tytuł: '.$info[($karta-1)*$photos_per_card+$i]['tytul'].'</div>';
			else if($info[$x]['prywatnosc']==1)echo '<div id="zdjecie"><img src=static/private.png /></div>';
		}
	}
}
?>