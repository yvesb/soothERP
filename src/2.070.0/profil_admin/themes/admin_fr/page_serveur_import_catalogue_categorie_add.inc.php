
<?php

// *************************************************************************************************************
// IMPORT D'UNE CATEGORIE
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
<p>art_categ import </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var ref_art_categ_exist = false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="ref_art_categ_exist") {
		?>
		erreur=true;
		ref_art_categ_exist = true;
		<?php
	}
	
}

?>
if (erreur) {


	if (ref_art_categ_exist) {
		texte_erreur += "Cette catégorie a déjà été importée.<br/>";
	} 
	window.parent.alerte.alerte_erreur ('Erreur', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
}
else
{
<?php 
if (isset ($_INFOS['Création_art_categ']) ) {?>
window.parent.changed = false;
window.parent.stop_observe('tr_<?php echo $ref_art_categ?>', 'mouseover');
window.parent.stop_observe('tr_<?php echo $ref_art_categ?>', 'mouseout');
window.parent.stop_observe('ins_<?php echo $ref_art_categ?>', 'click');
window.parent.document.getElementById('tr_<?php echo $ref_art_categ?>').bgColor="#FFEDFE";
window.parent.document.getElementById("content_art_categs").innerHTML = "Catégorie importée avec succés";
<?php }?>
}
</script>