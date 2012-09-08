<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("stocks_liste", "adresses_liste");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_entreprise", "smenu_entreprise.php" ,"true" ,"sub_content", "Entreprise");
tableau_smenu[1] = Array('catalogue_stockage','catalogue_stockage.php' ,"true" ,"sub_content", "Lieux de stockage");
update_menu_arbo();
</script>
<div class="emarge">

<div id="pop_up_choix_transfert_articles" class="mini_moteur" style="width:580px; height:480px;">

	<div id="recherche_transfert_articles" class="corps_mini_moteur"  style="width:580px; height:480px;">
			<a href="#" id="close_choix_transfert_articles" style="float:right">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
			</a>

			<div style="font-weight:bolder">Déplacer les articles du stock <span id="lib_stock_to_move"></span></div>
	<br />
<br />
<br />

					<input name="id_stock_to_del" id="id_stock_to_del" type="hidden" value="" />
	<table>
		<tr class="smallheight">
			<td style="width:45%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td >Transfèrer les articles vers le stock:
			</td>
			<td>
				<select name="new_id_stock" id="new_id_stock" class="classinput_xsize" >
					<option value=""></option>
					<?php 
					foreach ($stocks_liste as $stock_liste) {
					if ($stock_liste->actif) {
						?>
						<option value="<?php echo $stock_liste->id_stock; ?>"><?php echo $stock_liste->lib_stock; ?></option>
						<?php
					}
					}
					?>
				</select>
			</td>
			<td>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/transferer_stock.gif" width="100%" id="transferer_stock" style="cursor:pointer"/>
			</td>
			<td >
			</td>
		</tr>
		<tr>
			<td colspan="3">Les articles seront répartis dans différents Transferts de Marchandises
			
			</td>
			<td >
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<br />
				<br />
				ou<br />
				<hr style="border:1px solid #000000" />
			</td>
		</tr>
		<tr>
			<td>Livrer les articles à un contact
			</td>
			<td>
					<input name="ref_contact" id="ref_contact" type="hidden" value="" />
					<table cellpadding="0" cellspacing="0" border="0" style=" width:100%">
						<tr>
							<td>
							<input name="nom_contact" id="nom_contact" type="text" value=""  class="classinput_xsize" readonly=""/>
							</td>
							<td style="width:20px">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right; cursor:pointer" id="ref_contact_select_img">
							</td>
						</tr>
					</table>
					
				<script type="text/javascript">
				//effet de survol sur le faux select
				Event.observe('ref_contact_select_img', 'mouseover',  function(){$("ref_contact_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_hover.gif";}, false);
				Event.observe('ref_contact_select_img', 'mousedown',  function(){$("ref_contact_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find_down.gif";}, false);
				Event.observe('ref_contact_select_img', 'mouseup',  function(){$("ref_contact_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
				Event.observe('ref_contact_select_img', 'mouseout',  function(){$("ref_contact_select_img").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif";}, false);
				Event.observe('ref_contact_select_img', 'click',  function(evt){Event.stop(evt); show_mini_moteur_contacts ("recherche_livraison_stock_set_contact", "\'ref_contact\', \'nom_contact\' "); }, false);
				</script>
			</td>
			<td>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/livrer_stock.gif" style="cursor:pointer; " id="livrer_stock" />
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td colspan="3">Les articles seront répartis dans différents Bons de Livraison
			
			</td>
			<td>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		Event.observe('new_id_stock', 'change',  function(evt){
		Event.stop(evt); 
		if ($('new_id_stock').value == $('id_stock_to_del').value) {
   	 $('new_id_stock').options[0].selected = "selected";
		}
		}, false);
		
		Event.observe('transferer_stock', 'click',  function(evt){
			Event.stop(evt); 
			if ($('new_id_stock').value != "") {
				$("titre_alert").innerHTML = "Désactivation d'un lieux de stockage";
				$("texte_alert").innerHTML = "Confirmer le transfére des articles vers le nouveau lieu de stockage selectionné et la désactivation du lieux de stockage actuel.";
				$("bouton_alert").innerHTML = "<input type=\"submit\" name=\"bouton1\" id=\"bouton1\" value=\"Confirmer\" /><input type=\"submit\" id=\"bouton0\" name=\"bouton0\" value=\"Annuler\" />";
			
				$("alert_pop_up_tab").style.display = "block";
				$("framealert").style.display = "block";
				$("alert_pop_up").style.display = "block";
				
				$("bouton0").onclick= function () {
				$("framealert").style.display = "none";
				$("alert_pop_up").style.display = "none";
				$("alert_pop_up_tab").style.display = "none";
				}
				
				$("bouton1").onclick= function () {
				$("framealert").style.display = "none";
				$("alert_pop_up").style.display = "none";
				$("alert_pop_up_tab").style.display = "none";
				transferer_stock_and_delete ($('id_stock_to_del').value, $('new_id_stock').value); 
				}
			}
		}, false);
		Event.observe('livrer_stock', 'click',  function(evt){
			Event.stop(evt); 
			if ($('ref_contact').value != "") {
				$("titre_alert").innerHTML = "Désactivation d'un lieux de stockage";
				$("texte_alert").innerHTML = "Confirmer la livraison des articles vers le contact selectionné et la désactivation de ce lieux de stockage.";
				$("bouton_alert").innerHTML = "<input type=\"submit\" name=\"bouton1\" id=\"bouton1\" value=\"Confirmer\" /><input type=\"submit\" id=\"bouton0\" name=\"bouton0\" value=\"Annuler\" />";
			
				$("alert_pop_up_tab").style.display = "block";
				$("framealert").style.display = "block";
				$("alert_pop_up").style.display = "block";
				
				$("bouton0").onclick= function () {
				$("framealert").style.display = "none";
				$("alert_pop_up").style.display = "none";
				$("alert_pop_up_tab").style.display = "none";
				}
				
				$("bouton1").onclick= function () {
				$("framealert").style.display = "none";
				$("alert_pop_up").style.display = "none";
				$("alert_pop_up_tab").style.display = "none";
				livrer_stock_and_delete ($('id_stock_to_del').value, $('ref_contact').value); 
				}
			}
		}, false);
	</script>
	
	</div>
</div>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
<p class="titre">Lieux de stockage.</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="stockage" style="padding-left:10px; padding-right:10px">

	
	<p>Ajouter un stock</p>
					<table>
					<tr class="smallheight">
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td ><span class="labelled">Libell&eacute;:</span>
						</td>
						<td ><span class="labelled">Abréviation:</span>
						</td>
						<td ><span class="labelled">Adresse:</span>
						</td>
						<td ><span class="labelled">Actif:</span>
						</td>
						<td>
						<div style="width:80px"></div>
						</td>

					</tr>
				</table>
	<div class="caract_table">
	<table>
		<tr class="smallheight">
			<td>
				<form action="catalogue_stockage_add.php" method="post" id="catalogue_stockage_add" name="catalogue_stockage_add" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input name="lib_stock" id="lib_stock" type="text" value=""  class="classinput_lsize"/>
						<input name="ajout_stock" id="ajout_stock" type="hidden" value="1"/>
						</td>
						<td>
						<input name="abrev_stock" id="abrev_stock" type="text" value=""  class="classinput_lsize"/>
						</td>
						<td>
							<select  name="ref_adr_stock" id="ref_adr_stock" class="classinput_lsize">
								<option></option>
								<?php 
								foreach ($adresses_liste as $adresse_liste) {
								?>
								<option value="<?php echo $adresse_liste->ref_adresse?>">
								<?php if ($adresse_liste->lib_adresse!=""){?>
								<?php echo $adresse_liste->lib_adresse;?>
								<?php } else {?>
								<?php echo $adresse_liste->text_adresse;?> - <?php echo $adresse_liste->code_postal;?> - <?php echo $adresse_liste->ville;?>
								<?php }?>
								</option>
								<?php 
								}
								?>
							</select>
						</td>
						<td style="">
							<input name="actif"  type="checkbox" id="actif" value="" checked="checked" />
						</td>
						<td>
							<p style="text-align:right">
							<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
							</p>
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
	</div>
	<br />
	<?php 
	if ($stocks_liste) {
	?>
	<p>Liste des stocks </p>

					<table>
					<tr class="smallheight">
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td ><span class="labelled">Libell&eacute;:</span>
						</td>
						<td ><span class="labelled">Abréviation:</span>
						</td>
						<td ><span class="labelled">Adresse:</span>
						</td>
						<td ><span class="labelled">Actif:</span>
						</td>
						<td>
						<div style="width:80px"></div>
						</td>

					</tr>
				</table>
	<?php 
	}
	$first_inactif = 0;
	foreach ($stocks_liste as $stock_liste) {
		if (!$stock_liste->actif && !$first_inactif) {
			$first_inactif = 1;
			?>
			<span id="aff_inactif" style="text-decoration:underline; cursor:pointer">Voir les stocks inactifs</span>
			<div id="view_inactifs" style="display:none">
			<script type="text/javascript">
			
			Event.observe("aff_inactif", "click",  function(evt){
					Event.stop(evt);
					$("view_inactifs").toggle();
				}, false);
			</script>
			<?php
		}
	?>
	<div class="caract_table" id="stock_table_<?php echo $stock_liste->id_stock; ?>">

		<table>
		<tr>
			<td>
				<form action="catalogue_stockage_mod.php" method="post" id="catalogue_stockage_mod_<?php echo $stock_liste->id_stock; ?>" name="catalogue_stockage_mod_<?php echo $stock_liste->id_stock; ?>" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input id="lib_stock_<?php echo $stock_liste->id_stock; ?>" name="lib_stock_<?php echo $stock_liste->id_stock; ?>" type="text" value="<?php echo htmlentities($stock_liste->lib_stock); ?>"  class="classinput_lsize"/>
			<input name="id_stock" id="id_stock" type="hidden" value="<?php echo $stock_liste->id_stock; ?>" />
							
						</td>
						<td>
						<input name="abrev_stock_<?php echo $stock_liste->id_stock; ?>" id="abrev_stock_<?php echo $stock_liste->id_stock; ?>" type="text" value="<?php echo $stock_liste->abrev_stock; ?>"  class="classinput_lsize"/>
						</td>
						<td>
							<select id="ref_adr_stock_<?php echo $stock_liste->id_stock; ?>" name="ref_adr_stock_<?php echo $stock_liste->id_stock; ?>" class="classinput_lsize">
								<option></option>
								<?php 
								foreach ($adresses_liste as $adresse_liste) {
								?>
								<option value="<?php echo $adresse_liste->ref_adresse?>" <?php if ($adresse_liste->ref_adresse	==	$stock_liste->ref_adr_stock) {echo 'selected="selected"';}?>>
								<?php if ($adresse_liste->lib_adresse!=""){?>
								<?php echo htmlentities($adresse_liste->lib_adresse);?>
								<?php } else {?>
								<?php echo htmlentities($adresse_liste->text_adresse);?> - <?php echo $adresse_liste->code_postal;?> - <?php echo $adresse_liste->ville;?>
								<?php }?>
								</option>
								<?php 
								}
								?>
							</select>
						</td>
						<td style="">
						<input id="actif_<?php echo $stock_liste->id_stock; ?>" name="actif_<?php echo $stock_liste->id_stock; ?>" value="<?php echo htmlentities($stock_liste->actif); ?>" type="checkbox"  <?php if($stock_liste->actif==1){echo 'checked="checked"';}?>/>
						</td>
						<td>
							<p style="text-align:right">
								<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
							</p>
						</td>
					</tr>
				</table>
				</form>
		<script type="text/javascript">
		<?php
		if ($stock_liste->actif) {
		?>
		Event.observe('actif_<?php echo $stock_liste->id_stock; ?>', 'click',  function(evt){
			Event.stop(evt);
		if (!$("actif_<?php echo $stock_liste->id_stock; ?>").checked) {
		$("titre_alert").innerHTML = "Désactivation d'un lieux de stockage";
		$("texte_alert").innerHTML = "Confirmer la désactivation de ce lieux de stockage.";
		$("bouton_alert").innerHTML = "<input type=\"submit\" name=\"bouton1\" id=\"bouton1\" value=\"Désactiver\" /><input type=\"submit\" id=\"bouton0\" name=\"bouton0\" value=\"Annuler\" />";
	
		$("alert_pop_up_tab").style.display = "block";
		$("framealert").style.display = "block";
		$("alert_pop_up").style.display = "block";
		
		$("bouton0").onclick= function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
		}
		
		$("bouton1").onclick= function () {
		$("framealert").style.display = "none";
		$("alert_pop_up").style.display = "none";
		$("alert_pop_up_tab").style.display = "none";
		chek_used_stock("<?php echo $stock_liste->id_stock;?>");
		//submitform (formtosend);
		}
		}
		
		},false); 
		<?php
		}
		?>
		</script>
			</td>
		</tr>
	</table>
	</div>
	<br />
	<?php	
	}
	?>
	</div>
</div>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">
new Form.EventObserver('catalogue_stockage_add', function(element, value){formChanged();});

<?php 
if ($first_inactif) {
	?>
	Event.observe("aff_inactif", "click",  function(evt){
		Event.stop(evt);
		$("view_inactifs").show();
		$("aff_inactif").hide();
	}, false);
	<?php
}
foreach ($stocks_liste as $stock_liste) {
	?>
	new Form.EventObserver('catalogue_stockage_mod_<?php echo $stock_liste->id_stock; ?>', function(element, value){formChanged();});
	<?php
}
?>

//centrage du mini_moteur de recherche d'un contact

centrage_element("pop_up_mini_moteur");
centrage_element("pop_up_mini_moteur_iframe");

Event.observe(window, "resize", function(evt){
	centrage_element("pop_up_mini_moteur_iframe");
	centrage_element("pop_up_mini_moteur");
});

//pop up de choix de la redirection
centrage_element("pop_up_choix_transfert_articles");

Event.observe(window, "resize", function(evt){
	centrage_element("pop_up_choix_transfert_articles");
});

Event.observe("close_choix_transfert_articles", "click",  function(evt){
		Event.stop(evt);
		$("pop_up_choix_transfert_articles").style.display = "none";
	}, false);
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>