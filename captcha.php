<?php
session_start();
$rand = mt_rand(1000, 9999);
$_SESSION["rand"] = $rand;
$im = imageCreateTrueColor(80, 44);
$c = imageColorAllocate($im, 130, 120, 210);
imagettftext($im, 18, -8, 8, 32, $c, __DIR__ . "/fonts/arial.ttf", $rand);
header("Content-type: image/png");
imagePng($im);
imageDestroy($im);
