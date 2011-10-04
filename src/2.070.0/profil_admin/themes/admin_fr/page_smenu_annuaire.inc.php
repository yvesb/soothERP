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
tableau_smenu[0] = Array("smenu_annuaire", "smenu_annuaire.php" ,"true" ,"sub_content", "Annuaire");
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
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_annuaire.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="280px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:80%"><span style="width:47%; height:50px"><br />
				<br />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_annuaire.jpg" style="padding-left:25px" /><br />
			<br />
				<br />
			</span></td>
			</tr>
		<tr>
			<td style="text-align:left;" valign="top">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px" /><br />

				<span class="titre_smenu_page" id="annuaire_smenu_gestion_profils"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des Profils</span><br /><br />

				<span class="titre_smenu_page" id="annuaire_gestion_clients_categ"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des catégories de Clients</span><br /><br />

				<span class="titre_smenu_page" id="annuaire_gestion_fournisseurs_categ"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des catégories de Fournisseurs</span><br /><br />

			<!--	<span class="titre_smenu_page" id="annuaire_gestion_commerciaux_categ"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des catégories de Commerciaux</span><br /><br />-->
				
				<span class="titre_smenu_page" id="annuaire_gestion_evenements_contact"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des événements</span><br /><br />

				<span class="titre_smenu_page" id="annuaire_gestion_liaisons_contact"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des relations</span><br /><br />

			</td>
			<td style="text-align:left;" valign="top">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px"/><br />

                                <span class="titre_smenu_page" id="annuaire_config_nouvelle_fiche"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Configuration des nouvelles fiches contact</span><br /><br />

				<span class="titre_smenu_page" id="annuaire_ajouter"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Ajouter un contact</span><br /><br />

				<span class="titre_smenu_page" id="annuaire_smenu_recherche"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Rechercher un contact</span><br /><br />

<?php if (isset($import_annuaire_csv['folder_name'])) {?><br /><br />

				<span class="titre_smenu_page" id="import_annuaire_csv"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Import de contacts depuis un fichier CSV</span><br /><br />
<?php } ?>
			</td>
		</tr>
	</table>
</div>

</div>
<SCRIPT type="text/javascript">
Event.observe('annuaire_smenu_gestion_profils', "click", function(evt){
	page.verify('annuaire_gestion_profils','annuaire_gestion_profils.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('annuaire_gestion_clients_categ', "click", function(evt){
	page.verify('annuaire_gestion_categ_client','annuaire_gestion_categories_client.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('annuaire_gestion_fournisseurs_categ', "click", function(evt){
	page.verify('annuaire_gestion_categ_fournisseur','annuaire_gestion_categories_fournisseur.php','true','sub_content');  
	Event.stop(evt);}
);
//Event.observe('annuaire_gestion_commerciaux_categ', "click", function(evt){
//	page.verify('annuaire_gestion_commerciaux_categ','annuaire_gestion_categories_commerciaux.php','true','sub_content');  
//	Event.stop(evt);}
//);
Event.observe('annuaire_gestion_evenements_contact', "click", function(evt){
	page.verify('annuaire_gestion_evenements_contact','annuaire_gestion_evenements_contact.php','true','sub_content');  
	Event.stop(evt);}
);

Event.observe('annuaire_gestion_liaisons_contact', "click", function(evt){
	page.verify('annuaire_gestion_liaisons_contact','annuaire_gestion_liaisons_contact.php','true','sub_content');  
	Event.stop(evt);}
);

Event.observe('annuaire_config_nouvelle_fiche', "click", function(evt){
	page.verify('annuaire_config_nouvelle_fiche','annuaire_config_nouvelle_fiche.php','true','sub_content');
	Event.stop(evt);}
);

Event.observe('annuaire_ajouter', "click", function(evt){
	page.verify('annuaire_nouvelle_fiche','annuaire_nouvelle_fiche.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('annuaire_smenu_recherche', "click", function(evt){
	page.verify('annuaire_recherche','annuaire_recherche.php','true','sub_content');  
	Event.stop(evt);}
);

<?php if (isset($import_annuaire_csv['folder_name'])) {?>
Event.observe('import_annuaire_csv', "click", function(evt){
	page.verify('import_annuaire_csv','modules/<?php echo $import_annuaire_csv['folder_name'];?>import_annuaire_csv.php','true','sub_content');  
	Event.stop(evt);}
);
<?php } ?>


//on masque le chargement
H_loading();
</SCRIPT>