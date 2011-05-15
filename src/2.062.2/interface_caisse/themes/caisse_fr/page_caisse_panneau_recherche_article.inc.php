<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("art_categs_racine", "art_categs_racine_selected", "NoHeader_caisse_panneau_recherche_article", "NoHeader_caisse_panneau_recherche_articles_result");
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
	art_categs_racine_selected = "<?php echo $art_categs_racine_selected; ?>";
</script>

<div class="panneau_bas">
	<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
		<tr class="panneau_bas_barre_titre">
			<td class="panneau_bas_barre_titre_left"	></td>
			<td class="panneau_bas_barre_titre_coprs" style="width:202px"	>Rayons</td>
			<td class="panneau_bas_barre_titre_coprs"	style="width:2px; background-image:none;" ></td>
			<td class="panneau_bas_barre_titre_coprs"	style="width:10px;" ></td>
			<td class="panneau_bas_barre_titre_coprs"	style="width:178px;" >Familles</td>
			<td class="panneau_bas_barre_titre_coprs"	style="width:2px; background-image:none;" ></td>
			<td class="panneau_bas_barre_titre_coprs"	style="width:10px;" ></td>
			<td class="panneau_bas_barre_titre_coprs"											>Articles</td>
			<td class="panneau_bas_barre_titre_right"	></td>
		</tr>
	</table>
	
	<!-- <div style="height: 10px"></div> -->
	

		<table width="100%" border="0" cellpadding="0" cellspacing="0" height="257px">
			<tr>
				<td style="width:198px; padding-left:8px; padding-right:4px; padding-top:10px;" id="liste_art_categs_racine">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr height="0px">
							<td width="0%"></td>
							<td width="100%"></td>
							<td width="0%"></td>
						</tr>
						<?php for($i = 0; $i < count($art_categs_racine) ; $i++){?>
						<tr height="40px" id="<?php echo $art_categs_racine[$i][0]->getRef_art_categ(); ?>" >
							<?php if($art_categs_racine_selected == $art_categs_racine[$i][0]->getRef_art_categ()){ ?>
							<td>
								<img id="<?php echo $art_categs_racine[$i][0]->getRef_art_categ(); ?>_bt_vide_a" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_a.gif">
							</td>
							<td id="<?php echo $art_categs_racine[$i][0]->getRef_art_categ(); ?>_bt_vide_b" class="recherche_categorie_lib" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_b.gif');background-repeat: repeat-x;">
								<?php echo $art_categs_racine[$i][0]->getLib_art_categ(); ?>
							</td>
							<td>
								<img id="<?php echo $art_categs_racine[$i][0]->getRef_art_categ(); ?>_bt_vide_c" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_c.gif">
							</td>
						<?php }else{ ?>
							<td>
								<img id="<?php echo $art_categs_racine[$i][0]->getRef_art_categ(); ?>_bt_vide_a" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_a.gif">
							</td>
							<td id="<?php echo $art_categs_racine[$i][0]->getRef_art_categ(); ?>_bt_vide_b" class="recherche_categorie_lib" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_b.gif');background-repeat: repeat-x;">
								<?php echo $art_categs_racine[$i][0]->getLib_art_categ(); ?>
							</td>
							<td>
								<img id="<?php echo $art_categs_racine[$i][0]->getRef_art_categ(); ?>_bt_vide_c" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_c.gif">
							</td>
						<?php } ?>
								<script type="text/javascript">
	
									Event.observe("<?php echo $art_categs_racine[$i][0]->getRef_art_categ(); ?>", "click",  function(evt){
										Event.stop(evt);
										//debugger;
										
										if(art_categs_racine_selected != undefined && art_categs_racine_selected != ""){
											$(art_categs_racine_selected+"_bt_vide_a").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_a.gif";
											$(art_categs_racine_selected+"_bt_vide_b").style.backgroundImage = "url(<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_b.gif)";
											$(art_categs_racine_selected+"_bt_vide_c").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_unselected_c.gif";
										}
										
										$("<?php echo $art_categs_racine[$i][0]->getRef_art_categ(); ?>_bt_vide_a").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_a.gif";
										$("<?php echo $art_categs_racine[$i][0]->getRef_art_categ(); ?>_bt_vide_b").style.backgroundImage = "url(<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_b.gif)";
										$("<?php echo $art_categs_racine[$i][0]->getRef_art_categ(); ?>_bt_vide_c").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_selected_c.gif";
										
										art_categs_racine_selected = "<?php echo $art_categs_racine[$i][0]->getRef_art_categ(); ?>";
										
										page.traitecontent("liste_art_categs_fille","caisse_panneau_recherche_article_sous_categs.php?art_categs_racine_selected=<?php echo $art_categs_racine[$i][0]->getRef_art_categ()?>", true ,"liste_art_categs_fille");
										
										var params = "";
										params+= "?art_page_to_show_s="+$F("art_page_to_show_s");
										params+= "&categ_racine_page_to_show_s="+$F("categ_racine_page_to_show_s");
										params+= "&categ_sous_page_to_show_s="+$F("categ_sous_page_to_show_s");
										params+= "&categ_ref_selected_s=<?php echo $art_categs_racine[$i][0]->getRef_art_categ(); ?>";
										page.traitecontent("resultat_article","caisse_panneau_recherche_articles_result.php"+params, true ,"resultat_article");
										$("art_lib_s").focus();
	
									}, false);
								
								</script>
								
						</tr>
						<tr height="5px">
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<?php }?>
					</table>
				</td>
				<td style="background-color:#7e7e96; width:2px;"></td>
				<td style="width:180px; padding-left:4px; padding-right:4px; padding-top:10px;" id="liste_art_categs_fille">
					<?php if($NoHeader_caisse_panneau_recherche_article){include ("caisse_panneau_recherche_article_sous_categs.php");}?>
				</td>
				<td style="background-color:#7e7e96; width:2px;"></td>
				<td style="max-width: 867px;;padding-left:4px; padding-right:8px; padding-top:10px;" id="resultat_article">
					<?php if($NoHeader_caisse_panneau_recherche_articles_result){
						//Variables à définir dans caisse_panneau_recherche_articles_result.php
						$art_page_to_show_s = 1;
						$art_lib_s = "";
						if(count($art_categs_racine)>0)
						{			$categ_ref_selected_s = $art_categs_racine[0][0]->getRef_art_categ();}
						else {$categ_ref_selected_s = "";}
						include ("caisse_panneau_recherche_articles_result.php");
					}?>
				</td>
			</tr>
		</table>
</div>

<SCRIPT type="text/javascript">
	H_loading();
</SCRIPT>