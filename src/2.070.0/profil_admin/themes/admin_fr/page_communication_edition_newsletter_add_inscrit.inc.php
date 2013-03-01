<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************	



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

if (isset($erreur)) {
	?>
	<script type="text/javascript">
	alerte.alerte_erreur ('Email déjà existant', 'Cet adresse Email est déjà présente dans la liste.','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
	</script>
<?php } else {?>
	<li id="<?php if ($_REQUEST["inscrit"]) {?>envoyer<?php } else {?>refuser<?php } ?>_a_<?php echo $serialisation_envoyer_a?>">
		<table style="width:100%;">
			<tr>
				<td style="width:95%; text-align:left;">
					<?php echo $_REQUEST["nom"];?> - <?php echo $_REQUEST["email"];?>
				</td>
				<td style="width:5%; text-align:right;">
					<a href="#" id="envoyer_a_del_<?php echo $serialisation_envoyer_a?>">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
					</a>
				</td>
			</tr>
		</table>
		<script type="text/javascript">
		Event.observe("envoyer_a_del_<?php echo $serialisation_envoyer_a?>", "click", function(evt){ 
			alerte.confirm_supprimer_tag_and_callpage("envoyer_a_del", "envoyer_a_<?php echo $serialisation_envoyer_a?>",																			"communication_edition_newsletter_del_inscrit.php?email=<?php echo $_REQUEST["email"];?>&id_newsletter=<?php echo $_REQUEST['id_newsletter']; ?>");	
			Event.stop(evt);}
		);
		</script>
	</li>
	<?php
}
?>