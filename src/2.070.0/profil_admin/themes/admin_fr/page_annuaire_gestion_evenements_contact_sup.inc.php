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
<p>suppression d'un type d'événement </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var exist_id_comm_event=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="exist_id_comm_event") {
		echo "exist_id_comm_event=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {
	

	if (exist_id_comm_event) {
		texte_erreur += "Ce type d'événement est déjà utilisé pour différents contacts.<br/>Ce type d'événement ne peut donc pas être supprimé.";
	} 

	window.parent.alerte.alerte_erreur ('Suppression impossible', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
}
else
{

window.parent.changed = false;

window.parent.page.verify('annuaire_gestion_evenements_contact','annuaire_gestion_evenements_contact.php','true','sub_content');

}
</script>