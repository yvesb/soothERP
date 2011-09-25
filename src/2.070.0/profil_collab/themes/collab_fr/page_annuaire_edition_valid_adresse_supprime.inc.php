
<?php

// *************************************************************************************************************
//  SUPPRESSION DE L'ADRESSE D'UN CONTACT
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
<p>adresse: supression dans un contact existant </p>
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
<?php
foreach ($adress as $adres) {
	?>
	window.parent.refreshtagmobil('adresslist2','li','adressecontent', 'annuaire_edition_valid_view_adresse_nouvelle', '<?php echo $adres->ref_adresse?>', '');	
	<?php
}
?>
window.parent.remove_tag ('adressecontent_li_<?php echo $_REQUEST['ref_idform']?>');
}
</script>