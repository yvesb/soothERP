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
tableau_smenu[0] = Array("smenu_comptabilite", "smenu_comptabilite.php" ,"true" ,"sub_content", "Comptabilité");
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
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_comptabilite.jpg" />				</div>
				<span style="width:35px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="280px" height="20px" id="imgsizeform"/>				</span>			</td>
			<td colspan="2" style="width:80%"><span style="width:47%; height:50px"><br />
				<br />
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/titre_comptabilite.jpg" style="padding-left:25px" /><br />
			<br />
				<br />
			</span></td>
			</tr>
		<tr>
			<td style="text-align:left;">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px" /><br />

				<span class="titre_smenu_page" id="comptabilite_smenu_compte_bancaire_gestion"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Comptes bancaires</span><br /><br />

				<span class="titre_smenu_page" id="comptabilite_smenu_caisses"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Caisses</span><br /><br />

				<span class="titre_smenu_page" id="comptabilite_smenu_tpe"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Terminaux de paiement électronique</span><br /><br />

				<span class="titre_smenu_page" id="comptabilite_smenu_tpv"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Terminaux de paiement virtuels</span><br /><br />

				<span class="titre_smenu_page" id="comptabilite_smenu_cbs"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Carte(s) bancaire(s) de l'entreprise</span><br /><br />
				
				<br /><br />
				
				<span class="titre_smenu_page" id="comptabilite_smenu_gest_tva"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Paramétrage TVA</span><br /><br />
				
				<span class="titre_smenu_page" id="comptabilite_smenu_mod_ech"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Modèles d'échéanciers</span><br /><br />

			</td>
			<td style="text-align:left;">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="20px"/><br />

				<span class="titre_smenu_page" id="comptabilite_smenu_exercices"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Définir les exercices comptables</span><br /><br />

				<br /><br />

				<span class="titre_smenu_page_unvalid" id="comptabilite_smenu_reg_fav_enc" title="fonctionnalité prochainement disponible"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Modes de règlements favoris (encaissements)</span><br /><br />

				<span class="titre_smenu_page_unvalid" id="comptabilite_smenu_reg_fav_dec" title="fonctionnalité prochainement disponible"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Modes de règlements favoris (décaissements)</span><br /><br />

				<span class="titre_smenu_page" id="comptabilite_smenu_niveaurelance"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Règles de relance des factures</span><br /><br />
				
				<br /><br />
				
				<span class="titre_smenu_page" id="comptabilite_smenu_pla_compt_gene"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gérer le plan comptable général</span><br /><br />

				<span class="titre_smenu_page" id="comptabilite_smenu_pla_compt_entr"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gérer le plan comptable de l'entreprise</span><br /><br />
				
				<span class="titre_smenu_page" id="comptabilite_smenu_compt_defaut"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Gérer les numéros de compte par défaut</span><br /><br />
				
				<span class="titre_smenu_page" id="comptabilite_smenu_export_veac"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_grey.jpg" align="absmiddle" />Export des journaux des ventes et des achats</span><br /><br />



			</td>
		</tr>
	</table>
</div>

</div>
<SCRIPT type="text/javascript">
Event.observe('comptabilite_smenu_compte_bancaire_gestion', "click", function(evt){
	page.verify('compta_compte_bancaire','compta_compte_bancaire.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_caisses', "click", function(evt){
	page.verify('compte_caisse','compta_compte_caisse.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_tpe', "click", function(evt){
	page.verify('compte_tpes','compta_compte_tpes.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_tpv', "click", function(evt){
	page.verify('compte_tpv','compta_compte_tpv.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_cbs', "click", function(evt){
	page.verify('compte_cbs','compta_compte_cbs.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_exercices', "click", function(evt){
	page.verify('compta_exercices','compta_exercices.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_niveaurelance', "click", function(evt){
	page.verify('annuaire_gestion_factures','annuaire_gestion_factures.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_reg_fav_enc', "click", function(evt){
	//page.verify('','','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_reg_fav_dec', "click", function(evt){
	//page.verify('','','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_pla_compt_gene', "click", function(evt){
	page.verify('compta_plan_general','compta_plan_general.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_pla_compt_entr', "click", function(evt){
	page.verify('compta_plan_entreprise','compta_plan_entreprise.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_compt_defaut', "click", function(evt){
	page.verify('compta_plan_compte_defaut','compta_plan_compte_defaut.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_gest_tva', "click", function(evt){
	page.verify('configuration_tva','configuration_tva.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_export_veac', "click", function(evt){
	page.verify('compta_journal_veac_export','compta_journal_veac_export.php','true','sub_content');  
	Event.stop(evt);}
);
Event.observe('comptabilite_smenu_mod_ech', "click", function(evt){
	page.verify('compta_modeles_echeanciers','compta_modeles_echeanciers.php','true','sub_content');  
	Event.stop(evt);}
);


//on masque le chargement
H_loading();
</SCRIPT>