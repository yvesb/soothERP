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
tableau_smenu[0] = Array("smenu_catalogue", "smenu_catalogue.php" ,"true" ,"sub_content", "Catalogue");
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
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_catalogue.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="280px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:80%"><span style="width:47%; height:50px"><br />
				<br />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_catalogue.jpg" style="padding-left:25px" /><br />
			<br />
				<br />
			</span></td>
			</tr>
		<tr>
			<td style="text-align:left;" valign="top">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px" /><br />

				<span class="titre_smenu_page" id="catalogue_smenu_param_gene"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Paramètres généraux</span><br /><br />

				<span class="titre_smenu_page" id="catalogue_smenu_param_tarifs"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Paramètres tarifaires</span><br /><br />
				
				<span class="titre_smenu_page" id="catalogue_smenu_param_taxes"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Paramètres taxes</span><br /><br />

				<span class="titre_smenu_page" id="catalogue_smenu_livraison"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Modes de livraison</span><br /><br />

				<span class="titre_smenu_page" id="catalogue_smenu_code_promo"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Codes promo</span><br /><br />

<br /><br />
				<span class="titre_smenu_page" id="catalogue_smenu_archiver_perimer"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Archiver les articles périmés</span><br /><br />

			</td>
			<td style="text-align:left;" valign="top">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px"/><br />

				<span class="titre_smenu_page" id="catalogue_smenu_art_categ"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Catégories d'articles</span><br /><br />

				<span class="titre_smenu_page" id="catalogue_smenu_catalogue_client"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Catalogues clients</span><br /><br />

                                				<span class="titre_smenu_page" id="catalogue_smenu_articles_favoris"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des articles favoris</span><br /><br />
<?php if (isset($import_catalogue_csv['folder_name'])) {?><br /><br />

				<span class="titre_smenu_page" id="import_catalogue_csv"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Import d'articles depuis un fichier CSV</span><br /><br />
<?php } ?>
<?php if (isset($import_catalogue_csv_var['folder_name'])) {?>

				<span class="titre_smenu_page" id="import_catalogue_csv_var"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Import d'articles avec variantes depuis un fichier CSV</span><br /><br />
<?php } ?>
			</td>
		</tr>
	</table>
</div>

</div>
<SCRIPT type="text/javascript">
Event.observe('catalogue_smenu_param_gene', "click", function(evt){
	page.verify('configuration_catalogue','configuration_catalogue.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('catalogue_smenu_param_tarifs', "click", function(evt){
	page.verify('configuration_tarifs','configuration_tarifs.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('catalogue_smenu_param_taxes', "click", function(evt){
	page.verify('configuration_taxes','configuration_taxes.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('catalogue_smenu_livraison', "click", function(evt){
	page.verify('livraison_modes','livraison_modes.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('catalogue_smenu_code_promo', "click", function(evt){
	page.verify('codes_promo','codes_promo.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('catalogue_smenu_archiver_perimer', "click", function(evt){
	page.verify('archiver_perimer','stocks_archiver_perime.php','true','sub_content');  
	Event.stop(evt);}
);

Event.observe('catalogue_smenu_art_categ', "click", function(evt){
	page.verify('catalogue_categorie','catalogue_categorie.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('catalogue_smenu_catalogue_client', "click", function(evt){
	page.verify('catalogues_clients','catalogues_clients.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('catalogue_smenu_articles_favoris', "click", function(evt){
	page.verify('catalogue_articles_favoris','catalogue_articles_favoris.php','true','sub_content');
	Event.stop(evt);}
);

<?php if (isset($import_catalogue_csv['folder_name'])) {?>
Event.observe('import_catalogue_csv', "click", function(evt){
	page.verify('import_catalogue_csv','modules/<?php echo $import_catalogue_csv['folder_name']?>import_catalogue_csv.php','true','sub_content');  
	Event.stop(evt);}
);
<?php } ?>
<?php if (isset($import_catalogue_csv_var['folder_name'])) {?>
Event.observe('import_catalogue_csv_var', "click", function(evt){
	page.verify('import_catalogue_csv_var','modules/<?php echo $import_catalogue_csv_var['folder_name']?>import_catalogue_csv_var.php','true','sub_content');
	Event.stop(evt);}
);
<?php } ?>


//on masque le chargement
H_loading();
</SCRIPT>
