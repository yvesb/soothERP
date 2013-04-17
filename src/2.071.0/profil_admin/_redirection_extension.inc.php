<?php

$DIR_EXTENSION = "plus/";

$path_parts = pathinfo($_SERVER["PHP_SELF"]);
$path_parts2 = pathinfo($THIS_DIR);

$NEW_DIR = $DIR.$DIR_EXTENSION.$path_parts2["basename"]."/";
$file = $NEW_DIR.$path_parts["basename"];

if(file_exists($file)){
	include($file);
	exit;
}

?>