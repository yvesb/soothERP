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
tableau_smenu[1] = Array('compta_exercices','compta_exercices.php','true','sub_content', "Gestion des exercices comptables");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Gestion des exercices comptables</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div id="cat_client" style="padding-left:10px; padding-right:10px">


	<?php 
if ($liste_exercices) {
	?>
<p>Exercices comptables </p>
	<?php
	$i = 0;
	foreach ($liste_exercices as $exercice) {
		?>
		<div class="caract_table">
			<table>
			<tr>
				<td style="width:95%">
				<?php
				if ($exercice->date_fin < date("Y-m-d") && ((isset($liste_exercices[$i+1]) && !$liste_exercices[$i+1]->etat_exercice) || !isset($liste_exercices[$i+1]))) {
					?>
				<form method="post" action="compta_exercices_cloture.php" id="compta_exercice_cloture_<?php echo $exercice->id_exercice; ?>" name="compta_exercice_cloture_<?php echo $exercice->id_exercice; ?>" target="formFrame">
					<input name="id_exercice" id="id_exercice" type="hidden" value="<?php echo $exercice->id_exercice; ?>" />
				</form>
					<?php
				}
				?>
					<form action="compta_exercices_mod.php" method="post" id="compta_exercice_mod_<?php echo $exercice->id_exercice;?>" name="compta_exercice_mod_<?php echo $exercice->id_exercice;?>" target="formFrame" >
					<table>
						<tr class="smallheight">
							<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>	
						<tr>
							<td style="text-align:left">
							<?php
							if (!$exercice->etat_exercice) {
								?>
								Clôturé
								<?php
							} else {
								if ($exercice->date_fin >= date("Y-m-d")) {
									?>
									En cours
									<?php
								} else {
									?>
									Non clôturé
									<?php
									if ((isset($liste_exercices[$i+1]) && !$liste_exercices[$i+1]->etat_exercice) || !isset($liste_exercices[$i+1])) {
										?>
										<!--<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_compta_cloturer.gif"  id="cloturer" style="cursor:pointer"/>
										<script type="text/javascript">
										Event.observe("cloturer", "click",  function(evt){
											Event.stop(evt);
											alerte.confirm_supprimer('compta_exercice_cloture', 'compta_exercice_cloture_<?php echo $exercice->id_exercice; ?>');
										}, false);
										</script>-->
										<?php
									}
								}
							}
							$i++;
							?>
							</td>
							<td style="text-align:right">Libell&eacute;:
							</td>
							<td>
							<input name="id_exercice" id="id_exercice" type="hidden" value="<?php echo $exercice->id_exercice; ?>" />
							<input name="lib_exercice_<?php echo $exercice->id_exercice;?>" id="lib_exercice_<?php echo $exercice->id_exercice;?>" type="text" value="<?php echo htmlentities($exercice->lib_exercice);?>"  class="classinput_xsize" <?php 
							if (!$exercice->etat_exercice) {
							?> disabled="disabled" <?php }?>/>
							</td>
							<td style="text-align:right">
							Du <?php echo date_Us_to_Fr($exercice->date_debut);?>
							</td>
							<td> au 
							<input name="date_fin_<?php echo $exercice->id_exercice;?>" id="date_fin_<?php echo $exercice->id_exercice;?>" type="text" value="<?php echo date_Us_to_Fr($exercice->date_fin);?>"  class="classinput_lsize" <?php 
							if (!$exercice->etat_exercice) {
							?> disabled="disabled" <?php }?>/>	</td>
							<td style="text-align:center">
							<input name="modifier_<?php echo $exercice->id_exercice;?>" id="modifier_<?php echo $exercice->id_exercice;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif"<?php 
							if (!$exercice->etat_exercice) {
							?> disabled="disabled" style="display:none"<?php }?>/>
							</td>
						</tr>
					</table>
					</form>
				</td>
				<td style="width:55px; text-align:center">
				<form method="post" action="compta_exercices_sup.php" id="compta_exercice_sup_<?php echo $exercice->id_exercice; ?>" name="compta_exercice_sup_<?php echo $exercice->id_exercice; ?>" target="formFrame">
					<input name="id_exercice" id="id_exercice" type="hidden" value="<?php echo $exercice->id_exercice; ?>" />
				</form>
				<a href="#" id="link_compta_exercice_sup_<?php echo  $exercice->id_exercice; ?>" <?php 
							if (!$exercice->etat_exercice) {
							?> style="display:none" <?php }?>><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
				<script type="text/javascript">
				Event.observe("link_compta_exercice_sup_<?php echo $exercice->id_exercice; ?>", "click",  function(evt){
					Event.stop(evt);
					alerte.confirm_supprimer('compta_exercice_sup', 'compta_exercice_sup_<?php echo $exercice->id_exercice; ?>');
				}, false);
				
				
				Event.observe("date_fin_<?php echo $exercice->id_exercice;?>", "blur", function(evt){
					datemask(evt);
				}, false);
				</script>
				
				</td>
			</tr>
		</table>
		</div>
		<?php 
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


//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>