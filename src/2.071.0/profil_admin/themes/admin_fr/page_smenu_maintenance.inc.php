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
tableau_smenu[0] = Array("smenu_maintenance", "smenu_maintenance.php" ,"true" ,"sub_content", "Maintenance");
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
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_maintenance.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="280px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:80%"><span style="width:40%; height:50px"><br />
				<br />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_maintenance.jpg" style="padding-left:25px" /><br />
			<br />
				<br />
			</span>			</td>
			</tr>
		<tr>
			<td style="text-align:left;" valign="top">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px" /><br />

				<span class="titre_smenu_page_unvalid" id="smenu_maintenance_disk"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Espace disque</span><br /><br />
				
				<span class="titre_smenu_page" id="smenu_maintenance_delestage"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Délestage des documents</span><br />
				<br />
				<span class="titre_smenu_page" id="smenu_maintenance_save_bdd"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Sauvegarde de la base de données</span><br />
				<br />
				<!-- Accès édition des fichiers de configuration désactivée - commentée - ci-dessous, pour des raisons de sécurité. Simplement commenté en cas de réimplantation ultérieure sous une autre forme -->		
				<!--<span class="titre_smenu_page" id="smenu_maintenance_config_files"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Edition des fichiers de configurations</span><br />-->
				<br />	
			</td>
			<td style="text-align:left;" valign="top">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px"/><br />
			</td>
		</tr>
	</table>
</div>

</div>
<SCRIPT type="text/javascript">
Event.observe('smenu_maintenance_delestage', "click", function(evt){
	page.verify('gestion_document_purge','documents_gestion_purge.php','true','sub_content');  
	Event.stop(evt);}
);
/* désactivé pour raison de sécurité
Event.observe("smenu_maintenance_config_files", "click",  function(evt){
	page.verify('configuration_config_files','configuration_config_files.php' ,"true" ,"sub_content");
	Event.stop(evt);}
);
*/
Event.observe('smenu_maintenance_save_bdd', "click", function(evt){
	page.verify('serveur_backup','serveur_backup.php','true','sub_content');  
	Event.stop(evt);}
);
//on masque le chargement
H_loading();
</SCRIPT>