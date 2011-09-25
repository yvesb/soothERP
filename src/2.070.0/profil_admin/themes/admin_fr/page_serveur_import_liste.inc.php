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
tableau_smenu[0] = Array("smenu_transfert_donnees", "smenu_transfert_donnees.php" ,"true" ,"sub_content", "Transfert de données");
tableau_smenu[1] = Array('serveur_import_liste','serveur_import_liste.php','true','sub_content', "Gestion des serveurs d'import");
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Gestion des serveurs d'import </p>

<div>
<strong>Ajouter un nouveau serveur </strong>
	<table class="caract_table">
		<tr class="smallheight">
			<td>
				<form action="serveur_import_add.php" method="post" id="import_serveur_add" name="import_serveur_add" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:4%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:190px">Référence du serveur: </td>
						<td style="width:190px">Libellé du serveur: </td>
						<td colspan="2">URL du serveur: (http://www.site.com/)</td>
					</tr>	
					<tr>
						<td>
						</td>
						<td>
						<input name="ref_serveur_import" id="ref_serveur_import" type="text" value=""  class="classinput_xsize"/>
						</td>
						<td>
						<input name="lib_serveur_import" id="lib_serveur_import" type="text" value=""  class="classinput_xsize"/>
						</td>
						<td  style="width:190px">
						<input name="url_serveur_import" id="url_serveur_import" type="text" value=""  class="classinput_xsize" />
						</td>
						<td style="width:width:190px"> 
						<span id="verifier_serveur" style="cursor:pointer">Verifier les types d'imports disponibles sur ce serveur</span>
						<SCRIPT type="text/javascript">
				Event.observe("verifier_serveur", "click",  function(evt){
					Event.stop(evt); 
					url_to_send = $("url_serveur_import").value+"<?php echo $ECHANGE_LMB_DIR;?>/serveur_export_partage_liste.php?url="+document.URL.replace("/profil_admin/serveur_import_liste.php", "");
					
					//window.open($("url_serveur_import").value+"<?php echo $ECHANGE_LMB_DIR;?>/serveur_export_partage_liste.php?url="+document.URL.replace("/profil_admin/serveur_import_liste.php"), "formFrame");
					//var AppelAjax = new Ajax.Request(
//									$("url_serveur_import").value+"<?php echo $ECHANGE_LMB_DIR;?>serveur_export_partage_liste.php",
//									{
//									method: 'post',
//									asynchronous: true,
//									contentType:  'application/x-www-form-urlencoded',
//									encoding:     'UTF-8',
//									parameters: { url: ""},
//									evalScripts:true, 
//									onFailure: function (){$("url_serveur_import").style.backgroundColor  = "#FF000";},
//									onException: function (requester){
//										alert(requester.responseText);;
//										$("url_serveur_import").style.backgroundColor  = "#FF0000";}, 
//									onSuccess:function (){
//										$("url_serveur_import").style.backgroundColor  = "#FFFFFF";
										window.open(url_to_send, "formFrame");
//										}							
//									}
//									);
				}, false);
				</SCRIPT>
						
						</td>

					</tr>
					<tr>
						<td colspan="5" id="show_impex">
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td>
				<div style="text-align:left; width:35px">
				</div>
			</td>
		</tr>
	</table>
</div><br />

<div>
<?php 
if (count($liste_serveurs_import)) {
	?>
	<strong>Liste des serveurs</strong>
	<table class="caract_table" >
	<?php 
	foreach ($liste_serveurs_import as $serveur_import) {
		?>
		<tr class="smallheight">
			<td>
				<form action="serveur_import_mod.php" method="post" id="import_serveur_mod_<?php echo $serveur_import->ref_serveur_import;?>" name="import_serveur_mod_<?php echo $serveur_import->ref_serveur_import;?>" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:6%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:190px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:190px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:190px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						
						</td>
						<td><?php echo htmlentities($serveur_import->ref_serveur_import);?>
						<input name="ref_serveur_import" id="ref_serveur_import" type="hidden" value="<?php echo htmlentities($serveur_import->ref_serveur_import);?>"  class="classinput_xsize"/>
						<input name="old_ref_serveur" id="old_ref_serveur" type="hidden" value="<?php echo htmlentities($serveur_import->ref_serveur_import);?>"  class="classinput_xsize"/>
						</td>
						<td><?php echo ($serveur_import->lib_serveur_import);?>
						<input name="lib_serveur_import" id="lib_serveur_import" type="hidden" value="<?php echo ($serveur_import->lib_serveur_import);?>"  class="classinput_xsize"/>
						</td>
						<td><?php echo htmlentities($serveur_import->url_serveur_import);?>
						<input name="url_serveur" id="url_serveur" type="hidden" value="<?php echo htmlentities($serveur_import->url_serveur_import);?>"  class="classinput_xsize"/>
						</td>
						<td style="width:1px">
							<div style="text-align:right; display:none">
							<input name="modifier_<?php echo $serveur_import->ref_serveur_import;?>" id="modifier_<?php echo $serveur_import->ref_serveur_import;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
							</div>
						</td>
					</tr>
				</table>
				</form>
	<table style="width:100%;">
		<tr>
			<td colspan="3">
				Types d'imports :
			</td>
		</tr>
		<?php
		foreach ($liste_import_types as $import_type) {
			?>
			<tr>
				<td style="width:190px">
					<?php echo $import_type->lib_impex_type;?> :
				</td>
				<td style="text-align:center; width:55px">
					<input name="id_impex_type_<?php echo $import_type->id_impex_type ;?>" id="id_impex_type_<?php echo $import_type->id_impex_type ;?>" type="checkbox" value="<?php echo $import_type->id_impex_type ;?>" <?php if (isset($serveur_import->import_types[$import_type->id_impex_type])) {echo 'checked="checked"';}?>/>
					
					
				<SCRIPT type="text/javascript">
				Event.observe('id_impex_type_<?php echo $import_type->id_impex_type ;?>', 'click',  function(evt){
				if ($('id_impex_type_<?php echo $import_type->id_impex_type ;?>').checked) {
					maj_import_type( "<?php echo $serveur_import->ref_serveur_import;?>", "<?php echo $import_type->id_impex_type ;?>", 1);
				} else {
					maj_import_type( "<?php echo $serveur_import->ref_serveur_import;?>", "<?php echo $import_type->id_impex_type ;?>", 0);
				}
				}, false);
				</SCRIPT>
				</td>
				<td style="text-align:left"> 
				<?php if (isset($serveur_import->import_types[$import_type->id_impex_type])) {?> 
				<a href="#" id="choix_serveur_<?php echo $serveur_import->ref_serveur_import;?>_<?php echo $import_type->id_impex_type ;?>">
					Mettre à jour / importer les données
				</a>
					
				<SCRIPT type="text/javascript">
				
					Event.observe("choix_serveur_<?php echo $serveur_import->ref_serveur_import;?>_<?php echo $import_type->id_impex_type ;?>", "click", function(evt){
						Event.stop(evt);
						page.traitecontent('serveur_import_data_<?php echo $import_type->id_impex_type ;?>','serveur_import_data_<?php echo $import_type->id_impex_type ;?>.php?ref_serveur=<?php echo htmlentities($serveur_import->ref_serveur_import);?>','true','sub_content');
					}, false);	
				</SCRIPT>
				<?php }?>
				</td>
				
			</tr>
		<?php
	}
	?>
	</table>
			</td>
			<td>
				<div style="text-align:left; width:35px">
				<form action="serveur_import_sup.php" method="post" id="import_serveur_sup_<?php echo $serveur_import->ref_serveur_import;?>" name="import_serveur_sup_<?php echo $serveur_import->ref_serveur_import;?>" target="formFrame" >
						<input name="ref_serveur" id="ref_serveur" type="hidden" value="<?php echo htmlentities($serveur_import->ref_serveur_import);?>"/>
							<input name="supprimer_<?php echo $serveur_import->ref_serveur_import;?>" id="supprimer_<?php echo $serveur_import->ref_serveur_import;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" />
				</form>
				<SCRIPT type="text/javascript">
				Event.observe("supprimer_<?php echo $serveur_import->ref_serveur_import;?>", "click",  function(evt){
					Event.stop(evt); 
					alerte.confirm_supprimer("serveur_import_supprime", "import_serveur_sup_<?php echo $serveur_import->ref_serveur_import;?>")
				}, false);
				</SCRIPT>
				</div>
			</td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
}
?>
</div>
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>
</div>