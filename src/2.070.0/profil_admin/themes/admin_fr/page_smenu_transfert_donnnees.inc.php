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
tableau_smenu[0] = Array("smenu_transfert_donnees", "smenu_transfert_donnees.php" ,"true" ,"sub_content", "Transfert de données");
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
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_transfert_donnees.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="280px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:80%"><span style="width:40%; height:50px"><br />
				<br />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_transfert_donnees.jpg" style="padding-left:25px" /><br />
			<br />
				<br />
			</span>			</td>
			</tr>
		<tr>
			<td style="text-align:left;" valign="top">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px" /><br />

				<span class="titre_smenu_page" id="smenu_transfert_donnnees_gestion_import" > <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des serveurs d'import</span><br /><br />
				
			
			<?php 
				if (isset($modules) && isset($export_general)) {
					?>
					<span class="titre_smenu_page" id="transfert_donnnees_export_dispo"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Données disponibles à l'export</span><br />
					<br />
					<span class="titre_smenu_page" id="transfert_donnnees_export_servers"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des serveurs d'export</span><br />
					<br />
					<SCRIPT type="text/javascript">
					Event.observe('transfert_donnnees_export_dispo', "click", function(evt){
						page.verify('<?php echo $export_general['menu_admin'][1][0];?>','<?php echo $export_general['menu_admin'][1][1];?>','true','sub_content');  
						Event.stop(evt);}
					);
					Event.observe('transfert_donnnees_export_servers', "click", function(evt){
						page.verify('<?php echo $export_general['menu_admin'][2][0];?>','<?php echo $export_general['menu_admin'][2][1];?>','true','sub_content');  
						Event.stop(evt);}
					);
					</SCRIPT>
					<?php
				} else {
					?>
					<span class="titre_smenu_page_unvalid" id="transfert_donnnees_export_dispo" title="Vous devez installer le module d'export de données pour accéder à cette fonctionnalité"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Données disponibles à l'export <br />
(Vous devez installer le module d'export de données pour accéder à cette fonctionnalité)</span><br />
					<br />
					<span class="titre_smenu_page_unvalid" id="transfert_donnnees_export_servers" title="Vous devez installer le module d'export de données pour accéder à cette fonctionnalité"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des serveurs d'export <br />
(Vous devez installer le module d'export de données pour accéder à cette fonctionnalité)</span><br />
					<br />
					<?php
				}
			?>
			
			
			</td>
			<td style="text-align:left;" valign="top">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px"/><br />
			</td>
		</tr>
	</table>
</div>

</div>
<SCRIPT type="text/javascript">
Event.observe('smenu_transfert_donnnees_gestion_import', "click", function(evt){
	page.verify('serveur_import_liste','serveur_import_liste.php','true','sub_content');  
	Event.stop(evt);}
);
//on masque le chargement
H_loading();
</SCRIPT>