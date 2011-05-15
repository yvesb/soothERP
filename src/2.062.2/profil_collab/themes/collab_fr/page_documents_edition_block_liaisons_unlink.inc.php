<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
// on recharge les liaisons
	var AppelAjax = new Ajax.Updater(
											"block_liaisons",
											"documents_edition_block_liaisons.php", 
											{
											parameters: { ref_doc: '<?php echo $document->getRef_doc()?>' <?php if (isset($_REQUEST["lets_open"])) {?>, lets_open: 1<?php } ?>},
											evalScripts:true, 
											onLoading:S_loading, onException: function () {S_failure();}, 
											onComplete: function (){
																	H_loading();
																	}
											}
											);

//on masque le chargement
H_loading();

</script>