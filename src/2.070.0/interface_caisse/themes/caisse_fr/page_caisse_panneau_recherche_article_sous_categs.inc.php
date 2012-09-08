<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("art_categs_fille");
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<script type="text/javascript">
	art_categs_fille_selected = null;
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr height="0px">
		<td width="0%"></td>
		<td width="100%"></td>
		<td width="0%"></td>
	</tr>
	<?php foreach ($art_categs_fille as $t_art_categ){?>
	<tr height="40px" id="<?php echo $t_art_categ[0]->getRef_art_categ(); ?>" >
		<td>
			<img id="<?php echo $t_art_categ[0]->getRef_art_categ(); ?>_bt_vide_a" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_a.gif">
		</td>
		<td id="<?php echo $t_art_categ[0]->getRef_art_categ(); ?>_bt_vide_b" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_b.gif');background-repeat: repeat-x;"
				class="recherche_sous_categorie_lib">
			<?php echo $t_art_categ[0]->getLib_art_categ(); ?>
		</td>
		<td>
			<img id="<?php echo $t_art_categ[0]->getRef_art_categ(); ?>_bt_vide_c" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_c.gif">
	
			<script type="text/javascript">
				Event.observe("<?php echo $t_art_categ[0]->getRef_art_categ(); ?>", "click",  function(evt){
					Event.stop(evt);
					
					if(art_categs_fille_selected != undefined && art_categs_fille_selected != null){
						$(art_categs_fille_selected+"_bt_vide_a").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_a.gif";
						$(art_categs_fille_selected+"_bt_vide_b").style.backgroundImage = "url(<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_b.gif)";
						$(art_categs_fille_selected+"_bt_vide_c").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_c.gif";
					}

					$("<?php echo $t_art_categ[0]->getRef_art_categ(); ?>_bt_vide_a").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_a.gif";
					$("<?php echo $t_art_categ[0]->getRef_art_categ(); ?>_bt_vide_b").style.backgroundImage = "url(<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_b.gif)";
					$("<?php echo $t_art_categ[0]->getRef_art_categ(); ?>_bt_vide_c").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_c.gif";

					art_categs_fille_selected = "<?php echo $t_art_categ[0]->getRef_art_categ(); ?>";
					
					var params = "";
					params+= "?art_page_to_show_s="+$F("art_page_to_show_s");
					params+= "&categ_racine_page_to_show_s="+$F("categ_racine_page_to_show_s");
					params+= "&categ_sous_page_to_show_s="+$F("categ_sous_page_to_show_s");
					params+= "&categ_ref_selected_s=<?php echo $t_art_categ[0]->getRef_art_categ(); ?>";
					page.traitecontent("resultat_article","caisse_panneau_recherche_articles_result.php"+params, true ,"resultat_article");
					$("art_lib_s").focus();
					
				}, false);
			</script>
			</td>
	</tr>
	<tr height="5px">
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<?php }?>
</table>
			

			<?php /*
			<td style="width: 2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_show_right.gif" alt="Clavier" title="Clavier" height="250px"/></td>
			<td style="width: 1%"></td>
			*/ ?>

<?php /*

									var AppelAjax = new Ajax.Updater(
										"panneau_bas",
										"caisse_panneau_recherche_article.php",
										{
										method: 'post',
										asynchronous: false,
										contentType:  'application/x-www-form-urlencoded',
										encoding:     'UTF-8',
										parameters: { art_page_to_show_s : $F("art_page_to_show_s"), categ_racine_page_to_show_s : $F("categ_racine_page_to_show_s"), categ_sous_page_to_show_s : $F("categ_sous_page_to_show_s"), categ_ref_selected_s : "<?php echo $t_art_categ[0]->getRef_art_categ(); ?>" },
										evalScripts:true,
										onLoading:S_loading,
										onException: function () {S_failure();}, 
										onSuccess: function (requester){ requester.responseText.evalScripts(); },
										onComplete:H_loading
									}
									);

							<td>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_a.gif">
						</td>
						<td style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_b.gif');background-repeat: repeat-x;">
							<?php echo $t_art_categ[0]->getLib_art_categ(); ?>
						</td>
						<td>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_c.gif">
						</td>
*/ ?>

<?php /*

<table width="100%" border="0" cellpadding="0" cellspacing="0" >
				<?php foreach ($art_categs_fille as $t_art_categ){?>
					<tr height="40px" id="<?php echo $t_art_categ[0]->getRef_art_categ(); ?>" >
						<?php if($t_art_categ[0]->getRef_art_categ() == $ref_art_categ_fille_selected) { ?>
						<td width="0%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_a.gif">
						<td width="100%" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_b.gif');background-repeat: repeat-x;">
							<?php echo $t_art_categ[0]->getLib_art_categ(); ?>
						</td>
						<td width="0%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_c.gif">
						<?php }else{?>
							<td width="0%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_a.gif">
							<td width="100%" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_b.gif');background-repeat: repeat-x;">
								<?php echo $t_art_categ[0]->getLib_art_categ(); ?>
							</td>
							<td width="0%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_c.gif"></td>
						<?php }?>
						</tr>
						<tr>
							<td>
								<div style="height:3px">
									<script type="text/javascript">
										Event.observe("<?php echo $t_art_categ[0]->getRef_art_categ(); ?>", "click",  function(evt){
											Event.stop(evt);
											var params = "";
											params+= "?art_page_to_show_s="+$F("art_page_to_show_s");
											params+= "&categ_racine_page_to_show_s="+$F("categ_racine_page_to_show_s");
											params+= "&categ_sous_page_to_show_s="+$F("categ_sous_page_to_show_s");
											params+= "&categ_ref_selected_s=<?php echo $t_art_categ[0]->getRef_art_categ(); ?>";
											//page.traitecontent("panneau_bas","caisse_panneau_recherche_article.php"+params, true ,"panneau_bas");
											function caisse_encaisser_ticket (ref_ticket, moyens_de_paiememnt, montants,  type_print) {
												var AppelAjax = new Ajax.Updater(
													"panneau_bas",
													"caisse_panneau_recherche_article.php",
													{
													method: 'post',
													asynchronous: false,
													contentType:  'application/x-www-form-urlencoded',
													encoding:     'UTF-8',
													parameters: { art_page_to_show_s : $F("art_page_to_show_s"), categ_racine_page_to_show_s : $F("categ_racine_page_to_show_s"), categ_sous_page_to_show_s : $F("categ_sous_page_to_show_s"), categ_ref_selected_s : "<?php echo $t_art_categ[0]->getRef_art_categ(); ?>" },
													evalScripts:true,
													onLoading:S_loading,
													onException: function () {S_failure();}, 
													onSuccess: function (requester){ requester.responseText.evalScripts(); },
													onComplete:H_loading
												}
												);
											}
											page.traitecontent("resultat_article","caisse_panneau_recherche_articles_result.php"+params, true ,"resultat_article");
											$("art_lib_s").focus();
										}, false);
									</script>
								</div>
							</td>
					</tr>
					<?php }?>
				</table>
*/ ?>