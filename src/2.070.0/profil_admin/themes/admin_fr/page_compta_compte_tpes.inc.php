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
tableau_smenu[1] = Array('compte_tpes','compta_compte_tpes.php','true','sub_content', "Gestion des Terminaux de paiements &eacute;lectroniques");
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
Event.observe("com_ope_cal", "blur", function(evt){nummask(evt,"0", "X.XX");}, false);
Event.observe("com_var_cal", "blur", function(evt){nummask(evt,"0", "X.XX");}, false);


Event.observe("valider_cal", "click",  function(evt){
	Event.stop(evt); 
	
	if ($("retour_cal").value == "") {
		$("com_ope").value = $("com_ope_cal").value;
		$("com_var").value = $("com_var_cal").value;
	} else {
		$("com_ope"+$("retour_cal").value).value = $("com_ope_cal").value;
		$("com_var"+$("retour_cal").value).value = $("com_var_cal").value;
		$("compta_compte_tpes_mod"+$("retour_cal").value).submit();
	
	}
	$("pop_up_commission").hide();
}, false);

</script>
</div>

<div class="emarge">

<p class="titre">Gestion des Terminaux de paiements &eacute;lectroniques</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="cat_client" style="padding-left:10px; padding-right:10px">

	<p>Choix du magasin </p>

	<select id="choix_id_magasin" name="choix_id_magasin" >
	<option value=""></option>
	<?php 
	foreach ($magasins_liste as $magasin_liste) {
		?>
		<option value="<?php echo $magasin_liste->getId_magasin(); ?>" <?php if ($magasin_liste->getId_magasin() == $id_magasin) {echo 'selected="selected"';}?>><?php echo htmlentities($magasin_liste->getLib_magasin()); ?></option>
		<?php 
	}
	?>
	</select>
	<br />
	<br />
