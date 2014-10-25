<?php
// *************************************************************************************************************
// AJOUT DE LIGNES AU DOCUMENT
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

echo"tott";
if (isset($_REQUEST['ref_doc'])) {

// ouverture des infos du document
	$document = open_doc ($_REQUEST['ref_doc']);
	
}

if (isset($_REQUEST['lines_data'])) {

// 
	$lines_data = unserialize (stripslashes($_REQUEST['lines_data']));
}
$infos = array();

if (is_array($lines_data)){
	foreach($lines_data as $key => $value){
		$infos = array();
			$infos['type_of_line']	=	"article";
			$infos['sn']						= array();
			if (isset($_REQUEST['num_serie']) && $_REQUEST['num_serie'] != "") {
				$infos['sn'][]					=	$_REQUEST['num_serie'];
			}
			$infos['ref_article']		=	$key;
			$infos['qte']				=	$value;
			if (!$document->getQuantite_locked ()) {
				$document->add_line ($infos);
			}
	}
}



// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_line_add.inc.php");
?>