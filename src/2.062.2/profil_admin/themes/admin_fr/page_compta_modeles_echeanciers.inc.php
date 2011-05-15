<?php

// *************************************************************************************************************
//journal des ventes
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

//_vardump($reglements_modes);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">	
tableau_smenu[0] = Array("smenu_comptabilite", "smenu_comptabilite.php" ,"true" ,"sub_content", "Comptabilité");
tableau_smenu[1] = Array('compta_modeles_echeanciers','compta_modeles_echeanciers.php','true','sub_content', "Modèles d'échéanciers");
update_menu_arbo();
</script>
<div id="dev_debug_compta_mod_ech"></div>
<div id="div_export" class="emarge">
	<div id="div_mod_ech_titre" class="titre">
		Gestion des modèles d'échéanciers
	</div>
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="cat_client" style="padding-left:10px; padding-right:10px">
<p>Ajouter un modèle d'échéancier </p>

	<div class="caract_table">

	<table>
	<tr>
		<td style="width:95%">
		<form action="compta_modeles_echeanciers_add.php" method="post" id="compta_compte_cbs_add" name="compta_compte_cbs_add" target="formFrame" >
			<table>
				<tr class="smallheight">
					<td style="width:23%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:62%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>
				<tr>
				<td style="text-align:right">Libellé du modèle d'échéancier :
				</td>
				<td>
					<input name="lib_modele" id="lib_modele" type="text" value=""  class="classinput_xsize" style="width:41%"/>
				</td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td style="text-align:right">Nombre de règlements :
				</td>
				<td>
                                    <input name="nb_reglements" id="nb_reglements" type="text" value="" onfocus="$('valider_nb_reg').style.display = '';" class="classinput_xsize" style="width:20px" MAXLENGTH="2"/>
                                        &nbsp;&nbsp;&nbsp; <img id="valider_nb_reg" name="valider_nb_reg" style="cursor:pointer" onclick="this.style.display='none';" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-continuer.gif" />
                                        <script type="text/javascript">
					Event.observe('nb_reglements', 'keypress',  function(evt){
						if (evt.keyCode == 13){
							Event.stop(evt);
							this.blur();
						}		
					},false);
					Event.observe('nb_reglements', 'change',  function(){
                                                $('valider_nb_reg').style.display = 'none';
						i=1;
						strlignetot = '<table id="tb_liste_regl" name="tb_liste_regl">'+
						'<tr class="smallheight">'+
						'<td style="width:25%"><strong>Echéance</strong></td>'+
						'<td style="width:20%;text-align:center"><strong>Type d\'échéance</strong></td>'+
						'<td style="width:20%;text-align:center"><strong>Mode de règlement</strong></td>'+
						'<td style="width:20%;text-align:center"><strong>Délai</strong></td>'+
						'<td style="width:15%;text-align:center"><strong>Montant</strong></td>'+
						'</tr>';
						str_mode_regl_select = '<option value="">Au choix du client</option><?php foreach ($reglements_modes as $reglement_mode) {?><option value="<?php echo $reglement_mode->id_reglement_mode; ?>"><?php echo htmlentities($reglement_mode->lib_reglement_mode); ?></option><?php } ?>';
						nbregl = parseInt(this.value);
						this.value = parseInt(this.value);
						if(nbregl>0){
							if(nbregl>1){
								for(i=1;i<=nbregl;i++){
									if(i==nbregl){
										strligne = '<tr>'+
										'<td>'+ i +'<sup>e</sup> échéance : </td>'+
										'<td style="text-align:center"><select name="slct_type_'+i+'" id="slct_type_'+i+'" style="width:100px"><option value="Solde">Solde</option></select></td>'+
										'<td style="text-align:center"><select name="slct_mode_'+i+'" id="slct_mode_'+i+'" style="width:160px">'+str_mode_regl_select+'</select></td>'+
										'<td style="text-align:center"><input name="inp_delai_'+i+'" id="inp_delai_'+i+'" type="text" value="" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> jours</td>'+
										'<td style="text-align:center"><input name="inp_montant_'+i+'" id="inp_montant_'+i+'" type="text" value="" class="classinput_xsize" style="width:30px" MAXLENGTH="3" readonly="readonly" /> %</td>'+
										'</tr>';
									}
									else{
										if(i==1){
											strligne = '<tr>'+
											'<td>'+ i +'<sup>e</sup> échéance : </td>'+
											'<td style="text-align:center"><select name="slct_type_'+i+'" id="slct_type_'+i+'" style="width:100px"><option value="Acompte">Acompte</option><option value="Arrhes">Arrhes</option><option value="Echeance">Echeance</option></select></td>'+
											'<td style="text-align:center"><select name="slct_mode_'+i+'" id="slct_mode_'+i+'" style="width:160px">'+str_mode_regl_select+'</select></td>'+
											'<td style="text-align:center"><input name="inp_delai_'+i+'" id="inp_delai_'+i+'" type="text" value="" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> jours</td>'+
											'<td style="text-align:center"><input name="inp_montant_'+i+'" id="inp_montant_'+i+'" type="text" value="" onKeyUp="maj_mnt_solde(\'div_lignes_reglement\','+nbregl+');" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> %</td>'+
											'</tr>';
										}else{
											strligne = '<tr>'+
											'<td>'+ i +'<sup>e</sup> échéance : </td>'+
											'<td style="text-align:center"><select name="slct_type_'+i+'" id="slct_type_'+i+'" style="width:100px"><option value="Echeance">Echeance</option></select></td>'+
											'<td style="text-align:center"><select name="slct_mode_'+i+'" id="slct_mode_'+i+'" style="width:160px">'+str_mode_regl_select+'</select></td>'+
											'<td style="text-align:center"><input name="inp_delai_'+i+'" id="inp_delai_'+i+'" type="text" value="" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> jours</td>'+
											'<td style="text-align:center"><input name="inp_montant_'+i+'" id="inp_montant_'+i+'" type="text" value="" onKeyUp="maj_mnt_solde(\'div_lignes_reglement\','+nbregl+');" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> %</td>'+
											'</tr>';
										}
									}								
									strlignetot += strligne;
								}
							}else{
								strlignetot += '<tr>'+
								'<td>1<sup>e</sup> échéance : </td>'+
								'<td style="text-align:center"><select name="slct_type_'+i+'" id="slct_type_'+i+'" style="width:100px"><option value="Acompte">Acompte</option><option value="Arrhes">Arrhes</option><option value="Solde">Solde</option></select></td>'+
								'<td style="text-align:center"><select name="slct_mode_'+i+'" id="slct_mode_'+i+'" style="width:160px">'+str_mode_regl_select+'</select></td>'+
								'<td style="text-align:center"><input name="inp_delai_'+i+'" id="inp_delai_'+i+'" type="text" value="" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> jours</td>'+
								'<td style="text-align:center"><input name="inp_montant_'+i+'" id="inp_montant_'+i+'" type="text" value="100" class="classinput_xsize" style="width:30px" MAXLENGTH="3" readonly="readonly" /> %</td>'+
								'</tr>';				
							}						
							strlignetot += '</table>';
							$("div_lignes_reglement").innerHTML = strlignetot;
							$("ajouter").style.marginTop = 24*nbregl + "px";
							$("tr_lignes_reglement").style.display = "";
						}else{
						$("div_lignes_reglement").innerHTML = "";
						$("tr_lignes_reglement").style.display = "none";
						}
						},
					false);
					</script>
				</td>
				<td colspan="2">
				</td>				
				</tr>
				<tr id="tr_lignes_reglement" style="display: none">
				<!--------Lignes en affichage dynamique en fonction du nombre de règlements -------->
				<td colspan="4">
					<div id="div_lignes_reglement"></div>
				</td>
				<td style="height: 100%;">
					<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
				</td>
				</tr>
			</table>
			</form>		
		</td>
	</tr>
	</table>
	</div>

