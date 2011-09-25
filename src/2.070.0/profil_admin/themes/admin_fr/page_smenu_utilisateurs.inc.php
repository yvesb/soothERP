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
tableau_smenu[0] = Array("smenu_utilisateurs", "smenu_utilisateurs.php" ,"true" ,"sub_content", "Utilisateurs");
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
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_utilisateurs.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="280px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:80%">
			
			<span style="width:40%; height:50px"><br />
				<br />
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_gestion_collab.jpg" style="padding-left:25px" />
				<br />
				<br />
				<br />
			</span>			</td>
			<td style="text-align:left;" valign="top">&nbsp;</td>
		</tr>
		<tr>
			<td style="text-align:left;" valign="top"><span class="titre_smenu_page" id="utilisateurs_smenu_liste_collab"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Liste des collaborateurs</span><br />
				<br />
				<span class="titre_smenu_page" id="utilisateurs_smenu_fonctions"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Fonctions dans l'entreprise</span><br />
				<br /></td>
			<td style="text-align:left;" valign="top">&nbsp;</td>
		</tr>
		<tr>
			<td style="text-align:left;" valign="top">
			
			<span style="width:40%; height:50px"><br />
				<br />
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_gestion_admin.jpg" style="padding-left:25px" />
				<br />
				<br />
				<br />
			</span>	
			</td>
			<td style="text-align:left;" valign="top"></td>
		</tr>
		<tr>
			<td style="text-align:left;" valign="top">
			<span class="titre_smenu_page" id="utilisateurs_smenu_liste_admin"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Liste des administrateurs</span><br />
			<br />
			</td>
			<td style="text-align:left;" valign="top">&nbsp;</td>
		</tr>
		<tr>
			<td style="width:280px; height:50px">&nbsp;</td>
			<td style="text-align:left;" valign="top">
			<span style="width:40%; height:50px"><br />
				<br />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_utilisateurs.jpg" style="padding-left:25px" /><br />
			<br />
				<br />
			</span>			</td>
			</tr>
		<tr>
			<td style="width:280px; height:50px">&nbsp;</td>
			<td style="text-align:left;" valign="top">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px" /><br />

				<span class="titre_smenu_page" id="utilisateurs_smenu_editer_compte_utilisateurs"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Editer un compte utilisateur</span><br /><br />

				<span class="titre_smenu_page" id="utilisateurs_smenu_historique_connexions"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Historique des connexions</span><br /><br />			</td>
			<td style="text-align:left;" valign="top">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px"/><br />
			<div> </div>			</td>
		</tr>
		<tr>
			<td style="text-align:left;" valign="top">
	</table>
</div>

</div>
<SCRIPT type="text/javascript">
Event.observe('utilisateurs_smenu_editer_compte_utilisateurs', "click", function(evt){
	page.verify('utilisateur_recherche','utilisateur_recherche.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('utilisateurs_smenu_historique_connexions', "click", function(evt){
	page.verify('utilisateur_histo','utilisateur_histo.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('utilisateurs_smenu_liste_collab', "click", function(evt){
	page.verify('annuaire_gestion_collabs_liste', 'annuaire_gestion_collabs_liste.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('utilisateurs_smenu_fonctions', "click", function(evt){
	page.verify('annuaire_gestion_users_fonctions','annuaire_gestion_users_fonctions.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('utilisateurs_smenu_liste_admin', "click", function(evt){
	page.verify('annuaire_gestion_admin_liste', 'annuaire_gestion_admin_liste.php','true','sub_content');  
	Event.stop(evt);}
);
//on masque le chargement
H_loading();
</SCRIPT>