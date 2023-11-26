<?
session_start(); 

$alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

$text = substr(str_shuffle($alphanum), 0, 5);
$_SESSION["vercode"] = $text;

$height = 30;
$width = 65;
$bgNum = rand(1, 1);
  
$image_p = imagecreatefromjpeg("../images/background$bgNum.jpg");
$white = imagecolorallocate($image_p, 255, 255, 255);
$black = imagecolorallocate($image_p, 0, 0, 0); 
$font_size = 50;  

imagestring($image_p, $font_size, 5, 5, $text, $black); 
imagejpeg($image_p, null, 80);
?> 