<?php
if (isset($id_magasin)) {
	?>
	<p>Ajouter un Terminal de paiement &eacute;lectronique </p>
	
	
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
								<td style="text-align:center">Magasin: 
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
				<form action="compta_compte_tpes_add.php" method="post" id="compta_compte_tpes_add" name="compta_compte_tpes_add" target="formFrame" >
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
						<input name="lib_tpe" id="lib_tpe" type="text" value=""  class="classinput_xsize"  />
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
						<select id="id_magasin" name="id_magasin"  class="classinput_xsize" >
							<option value=""></option>
							<?php 
							foreach ($magasins_liste as $magasin_liste) {
								?>
								<option value="<?php echo $magasin_liste->getId_magasin(); ?>" <?php if ($magasin_liste->getId_magasin() == $id_magasin) {echo 'selected="selected"';}?>><?php echo htmlentities($magasin_liste->getLib_magasin()); ?></option>
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
	if ($comptes_tpes) {
		?>
		<p>Terminaux de paiement &eacute;lectronique</p>
		
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
								Magasin: 
								</td>
								<td style="text-align:center">
								Caisses associées: 
								</td>
								<td style="text-align:center">
								Commission: 
								</td>
								<td style="text-align:center">
								Actif: 
								</td>
								<td style="text-align:center">
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
		foreach ($comptes_tpes as $compte_tpes) {
			?>
			<div class="caract_table">
				<table>
				<tr>
					<td style="width:95%">
						<form action="compta_compte_tpes_mod.php" method="post" id="compta_compte_tpes_mod_<?php echo $compte_tpes->id_compte_tpe;?>" name="compta_compte_tpes_mod_<?php echo $compte_tpes->id_compte_tpe;?>" target="formFrame" >
						<table style="width:100%">
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
								<input name="lib_tpe_<?php echo $compte_tpes->id_compte_tpe;?>" id="lib_tpe_<?php echo $compte_tpes->id_compte_tpe;?>" type="text" value="<?php echo htmlentities($compte_tpes->lib_tpe);?>"  class="classinput_xsize"  />
								</td>
								<td style="text-align:center">
								<select id="id_compte_bancaire_<?php echo $compte_tpes->id_compte_tpe;?>" name="id_compte_bancaire_<?php echo $compte_tpes->id_compte_tpe;?>"  class="classinput_xsize" >
								<?php 
								foreach ($comptes_bancaires as $compte_bancaire) {
									?>
									<option value="<?php echo $compte_bancaire->id_compte_bancaire; ?>" <?php if ($compte_bancaire->id_compte_bancaire == $compte_tpes->id_compte_bancaire) {echo 'selected="selected"';}?>><?php echo htmlentities($compte_bancaire->lib_compte); ?></option>
									<?php 
								}
								?>
								</select>
								</td>
								<td style="text-align:center">
								<select id="id_magasin_<?php echo $compte_tpes->id_compte_tpe;?>" name="id_magasin_<?php echo $compte_tpes->id_compte_tpe;?>"   class="classinput_xsize" >
									<option value=""></option>
									<?php 
									foreach ($magasins_liste as $magasin_liste) {
										?>
										<option value="<?php echo $magasin_liste->getId_magasin(); ?>" <?php if ($magasin_liste->getId_magasin() == $compte_tpes->id_magasin) {echo 'selected="selected"';}?>><?php echo htmlentities($magasin_liste->getLib_magasin()); ?></option>
										<?php 
									}
									?>
								</select>
								</td>
								<td style="text-align:center">
								<?php
								foreach ($comptes_caisses as $compte_caisse) {
									if ($compte_caisse->id_compte_tpe == $compte_tpes->id_compte_tpe) {
									?>
									<?php echo htmlentities($compte_caisse->lib_caisse);?><br />
									<?php
									}
								}
								?>
								</td>
								<td style="text-align:center">
								<input name="com_ope_<?php echo $compte_tpes->id_compte_tpe;?>" id="com_ope_<?php echo $compte_tpes->id_compte_tpe;?>" type="hidden" value="<?php echo $compte_tpes->com_ope;?>" />
								<input name="com_var_<?php echo $compte_tpes->id_compte_tpe;?>" id="com_var_<?php echo $compte_tpes->id_compte_tpe;?>" type="hidden" value="<?php echo $compte_tpes->com_var;?>" />
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_calcul.gif" id="cal_com_<?php echo $compte_tpes->id_compte_tpe;?>" style="cursor:pointer" title="Règles de commissionnement de votre banque."/>
								<script type="text/javascript">
									Event.observe("cal_com_<?php echo $compte_tpes->id_compte_tpe;?>", "click",  function(evt){
										Event.stop(evt); 
										$("pop_up_commission").show();
										$("com_ope_cal").value = $("com_ope_<?php echo $compte_tpes->id_compte_tpe;?>").value;
										$("com_var_cal").value = $("com_var_<?php echo $compte_tpes->id_compte_tpe;?>").value;
										$("retour_cal").value = "_<?php echo $compte_tpes->id_compte_tpe;?>";
									}, false);
								</script>
								</td>
								<td style="text-align:center">
								<input type="checkbox" id="actif_<?php echo $compte_tpes->id_compte_tpe;?>" name="actif_<?php echo $compte_tpes->id_compte_tpe;?>" value="1" <?php if ($compte_tpes->actif) {echo 'checked="checked"';};?>/>
								<input id="id_compte_tpe" name="id_compte_tpe" value="<?php echo $compte_tpes->id_compte_tpe?>" type="hidden"/>
								</td>
								<td style="text-align:center">
								<input name="modifier_<?php echo $compte_tpes->id_compte_tpe;?>" id="modifier_<?php echo $compte_tpes->id_compte_tpe;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
								</td>
							</tr>
						</table>
						</form>
					</td>
					<td style="width:85px; text-align:center">
					<form method="post" action="compta_compte_tpes_sup.php" id="compta_compte_tpes_sup_<?php echo $compte_tpes->id_compte_tpe; ?>" name="compta_compte_tpes_sup_<?php echo $compte_tpes->id_compte_tpe; ?>" target="formFrame">
						<input id="id_magasin_<?php echo $compte_tpes->id_compte_tpe;?>" name="id_magasin_<?php echo $compte_tpes->id_compte_tpe;?>" value="<?php echo $compte_tpes->id_magasin?>" type="hidden"/>
						<input name="id_compte_tpe" id="id_compte_tpe" type="hidden" value="<?php echo $compte_tpes->id_compte_tpe; ?>" />
					</form>
					<a href="#" id="link_compta_compte_tpes_sup_<?php echo $compte_tpes->id_compte_tpe; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
					<script type="text/javascript">
					Event.observe("link_compta_compte_tpes_sup_<?php echo $compte_tpes->id_compte_tpe; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('compta_compte_tpes_sup', 'compta_compte_tpes_sup_<?php echo $compte_tpes->id_compte_tpe; ?>');}, false);
					</script>
					<table cellspacing="0">
						<tr>
							<td>
								<div id="up_arrow_<?php echo $compte_tpes->id_compte_tpe; ?>">
								<?php
								if ($fleches_ascenseur!=0) {
								?>
								<form action="compta_compte_tpes_ordre.php" method="post" id="compta_compte_tpes_ordre_<?php echo $compte_tpes->id_compte_tpe; ?>" name="compta_compte_tpes_ordre_<?php echo $compte_tpes->id_compte_tpe; ?>" target="formFrame">
									<input name="new_ordre" id="new_ordre" type="hidden" value="<?php echo ($compte_tpes->ordre)-1?>" />
									<input name="id_compte_tpe" id="id_compte_tpe" type="hidden" value="<?php echo $compte_tpes->id_compte_tpe; ?>" />
									
									<input id="id_magasin_<?php echo $compte_tpes->id_compte_tpe;?>" name="id_magasin_<?php echo $compte_tpes->id_compte_tpe;?>" value="<?php echo $compte_tpes->id_magasin?>" type="hidden"/>
									
									<input name="modifier_ordre_<?php echo $compte_tpes->id_compte_tpe; ?>" id="modifier_ordre_<?php echo $compte_tpes->id_compte_tpe; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif">
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
							<div id="down_arrow_<?php echo $compte_tpes->id_compte_tpe; ?>">
								<?php
								if ($fleches_ascenseur!=count($comptes_tpes)-1) {
								?>
							<form action="compta_compte_tpes_ordre.php" method="post" id="compta_compte_tpes_ordre_<?php echo $compte_tpes->id_compte_tpe; ?>" name="compta_compte_tpes_ordre_<?php echo $compte_tpes->id_compte_tpe; ?>" target="formFrame">
									<input name="new_ordre" id="new_ordre" type="hidden" value="<?php echo ($compte_tpes->ordre)+1?>" />
									<input name="id_compte_tpe" id="id_compte_tpe" type="hidden" value="<?php echo $compte_tpes->id_compte_tpe; ?>" />
									
									<input id="id_magasin_<?php echo $compte_tpes->id_compte_tpe;?>" name="id_magasin_<?php echo $compte_tpes->id_compte_tpe;?>" value="<?php echo $compte_tpes->id_magasin?>" type="hidden"/>
									
									<input name="modifier_ordre_<?php echo $compte_tpes->id_compte_tpe; ?>" id="modifier_ordre_<?php echo $compte_tpes->id_compte_tpe; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif">
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
Event.observe("choix_id_magasin", "change", function(evt){ if ($("choix_id_magasin").value != "") { page.traitecontent('compta_compte_tpes','compta_compte_tpes.php?id_magasin='+$("choix_id_magasin").value,'true','sub_content');} }, false);	
<?php
if (isset($id_magasin)) {
	?>
	new Form.EventObserver('compta_compte_tpes_add', function(){formChanged();});
	<?php
	foreach ($comptes_tpes as $compte_tpes) {
		?>
		Event.observe($("actif_<?php echo $compte_tpes->id_compte_tpe;?>"), "click", function(evt){
			if ($("actif_<?php echo $compte_tpes->id_compte_tpe;?>").checked) {
				set_active_compte_tpe("<?php echo $compte_tpes->id_compte_tpe;?>");
			} else {
				set_desactive_compte_tpe("<?php echo $compte_tpes->id_compte_tpe;?>");
			}
		});
		
		
		
		new Form.EventObserver('compta_compte_tpes_mod_<?php echo $compte_tpes->id_compte_tpe; ?>', function(){formChanged();});
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