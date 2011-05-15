<?php

// *************************************************************************************************************
// CNOFIG DES DONNEES pdf
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
tableau_smenu[0] = Array("smenu_entreprise", "smenu_entreprise.php" ,"true" ,"sub_content", "Entreprise");
tableau_smenu[1] = Array('configuration_pdf','configuration_pdf.php',"true" ,"sub_content", "Documents commerciaux - Paramètres généraux");
update_menu_arbo();
</script>
<div class="emarge">
<p class="titre">Documents commerciaux - Paramètres généraux</p>


<div class="contactview_corps">
<form action="configuration_pdf_maj.php" enctype="multipart/form-data" method="POST"  id="configuration_pdf_maj" name="configuration_pdf_maj" target="formFrame" >

<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:26%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:39%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>	
	<tr>
		<td class="titre_config" colspan="3">Image affich&eacute;e en ent&ecirc;te des documents:		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Ent&ecirc;te de vos documents:		<br />
			<a href="<?php echo $IMAGES_DIR.$DOCUMENTS_IMG_LOGO;?>" target="_blank" style="font-weight:normal; color:#000000">voir l'ent&ecirc;te actuelle</a> </td>
		<td>
		<input type="file" accept="image/*" size="35" name="image"    class="classinput_nsize" />		</td>
		<td class="infos_config">Cette image sera utilisée sur les documents imprimés au format pdf (factures, devis, etc...), nous vous recommandons d'utiliser une image sur fond blanc de taille 1000 pixels par 1000 pixels maximum format  jpg.		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="titre_config" colspan="3">Informations affichées en bas de page des documents au format pdf :		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Bas de page, première ligne gauche:		</td>
		<td>
		<input id="pied_de_page_gauche_0" name="pied_de_page_gauche_0" value="<?php echo  str_replace("€", "&euro;", htmlentities($PIED_DE_PAGE_GAUCHE_0)); ?>" type="text" class="classinput_xsize" maxlength="70" />		</td>
		<td class="infos_config">Indiquez le nom de l'entreprise, son capital et son adresse.		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Bas de page, deuxième ligne gauche:		</td>
		<td>
		<input id="pied_de_page_gauche_1" name="pied_de_page_gauche_1" value="<?php echo str_replace("€", "&euro;", htmlentities($PIED_DE_PAGE_GAUCHE_1)); ?>" type="text" class="classinput_xsize" maxlength="70" />		</td>
		<td class="infos_config">Indiquez le numéro de Siret, de TVA intracommunautaire et le code APE de l'entreprise.		</td>
	</tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Bas de page, première ligne droite:		</td>
		<td>
		<input id="pied_de_page_droit_0" name="pied_de_page_droit_0" value="<?php echo str_replace("€", "&euro;", htmlentities($PIED_DE_PAGE_DROIT_0)); ?>" type="text" class="classinput_xsize" maxlength="70" />		</td>
		<td class="infos_config">Indiquez l'adresse Internet ou autres informations.		</td>
	</tr>
	<tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Bas de page, deuxième ligne droite:		</td>
		<td>
		<input id="pied_de_page_droit_1" name="pied_de_page_droit_1" value="<?php echo str_replace("€", "&euro;", htmlentities($PIED_DE_PAGE_DROIT_1)); ?>" type="text" class="classinput_xsize" maxlength="70" />		</td>
		<td class="infos_config">Indiquez l'adresse Email ou autres informations.		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>	<tr>
		<td class="titre_config" colspan="3">Paramètres utilisés dans les documents:		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Utilisation de remises dans les documents </td>
		<td>
		
		<input id="aff_remises" name="aff_remises" value="1" type="checkbox" <?php if ($AFF_REMISES) { ?>checked="checked"<?php } ?> />
		</td>
		<td class="infos_config">Permet d'effectuer une remise sur un ou plusieurs articles dans un document. </td>
	</tr>
	
