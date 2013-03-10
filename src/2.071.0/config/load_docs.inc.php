<?php

// *************************************************************************************************************
// CLASSES A CHARGER POUR LA GESTION DES DOCUMENTS
// *************************************************************************************************************
$types_docs = array ("dev", "cdc", "blc", "fac", "def", "cdf", "blf", "faf", "trm", "pac", "inv", "fab", "des","tic", "mod","cot");

foreach ($types_docs as $code_doc) {
	require_once ($DIR."documents/_doc_".$code_doc.".config.php");
}


?>