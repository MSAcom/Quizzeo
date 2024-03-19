<?php
session_start(); 

$_SESSION['captcha'] = mt_rand(1000,9999); //génère nbr aléatoire pour le captcha
$img = imagecreate(150, 50); // crée une image avec une taille
$font = 'font/28DaysLater.ttf';

$bg = imagecolorallocate($img, 255, 255, 255); // background blanc
$textcolor = imagecolorallocate($img, 0, 0, 0); //texte noir


$font_size = 20; // taille des chiffres dans l'image
imagettftext($img, $font_size, 0, 10, 40, $textcolor, $font, $_SESSION['captcha']); // inclu et redimensionne le texte dans l'image (img, taille police, rotation, horizontale, verticale, couleur, font, texte à afficher)

header('Content-type: image/jpeg'); // dire au navigateur que le contenue de l'image est en jpeg pour éviter des bug.
imagejpeg($img); //affiche image au format jpeg *pareil* 
imagedestroy($img); 
?>