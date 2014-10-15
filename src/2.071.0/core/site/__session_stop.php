<?php
$DIR = "../";
if(!session_id()) {session_start(); }

session_unset();
session_destroy();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

header ("Location: ".$DIR); 
exit();
?>