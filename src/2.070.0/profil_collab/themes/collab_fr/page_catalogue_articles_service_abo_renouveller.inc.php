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
//echo $_REQUEST['desc_courte'];
?>
<p>&nbsp;</p>
<p>article service _ abo  renouvellement </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

?>

<script type="text/javascript">
	window.parent.page.traitecontent('catalogue_articles_abonnement_edition','catalogue_articles_abonnement_edition.php?id_abo=<?php echo $id_abo;?>&ref_article=<?php echo $article->getRef_article();?>','true','edition_abonnement');
	<?php if(!isset ($source)){?>
	window.parent.page.article_recherche_abo();
	<?php }?>
</script>

<?php 
	if(isset($develop_abo)){	?>
		<script type="text/javascript">
			window.parent.page.traitecontent('annuaire_contact_client_abo.php','annuaire_contact_client_abo.php?ref_contact=<?php echo $ref_contact;?>&develop_abo=<?php echo $develop_abo;?>','true','show_abo_client');
		</script>
<?php 
	}else{		?>
		<script type="text/javascript">
				window.parent.page.traitecontent('annuaire_contact_client_abo.php','annuaire_contact_client_abo.php?ref_contact=<?php echo $ref_contact;?>','true','show_abo_client');
		</script>
<?php }?>

<?php /*
<script type="text/javascript">
	<?php 
	if(isset($cibles_a_Updater)){
		for ($i = 0; $i < count($cibles_a_Updater); $i++){
			if (count($cibles_a_Updater[$i])>=4){
				?>
				params:{<?php echo $cibles_a_Updater[$i]["param_nom1"].": '".$cibles_a_Updater[$i]["param_val1"]."'";?>
				<?php
				$j=4;
				while($j<(count($cibles_a_Updater[$i]))){
					echo ",".$cibles_a_Updater[$i]["param_nom".($j-2)].": ".$cibles_a_Updater[$i]["param_val".($j-2)];
					$j = $j+2;
				}
			}?>};
			window.parent.page.article_recherche_abo2('<?php echo $cibles_a_Updater[$i]["container"]; ?>', '<?php echo $cibles_a_Updater[$i]["url"];?>', params);
			window.parent.changed = false;
	<?php 
		}
	}else{ ?>
		window.parent.page.article_recherche_abo();
		window.parent.changed = false;
	<?php } ?>
}
</script>
*/?>