
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
<p>site: suppression dans un contact existant </p>
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
foreach ($sites as $site) {
	?>
		window.parent.refreshtagmobil('sitelist2','li','sitecontent', 'annuaire_edition_valid_view_site_nouvelle', '<?php echo $site->ref_site?>', '');	
	<?php
}
?>

window.parent.remove_tag ('sitecontent_li_<?php echo $_REQUEST['ref_idform']?>');
}
</script>