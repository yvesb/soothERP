
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
<script type="text/javascript">
var appartenance_lot=false;
var still_dispo=false;
var erreur=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="appartenance_lot") {
		echo "appartenance_lot=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="still_dispo") {
		echo "still_dispo=true;\n";
		echo "erreur=true;\n";
	}
}

?>
if (erreur) {

	//article appartenant à un lot
	if (appartenance_lot) {
		alerte.confirm_supprimer('article_appartenance_lot', '');
	}
	//article toujours en stock
	if (still_dispo) {
		alerte.confirm_supprimer('article_toujours_dispo', '');
		<?php 
		if (isset ($_REQUEST['ref_article']) && isset ($_REQUEST['id_tag'])) {
		?>
		$('<?php echo $_REQUEST['id_tag']?>_0').show();
		<?php
		}
		?>
	}

<?php 
if (isset ($_REQUEST['ref_article']) && isset ($_REQUEST['id_ligne']) ) {
	?>
	changeclassname ('<?php echo $_REQUEST['id_ligne']?><?php echo $_REQUEST['ref_article']?>', 'colorise3');
	<?php
}
?>
<?php 
if (isset ($_REQUEST['ref_article']) && isset ($_REQUEST['id_tag'])) {
	?>
	$("date_fin_dispo").value = "<?php echo date("d-m-Y");?>";
	<?php
}
?>
}
else
{
<?php 
if (isset ($_REQUEST['ref_article']) && isset ($_REQUEST['id_ligne'])) {
	?>
	changeclassname ('<?php echo $_REQUEST['id_ligne']?><?php echo $_REQUEST['ref_article']?>', 'colorise3');
	<?php
}
?>
<?php 
if (isset ($_REQUEST['ref_article']) && isset ($_REQUEST['id_tag'])) {
	?>
	$("date_fin_dispo").value = "<?php echo date("d-m-Y");?>";
	$('<?php echo $_REQUEST['id_tag']?>').show();
	
	<?php
}
?>
}
</script>