<?php if($modeles){?>
	<p>Modèles d'échéanciers </p>
	<?php foreach($modeles as $modele){
	$modele_echeancier = new modele_echeancier($modele->id_echeancier_modele);?>
	<div class="caract_table">
			<table>
			<tr>
				<td style="width:95%">
					<form action="compta_modeles_echeanciers_mod.php" method="post" id="compta_modeles_echeanciers_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>" name="compta_modeles_echeanciers_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>" target="formFrame" >
					<table>
					<tr class="smallheight">
					<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:60%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>					
				<tr>
				<td style="text-align:right">Modèle d'échéancier :
				<input name="id_mod_ech" id="id_mod_ech" type="hidden" value="<?php echo $modele_echeancier->getId_echeancier_modele();?>" />
				</td>
				<td>
					<input name="lib_modele" id="lib_modele" type="text" value="<?php echo $modele_echeancier->getLib_echeancier_modele();?>"  class="classinput_xsize" style="width:50%" />
				</td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td style="text-align:right">Nombre de règlements :
				</td>
				<td>
					<input name="nb_reglements_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>" id="nb_reglements_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>" type="text" value="<?php echo count($modele_echeancier->getEcheances());?>" class="classinput_xsize" style="width:20px" MAXLENGTH="2"/>
					<script type="text/javascript">
					Event.observe('nb_reglements_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>', 'keypress',  function(evt){
						if (evt.keyCode == 13){
							Event.stop(evt);
							this.blur();
						}		
					},false);
					Event.observe('nb_reglements_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>', 'change',  function(){
						strlignetot = '<table id="tb_liste_regl" name="tb_liste_regl">'+
						'<tr class="smallheight">'+
						'<td style="width:25%"><strong>Echéance</strong></td>'+
						'<td style="width:20%;text-align:center"><strong>Type d\'échéance</strong></td>'+
						'<td style="width:20%;text-align:center"><strong>Mode de règlement</strong></td>'+
						'<td style="width:20%;text-align:center"><strong>Délai</strong></td>'+
						'<td style="width:15%;text-align:center"><strong>Montant</strong></td>'+
						'</tr>';
						str_type_select = '<option value="0">Solde</option><option value="1">Acompte</option></select>';							
						str_mode_regl_select = '<option value="">Au choix du client</option><?php foreach ($reglements_modes as $reglement_mode) {?><option value="<?php echo $reglement_mode->id_reglement_mode; ?>"><?php echo htmlentities($reglement_mode->lib_reglement_mode); ?></option><?php } ?>';
						nbregl = parseInt(this.value);
						this.value = parseInt(this.value);
						if(nbregl>0){
							if(nbregl>1){
								for(i=1;i<=nbregl;i++){
									if(i==nbregl){
										strligne = '<tr>'+
										'<td>'+ i +'<sup>e</sup> échéance : </td>'+
										'<td style="text-align:center"><select name="slct_type_'+i+'" id="slct_type_'+i+'" style="width:100px"><option value="Solde">Solde</option></select></td>'+
										'<td style="text-align:center"><select name="slct_mode_'+i+'" id="slct_mode_'+i+'" style="width:160px">'+str_mode_regl_select+'</select></td>'+
										'<td style="text-align:center"><input name="inp_delai_'+i+'" id="inp_delai_'+i+'" type="text" value="" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> jours</td>'+
										'<td style="text-align:center"><input name="inp_montant_'+i+'" id="inp_montant_'+i+'" type="text" value="" class="classinput_xsize" style="width:30px" MAXLENGTH="3" readonly="readonly" /> %</td>'+
										'</tr>';
									}
									else{
										if(i==1){
											strligne = '<tr>'+
											'<td>'+ i +'<sup>e</sup> échéance : </td>'+
											'<td style="text-align:center"><select name="slct_type_'+i+'" id="slct_type_'+i+'" style="width:100px"><option value="Acompte">Acompte</option><option value="Arrhes">Arrhes</option><option value="Echeance">Echeance</option></select></td>'+
											'<td style="text-align:center"><select name="slct_mode_'+i+'" id="slct_mode_'+i+'" style="width:160px">'+str_mode_regl_select+'</select></td>'+
											'<td style="text-align:center"><input name="inp_delai_'+i+'" id="inp_delai_'+i+'" type="text" value="" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> jours</td>'+
											'<td style="text-align:center"><input name="inp_montant_'+i+'" id="inp_montant_'+i+'" type="text" value="" onKeyUp="maj_mnt_solde(\'div_lignes_reglement_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>\','+nbregl+');" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> %</td>'+
											'</tr>';
										}else{
											strligne = '<tr>'+
											'<td>'+ i +'<sup>e</sup> échéance : </td>'+
											'<td style="text-align:center"><select name="slct_type_'+i+'" id="slct_type_'+i+'" style="width:100px"><option value="Echeance">Echeance</option></select></td>'+
											'<td style="text-align:center"><select name="slct_mode_'+i+'" id="slct_mode_'+i+'" style="width:160px">'+str_mode_regl_select+'</select></td>'+
											'<td style="text-align:center"><input name="inp_delai_'+i+'" id="inp_delai_'+i+'" type="text" value="" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> jours</td>'+
											'<td style="text-align:center"><input name="inp_montant_'+i+'" id="inp_montant_'+i+'" type="text" value="" onKeyUp="maj_mnt_solde(\'div_lignes_reglement_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>\','+nbregl+');" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> %</td>'+
											'</tr>';
										}
									}								
									strlignetot += strligne;
								}
							}else{
								strlignetot += '<tr>'+
								'<td>1<sup>e</sup> échéance : </td>'+
								'<td style="text-align:center"><select name="slct_type_'+i+'" id="slct_type_'+i+'" style="width:100px"><option value="Acompte">Acompte</option><option value="Arrhes">Arrhes</option><option value="Solde">Solde</option></select></td>'+
								'<td style="text-align:center"><select name="slct_mode_'+i+'" id="slct_mode_'+i+'" style="width:160px">'+str_mode_regl_select+'</select></td>'+
								'<td style="text-align:center"><input name="inp_delai_'+i+'" id="inp_delai_'+i+'" type="text" value="" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> jours</td>'+
								'<td style="text-align:center"><input name="inp_montant_'+i+'" id="inp_montant_'+i+'" type="text" value="100" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> %</td>'+
								'</tr>';				
							}						
							strlignetot += '</table>';
							$("div_lignes_reglement_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>").innerHTML = strlignetot;
							//$("ajouter").style.marginTop = 24*nbregl + "px";
							//$("tr_lignes_reglement").style.display = "";
						}else{
						$("div_lignes_reglement_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>").innerHTML = "";
						//$("tr_lignes_reglement").style.display = "none";
						}
						},
					false);
					</script>
				</td>
				<td colspan="2">
				</td>				
				</tr>
				<tr id="tr_lignes_reglement" >
				<!--------Lignes en affichage dynamique en fonction du nombre de règlements -------->
				<td colspan="4">
				<div id="div_lignes_reglement_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>">
				<table id="tb_liste_regl" >
						<tr class="smallheight">
						<td style="width:25%"><strong>Echéance</strong></td>
						<td style="width:20%;text-align:center"><strong>Type d'échéance</strong></td>
						<td style="width:20%;text-align:center"><strong>Mode de règlement</strong></td>
						<td style="width:20%;text-align:center"><strong>Délai</strong></td>
						<td style="width:15%;text-align:center"><strong>Montant</strong></td>
						</tr>
					<?php $i = 1;
					$echTot = count($modele_echeancier->getEcheances());
					 foreach($modele_echeancier->getEcheances() as $echeance){?>					
							<tr>
							<td><?php echo $i;?><sup>e</sup> échéance : </td>
							<td style="text-align:center">
							<select name="slct_type_<?php echo $i;?>" id="slct_type_<?php echo $i;?>" style="width:100px">
							<?php if($i==1 && $echTot> 1){?>
							<option value="Acompte" <?php if($echeance['type_reglement'] == "Acompte"){echo "selected='selected'";}?>>Acompte</option>
							<option value="Arrhes" <?php if($echeance['type_reglement'] == "Arrhes"){echo "selected='selected'";}?>>Arrhes</option>
							<option value="Echeance" <?php if($echeance['type_reglement'] == "Echeance"){echo "selected='selected'";}?>>Echeance</option>
							<?php } ?>
							<?php if($i==1 && $echTot== 1){?>
							<option value="Acompte" <?php if($echeance['type_reglement'] == "Acompte"){echo "selected='selected'";}?>>Acompte</option>
							<option value="Arrhes" <?php if($echeance['type_reglement'] == "Arrhes"){echo "selected='selected'";}?>>Arrhes</option>
							<option value="Solde" <?php if($echeance['type_reglement'] == "Solde"){echo "selected='selected'";}?>>Solde</option>
							<?php } ?>
							<?php if($i!=1 && $i!=$echTot && $echTot> 1){?>
							<option value="Echeance" <?php if($echeance['type_reglement'] == "Echeance"){echo "selected='selected'";}?>>Echeance</option>							
							<?php } ?>
							<?php if($i==$echTot && $echTot > 1){?>
							<option value="Solde" <?php if($echeance['type_reglement'] == "Solde"){echo "selected='selected'";}?>>Solde</option>							
							<?php } ?>
							</select></td>
							<td style="text-align:center"><select name="slct_mode_<?php echo $i;?>" id="slct_mode_<?php echo $i;?>" style="width:160px">
                                                        <option value="">Au choix du client</option>
							<?php foreach ($reglements_modes as $reglement_mode) {?>
							<option value="<?php echo $reglement_mode->id_reglement_mode; ?>" <?php if($echeance['id_mode_reglement'] == $reglement_mode->id_reglement_mode){echo "selected='selected'";}?> >
							<?php echo htmlentities($reglement_mode->lib_reglement_mode); ?></option>
							<?php } ?></select></td>
							<td style="text-align:center"><input name="inp_delai_<?php echo $i;?>" id="inp_delai_<?php echo $i;?>" type="text" value="<?php echo $echeance['jour'];?>" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> jours</td>
							<?php if($i!=$echTot){?>
								<td style="text-align:center"><input name="inp_montant_<?php echo $i;?>" id="inp_montant_<?php echo $i;?>" type="text" value="<?php echo $echeance['pourcentage'];?>" onKeyUp="maj_mnt_solde('div_lignes_reglement_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>',<?php echo $echTot;?>)" class="classinput_xsize" style="width:30px" MAXLENGTH="3"/> %</td>
							<?php }else {?>
								<td style="text-align:center"><input name="inp_montant_<?php echo $i;?>" id="inp_montant_<?php echo $i;?>" type="text" value="<?php echo $echeance['pourcentage'];?>" class="classinput_xsize" style="width:30px" MAXLENGTH="3" readonly="readonly"/> %</td>
							<?php }?>
							</tr>
					<?php $i++;}?>
					</table>
					</div>	
				</td>
				<td style="height: 100%;">
					<input name="modifier" id="modifier" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
				</td>
				</tr>
				</table>
				</form>
				</td>
				<td style="width:55px; text-align:center">
				<form action="compta_modeles_echeanciers_sup.php" method="post" id="compta_modeles_echeanciers_sup_<?php echo $modele_echeancier->getId_echeancier_modele();?>" name="compta_modeles_echeanciers_sup_<?php echo $modele_echeancier->getId_echeancier_modele();?>" target="formFrame">
					<input name="id_mod_ech" id="id_mod_ech" type="hidden" value="<?php echo $modele_echeancier->getId_echeancier_modele();?>" />
				</form>
				<a href="#" id="link_compta_modeles_echeanciers_sup_<?php echo $modele_echeancier->getId_echeancier_modele();?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
				</td>
				<script type="text/javascript">
				Event.observe("link_compta_modeles_echeanciers_sup_<?php echo $modele_echeancier->getId_echeancier_modele();?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('compta_modeles_echeanciers_sup', "compta_modeles_echeanciers_sup_<?php echo $modele_echeancier->getId_echeancier_modele();?>");}, false);
				</script>			
			</tr>
			</table>					
	</div>
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>	
	<?php } ?>
<?php } ?>					

</div>
</td>
</tr>
</table>	
</div>
<script type="text/javascript">

</script>
<span id="spacer" >&nbsp;</span>
