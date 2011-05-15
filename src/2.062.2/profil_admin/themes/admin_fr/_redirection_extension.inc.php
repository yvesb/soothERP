<?php
$file = $DIR.$DIR_EXTENSION.$_SESSION['theme']->getDir_theme().$path_parts["basename"];
unset($path_parts);

if(file_exists($file)){
	include($file);
	exit;
}
?>