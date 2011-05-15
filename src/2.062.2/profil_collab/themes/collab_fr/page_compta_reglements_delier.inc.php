
<?php

// *************************************************************************************************************
// DELIER UNE REGLEMENT
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
<p>delier un reglement </p>
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
foreach ($_ALERTES as $alerte => $value) {
if ($alerte =="bad_ref_reglement") {
echo "erreur = true";
}
}
?>
if (erreur) {

}
else
{

window.parent.changed = false;

<?php 
if (isset($_REQUEST["maj_ref_doc"]) && $_REQUEST["maj_ref_doc"] != "") { 
	?>
		if (window.parent.montant_total_neg) {
			window.parent.page.traitecontent('reglements_content','documents_reglements.php?ref_doc=<?php echo $_REQUEST["maj_ref_doc"]; ?>&montant_neg=1','true','reglements_content');
		} else {
			window.parent.page.traitecontent('reglements_content','documents_reglements.php?ref_doc=<?php echo $_REQUEST["maj_ref_doc"]; ?>','true','reglements_content');
		}
	window.parent.page.traitecontent('documents_entete','documents_entete_maj.php?ref_doc=<?php echo $_REQUEST["maj_ref_doc"]; ?>','true','block_head');
	<?php 
} 
?>
<?php 
if (isset($_REQUEST["maj_ref_contact"]) && $_REQUEST["maj_ref_contact"] != "") { ?>
	window.parent.page.grand_livre_result ("<?php echo $_REQUEST["maj_ref_contact"];?>");
<?php 
} 
?>
window.parent.remove_tag("<?php echo $_REQUEST["id_tag"];?>");
}
</script>