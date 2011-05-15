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
tableau_smenu[0] = Array("smenu_gestion_modules", "smenu_gestion_modules.php" ,"true" ,"sub_content", "Gestion des Modules");
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
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_gestion_modules.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="280px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:80%"><span style="width:40%; height:50px"><br />
				<br />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_gestion-modules.jpg" style="padding-left:25px" /><br />
			<br />
				<br />
			</span>			</td>
			</tr>
		<tr>
			<td style="text-align:left;" valign="top">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px" /><br />

			<?php 
if (isset($modules)) {
	foreach ($modules as $module) {
		if (isset(${$module}['menu_admin'])) {
			foreach (${$module}['menu_admin'] as $menu_mod) {
				if ($menu_mod[0] == 'separateur') {continue;}
				if ($menu_mod[0] == 'import_annuaire_csv') {continue;}
				if ($menu_mod[0] == 'import_catalogue_csv') {continue;}
					?>
					<span class="titre_smenu_page" id="smenu_modules_<?php echo $menu_mod[0];?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" /><?php echo $menu_mod[4];?></span><br />
					<br />
					<SCRIPT type="text/javascript">
					Event.observe('smenu_modules_<?php echo $menu_mod[0];?>', "click", function(evt){
						page.verify('<?php echo $menu_mod[0];?>','<?php echo $menu_mod[1];?>','<?php echo $menu_mod[2];?>','<?php echo $menu_mod[3];?>');  
						Event.stop(evt);}
					);
					</SCRIPT>
					<?php
			}
		}
	?>
	<br /><br />
	<?php
	}
}
			?>
			
				<span class="titre_smenu_page_unvalid" id="smenu_gestion_modules_add" > <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Ajouter un module</span><br /><br />
				
			<span class="titre_smenu_page" id="osmenu_gestion_vehicules" > <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gestion des v&eacute;hicules</span><br /><br />
			
			</td>
			<td style="text-align:left;" valign="top">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px"/><br />
			</td>
		</tr>
	</table>
</div>

</div>
<SCRIPT type="text/javascript">
Event.observe('smenu_gestion_modules_add', "click", function(evt){
	page.verify('','','true','sub_content');  
	Event.stop(evt);}
);
Event.observe("osmenu_gestion_vehicules", "click",  function(evt){Event.stop(evt); page.verify('smenu_gestion_vehicules', 'smenu_gestion_vehicules.php' ,"true" ,"sub_content");}, false);
//on masque le chargement
H_loading();
</SCRIPT>