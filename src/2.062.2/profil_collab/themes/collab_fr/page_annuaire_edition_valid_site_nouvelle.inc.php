
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
<p>site: ajout d'une nouvelle dans un contact existant </p>
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
var email=false;
var erreur=false;
<?php 
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="email_used") {
		echo "email=true;";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {

}
else
{
window.parent.changed = false;
window.parent.remove_tag ('sitecontent_li_<?php echo $_REQUEST['ref_idform']?>');


<?php
if (isset($ref_site_previous)) {
	?>
	window.parent.refreshtagmobil('sitelist2','li','sitecontent', 'annuaire_edition_valid_view_site_nouvelle', '<?php echo $ref_site_previous?>', '');	
	<?php
}

if (isset($_INFOS['Création_site_web'])) {
	?>
	window.parent.switchtagmobil('sitelist2','li','sitecontent', 'annuaire_edition_valid_view_site_nouvelle', '<?php echo $_INFOS['Création_site_web']?>');
	<?php
}
?>
}
</script>