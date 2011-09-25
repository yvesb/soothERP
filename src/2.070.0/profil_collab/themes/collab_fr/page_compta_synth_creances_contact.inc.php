<?php

// *************************************************************************************************************
// AFFICHAGE DES FACTURES CLIENTS NON REGLEES
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("factures");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
array_menu_scc	=	new Array();
array_menu_scc[0] 	=	new Array('scc_liste_content', 'menu_0');
array_menu_scc[1] 	=	new Array('scc_liste_content', 'menu_1');
</script>
<div id="main_doc_div" style="" class="emarge">
<a  href="#" id="link_retour_contact" style="float:right" class="common_link">retour à la fiche du contact</a><br />
</span>
<script type="text/javascript">
Event.observe("link_retour_contact", "click",  function(evt){Event.stop(evt); page.verify('annuaire_view_fiche','annuaire_view_fiche.php?ref_contact=<?php echo $contact->getRef_contact();?>','true','sub_content');}, false);
</script>
<p class="titre">Synthèse des créances de <?php echo htmlentities($contact->getNom())?></p>

<ul id="menu_recherche" class="menu">
	<li id="doc_menu_0">
		<a href="#" id="menu_0" class="menu_select">Factures non réglées</a>
	</li>
	<li id="doc_menu_1">
		<a href="#" id="menu_1" class="menu_unselect">Bon de livraison non facturés</a>
	</li>
</ul>

<div id="scc_liste_content" class="articletview_corps"  style="width:100%;">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_synth_creances_contact_fnr.inc.php";?>
</div>


</div>

<script type="text/javascript">
//actions du menu
Event.observe('menu_0', "click", function(evt){
	view_menu_1('scc_liste_content', 'menu_0', array_menu_scc); 
	page.verify("compta_synth_creances_contact_fnr","compta_synth_creances_contact_fnr.php?ref_contact=<?php echo $contact->getRef_contact();?>", "true", "scc_liste_content");
	Event.stop(evt);
});

Event.observe('menu_1', "click", function(evt){
	view_menu_1('scc_liste_content', 'menu_1', array_menu_scc); 
	page.verify("compta_synth_creances_contact_blnf","compta_synth_creances_contact_blnf.php?ref_contact=<?php echo $contact->getRef_contact();?>", "true", "scc_liste_content");
	Event.stop(evt);
});

//on masque le chargement
H_loading();

</script>