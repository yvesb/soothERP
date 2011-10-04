<?php

// *************************************************************************************************************
// CONFIG DES DONNEES des documents
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
tableau_smenu[1] = Array('configuration_docs_infos_lines','configuration_docs_infos_lines.php',"true" ,"sub_content", "Lignes d'informations prédéfinies");
update_menu_arbo();
</script>
<div class="emarge">
<p class="titre">Modèles de lignes d'information à insérer dans vos documents commerciaux</p>

<div class="contactview_corps" style="padding:5px">

<form action="configuration_docs_infos_lines_add.php" enctype="multipart/form-data" method="POST"  id="configuration_docs_infos_lines_add" name="configuration_docs_infos_lines_add" target="formFrame" >

<table width="100%" class="titre_config">
	<tr class="smallheight">
		<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td style="font-weight:bolder">Libellé de la ligne </td>
		<td style="font-weight:bolder">Description de la ligne </td>
		<td style="font-weight:bolder">Description interne</td>
		<td style="font-weight:bolder">Documents concernés</td>
	</tr>
	<tr>
		<td>
		<input type="text" value="" id="lib_line" name="lib_line" class="classinput_xsize"/>
		</td>
		<td>
		<textarea id="desc_line" name="desc_line" class="classinput_xsize" rows="6" ></textarea>
		</td>
		<td>
		<textarea id="desc_line_interne" name="desc_line_interne" class="classinput_xsize" rows="6"  ></textarea>
		</td>
		<td>
			<select name="id_type_doc[]" id="id_type_doc[]" class="classinput_xsize" multiple="multiple" size="6" />
				
			<?php 
			$doc_clients = true;
			$doc_fournisseurs = true;
			$doc_stock = true;
			
			foreach ($types_liste as $type_liste) {
				if ( $type_liste->id_type_doc == 10) {continue;}
				if ( $type_liste->id_type_groupe == 1 && $doc_clients) { ?>
				<optgroup label="Documents clients"></optgroup>
				<?php $doc_clients = false;
				}
				if ( $type_liste->id_type_groupe == 2 && $doc_fournisseurs) {?>
				<optgroup label="Documents fournisseurs"></optgroup>
				<?php $doc_fournisseurs = false;
				}
				if ( $type_liste->id_type_groupe == 3 && $doc_stock) { ?>
				<optgroup label="Documents stock"></optgroup>
				<?php $doc_stock = false;
				} ?>
				<option value="<?php echo $type_liste->id_type_doc;?>" ><?php echo htmlentities($type_liste->lib_type_doc);?></option>
				<?php 
			}
			?>
			</select>
		<p style="text-align:center">
			<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
		</p>
		</td>
	</tr>
</table>
</form>

<br />

<?php
foreach ($liste_modeles as $modele) { ?>
<form action="configuration_docs_infos_lines_maj.php" enctype="multipart/form-data" method="POST"  id="configuration_docs_infos_lines_maj_<?php echo $modele->id_doc_info_line;?>" name="configuration_docs_infos_lines_maj_<?php echo $modele->id_doc_info_line;?>" target="formFrame" >
<input type="hidden" value="<?php echo $modele->id_doc_info_line;?>" id="id_doc_info_line" name="id_doc_info_line"/>
<table width="100%" class="titre_config">
	<tr class="smallheight">
		<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td>
		<input type="text" value="<?php echo $modele->lib_line;?>" id="lib_line_<?php echo $modele->id_doc_info_line;?>" name="lib_line_<?php echo $modele->id_doc_info_line;?>" class="classinput_xsize"/>
		</td>
		<td>
		<textarea id="desc_line_<?php echo $modele->id_doc_info_line;?>" name="desc_line_<?php echo $modele->id_doc_info_line;?>" class="classinput_xsize" size="6" ><?php echo $modele->desc_line;?></textarea>
		</td>
		<td>
		<textarea id="desc_line_interne_<?php echo $modele->id_doc_info_line;?>" name="desc_line_interne_<?php echo $modele->id_doc_info_line;?>" class="classinput_xsize" size="6" ><?php echo $modele->desc_line_interne;?></textarea>
		</td>
		<td>
			<select name="id_type_doc_<?php echo $modele->id_doc_info_line;?>[]" id="id_type_doc_<?php echo $modele->id_doc_info_line;?>[]" class="classinput_xsize" multiple="multiple" size="6" />
				
			<?php
			$tmp_id_type = explode(";", $modele->id_type_doc);
                        $doc_clients = true;
			$doc_fournisseurs = true;
			$doc_stock = true;

                        foreach ($types_liste as $type_liste) {
				if ( $type_liste->id_type_doc == 10) {continue;}
				if ( $type_liste->id_type_groupe == 1 && $doc_clients) { ?>
				<optgroup label="Documents clients"></optgroup>
				<?php $doc_clients = false;
				}
				if ( $type_liste->id_type_groupe == 2 && $doc_fournisseurs) {?>
				<optgroup label="Documents fournisseurs"></optgroup>
				<?php $doc_fournisseurs = false;
				}
				if ( $type_liste->id_type_groupe == 3 && $doc_stock) { ?>
				<optgroup label="Documents stock"></optgroup>
				<?php $doc_stock = false;
				} ?>
                                <option value="<?php echo $type_liste->id_type_doc;?>" <?php if (in_array($type_liste->id_type_doc, $tmp_id_type)) {?>selected="selected"<?php } ?> ><?php echo htmlentities($type_liste->lib_type_doc);?></option>
				<?php
			}
			?>
			</select>
		<div style="text-align:right; vertical-align: top; line-height:18px; height:18px; padding-top: 10px">
			<img id="supprimer_<?php echo $modele->id_doc_info_line;?>"  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-supprimer.gif" style="float:right" />
			<input name="modifier_<?php echo $modele->id_doc_info_line;?>" id="modifier_<?php echo $modele->id_doc_info_line;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif"  />&nbsp;&nbsp;&nbsp;
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="3"> </td>
	</tr>
</table>
</form>

<form action="configuration_docs_infos_lines_del.php" enctype="multipart/form-data" method="POST"  id="configuration_docs_infos_lines_del_<?php echo $modele->id_doc_info_line;?>" name="configuration_docs_infos_lines_del_<?php echo $modele->id_doc_info_line;?>" target="formFrame" >
<input type="hidden" value="<?php echo $modele->id_doc_info_line;?>" id="id_doc_info_line" name="id_doc_info_line"/>
</form>
<script type="text/javascript">
Event.observe("supprimer_<?php echo $modele->id_doc_info_line;?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('configuration_docs_infos_lines_del', 'configuration_docs_infos_lines_del_<?php echo $modele->id_doc_info_line;?>');}, false);

</script>

<br />
<?php } ?>
</div>
</div>
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>