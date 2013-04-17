<?php

// *************************************************************************************************************
// AFFICHAGE DES LIVRAISONS CLIENTS NON FACTUREES
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("livraisons");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

array_menu_lcnf	=	new Array();

<?php 
$i = 0;
foreach ($stocks_liste as $stocks) {
	?>
	array_menu_lcnf[<?php echo $i;?>] 	=	new Array('lcnf', 'menu_<?php echo $i;?>');
	<?php
	$i++;
}
?>
	
</script>
<div id="main_doc_div" style="" class="emarge">

<p class="titre">Livraisons clients non factur&eacute;es</p>


<ul id="menu_recherche" class="menu">
<?php 
$i = 0;
foreach ($stocks_liste as $stocks) {
	?>
	<li id="doc_menu_<?php echo $i;?>">
		<a href="#" id="menu_<?php echo $i;?>" class="menu_<?php if ($_SESSION['magasin']->getId_stock() != $stocks->getId_stock ()) {echo "un";}?>select" <?php if (!isset($_SESSION['stocks'][$stocks->getId_stock ()])) {echo 'style="color:#FF0000"';}?>><?php echo htmlentities($stocks->getLib_stock ());?></a>
	</li>
	<?php
	$i++;
}
$stocks = $_SESSION['stocks'][$_SESSION['magasin']->getId_stock()];
?>
</ul>

<div id="lcnf" class=""  style="width:100%;">
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_livraisons_client_nonfacturees_liste.inc.php";?>
</div>

<script type="text/javascript">
<?php 
$i = 0;
foreach ($stocks_liste as $stocks) {
	?>
	Event.observe('menu_<?php echo $i;?>', "click", function(evt){
		view_menu_1('lcnf', 'menu_<?php echo $i;?>', array_menu_lcnf);
		load_livraison_nonfacturees ("<?php echo $stocks->getId_stock ();?>", "", "");
		Event.stop(evt);
});
	<?php 
	
	$i++;
}
?>

//on masque le chargement
H_loading();

</script>