
<?php

// *************************************************************************************************************
//  MODIFICATION DE L'ORDRE LA COORDONNEE D'UN CONTACT
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
<p>coordonnées: ordre dans un contact existant </p>
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
var erreur=false;
<?php 
foreach ($_ALERTES as $alerte => $value) {
	
}

?>
if (erreur) {
}
else
{

window.parent.switch_element('coordcontent_li_'+window.parent.document.getElementById('<?php echo $ref_coord_other?>').value, 'coordcontent_li_'+window.parent.document.getElementById('<?php echo $ref_coord?>').value);


window.parent.switch_inner_element('up_arrow_'+window.parent.document.getElementById('<?php echo $ref_coord_other?>').value,'up_arrow_'+window.parent.document.getElementById('<?php echo $ref_coord?>').value);


window.parent.switch_inner_element('down_arrow_'+window.parent.document.getElementById('<?php echo $ref_coord_other?>').value,'down_arrow_'+window.parent.document.getElementById('<?php echo $ref_coord?>').value);


}

</script>