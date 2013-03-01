
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
<p>liaisons type ORDRE </p>
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
if (isset($id_liaison_type)) {?>
window.parent.changed = false;

window.parent.switch_inner_element('down_arrow_<?php echo $id_liaison_type?>','down_arrow_<?php echo $id_liaison_type_other?>');
window.parent.switch_inner_element('up_arrow_<?php echo $id_liaison_type?>','up_arrow_<?php echo $id_liaison_type_other?>');
window.parent.switch_element('liaison_table_<?php echo $id_liaison_type?>','liaison_table_<?php echo $id_liaison_type_other?>');

<?php
}
?>
}
</script>