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
<p>comptes bancaire (edition relevé) </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
var bad_releve_solde_reel= false;
var releve_in_closed_exercice= false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_releve_solde_reel") {
		echo "bad_releve_solde_reel=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="releve_in_closed_exercice") {
		echo "releve_in_closed_exercice=true;";
		echo "erreur=true;\n";
	}
	

}

?>
if (erreur) {

	if (bad_releve_solde_reel) {
		texte_erreur += "Le Solde réél n'est pas valide.";
	}
	if (releve_in_closed_exercice) {
		texte_erreur += "Le Relevé fait parti d'un exercice comptable clôt.<br /> Modification impossible.";
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');




}
else
{

window.parent.document.getElementById("edition_operation").style.display = "none";
window.parent.changed = false;
window.parent.page.verify('compte_bancaire_moves','compta_compte_bancaire_moves.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire();?>','true','sub_content');
//window.parent.page.compte_bancaire_moves();

}
</script>