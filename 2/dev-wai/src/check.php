<?php
function check(){
	if(empty($file['name'])) 
		return"Brak przesłanego zdjęcia";
	else if (($mime_type!=='image/jpeg'&&$mime_type!=='image/png')&&$file_size<=1024*1024)
		return "Nieprawidłowy format pliku. Obsługiwane typy to JPG i PNG.";
	else if (($mime_type==='image/jpeg'||$mime_type==='image/png')&&$file_size>1024*1024)
		return "Przesłany plik jest zbyt duży. Maksymalny dopuszczalny rozmiar to 1MB.";
	else if(($mime_type!=='image/jpeg'&&$mime_type!=='image/png')&&$file_size>1024*1024) return "Nieprawidłowy format i rozmiar pliku. Obsługiwane typy to JPG i PNG, a maksymalny dopuszczalny rozmiar to 1MB.";
	else if(empty(($string))) return "Proszę wprowadzić znak wodny!";
	else return NULL;
}
?>