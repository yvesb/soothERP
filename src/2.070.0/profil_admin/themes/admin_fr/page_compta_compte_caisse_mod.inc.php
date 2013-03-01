
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
<p>comptes caisse (modifier) </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var caisse_fonds_present = false;
var bad_id_magasin = false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="caisse_fonds_present") {
		echo "caisse_fonds_present=true;";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_id_magasin") {
		echo "bad_id_magasin=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {
	

	
	if (caisse_fonds_present) {
window.parent.document.getElementById("actif_<?php echo $_REQUEST['id_compte_caisse']?>").checked="checked";
		texte_erreur += "Votre caisse contient actuellement des fonds.<br/> Veuillez depuis l'interface collaborateur procéder à un transfert entre caisse ou à une remise en banque avant d'inactiver la caisse ";
	} 
	if (bad_id_magasin) {
		texte_erreur += "Votre caisse doit être liée à un magasin ";
	} 
	window.parent.alerte.alerte_erreur ('Modification impossible', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');



}
else
{

window.parent.changed = false;

window.parent.page.traitecontent('compta_compte_caisse','compta_compte_caisse.php?id_magasin=<?php echo $_REQUEST["id_magasin_".$_REQUEST["id_compte_caisse"]]?>','true','sub_content');

}
</script>