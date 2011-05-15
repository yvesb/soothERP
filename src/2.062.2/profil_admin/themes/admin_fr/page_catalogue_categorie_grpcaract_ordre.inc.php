
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
<p>art_categ grp_caract ORDRE </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var bad_ordre=false;
var bad_ref_carac_groupe=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="bad_ref_carac_groupe") {
	echo "erreur=true;";
	}
	if ($alerte=="bad_ordre") {
	echo "erreur=true;";

	}
	
}

?>
if (erreur) {

}
else
{
<?php 
if (isset ($_REQUEST['ref_art_categ']) ) {?>
window.parent.changed = false;

window.parent.switch_inner_element('down_arrow_<?php echo $ref_carac_groupe?>','down_arrow_<?php echo $ref_carac_groupe_other?>');
window.parent.switch_inner_element('up_arrow_<?php echo $ref_carac_groupe?>','up_arrow_<?php echo $ref_carac_groupe_other?>');
window.parent.switch_element('caract_table_<?php echo $ref_carac_groupe?>','caract_table_<?php echo $ref_carac_groupe_other?>');

window.parent.page.verify('caract_art_categ', 'catalogue_categorie_caract.php?ref_art_categs=<?php echo $_REQUEST['ref_art_categ']?>', 'true', 'caract_art_categ');


<?php }?>
}
</script>