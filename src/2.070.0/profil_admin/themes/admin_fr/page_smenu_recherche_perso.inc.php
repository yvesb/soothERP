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
tableau_smenu[0] = Array("smenu_affichage", "smenu_affichage.php" ,"true" ,"sub_content", "Affichage");
tableau_smenu[1] = Array("smenu_recherche_perso", "smenu_recherche_perso.php" ,"true" ,"sub_content", "Recherches personnalisées");
tableau_smenu[2] = Array("", "" ,"" ,"", "");
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
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_affichage.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="280px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:80%" valign="top"><span style="width:47%; height:20px"><br />
				<br />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_affichage.jpg" style="padding-left:25px" /><br />
			<br />
			</span></td>
			</tr>
		<tr>
			<td style="text-align:left;" valign="top">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px" /><br />

				<span class="titre_smenu_page" id="recherche_contact"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Recherche de contact</span><br /><br />
				<span class="titre_smenu_page" id="recherche_article"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Recherche d'articles</span><br /><br />
				<span class="titre_smenu_page" id="recherche_com_vente"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Recherche de documents commerciaux - Vente</span><br /><br />
				<span class="titre_smenu_page" id="recherche_com_achat"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Recherche de documents commerciaux - Achat</span><br /><br />
				<span class="titre_smenu_page" id="recherche_com_stock"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Recherche de documents commerciaux - Stock</span><br /><br />
				
			</td>
			<td style="text-align:left;">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px"/><br />


			</td>
		</tr>
	</table>
</div>

</div>
<SCRIPT type="text/javascript">
Event.observe('recherche_contact', "click", function(evt){
	page.verify('recherche_contact','recherche_contact.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('recherche_article', "click", function(evt){
	page.verify('recherche_article','recherche_article.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('recherche_com_vente', "click", function(evt){
	page.verify('recherche_com_vente','recherche_com_vente.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('recherche_com_achat', "click", function(evt){
	page.verify('recherche_com_achat','recherche_com_achat.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('recherche_com_stock', "click", function(evt){
	page.verify('recherche_com_stock','recherche_com_stock.php','true','sub_content');  
	Event.stop(evt);}
);
//on masque le chargement
H_loading();
</SCRIPT>