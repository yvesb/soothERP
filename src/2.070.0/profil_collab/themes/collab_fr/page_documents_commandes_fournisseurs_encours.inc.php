<?php

// *************************************************************************************************************
// AFFICHAGE DES COMMANDES FOURNISSEUR EN COURS
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
<script type="text/javascript">

array_menu_cdf	=	new Array();
<?php 
$i = 0;
foreach ($_SESSION['stocks'] as $stock) {
	?>
	array_menu_cdf[<?php echo $i;?>] 	=	new Array('cdf_<?php echo $stock->getId_stock();?>', 'menu_<?php echo $i;?>');
	<?php
	$i++;
}
if (count($_SESSION['stocks']) > 1) {
	?>
	array_menu_cdf[<?php echo $i;?>] 	=	new Array('cdf_toutes', 'menu_<?php echo $i;?>');
	<?php
}
?>
	
</script>
<div id="main_doc_div" style="" class="emarge">
<p class="titre">Commandes fournisseurs en cours</p>


<ul id="menu_recherche" class="menu">
<?php 
$i = 0;
foreach ($_SESSION['stocks'] as $stock) {
	?>
	<li id="doc_menu_<?php echo $i;?>">
		<a href="#" id="menu_<?php echo $i;?>" class="menu_unselect"><?php echo htmlentities($stock->getLib_stock());?></a>
	</li>
	<?php
	$i++;
}
if (count($_SESSION['stocks']) > 1) {
	?>
	<li id="doc_menu_<?php echo $i;?>">
		<a href="#" id="menu_<?php echo $i;?>" class="menu_select">Toutes</a>
	</li>
	<?php
}
?>
</ul>

<?php 
foreach ($_SESSION['stocks'] as $stock) {
	?>
	<div style="height:25px; width:100%; display: none;" id="cdf_<?php echo $stock->getId_stock();?>">
	</div>
	<?php
}
if (count($_SESSION['stocks']) > 1) {
	?>
	<div style="height:25px; width:100%;" id="cdf_toutes">
	<?php
		include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_commandes_fournisseurs_encours_content.inc.php";
		?>
	</div>
	<?php
}
?>

<iframe frameborder="0" scrolling="no" src="about:_blank" id="resume_stock_iframe" class="resume_stock_iframe"></iframe>
<div id="resume_stock" class="resume_stock">
</div>


</div>

<script type="text/javascript">


<?php 
$i = 0;
foreach ($_SESSION['stocks'] as $stock) {
	?>
	Event.observe('menu_<?php echo $i;?>', "click", function(evt){
		view_menu_1('cdf_<?php echo $stock->getId_stock();?>', 'menu_<?php echo $i;?>', array_menu_cdf);  
	page.verify("documents_commandes_fournisseurs_encours_content","documents_commandes_fournisseurs_encours_content.php?id_stock=<?php echo $stock->getId_stock();?>","true","cdf_<?php echo $stock->getId_stock();?>");
		Event.stop(evt);
});
	<?php
	$i++; 
}
if (count($_SESSION['stocks']) > 1) {
	?>
Event.observe('menu_<?php echo $i;?>', "click", function(evt){
	view_menu_1('cdf_toutes', 'menu_<?php echo $i;?>', array_menu_cdf);  
	page.verify("documents_commandes_fournisseurs_encours_content","documents_commandes_fournisseurs_encours_content.php?id_stock=","true","cdf_toutes");
	Event.stop(evt);
});
	<?php
}
?>

//on masque le chargement
H_loading();

</script>