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
<script type="text/javascript" language="javascript">
tableau_smenu[0] = Array("smenu_entreprise", "smenu_entreprise.php" ,"true" ,"sub_content", "Entreprise");
tableau_smenu[1] = Array("", "" ,"" ,"", "");
update_menu_arbo();
</script>

<div class="emarge" style="text-align:right" >
<br />
<br />
<br />
<br />
<div>
	<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF">
		<tr>
			<td rowspan="2" style="width:280px; height:50px">
				<div style="position:relative; top:-35px; left:-35px; width:230px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_entreprise.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="280px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:80%"><span style="width:47%; height:50px"><br />
				<br />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_info_entreprise.jpg" width="324" height="30" style="padding-left:25px" /><br />
			<br />
				<br />
			</span></td>
			</tr>
		<tr>
			<td style="text-align:left;">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px" /><br />

				<span class="titre_smenu_page" id="entreprise_rg"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Renseignements généraux</span><br /><br />

				<span class="titre_smenu_page" id="entreprise_activite"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Renseignements sur l'activité</span><br /><br />				
				
				<span class="titre_smenu_page_unvalid"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Visuels de l'entreprise</span><br /><br />

				<span class="titre_smenu_page" id="entreprise_lieux_stock"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Lieux de stockage</span><br /><br />

				<span class="titre_smenu_page" id="entreprise_enseigne"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Enseignes</span><br /><br />

				<span class="titre_smenu_page" id="entreprise_point_vente"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Points de vente </span><br /><br />
				
				<br /><br />
				<span class="titre_smenu_page" id="entreprise_agenda"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Agenda </span><br /><br />
				
				<br /><br />
				<span class="titre_smenu_page" id="entreprise_ged"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des pi&egrave;ces jointes </span><br /><br />
				<span class="titre_smenu_page" id="entreprise_options"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Options </span><br /><br />

			</td>
			<td style="text-align:left;">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px"/><br />


				<span class="titre_smenu_page" id="entreprise_doc_pdf"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Documents commerciaux - Paramètres généraux </span><br /><br />

			<?php 
			foreach ($docs_types_groupes  as $groupe) {
				?>
				<span class="titre_smenu_page" id="entreprise_doc_gestion_type_<?php echo $groupe->id_type_groupe;?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" /><?php echo $groupe->lib_type_groupe;?></span><br /><br />
				<?php
			}
			?>
			<br /><br />
			<span class="titre_smenu_page" id="entreprise_docs_infos_lines"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Lignes d'informations prédéfinies</span><br /><br />
			
			
			<br /><br />
			<span class="titre_smenu_page" id="entreprise_commi_commerciaux"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Commissionnement des commerciaux</span><br /><br />
			
			</td>
		</tr>
	</table>
</div>

</div>
<SCRIPT type="text/javascript">
Event.observe('entreprise_rg', "click", function(evt){
	page.verify('annuaire_contact','annuaire_view_fiche.php?ref_contact=<?php echo $REF_CONTACT_ENTREPRISE;?>','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('entreprise_lieux_stock', "click", function(evt){
	page.verify('catalogue_stockage','catalogue_stockage.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('entreprise_enseigne', "click", function(evt){
	page.verify('catalogue_enseignes','catalogue_enseignes.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('entreprise_point_vente', "click", function(evt){
	page.verify('catalogue_magasin','catalogue_magasins.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('entreprise_activite', "click", function(evt){
	page.verify('configuration_activite','configuration_activite.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('entreprise_doc_pdf', "click", function(evt){
	page.verify('configuration_pdf','configuration_pdf.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('entreprise_ged', "click", function(evt){
	page.verify('configuration_entreprise_ged','configuration_entreprise_ged.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('entreprise_options', "click", function(evt){
	page.verify('configuration_entreprise_options','configuration_entreprise_options.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('entreprise_agenda', "click", function(evt){
	page.verify('configuration_entreprise_agenda','agenda_configuration.php','true','sub_content');
	Event.stop(evt);}
);

<?php 
foreach ($docs_types_groupes  as $groupe) {
	?>
	Event.observe('entreprise_doc_gestion_type_<?php echo $groupe->id_type_groupe;?>', "click", function(evt){
		page.verify('documents_gestion_type','documents_gestion_type.php?id_type_groupe=<?php echo $groupe->id_type_groupe;?>','true','sub_content');  
		Event.stop(evt);}
	);
	<?php
}
?>
Event.observe('entreprise_docs_infos_lines', "click", function(evt){
	page.verify('configuration_docs_infos_lines','configuration_docs_infos_lines.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('entreprise_commi_commerciaux', "click", function(evt){
	page.verify('configuration_commission','configuration_commission.php','true','sub_content');  
	Event.stop(evt);}
);

//on masque le chargement
H_loading();
</SCRIPT>