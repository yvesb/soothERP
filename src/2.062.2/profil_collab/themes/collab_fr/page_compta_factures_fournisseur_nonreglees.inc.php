<?php

// *************************************************************************************************************
// AFFICHAGE DES FACTURES FOURNISSEURS NON REGLEES
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
array_menu_fnr	=	new Array();
<?php 
$i = 0;
foreach ($liste_categories_fournisseur as $categorie_fournisseur) {
	?>
	array_menu_fnr[<?php echo $i;?>] 	=	new Array('fac_liste_content', 'menu_<?php echo $i;?>');
	<?php
	$i++;
}
?>
	array_menu_fnr[<?php echo $i;?>] 	=	new Array('fac_liste_content', 'menu_<?php echo $i;?>');
</script>
<div id="main_doc_div" style="" class="emarge">
<br />

<ul id="menu_recherche" class="menu">
<?php 
$i = 0;
$onglet_select = false;
foreach ($liste_categories_fournisseur as $categorie_fournisseur) {
	?>
	<li id="doc_menu_<?php echo $i;?>">
		<a href="#" id="menu_<?php echo $i;?>" class="menu_<?php if ($categorie_fournisseur->id_fournisseur_categ != $DEFAUT_ID_FOURNISSEUR_CATEG) {echo "un"; }else {$onglet_select = true;}?>select">Factures <?php echo htmlentities($categorie_fournisseur->lib_fournisseur_categ);?> (<?php echo htmlentities($categorie_fournisseur->count_fact);?>)</a>
	</li>
	<?php
	$i++;
}
?>
	<li id="doc_menu_<?php echo $i;?>">
		<a href="#" id="menu_<?php echo $i;?>" class="menu_unselect">Factures non attribuées (<?php echo $nb_faf_non_attrib;?>)</a>
	</li>
</ul>

<div id="fac_liste_content" class="articletview_corps"  style="width:100%;">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_factures_fournisseur_nonreglees_liste.inc.php";?>
</div>


</div>

<script type="text/javascript">
//actions du menu
<?php 
$i = 0;
foreach ($liste_categories_fournisseur as $categorie_fournisseur) {
	?>
	Event.observe('menu_<?php echo $i;?>', "click", function(evt){
		view_menu_1('fac_liste_content', 'menu_<?php echo $i;?>', array_menu_fnr);
		load_facture_nonreglees_fournisseur ("<?php echo $categorie_fournisseur->id_fournisseur_categ;?>");
		Event.stop(evt);
});
	<?php
	$i++; 
}
?>
	Event.observe('menu_<?php echo $i;?>', "click", function(evt){
		view_menu_1('fac_liste_content', 'menu_<?php echo $i;?>', array_menu_fnr);
		load_facture_nonreglees_fournisseur ("");
		Event.stop(evt);
});
//on masque le chargement
H_loading();

</script>