<!--style="width:35%" style="width:30%"-->
	<tr class="smallheight">
		<td ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>	
	<tr>
		<td class="titre_config" colspan="3">Définition de délais :	</td>
	</tr>	
	<tr>
		<td colspan="2"> </td>
	</tr>
		<tr>
		<td class="lib_config">Délai pour devis client récent:		</td>
		<td>
		<input id="delai_devis_client_recent" name="delai_devis_client_recent" value="<?php echo $DELAI_DEVIS_CLIENT_RECENT;?>" type="text" size="4" class="classinput_nsize" maxlength="60" />	jours	</td>
		<td class="infos_config">Délai pendant lequel un devis client est "récent"</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	</tr>
		<tr>
		<td class="lib_config">Délai pour devis client périmé:		</td>
		<td>
		<input id="delai_devis_client_perime" name="delai_devis_client_perime" value="<?php echo $DELAI_DEVIS_CLIENT_RETARD;?>" type="text" size="4" class="classinput_nsize" maxlength="60" />	jours	</td>
		<td class="infos_config">Délai pendant lequel un devis client est "périmé"</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Délai pour commande client récente:		</td>
		<td>
		<input id="delai_commande_client_recente" name="delai_commande_client_recente" value="<?php echo $DELAI_COMMANDE_CLIENT_RECENTE;?>" type="text" size="4" class="classinput_nsize" maxlength="60" />	jours	</td>
		<td class="infos_config">Délai pendant lequel une commande client est "récente"</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Délai pour commande client en retard:		</td>
		<td>
		<input id="delai_commande_client_retard" name="delai_commande_client_retard" value="<?php echo $DELAI_COMMANDE_CLIENT_RETARD;?>" type="text" size="4" class="classinput_nsize" maxlength="60" />	jours	</td>
		<td class="infos_config">Délai après lequel une commande client est "en retard"</td>
	</tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Délai pour commande fournisseur récente:		</td>
		<td>
		<input id="delai_commande_fournisseur_recente" name="delai_commande_fournisseur_recente" value="<?php echo $DELAI_COMMANDE_FOURNISSEUR_RECENTE;?>" type="text" size="4" class="classinput_nsize" maxlength="60" />	jours	</td>
		<td class="infos_config">Délai pendant lequel une commande fournisseur est "récente"</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td class="lib_config">Délai pour commande fournisseur en retard:		</td>
		<td>
		<input id="delai_commande_fournisseur_retard" name="delai_commande_fournisseur_retard" value="<?php echo $DELAI_COMMANDE_FOURNISSEUR_RETARD;?>" type="text" size="4" class="classinput_nsize" maxlength="60" />	jours	</td>
		<td class="infos_config">Délai après lequel une commande fournisseur est "en retard"</td>
	</tr>
		<td colspan="3"> </td>
	</tr>

</table>
<p style="text-align:center">
	<input name="valider" id="valider" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
</p>
</form>


<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:26%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:39%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>	
	<tr>
		<td class="titre_config" colspan="3">Filigranes d'arrière plan des documents:	</td>
	</tr>
