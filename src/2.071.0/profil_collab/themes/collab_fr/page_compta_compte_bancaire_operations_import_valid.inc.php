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
<p>comptes bancaire (import d'opérations) </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
var operation_in_closed_exercice= false;
var bad_operation_montant_move= false;
var exist_fitid = false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
//	if ($alerte=="operation_in_closed_exercice") {
//		echo "operation_in_closed_exercice=true;";
//		echo "erreur=true;\n";
//	}
	

}

?>
if (erreur) {

	if (operation_in_closed_exercice) {
		texte_erreur += "La date saisie correspond à un exercice comptable déjà clôturé.<br/> L'ajout d'opération est impossible dans un exercice clôturé";
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{
texte_erreur += "<?php echo $count_nb_import;?> opérations importées<br />";
texte_erreur += "<?php if ($nb_erreur_1 || $nb_erreur_2 ||  $nb_erreur_3) { echo $nb_erreur_1+$nb_erreur_2+$nb_erreur_3." opérations non importées<br /> dont: <br />";}?>";
texte_erreur += "<?php if ($nb_erreur_1) { echo $nb_erreur_1." opérations dont la date correspond à un exercice clôt<br />";}?>";
texte_erreur += "<?php if ($nb_erreur_2) { echo $nb_erreur_2." opérations déjà presentes<br />";}?>";
texte_erreur += "<?php if ($nb_erreur_3) { echo $nb_erreur_3." opérations dont le montant est érroné<br />";}?>";
	
window.parent.document.getElementById("edition_operation").style.display = "none";
window.parent.changed = false;
<?php if (isset($_REQUEST["from_tb"])) { ?>
window.parent.page.verify('compta_compte_bancaire_gestion2','compta_compte_bancaire_gestion2.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire();?>','true','sub_content');
<?php } else { ?>
window.parent.page.verify('compte_bancaire_releves','compta_compte_bancaire_releves.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire();?>','true','liste_releves');
window.parent.page.compte_bancaire_moves();
<?php } ?>
window.parent.alerte.alerte_erreur ('Import réussi', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}
</script>