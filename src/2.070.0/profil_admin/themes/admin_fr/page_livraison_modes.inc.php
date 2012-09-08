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

?>
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_catalogue", "smenu_catalogue.php" ,"true" ,"sub_content", "Catalogue");
tableau_smenu[1] = Array('livraison_modes','livraison_modes.php' ,"true" ,"sub_content", "Modes de livraison");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Modes de livraison</p>
<div style="height:50px">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="cat_client" style="padding-left:10px; padding-right:10px">
<div style="" id="show_new_compte">
<div id="add_mode" style="float:right; cursor:pointer"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" /> <span style="font-weight:bolder">Nouveau mode de livraison</span> </div><br />



	<script type="text/javascript">
	Event.observe('add_mode', 'click',  function(){
		$("view_add_new").show();
		$("lib_livraison_mode").focus();
	}, false);
	</script>
	<div class="caract_table" id="view_add_new" style="display:none">

	<table style="width:100%">
	<tr>
		<td>
			<form action="livraison_modes_add.php" method="post" id="livraison_modes_add" name="livraison_modes_add" target="formFrame" >
			<table>
				<tr class="smallheight">
					<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>	
				<tr>
					<td style="text-align:right">Libell&eacute;: 
					</td>
					<td>
					<input name="lib_livraison_mode" id="lib_livraison_mode" type="text" value=""  class="classinput_xsize"  />
					</td>
					<td style="text-align:right">Abréviation: 
					</td>
					<td>
					<input name="abrev_livraison_mode" id="abrev_livraison_mode" type="text" value=""  class="classinput_xsize"  />
					</td>
					<td style="text-align:right">Transporteur: 
					</td>
					<td>
					<input name="ref_transporteur" id="ref_transporteur" type="hidden" value="" />
					<table cellpadding="0" cellspacing="0" border="0" style=" width:100%">
						<tr>
							<td>
							<input name="nom_transporteur" id="nom_transporteur" type="text" value=""  class="classinput_xsize" readonly=""/>
							</td>
							<td style="width:20px">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right; cursor:pointer" id="ref_transporteur_select_img">
							</td>
						</tr>
					</table>
					
					<script type="text/javascript">
					//effet de survol sur le faux select
						Event.observe('ref_transporteur_select_img', 'mouseover',  function(){$("ref_transporteur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
						Event.observe('ref_transporteur_select_img', 'mousedown',  function(){$("ref_transporteur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
						Event.observe('ref_transporteur_select_img', 'mouseup',  function(){$("ref_transporteur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
						
						Event.observe('ref_transporteur_select_img', 'mouseout',  function(){$("ref_transporteur_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
						Event.observe('ref_transporteur_select_img', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_livraison_set_contact", "\'ref_transporteur\', \'nom_transporteur\' "); preselect ('<?php echo $CONSTRUCTEUR_ID_PROFIL; ?>', 'id_profil_m'); page.annuaire_recherche_mini();}, false);
					</script>
					</td>
					<td style="text-align:center">
						<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
<br />
</div>
<?php 
if ($livraison_modes) {
	?>
	<table style="width:100%">
		<tr>
			<td>
				<table>
					<tr class="smallheight">
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td style="text-align:left">Libell&eacute;: 
						</td>
						<td style="text-align:left">Abréviation:
						</td>
						<td style="text-align:left">Transporteur:  
						</td>
						<td style="text-align:left">
						</td>
						<td style="text-align:left">
						</td>
					</tr>
				</table>
			</td>
			<td style="width:55px; text-align:center">
			</td>
		</tr>
	</table>
	<?php
	$fleches_ascenseur=0;
	foreach ($livraison_modes as $livraison_mode) {
		?>
		<div class="caract_table">
			<table style="width:100%">
			<tr>
				<td>
					<form action="livraison_modes_mod.php" method="post" id="livraison_modes_mod_<?php echo $livraison_mode->id_livraison_mode;?>" name="livraison_modes_mod_<?php echo $livraison_mode->id_livraison_mode;?>" target="formFrame" >
					<table>
						<tr class="smallheight">
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>
						<tr>
							<td>
							<input name="lib_livraison_mode_<?php echo $livraison_mode->id_livraison_mode;?>" id="lib_livraison_mode_<?php echo $livraison_mode->id_livraison_mode;?>" type="text" value="<?php echo ($livraison_mode->article->getLib_article());?>"  class="classinput_xsize"  />
							</td>
							<td>
							<input name="ref_article_<?php echo $livraison_mode->id_livraison_mode;?>" id="ref_article_<?php echo $livraison_mode->id_livraison_mode;?>" type="hidden" value="<?php echo ($livraison_mode->ref_article);?>" />
							<input name="ref_transporteur_<?php echo $livraison_mode->id_livraison_mode;?>" id="ref_transporteur_<?php echo $livraison_mode->id_livraison_mode;?>" type="hidden" value="<?php echo htmlentities($livraison_mode->article->getRef_constructeur ());?>" />
							<input name="id_livraison_mode" id="id_livraison_mode" type="hidden" value="<?php echo $livraison_mode->id_livraison_mode;?>" />
							<input name="abrev_livraison_mode_<?php echo $livraison_mode->id_livraison_mode;?>" id="abrev_livraison_mode_<?php echo $livraison_mode->id_livraison_mode;?>" type="text" value="<?php echo htmlentities($livraison_mode->article->getLib_ticket ());?>" class="classinput_xsize" />
							</td>
							<td>
							<table cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td>
									<input name="nom_transporteur_<?php echo $livraison_mode->id_livraison_mode;?>" id="nom_transporteur_<?php echo $livraison_mode->id_livraison_mode;?>" type="text" value="<?php echo ($livraison_mode->article->getNom_constructeur ());?>"  class="classinput_xsize" readonly=""/>
									</td>
									<td style="width:20px">
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right" id="ref_transporteur_select_img_<?php echo $livraison_mode->id_livraison_mode;?>">
									</td>
								</tr>
							</table>
							
							<script type="text/javascript">
							//effet de survol sur le faux select
							Event.observe('ref_transporteur_select_img_<?php echo $livraison_mode->id_livraison_mode;?>', 'mouseover',  function(){$("ref_transporteur_select_img_<?php echo $livraison_mode->id_livraison_mode;?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
							Event.observe('ref_transporteur_select_img_<?php echo $livraison_mode->id_livraison_mode;?>', 'mousedown',  function(){$("ref_transporteur_select_img_<?php echo $livraison_mode->id_livraison_mode;?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
							Event.observe('ref_transporteur_select_img_<?php echo $livraison_mode->id_livraison_mode;?>', 'mouseup',  function(){$("ref_transporteur_select_img_<?php echo $livraison_mode->id_livraison_mode;?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
							
							Event.observe('ref_transporteur_select_img_<?php echo $livraison_mode->id_livraison_mode;?>', 'mouseout',  function(){$("ref_transporteur_select_img_<?php echo $livraison_mode->id_livraison_mode;?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
							Event.observe('ref_transporteur_select_img_<?php echo $livraison_mode->id_livraison_mode;?>', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_livraison_set_contact", "\'ref_transporteur_<?php echo $livraison_mode->id_livraison_mode;?>\', \'nom_transporteur_<?php echo $livraison_mode->id_livraison_mode;?>\' "); preselect ('<?php echo $CONSTRUCTEUR_ID_PROFIL; ?>', 'id_profil_m'); }, false);
							</script>
							</td>
							<td style="text-align:center">
							<div id="more_mode_liv_<?php echo $livraison_mode->id_livraison_mode;?>" style="cursor:pointer; display:inherit"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" /> de détails </div>
							
	<script type="text/javascript">
	Event.observe('more_mode_liv_<?php echo $livraison_mode->id_livraison_mode;?>', 'click',  function(){
		$('more_mode_liv_<?php echo $livraison_mode->id_livraison_mode;?>').hide();
		page.traitecontent('livraison_modes_zone','livraison_modes_zone.php?id_livraison_mode=<?php echo $livraison_mode->id_livraison_mode;?>' ,"true" ,"mode_liv_zone_<?php echo $livraison_mode->id_livraison_mode;?>");
		page.traitecontent('livraison_modes_cost','livraison_modes_cost.php?id_livraison_mode=<?php echo $livraison_mode->id_livraison_mode;?>' ,"true" ,"mode_liv_cost_<?php echo $livraison_mode->id_livraison_mode;?>");
		$("more_mode_liv_aff_<?php echo $livraison_mode->id_livraison_mode;?>").show();
	}, false);
	</script>
							</td>
							<td style="text-align:center">
							<input name="modifier_<?php echo $livraison_mode->id_livraison_mode;?>" id="modifier_<?php echo $livraison_mode->id_livraison_mode;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
							</td>
						</tr>
					</table>
					</form>
				</td>
				<td style="width:55px; text-align:center">
				<form method="post" action="livraison_modes_sup.php" id="livraison_modes_sup_<?php echo $livraison_mode->id_livraison_mode; ?>" name="livraison_modes_sup_<?php echo $livraison_mode->id_livraison_mode; ?>" target="formFrame">
					<input name="id_livraison_mode" id="id_livraison_mode" type="hidden" value="<?php echo $livraison_mode->id_livraison_mode; ?>" />
				</form>
				<a href="#" id="link_livraison_modes_sup_<?php echo $livraison_mode->id_livraison_mode; ?>" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
				<script type="text/javascript">
				Event.observe("link_livraison_modes_sup_<?php echo $livraison_mode->id_livraison_mode; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('livraison_modes_sup', 'livraison_modes_sup_<?php echo $livraison_mode->id_livraison_mode; ?>');}, false);
				</script>
	
				</td>
			</tr>
		</table>
			<div id="more_mode_liv_aff_<?php echo $livraison_mode->id_livraison_mode;?>" style="display:none">
				<div style="display:block; border-top:1px solid #999999">
				<table>
					<tr>
						<td style="width:49%; border-right:1px solid #999999">
								<div><br />

									<div style="text-align:center"><span class="titre_liv_mode">Zones de livraison</span></div><br />
			
			
									<div id="mode_liv_zone_<?php echo $livraison_mode->id_livraison_mode;?>">
										
									</div>
								</div>
						</td>
						<td >
						</td>
						<td style="width:49%; border-left:1px solid #999999">
								<div ><br />

									<div style="text-align:center"><span class="titre_liv_mode">Coût de livraison</span></div><br />
									
									<div id="mode_liv_cost_<?php echo $livraison_mode->id_livraison_mode;?>">
										
									</div>
								</div>
						</td>
					</tr>
				</table>
				</div>
			</div>
		</div>
		<?php 
		$fleches_ascenseur++;
		}
	?>
	<?php 
	}
?>

</div>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">
//centrage du mini_moteur

centrage_element("pop_up_mini_moteur");
centrage_element("pop_up_mini_moteur_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_mini_moteur_iframe");
centrage_element("pop_up_mini_moteur");
});


<?php
foreach ($livraison_modes as $livraison_mode) {
	//if (isset($_REQUEST["id_livraison_mode"]) && $livraison_mode->id_livraison_mode != $_REQUEST["id_livraison_mode"]) {continue;}
	?>
	new Form.EventObserver('livraison_modes_mod_<?php echo $livraison_mode->id_livraison_mode;?>', function(){formChanged();});
	
	<?php 
	}
?>
	

new Form.EventObserver('livraison_modes_add', function(){formChanged();});


//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>