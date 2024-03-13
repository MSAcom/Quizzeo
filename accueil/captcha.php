<?php
session_start();

$_SESSION['captcha'] = mt_rand(1000,9999);
$img = imagecreate(150, 50); // Taille de l'image modifiée
$font = 'font/28DaysLater.ttf';

$bg = imagecolorallocate($img, 255, 255, 255); // background blanc
$textcolor = imagecolorallocate($img, 0, 0, 0); //texte noir


$font_size = 20; // taille des chiffres dans l'image
imagettftext($img, $font_size, 0, 10, 40, $textcolor, $font, $_SESSION['captcha']); // fonction qui dimensionne et inclu le texte dans l'image (img, taille police, rotation, horizontale, verticale, couleur, font, texte à afficher)

//header('Content-type: image/jpeg');
imagejpeg($img); //affiche image au format jpeg
imagedestroy($img); 
?>