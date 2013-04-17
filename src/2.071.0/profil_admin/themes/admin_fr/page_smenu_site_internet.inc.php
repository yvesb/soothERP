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
tableau_smenu[0] = Array("smenu_site_internet", "smenu_site_internet.php" ,"true" ,"sub_content", "Interface");
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
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_site_internet.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="280px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:80%"><span style="width:40%; height:50px"><br />
				<br />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_site_internet.jpg" style="padding-left:25px" /><br />
			<br />
				<br />
			</span>			</td>
			</tr>
		<tr>
			<td style="text-align:left;" valign="top">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px" /><br />

				<span class="titre_smenu_page" id="site_interfaces_config"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Configuration des interfaces</span><br /><br />
				
				<span class="titre_smenu_page_unvalid" id="site_internet_choix_theme"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Choix du thème</span><br /><br />

				<span class="titre_smenu_page_unvalid" id="site_internet_gestion_menus"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des menus</span><br /><br />
				
				<span class="titre_smenu_page_unvalid" id="site_internet_gestion_pages"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des pages</span><br /><br />	
				
			</td>
			<td style="text-align:left;" valign="top">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px"/><br />
				<span class="titre_smenu_page" id="smenu_site_internet_referencement"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Référencement de votre site</span><br /><br />

			
			
			</td>
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
Event.observe('site_interfaces_config', "click", function(evt){
	page.verify('site_interfaces_config','site_interfaces_config.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('smenu_site_internet_referencement', "click", function(evt){
	page.verify('site_internet_referencement','site_internet_referencement.php','true','sub_content');  
	Event.stop(evt);}
);
//on masque le chargement
H_loading();
</SCRIPT>