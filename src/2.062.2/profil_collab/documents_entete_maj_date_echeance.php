<?php
// *************************************************************************************************************
// MAJ DE LA DATE_ECHEANCE D'UN DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (isset($_REQUEST['ref_doc'])) {

// ouverture des infos du document et mise à jour
	$document = open_doc ($_REQUEST['ref_doc']);

  $date = date_Fr_to_Us ($_REQUEST['info_content']);
	 
	$document->maj_date_echeance ($date);
}

if (round(strtotime($date)-strtotime(date("c")))<0) {
?>
#FF0000
<?php
} else {
?>
#000000
<?php
}
