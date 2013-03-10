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
tableau_smenu[0] = Array("smenu_communication", "smenu_communication.php" ,"true" ,"sub_content", "Communication");
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
			<td rowspan="4" style="width:280px; height:50px">
				<div style="position:relative; top:-35px; left:-35px; width:230px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_communication.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="280px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:80%"><span style="width:40%; height:50px"><br />
				<br />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_outils_com.jpg" style="padding-left:25px" /><br />
			<br />
				<br />
			</span>			</td>
			</tr>
		<tr>
			<td style="text-align:left;" valign="top">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px" /><br />
			<span class="titre_smenu_page" id="smenu_mail_templates"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />G&eacute;rer les mod&egrave;les d&apos;email</span><br /><br />
			<span class="titre_smenu_page" id="smenu_gerer_newsletters"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />G&eacute;rer les newsletters</span><br /><br />
			<span class="titre_smenu_page" id="smenu_courrier_templates"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />G&eacute;rer les mod&egrave;les de courriers</span><br /><br />
			 <br/><br/>
			<span class="titre_smenu_page" id="smenu_gerer_mod_fiche_art"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />G&eacute;rer les mod&egrave;les de fiches articles</span><br /><br />
            <span class="titre_smenu_page" id="smenu_gerer_mod_fiche_contact"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />G&eacute;rer les mod&egrave;les de fiches contacts</span><br /><br />
            <span class="titre_smenu_page" id="smenu_gerer_mod_fiche_stats"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />G&eacute;rer les mod&egrave;les de fiches statistiques</span><br /><br />
            <span class="titre_smenu_page" id="smenu_gerer_mod_etat_stocks"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />G&eacute;rer les mod&egrave;les d'&eacute;tat de stocks</span><br /><br />
            <span class="titre_smenu_page" id="smenu_gerer_mod_resultats_commerciaux"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />G&eacute;rer les mod&egrave;les de R&eacute;sultats des Commerciaux</span><br /><br />
			<span class="titre_smenu_page" id="smenu_gerer_mod_commande_client"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />G&eacute;rer les mod&egrave;les de commandes clients</span><br /><br />
	<br/>
			<span class="titre_smenu_page" id="smenu_gerer_mod_export_resultat_commerciaux"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />G&eacute;rer les mod&egrave;les d'export pour les r&eacute;sultats commerciaux</span><br /><br />
			<span class="titre_smenu_page" id="smenu_gerer_mod_export_stats_vente"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />G&eacute;rer les mod&egrave;les d'export pour les statistiques de ventes</span><br /><br />
			<span class="titre_smenu_page" id="smenu_gerer_mod_export_etat_stocks"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />G&eacute;rer les mod&egrave;les d'export d'&eacute;tat de stocks</span><br /><br />
            <span class="titre_smenu_page" id="smenu_gerer_mod_export_documents"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />G&eacute;rer les mod&egrave;les d'export de la liste de documents</span><br /><br />
			
		</tr>
		<tr>
			<td style="width:280px; height:50px">&nbsp;</td>
			<td style="text-align:left;" valign="top">&nbsp;</td>
			<td style="text-align:left;" valign="top">&nbsp;</td>
		</tr>
	</table>
</div>

</div>
<SCRIPT type="text/javascript">
Event.observe('smenu_gerer_newsletters', "click", function(evt){
	page.verify('communication_newsletters','communication_newsletters.php','true','sub_content');
	Event.stop(evt);}
);
Event.observe('smenu_mail_templates', "click", function(evt){
	page.verify('communication_mail_templates','communication_mail_templates.php','true','sub_content');
	Event.stop(evt);}
);
Event.observe('smenu_gerer_mod_fiche_art', "click", function(evt){
	page.verify('communication_mod_fiche_art','communication_mod_fiche_art.php','true','sub_content');
	Event.stop(evt);}
);
Event.observe('smenu_gerer_mod_fiche_contact', "click", function(evt){
  page.verify('communication_mod_fiche_contact','communication_mod_fiche_contact.php','true','sub_content');
  Event.stop(evt);}
);
Event.observe('smenu_gerer_mod_fiche_stats', "click", function(evt){
    page.verify('communication_mod_fiche_stats','communication_mod_fiche_stats.php','true','sub_content');
    Event.stop(evt);}
);
Event.observe('smenu_gerer_mod_etat_stocks', "click", function(evt){
    page.verify('communication_mod_etat_stocks','communication_mod_etat_stocks.php','true','sub_content');
    Event.stop(evt);}
);
Event.observe('smenu_courrier_templates', "click", function(evt){
	page.verify('documents_gestion_type','courriers_gestion_type.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('smenu_gerer_mod_resultats_commerciaux', "click", function(evt){
    page.verify('communication_mod_resultats_commerciaux','communication_mod_resultats_commerciaux.php','true','sub_content');
    Event.stop(evt);}
);
Event.observe('smenu_gerer_mod_export_resultat_commerciaux', "click", function(evt){
	page.verify('communication_mod_export_resultat_commerciaux','communication_mod_export_resultat_commerciaux.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('smenu_gerer_mod_export_stats_vente', "click", function(evt){
	page.verify('communication_mod_export_stats_vente','communication_mod_export_stats_vente.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('smenu_gerer_mod_export_etat_stocks', "click", function(evt){
	page.verify('communication_mod_export_etat_stocks','communication_mod_export_etat_stocks.php','true','sub_content');  
	Event.stop(evt);}
);
    Event.observe('smenu_gerer_mod_export_documents', "click", function(evt){
	page.verify('communication_mod_export_documents','communication_mod_export_documents.php','true','sub_content');  
	Event.stop(evt);}
);
/*Event.observe('smenu_messagerie_admin', "click", function(evt){
	page.verify('documents_gestion_type','messagerie_admin.php','true','sub_content'); 
	Event.stop(evt);}
);*/
Event.observe('smenu_gerer_mod_commande_client', "click", function(evt){
    page.verify('communication_mod_commande_client','communication_mod_commande_client.php','true','sub_content');
    Event.stop(evt);}
);
//on masque le chargement
H_loading();
</SCRIPT>