<?php

// *************************************************************************************************************
// AFFICHAGE D'ALERTE SN EXISTANT OU NON A UN ARTICLE FABRIQUE
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
<?php 
if (isset($_REQUEST['art_sn']) && ($id_type_doc == $FABRICATION_ID_TYPE_DOC )) {
	if (isset($_INFOS['fab_sn_exist']) && $_INFOS['fab_sn_exist']) {
		?>
		$("<?php echo $_REQUEST['art_sn'];?>").style.color = "#FF0000";
		<?php
	} else {
		?>
		$("<?php echo $_REQUEST['art_sn'];?>").style.color = "#000000";
		<?php
	} 
}
?>
</script>