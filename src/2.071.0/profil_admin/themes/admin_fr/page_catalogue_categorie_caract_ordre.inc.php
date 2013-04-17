
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
var bad_ref_carac=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="bad_ref_carac") {
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

window.parent.switch_inner_element('down_arrow_<?php echo $ref_carac?>','down_arrow_<?php echo $ref_carac_other?>');
window.parent.switch_inner_element('up_arrow_<?php echo $ref_carac?>','up_arrow_<?php echo $ref_carac_other?>');
window.parent.switch_element('caract_table_<?php echo $ref_carac?>','caract_table_<?php echo $ref_carac_other?>');



<?php }?>
}
</script>