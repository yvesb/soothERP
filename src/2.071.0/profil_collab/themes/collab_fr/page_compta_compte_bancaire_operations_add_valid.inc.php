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
<p>comptes bancaire (ajout d'opération) </p>
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
var bad_date_move= false;
var exist_fitid = false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="operation_in_closed_exercice") {
		echo "operation_in_closed_exercice=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_operation_montant_move") {
		echo "bad_operation_montant_move=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="exist_fitid") {
		echo "exist_fitid=true;";
		echo "erreur=true;\n";
	}
	
	if ($alerte=="bad_date_move") {
		echo "bad_date_move=true;";
		echo "erreur=true;\n";
	}
	

}

?>
if (erreur) {

	if (operation_in_closed_exercice) {
		for (i=0; i<=<?php echo $_REQUEST["indentation_add_ope"];?>; i++) {
			window.parent.document.getElementById("date_move_"+i).className="classinput_nsize";
		}
		<?php if (isset($GLOBALS['_ALERTES']['operation_in_closed_exercice']) && is_array($GLOBALS['_ALERTES']['operation_in_closed_exercice'])) {
			foreach ($GLOBALS['_ALERTES']['operation_in_closed_exercice'] as $bad_date) {?>
			window.parent.document.getElementById("date_move_<?php echo $bad_date;?>").className="alerteform_nsize";
		<?php }
		}?>
		texte_erreur += "La date saisie correspond à un exercice comptable déjà clôturé.<br/> L'ajout d'opération est impossible dans un exercice clôturé.<br />";
	} 
	
	if (bad_operation_montant_move) {
		texte_erreur += "Le montant n'est pas valide.<br />";
	}
	if (exist_fitid) {
		texte_erreur += "Le Fitid est déjà utilisé.<br />";
	}
	if (bad_date_move) {
		texte_erreur += "Vérifier la date de l'opération.<br />";
	}

	window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{

window.parent.document.getElementById("edition_operation").style.display = "none";
window.parent.changed = false;
<?php if (isset($_REQUEST["from_tb"])) { ?>
window.parent.page.verify('compta_compte_bancaire_gestion2','compta_compte_bancaire_gestion2.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire();?>','true','sub_content');
<?php } else { ?>
window.parent.page.verify('compte_bancaire_releves','compta_compte_bancaire_releves.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire();?>','true','liste_releves');
window.parent.page.compte_bancaire_moves();
<?php }?>

}
</script>