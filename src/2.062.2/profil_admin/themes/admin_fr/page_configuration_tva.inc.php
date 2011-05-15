<?php

// *************************************************************************************************************
// CONFIG DES DONNEES tarifs
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
tableau_smenu[1] = Array('configuration_tva','configuration_tva.php','true','sub_content', "Configuration TVA");
update_menu_arbo();
</script>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_recherche_mini.inc.php" ?>
<div class="emarge">
<p class="titre">Configuration TVA</p>

<div class="contactview_corps">

<table width="100%">
	<tr class="smallheight">
		<td style="width:29%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:71%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:1%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	
	<tr>
		<td class="lib_config">L'entreprise est-elle soumise à la TVA ?</td>
		<td>
		<form action="configuration_tva_maj.php" enctype="multipart/form-data" method="POST"  id="form_assujetti_tva" name="form_assujetti_tva" target="formFrame" >
		<input id="assujetti_tva" name="assujetti_tva" value="<?php echo  $ASSUJETTI_TVA; ?>" <?php if ($ASSUJETTI_TVA) {?>checked="checked"<?php } ?> type="checkbox" />
		</form>
		</td>
		<td class="infos_config"> </td>
	</tr>
	<tr>
		<td colspan="3" style="border-bottom:1px solid #999999"> </td>
	</tr>
	<tr>
		<td class="lib_config">Définir les taux de TVA pour :  </td>
		<td>
				<select id="id_pays"  name="id_pays" class="classinput_nsize">
					<?php
					$separe_listepays = 0;
					foreach ($listepays as $payslist){
						if ((!$separe_listepays) && (!$payslist->affichage)) { 
							$separe_listepays = 1; ?>
							<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
							<?php 		 
						}
						?>
						<option value="<?php echo $payslist->id_pays?>" <?php if ($id_pays == $payslist->id_pays) {echo 'selected="selected"';}?>>
						<?php echo htmlentities($payslist->pays)?></option>
						<?php 
					}
					?>
				</select>
		</td>
		<td class="infos_config"> </td>
	</tr>
	<tr>
		<td colspan="3" style="border-bottom:1px solid #999999"> </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config"> </td>
		
		<td >
					<table width="100%">
					<tr class="smallheight">
					<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>
					<tr>
					<td>
					Taux de TVA
					</td>
					<td style="text-align:center">
					&nbsp;</td>
					<td style="text-align:center">&nbsp;
					</td>
					<td>
					</td>
					<td>
					</td>
					</tr>
					</table>
		</td>
		<td class="lib_config"> </td>
	</tr>
	<tr>
		<td class="lib_config">Taux de TVA:  </td>
		<td>
		
		
				<?php
				//liste des TVA par pays
				foreach ($tvas  as $tva){
					?>
					<table style="width:100%">
					<tr>
					<td>
					<table width="100%">
					<tr class="smallheight">
					<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>
					<tr>
					<td>
					<table>
						<tr>
							<td style="width:66%">
								<form action="configuration_tva_mod.php" enctype="multipart/form-data" method="POST"  id="configuration_tva_mod_<?php echo $tva['id_tva'];?>" name="configuration_tva_mod_<?php echo $tva['id_tva'];?>" target="formFrame" >
								<input type="text" id="tva_<?php echo $tva['id_tva'];?>" name="tva_<?php echo $tva['id_tva'];?>"  value="<?php echo ($tva['tva']);?>" />
								<input type="hidden" id="id_tva" name="id_tva"  value="<?php echo ($tva['id_tva']);?>" />
								<input type="hidden" name="id_pays"  value="<?php echo ($id_pays);?>" />
								<script type="text/javascript">
								new Event.observe("tva_<?php echo $tva['id_tva'];?>", "blur", function(evt){
								nummask(evt, "<?php echo ($tva['tva']);?>", "X.XY"); 
								$("configuration_tva_mod_<?php echo $tva['id_tva'];?>").submit();
								}, false);
								</script>
								</form>
							</td>
							<td>
								<form method="post" action="configuration_tva_sup.php" id="configuration_tva_sup_<?php echo  $tva['id_tva'];?>" name="configuration_tva_sup_<?php echo $tva['id_tva'];?>" target="formFrame">
									<input name="id_tva" type="hidden" value="<?php echo  $tva['id_tva'];?>" />
									<input type="hidden" name="id_pays"  value="<?php echo ($id_pays);?>" />
								</form>
								<a href="#" id="bt_configuration_tva_sup_<?php echo $tva['id_tva']; ?>" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
								<script type="text/javascript">
								Event.observe("bt_configuration_tva_sup_<?php echo $tva['id_tva']; ?>", "click",  function(evt){
									Event.stop(evt);
									alerte.confirm_supprimer('configuration_tva_sup', 'configuration_tva_sup_<?php echo $tva['id_tva'];?>');
								}, false);
								</script>
							</td>
						</tr>
					</table>
					</td>
					<td style="text-align:center">
					</td>
					<td style="text-align:center">
					</td>
					<td>
					</td>
					</tr>
					</table>
					</td>
					</tr>
					</table>
					<?php 
				}
				?>
		</td>
		<td class="infos_config"> </td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td class="lib_config">Ajouter un taux de TVA:  </td>
		<td>
			<table style="width:100%">
			<tr>
			<td>
			<table width="100%">
			<tr class="smallheight">
			<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
			<td >
			<div style="line-height:26px">
			<form action="configuration_tva_add.php" enctype="multipart/form-data" method="POST"  id="configuration_tva_add" name="configuration_tva_add" target="formFrame" >
				<input type="text" id="tva" name="tva"  value="0" />
				<input type="hidden" name="id_pays"  value="<?php echo ($id_pays);?>" />
			<img id="ajouter" name="ajouter" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_recherche.gif" />
			</form>
			</div>
			</td>
			<td>
			</td>
			<td>
			</td>
			<td>
			</td>
			</tr>
			</table>
			<script type="text/javascript">
			new Event.observe("tva", "blur", function(evt){
			nummask(evt, "0", "X.XY"); 
			}, false);
			new Event.observe("ajouter", "click", function(evt){
			$("configuration_tva_add").submit(); 
			}, false);
			
			</script>
			</td>
			</tr>
			</table>
		</td>
		<td class="infos_config"> </td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
</table>
</div>
<SCRIPT type="text/javascript">

new Event.observe("id_pays", "change", function(evt){
	page.verify('configuration_tva','configuration_tva.php?id_pays='+$("id_pays").value,'true','sub_content');  
}, false);

new Event.observe("assujetti_tva", "click", function(evt){


		$("titre_alert").innerHTML = 'Confirmer la modification';
		$("texte_alert").innerHTML = 'Attention, cette modification entraine de profonds changements dans la gestion de la TVA au sein de votre entreprise. <br />Les données existantes ne seront pas modifiées, ce qui peut engendrer une incohérence dans les données comptable de l\'exercice en cours.<br />Confirmer la modification.';
		$("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />';
	
		show_pop_alerte ();
		
		$("bouton0").onclick= function () {
			if ($("assujetti_tva").checked) {
				$("assujetti_tva").checked = false;
			} else {
				$("assujetti_tva").checked = true;	
			}
			hide_pop_alerte ();
		}
		if ($("bouton1")) {
		$("bouton1").onclick= function () {
				hide_pop_alerte ();
				$("form_assujetti_tva").submit();
			}
		}
}, false);

//on masque le chargement
H_loading();
</SCRIPT>