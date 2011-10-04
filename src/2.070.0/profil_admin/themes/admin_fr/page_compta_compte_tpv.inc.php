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
tableau_smenu[0] = Array("smenu_comptabilite", "smenu_comptabilite.php" ,"true" ,"sub_content", "Comptabilité");
tableau_smenu[1] = Array('compte_tpv','compta_compte_tpv.php','true','sub_content', "Gestion des Terminaux de paiements Virtuels");
update_menu_arbo();
</script>

<div id="pop_up_commission" style="display:none" class="cal_com">
<a href="#" id="link_close_pop_up_commission" style="float:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
<script type="text/javascript">
Event.observe("link_close_pop_up_commission", "click",  function(evt){Event.stop(evt); 
	$("pop_up_commission").hide();
}, false);
</script>
<span class="bolder">Règles de commissionnement de votre banque.</span><br />
<br />
<span style="width:350px; float:left">	Commission forfaitaire par opération:	</span>
<input name="com_ope_cal" id="com_ope_cal" type="text" value="0" size="4"   class="classinput_nsize"/><br />
<span style="width:350px; float:left">Commission variable en % du montant de l'opération:	</span>
<input name="com_var_cal" id="com_var_cal" type="text" value="0" size="4"   class="classinput_nsize"/><br /><br />



<input name="retour_cal" id="retour_cal" type="hidden" value="" />

<span style="width:350px; float:left">&nbsp;</span>
<input name="valider_cal" id="valider_cal" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />

<script type="text/javascript">
new Event.observe("com_ope_cal", "blur", function(evt){nummask(evt,"0", "X.XX");}, false);
new Event.observe("com_var_cal", "blur", function(evt){nummask(evt,"0", "X.XX");}, false);


Event.observe("valider_cal", "click",  function(evt){
	Event.stop(evt); 
	
	if ($("retour_cal").value == "") {
		$("com_ope").value = $("com_ope_cal").value;
		$("com_var").value = $("com_var_cal").value;
	} else {
		$("com_ope"+$("retour_cal").value).value = $("com_ope_cal").value;
		$("com_var"+$("retour_cal").value).value = $("com_var_cal").value;
		$("compta_compte_tpv_mod"+$("retour_cal").value).submit();
	
	}
	$("pop_up_commission").hide();
}, false);

</script>
</div>
<div class="emarge">

<p class="titre">Gestion des Terminaux de paiements Virtuels</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="cat_client" style="padding-left:10px; padding-right:10px">

	<br />
