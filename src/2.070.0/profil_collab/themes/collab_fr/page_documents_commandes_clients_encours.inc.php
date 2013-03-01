<?php

// *************************************************************************************************************
// AFFICHAGE DES COMMANDES CLIENTS EN COURS
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("commandes");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

array_menu_cdc	=	new Array();

<?php 
$i = 0;
foreach ($_SESSION['stocks'] as $stock) {
	?>
	array_menu_cdc[<?php echo $i;?>] 	=	new Array('cdc_<?php echo $stock->getId_stock();?>', 'menu_<?php echo $i;?>');
	<?php
	$i++;
}
if (count($_SESSION['stocks']) > 1) {
	?>
	array_menu_cdc[<?php echo $i;?>] 	=	new Array('cdc_toutes', 'menu_<?php echo $i;?>');
	<?php
}
?>
	
</script>
<div id="main_doc_div" style="" class="emarge">
<p class="titre">Commandes clients en cours</p>


<ul id="menu_recherche" class="menu">
<?php 
$i = 0;
foreach ($_SESSION['stocks'] as $stock) {
	?>
	<li id="doc_menu_<?php echo $i;?>">
		<a href="#" id="menu_<?php echo $i;?>" class="menu_<?php if ($stock->getId_stock() != $_SESSION['magasin']->getId_stock()) {echo "un";}?>select"><?php echo htmlentities($stock->getLib_stock());?></a>
	</li>
	<?php
	$i++;
}
if (count($_SESSION['stocks']) > 1) {
	?>
	<li id="doc_menu_<?php echo $i;?>">
		<a href="#" id="menu_<?php echo $i;?>" class="menu_<?php if ($i != 0) {echo "un";}?>select">Toutes</a>
	</li>
	<?php
}
?>
</ul>

<?php 
$i = 0;
foreach ($_SESSION['stocks'] as $stock) {
	?>
	<div style="height:25px; width:100%;<?php if ($stock->getId_stock() != $_SESSION['magasin']->getId_stock()) {echo 'display: none;';}?>" id="cdc_<?php echo $stock->getId_stock();?>">
		<?php
		if($stock->getId_stock() == $_SESSION['magasin']->getId_stock()) {
		include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_commandes_clients_encours_content.inc.php";
		}
		?>
	</div>
	<?php
	$i++;
}
if (count($_SESSION['stocks']) > 1) {
	?>
	<div style="height:25px; width:100%;<?php if ($i != 0) {echo 'display: none;';}?>" id="cdc_toutes">

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
		view_menu_1('cdc_<?php echo $stock->getId_stock();?>', 'menu_<?php echo $i;?>', array_menu_cdc);  
	page.verify("documents_commandes_clients_encours_content","documents_commandes_clients_encours_content.php?id_stock=<?php echo $stock->getId_stock();?>","true","cdc_<?php echo $stock->getId_stock();?>");
		Event.stop(evt);
});
	<?php
	$i++; 
}
if (count($_SESSION['stocks']) > 1) {
	?>
Event.observe('menu_<?php echo $i;?>', "click", function(evt){
	view_menu_1('cdc_toutes', 'menu_<?php echo $i;?>', array_menu_cdc);  
	page.verify("documents_commandes_clients_encours_content","documents_commandes_clients_encours_content.php?id_stock=","true","cdc_toutes");
	Event.stop(evt);
});
	<?php
}
?>
//on masque le chargement
H_loading();

</script>