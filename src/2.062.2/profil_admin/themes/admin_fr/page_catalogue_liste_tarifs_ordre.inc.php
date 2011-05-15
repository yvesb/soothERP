
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
<p>liste_tarif ordre </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var bad_ordre=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="bad_ordre") {
		echo "bad_ordre=true;\n";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {


		

}
else
{
<?php
if (isset($id_tarif)) {?>
window.parent.changed = false;

window.parent.switch_inner_element('down_arrow_<?php echo $id_tarif?>','down_arrow_<?php echo $id_tarif_other?>');
window.parent.switch_inner_element('up_arrow_<?php echo $id_tarif?>','up_arrow_<?php echo $id_tarif_other?>');
window.parent.switch_element('tarif_table_<?php echo $id_tarif?>','tarif_table_<?php echo $id_tarif_other?>');

<?php
}
?>
}
</script>