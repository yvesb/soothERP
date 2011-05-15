
<?php

// *************************************************************************************************************
//  MODIFICATION DE LA COORDONNEE D'UN CONTACT
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
<p>coordonnées: modification dans un contact existant </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
if (count($_ALERTES)>0) {
	echo "erreur";
}
?>
<script type="text/javascript">
var email=false;
var erreur=false;
var texte_erreur = "";
<?php 
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="email_used") {
		echo "email=true;";
		echo "erreur=true;\n";
	}
	
}


?>
if (erreur) {
if (email) {
	window.parent.document.getElementById("coordonnee_email<?php echo $_REQUEST['ref_idform']?>").className="alerteform_lsize";
	window.parent.document.getElementById("coordonnee_email<?php echo $_REQUEST['ref_idform']?>").focus();
texte_erreur += "Cette adresse email est déjà utilisée par <br/> <a href=\"index.php#annuaire_view_fiche.php?ref_contact=<?php if (isset( $_ALERTES["email_used"])) { echo $_ALERTES["email_used"][0];}?>\" target=\"_blank\"><?php if (isset( $_ALERTES["email_used"])) {  echo str_replace("\n", " ",addslashes($_ALERTES["email_used"][1]));}?></a>";
} else {
	window.parent.document.getElementById("coordonnee_email<?php echo $_REQUEST['ref_idform']?>").className="classinput_lsize";
}

window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

}
else
{
window.parent.changed = false;
window.parent.refreshtagmobil('coordlist2','li','coordcontent', 'annuaire_edition_valid_view_coordonnee_nouvelle', '<?php echo $ref_coord?>', '<?php echo $_REQUEST['ref_idform']?>');	
		
}
</script>