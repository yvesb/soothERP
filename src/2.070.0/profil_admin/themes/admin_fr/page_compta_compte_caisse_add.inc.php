
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
<p>comptes caisse (ajouter une nouvelle) </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
var bad_id_magasin = false;
<?php 
if (count($_ALERTES)>0) {
	
	if ($alerte=="bad_id_magasin") {
		echo "bad_id_magasin=true;";
		echo "erreur=true;\n";
	}

}

?>
if (erreur) {
	

	if (bad_id_magasin) {
		texte_erreur += "Votre caisse doit être liée à un magasin ";
	} 
	window.parent.alerte.alerte_erreur ('Ajout impossible', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{

window.parent.changed = false;

window.parent.page.traitecontent('compta_compte_caisse','compta_compte_caisse.php?id_magasin=<?php echo $_REQUEST["id_magasin"]?>','true','sub_content');

}
</script>