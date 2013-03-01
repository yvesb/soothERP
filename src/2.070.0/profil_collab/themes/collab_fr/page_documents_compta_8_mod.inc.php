<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<p>&nbsp;</p>
<p>comptes de document (modifier) </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
	
}

?>
if (erreur) {
	


}
else
{

window.parent.changed = false;
<?php 
if (isset($_REQUEST["reload_search_grand_livre"])) {
	?>
	window.parent.compta_journal_achats_result<?php echo $_REQUEST["reload_search_grand_livre"];?>();
	window.parent.document.getElementById("pop_up_compta_facture_mini_moteur").style.display = "none";
	<?php
} else {
	?>
window.parent.page.traitecontent('documents_compta','documents_compta.php?ref_doc=<?php echo $_REQUEST["ref_doc_compta"]?>','true','compta_facture');
	<?php
}
?>
}
</script>