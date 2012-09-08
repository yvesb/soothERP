<?php

// *************************************************************************************************************
// SUPPRESSION D'UNE OPERATION
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
<p>comptes bancaire (supression opération) </p>
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
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="operation_in_closed_exercice") {
		echo "operation_in_closed_exercice=true;";
		echo "erreur=true;\n";
	}
}

?>
if (erreur) {

	if (operation_in_closed_exercice) {
		texte_erreur += "La date de l'opération correspond à un exercice comptable déjà clôturé.<br/> La supression d'opération est impossible dans un exercice clôturé.<br />";
	} 

	window.parent.alerte.alerte_erreur ('Suppression Impossible', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}
else
{
<?php if (!isset($_REQUEST["from_recherche"])) { ?>
	page.verify('compte_bancaire_releves','compta_compte_bancaire_releves.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire();?>','true','liste_releves');
	page.compte_bancaire_moves();
<?php } else {?>
	page.compte_bancaire_recherche();
<?php } ?>

}
</script>