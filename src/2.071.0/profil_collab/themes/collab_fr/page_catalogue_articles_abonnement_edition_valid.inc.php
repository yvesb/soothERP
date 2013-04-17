<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

?>

<script type="text/javascript">
	window.parent.page.traitecontent('catalogue_articles_abonnement_edition','catalogue_articles_abonnement_edition.php?id_abo=<?php echo $_REQUEST["abo_id_abo"];?>&ref_article=<?php echo $_REQUEST["abo_ref_article"];?>','true','edition_abonnement');
	window.parent.document.getElementById("edition_abonnement").style.display = "none";
	<?php if(!isset ($source)){?>
	window.parent.page.article_recherche_abo();
	<?php }?>
</script>

<?php 
	if(isset ($source)){
		if(isset($develop_abo)){	?>
			<script type="text/javascript">
				window.parent.page.traitecontent('annuaire_contact_client_abo.php','annuaire_contact_client_abo.php?ref_contact=<?php echo $_REQUEST["abo_ref_contact"];?>&develop_abo=<?php echo $develop_abo;?>','true','show_abo_client');
			</script>
<?php 
		}else{		?>
		<script type="text/javascript">
				window.parent.page.traitecontent('annuaire_contact_client_abo.php','annuaire_contact_client_abo.php?ref_contact=<?php echo $_REQUEST["abo_ref_contact"];?>','true','show_abo_client');
		</script>
<?php }}?>
