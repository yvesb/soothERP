<?php
// *************************************************************************************************************
// OUVERTURE DU PANIER D'UN DOCUMENT EN MODE EDITION
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

		
if (isset($_REQUEST["ref_doc"])) {
	if(isset($_SESSION['INFOS']['change_etat'])){
		if($_SESSION['INFOS']['change_etat'] == 1){
			unset($_SESSION['INFOS']['change_etat']);
			?>
			<script type="text/javascript">
			page.traitecontent('documents_entete','documents_entete_maj.php?ref_doc=<?php echo $_REQUEST['ref_doc']?>','true','block_head');
			</script>
			<?php 
		}
	}
		
	$ref_doc= $_REQUEST["ref_doc"];
	$document = open_doc ($ref_doc);
	
}
// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_edition_panier.inc.php");

?>