<?php
$ordre=1;
foreach ($liste_filigranes as $fili) {
	?>
	<tr>
		<td class="lib_config"> </td>
		<td colspan="2">
		
		<table border="0" cellpadding="0" cellspacing="0" style="">
			<tr>
				<td style="width:80%">
				<form  action="configuration_pdf_fili_maj.php" enctype="multipart/form-data" method="POST"  id="configuration_pdf_maj_<?php echo addslashes($fili->id_filigrane);?>" name="configuration_pdf_maj_<?php echo addslashes($fili->id_filigrane);?>" target="formFrame"  >
				<input id="id_filigrane" name="id_filigrane" value="<?php echo $fili->id_filigrane;?>" type="hidden"/>
				<input id="lib_filigrane_<?php echo addslashes($fili->id_filigrane);?>" name="lib_filigrane_<?php echo addslashes($fili->id_filigrane);?>" value="<?php echo $fili->lib_filigrane;?>" type="text" class="classinput_hsize" maxlength="70" style="width:310px"/>
				
				<input name="modifier_<?php echo addslashes($fili->id_filigrane);?>" id="modifier_<?php echo addslashes($fili->id_filigrane);?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
				</form>
				</td>
				<td style="width:5%">
				<form method="post" action="configuration_pdf_fili_sup.php" id="configuration_pdf_fili_sup_<?php echo $fili->id_filigrane; ?>" name="configuration_pdf_fili_sup_<?php echo $fili->id_filigrane; ?>" target="formFrame">
				<input name="id_filigrane"  type="hidden" value="<?php echo $fili->id_filigrane; ?>" />
				<input name="ordre"  type="hidden" value="<?php echo $fili->ordre; ?>" />
				</form>
				<a href="#" id="configuration_pdf_fili_bt_sup_<?php echo $fili->id_filigrane; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
				<script type="text/javascript">
				Event.observe("configuration_pdf_fili_bt_sup_<?php echo $fili->id_filigrane; ?>", "click",  function(evt){Event.stop(evt); $("configuration_pdf_fili_sup_<?php echo $fili->id_filigrane; ?>").submit();
				}, false);
				</script>
				
				</td>
				<td style="width:5%">
			
				<table border="0" cellpadding="0" cellspacing="0" style="">
					<tr>
						<td>
						<div id="up_arrow_<?php echo $fili->id_filigrane; ?>">
						<?php
						if ($fili->ordre!=1) {
						?>
						<form action="configuration_pdf_fili_ordre.php" method="post" id="configuration_pdf_fili_ordre_up_<?php echo $fili->id_filigrane; ?>" name="configuration_pdf_fili_ordre_up_<?php echo $fili->id_filigrane; ?>" target="formFrame">
							<input name="new_ordre" type="hidden" value="<?php echo ($fili->ordre)-1?>" />
							<input name="old_ordre" type="hidden" value="<?php echo ($fili->ordre)?>" />
							<input name="id_filigrane" type="hidden" value="<?php echo $fili->id_filigrane; ?>" />	
							<input name="modifier_ordre_<?php echo $fili->id_filigrane; ?>" id="modifier_ordre_<?php echo $fili->id_filigrane; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/up.gif">
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
						
						<div id="down_arrow_<?php echo $fili->id_filigrane; ?>">
						<?php
						if ($fili->ordre != count ($liste_filigranes)) {
						?>
						<form action="configuration_pdf_fili_ordre.php" method="post" id="configuration_pdf_fili_ordre_<?php echo $fili->id_filigrane; ?>" name="configuration_pdf_fili_ordre_<?php echo $fili->id_filigrane; ?>" target="formFrame">
							<input name="new_ordre" type="hidden" value="<?php echo ($fili->ordre)+1?>" />
							<input name="old_ordre" type="hidden" value="<?php echo ($fili->ordre)?>" />
							<input name="id_filigrane" type="hidden" value="<?php echo $fili->id_filigrane; ?>" />	
							<input name="modifier_ordre_<?php echo $fili->id_filigrane; ?>" id="modifier_ordre_<?php echo $fili->id_filigrane; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/down.gif">
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
		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<?php
	$ordre = $fili->ordre;
}
?>
	<tr>
		<td class="lib_config"> </td>
		<td colspan="2">
		<form  action="configuration_pdf_fili_add.php" enctype="multipart/form-data" method="POST"  id="configuration_pdf_add" name="configuration_pdf_add" target="formFrame"  >
		<input id="lib_filigrane" name="lib_filigrane" value="" type="text" class="classinput_hsize" maxlength="70"/>
		<input type="hidden" name="ordre_fili" value="<?php echo $ordre+1;?>"/>
		
		<input name="ajouter_fili" id="ajouter_fili" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
		</form>
		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
</table>

	
<table width="100%">
	<tr class="smallheight">
		<td style="width:35%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:26%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:39%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>	
	<tr>
		<td class="titre_config" colspan="3">Ajout d'un nouveau modèle d'impression PDF:	</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
	<tr>
		<td colspan="3">
		
<form action="configuration_pdf_add.php" enctype="multipart/form-data" method="POST"  id="configuration_pdf_add" name="configuration_pdf_add" target="formFrame" >
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width:35%" class="lib_config">Type de document concerné : </td>
				<td style="width:26%">
					<select name="id_type_doc" id="choix_type_doc" class="classinput_xsize">
						<option value=""></option>
					<?php 
					foreach ($liste_type_docs as $type_doc) {
						?>
						<option value="<?php echo $type_doc->id_type_doc;?>"><?php echo $type_doc->lib_type_doc;?></option>
						<?php
					}
					?>
					</select>
				</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none" id="step1_a">
			<tr>
				<td style="width:35%" class="lib_config">Création de ce modèle </td>
				<td style="width:26%">
					à partir d'un modèle existant
				</td>
				<td style="text-align:left"><input type="radio" name="choix_source" id="exist_model" value="1" /></td>
			</tr>
			<tr>
				<td> </td>
				<td>
					à partir des fichiers programme
				</td>
				<td style="text-align:left"><input type="radio" name="choix_source" id="new_model" value="2" /></td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none" id="step2_a">
			<tr>
				<td style="width:35%" class="lib_config">Nouveau nom de ce modèle: </td>
				<td style="width:26%">
					<input type="text" name="lib_modele" id="lib_modele" value="" class="classinput_xsize" />
				</td>
				<td class="infos_config">&nbsp;Ex : Facture Client XXX;</td>
			</tr>
			<tr>
				<td class="lib_config">Description de ce modèle: </td>
				<td>
					<textarea name="desc_modele" id="desc_modele" class="classinput_xsize" ></textarea>
				</td>
				<td class="infos_config">&nbsp;Ex : Facture avec RIB</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none" id="step2_b">
			<tr>
				<td style="width:35%" class="lib_config">Modèle source:  </td>
				<td style="width:26%">
					<select name="id_pdf_modele" id="choix_id_pdf_modele" class="classinput_xsize">
					<?php 
					foreach ($liste_pdf_modeles as $pdf_modele) {
						?>
						<option value="<?php echo $pdf_modele->id_pdf_modele;?>"><?php echo $pdf_modele->lib_modele;?></option>
						<?php
					}
					?>
					</select>
				</td>
				<td></td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none" id="step2_c">
			<tr>
				<td style="width:35%" class="lib_config">Fichiers de programme: </td>
				<td style="width:26%">
					<input type="file" name="file_1" id="file_1" value="" class="classinput_nsize" size="35" />
				</td>
				<td class="infos_config">&nbsp;Indiquez l'emplacement du fichier de configuration</td>
			</tr>
			<tr>
				<td> </td>
				<td>
					<input type="file" name="file_2" id="file_2" value="" class="classinput_nsize" size="35" />
				</td>
				<td class="infos_config">&nbsp;Indiquez l'emplacement du fichier de classe</td>
			</tr>
		</table>

<p style="text-align:center">
	<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" style="display:none" />
</p>
</form>
		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
</table>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />

		

</div>
<SCRIPT type="text/javascript">
				 Event.observe('choix_type_doc', "change" , function(evt){
				 	if ($("choix_type_doc").value != "") {
				 		$("step1_a").show();
					} else {
				 		$("step1_a").hide();
				 		$("step2_a").hide();
				 		$("step2_b").hide();
				 		$("step2_c").hide();
					}
				 } , false);
				 Event.observe('exist_model', "click" , function(evt){
				 	$("step2_a").show();
				 	$("step2_b").show();
				 	$("step2_c").hide();
					$("ajouter").show();
				 } , false);
				 Event.observe('new_model', "click" , function(evt){
				 	$("step2_a").show();
				 	$("step2_b").hide();
				 	$("step2_c").show();
					$("ajouter").show();
				 } , false);
//on masque le chargement
H_loading();
</SCRIPT>