<?php

// Load library
require_once('../ods.php');

// Create Ods object
$ods  = new ods();

// Set properties
$ods->setTitle("My title is cool");
$ods->setSubject("My subject is cool too");
$ods->setKeyword("ods, internet");
$ods->setDescription("I love odsPhpGenerator !!\n\nOk, i'm a programmer, sorry");

// Download the file
$ods->downloadOdsFile("Properties.ods"); 

?>
