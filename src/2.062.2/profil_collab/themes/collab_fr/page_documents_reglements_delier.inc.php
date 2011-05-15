<?php
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<p>&nbsp;</p>
<p>delier un document et un reglement </p>
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
}
?>
if (erreur) {

}
else
{

window.parent.changed = false;

if (window.parent.montant_total_neg) {
	window.parent.page.traitecontent('reglements_content','documents_reglements.php?ref_doc=<?php echo $ref_doc; ?>&montant_neg=1','true','reglements_content');
} else {
	window.parent.page.traitecontent('reglements_content','documents_reglements.php?ref_doc=<?php echo $ref_doc; ?>','true','reglements_content');
}
window.parent.page.traitecontent('documents_entete','documents_entete_maj.php?ref_doc=<?php echo $ref_doc; ?>','true','block_head');

}
</script>