<?php
if (isset($liste_modules_tpv) && count($liste_modules_tpv)) {
	?>
	<p>Ajouter un Terminal de paiement virtuel </p>
	
	
		<div>
			<table>
				<tr>
					<td style="width:95%">
						<table>
							<tr class="smallheight">
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							</tr>	
							<tr>
								<td style="text-align:center">
								Libell&eacute;: 
								</td>
								<td style="text-align:center">Compte bancaire:
								</td>
								<td style="text-align:center">Module de paiement 
								</td>
								<td style="text-align:center">
								Commission:
								</td>
								<td style="text-align:center">
								</td>
							</tr>
						</table>
					</td>
					<td style="width:55px; text-align:center">
					
					</td>
				</tr>
			</table>
		</div>
		<div class="caract_table">
	
		<table>
		<tr>
			<td style="width:95%">
				<form action="compta_compte_tpv_add.php" method="post" id="compta_compte_tpv_add" name="compta_compte_tpv_add" target="formFrame" >
				<table style="width:100%">
					<tr class="smallheight">
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input name="lib_tpv" id="lib_tpv" type="text" value=""  class="classinput_xsize"  />
						</td>
						<td>
						<select id="id_compte_bancaire" name="id_compte_bancaire"  class="classinput_xsize" >
						<?php 
						foreach ($comptes_bancaires as $compte_bancaire) {
							?>
							<option value="<?php echo $compte_bancaire->id_compte_bancaire; ?>"><?php echo htmlentities($compte_bancaire->lib_compte); ?></option>
							<?php 
						}
						?>
						</select>
						</td>
						<td>
						<select id="module_name" name="module_name"  class="classinput_xsize" >
							<?php 
							foreach ($liste_modules_tpv as $module_tpv) {
								?>
								<option value="<?php echo $module_tpv; ?>" ><?php echo htmlentities($module_tpv); ?></option>
								<?php 
							}
							?>
						</select>
						</td>
						<td style="text-align:center">
						<input name="com_ope" id="com_ope" type="hidden" value="0" />
						<input name="com_var" id="com_var" type="hidden" value="0" />
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_calcul.gif" id="cal_com" style="cursor:pointer" title="Règles de commissionnement de votre banque."/>
						<script type="text/javascript">
							Event.observe("cal_com", "click",  function(evt){
								Event.stop(evt); 
								$("pop_up_commission").show();
								$("com_ope_cal").value = $("com_ope").value;
								$("com_var_cal").value = $("com_var").value;
								$("retour_cal").value = "";
							}, false);
						</script>
						</td>
						<td style="text-align:center">
						<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td>
			</td>
		</tr>
	</table>
	</div>
	<?php 
	if ($comptes_tpv) {
		?>
		<p>Terminaux de paiement Virtuels</p>
		
		<div>
			<table>
				<tr>
					<td style="width:95%">
						<table>
							<tr class="smallheight">
								<td style="width:17%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:17%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:17%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:17%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:9%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:14%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							</tr>	
							<tr>
								<td style="text-align:center">
								Libell&eacute;: 
								</td>
								<td style="text-align:center">
								Compte bancaire:
								</td>
								<td style="text-align:center">
								Module de paiement :
								</td>
								<td style="text-align:center">
								Commission: 
								</td>
								<td style="text-align:center">
								Actif: 
								</td>
							</tr>
						</table>
					</td>
					<td style="width:85px; text-align:center">
					
					</td>
				</tr>
			</table>
		</div>
		<?php
		
		$fleches_ascenseur=0;
		foreach ($comptes_tpv as $compte_tpv) {
			?>
			<div class="caract_table">
				<table>
				<tr>
					<td style="width:95%">
						<form action="compta_compte_tpv_mod.php" method="post" id="compta_compte_tpv_mod_<?php echo $compte_tpv->id_compte_tpv;?>" name="compta_compte_tpv_mod_<?php echo $compte_tpv->id_compte_tpv;?>" target="formFrame" >
						<table style="width:100%">
							<tr class="smallheight">
								<td style="width:18%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:18%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:18%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							</tr>	
							<tr>
								<td style="text-align:center">
								<input name="lib_tpv_<?php echo $compte_tpv->id_compte_tpv;?>" id="lib_tpv_<?php echo $compte_tpv->id_compte_tpv;?>" type="text" value="<?php echo htmlentities($compte_tpv->lib_tpv);?>"  class="classinput_xsize"  />
								</td>
								<td style="text-align:center">
								<select id="id_compte_bancaire_<?php echo $compte_tpv->id_compte_tpv;?>" name="id_compte_bancaire_<?php echo $compte_tpv->id_compte_tpv;?>"  class="classinput_xsize" >
								<?php 
								foreach ($comptes_bancaires as $compte_bancaire) {
									?>
									<option value="<?php echo $compte_bancaire->id_compte_bancaire; ?>" <?php if ($compte_bancaire->id_compte_bancaire == $compte_tpv->id_compte_bancaire) {echo 'selected="selected"';}?>><?php echo htmlentities($compte_bancaire->lib_compte); ?></option>
									<?php 
								}
								?>
								</select>
								</td>
								<td style="text-align:center">
								<select id="module_name_<?php echo $compte_tpv->id_compte_tpv;?>" name="module_name_<?php echo $compte_tpv->id_compte_tpv;?>"   class="classinput_xsize" >
									<?php 
									foreach ($liste_modules_tpv as $module_tpv) {
										?>
								<option value="<?php echo $module_tpv; ?>"  <?php if ($module_tpv == $compte_tpv->module_name) {echo 'selected="selected"';}?>><?php echo htmlentities($module_tpv); ?></option>
										<?php 
									}
									?>
								</select>
								</td>
								<td style="text-align:center">
								<input name="com_ope_<?php echo $compte_tpv->id_compte_tpv;?>" id="com_ope_<?php echo $compte_tpv->id_compte_tpv;?>" type="hidden" value="<?php echo $compte_tpv->com_ope;?>" />
								<input name="com_var_<?php echo $compte_tpv->id_compte_tpv;?>" id="com_var_<?php echo $compte_tpv->id_compte_tpv;?>" type="hidden" value="<?php echo $compte_tpv->com_var;?>" />
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_calcul.gif" id="cal_com_<?php echo $compte_tpv->id_compte_tpv;?>" style="cursor:pointer" title="Règles de commissionnement de votre banque."/>
								<script type="text/javascript">
									Event.observe("cal_com_<?php echo $compte_tpv->id_compte_tpv;?>", "click",  function(evt){
										Event.stop(evt); 
										$("pop_up_commission").show();
										$("com_ope_cal").value = $("com_ope_<?php echo $compte_tpv->id_compte_tpv;?>").value;
										$("com_var_cal").value = $("com_var_<?php echo $compte_tpv->id_compte_tpv;?>").value;
										$("retour_cal").value = "_<?php echo $compte_tpv->id_compte_tpv;?>";
									}, false);
								</script>
								</td>
								<td style="text-align:center">
							<input type="checkbox" id="actif_<?php echo $compte_tpv->id_compte_tpv;?>" name="actif_<?php echo $compte_tpv->id_compte_tpv;?>" value="1" <?php if ($compte_tpv->actif) {echo 'checked="checked"';};?>/>
								<input id="id_compte_tpv" name="id_compte_tpv" value="<?php echo $compte_tpv->id_compte_tpv?>" type="hidden"/>
								</td>
								<td style="text-align:center">
						<input name="modifier_<?php echo $compte_tpv->id_compte_tpv;?>" id="modifier_<?php echo $compte_tpv->id_compte_tpv;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
								</td>
							</tr>
						</table>
						</form>
					</td>
					<td style="width:85px; text-align:center">
					<form method="post" action="compta_compte_tpv_sup.php" id="compta_compte_tpv_sup_<?php echo $compte_tpv->id_compte_tpv; ?>" name="compta_compte_tpv_sup_<?php echo $compte_tpv->id_compte_tpv; ?>" target="formFrame">
						<input name="id_compte_tpv" id="id_compte_tpv" type="hidden" value="<?php echo $compte_tpv->id_compte_tpv; ?>" />
					</form>
					<a href="#" id="link_compta_compte_tpv_sup_<?php echo $compte_tpv->id_compte_tpv; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
					<script type="text/javascript">
					Event.observe("link_compta_compte_tpv_sup_<?php echo $compte_tpv->id_compte_tpv; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('compta_compte_tpv_sup', 'compta_compte_tpv_sup_<?php echo $compte_tpv->id_compte_tpv; ?>');}, false);
					</script>
					<table cellspacing="0">
						<tr>
							<td>
								<div id="up_arrow_<?php echo $compte_tpv->id_compte_tpv; ?>">
								<?php
								if ($fleches_ascenseur!=0) {
								?>
								<form action="compta_compte_tpv_ordre.php" method="post" id="compta_compte_tpv_ordre_<?php echo $compte_tpv->id_compte_tpv; ?>" name="compta_compte_tpv_ordre_<?php echo $compte_tpv->id_compte_tpv; ?>" target="formFrame">
									<input name="new_ordre" id="new_ordre" type="hidden" value="<?php echo ($compte_tpv->ordre)-1?>" />
									<input name="id_compte_tpv" id="id_compte_tpv" type="hidden" value="<?php echo $compte_tpv->id_compte_tpv; ?>" />
																		
									<input name="modifier_ordre_<?php echo $compte_tpv->id_compte_tpv; ?>" id="modifier_ordre_<?php echo $compte_tpv->id_compte_tpv; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif">
								</form>
								<?php
								} else {
								?>
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>
								<?php
								}
								?>
								</div>
							</td>
						</tr>
						<tr>
							<td>
							<div id="down_arrow_<?php echo $compte_tpv->id_compte_tpv; ?>">
								<?php
								if ($fleches_ascenseur!=count($comptes_tpv)-1) {
								?>
							<form action="compta_compte_tpv_ordre.php" method="post" id="compta_compte_tpv_ordre_<?php echo $compte_tpv->id_compte_tpv; ?>" name="compta_compte_tpv_ordre_<?php echo $compte_tpv->id_compte_tpv; ?>" target="formFrame">
									<input name="new_ordre" id="new_ordre" type="hidden" value="<?php echo ($compte_tpv->ordre)+1?>" />
									<input name="id_compte_tpv" id="id_compte_tpv" type="hidden" value="<?php echo $compte_tpv->id_compte_tpv; ?>" />
									
									<input name="modifier_ordre_<?php echo $compte_tpv->id_compte_tpv; ?>" id="modifier_ordre_<?php echo $compte_tpv->id_compte_tpv; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif">
								</form>
								<?php
								} else {
								?>
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>							
								<?php
								}
								?>
								</div>
							</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
			</div>
			<?php 
			$fleches_ascenseur++;
			}
		?>
		<?php 
		}
}
?>

</div>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">
<?php
if (isset($liste_modules_tpv) && count($liste_modules_tpv)) {
	?>
	new Form.EventObserver('compta_compte_tpv_add', function(){formChanged();});
	<?php
	foreach ($comptes_tpv as $compte_tpv) {
		?>
		Event.observe($("actif_<?php echo $compte_tpv->id_compte_tpv;?>"), "click", function(evt){
			if ($("actif_<?php echo $compte_tpv->id_compte_tpv;?>").checked) {
				set_active_compte_tpv("<?php echo $compte_tpv->id_compte_tpv;?>");
			} else {
				set_desactive_compte_tpv("<?php echo $compte_tpv->id_compte_tpv;?>");
			}
		});
		
		
		
		new Form.EventObserver('compta_compte_tpv_mod_<?php echo $compte_tpv->id_compte_tpv; ?>', function(){formChanged();});
		<?php 
		}
}
?>

//centrage de l'assistant calcul_commission

centrage_element("pop_up_commission");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_commission");
});

//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>