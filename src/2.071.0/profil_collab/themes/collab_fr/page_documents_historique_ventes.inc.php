<?php

// *************************************************************************************************************
// AFFICHAGE DE HISTORIQUE DES VENTES
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("histo_ventes");
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
	array_menu_cdc[<?php echo $i;?>] 	=	new Array('blc_<?php echo $stock->getId_stock();?>', 'menu_<?php echo $i;?>');
	<?php
	$i++;
}
if (count($_SESSION['stocks']) > 1) {
	?>
	array_menu_cdc[<?php echo $i;?>] 	=	new Array('blc_toutes', 'menu_<?php echo $i;?>');
	<?php
}
?>
	
</script>
<div id="main_doc_div" style="" class="emarge">
<p class="titre">Historique des ventes</p>

<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>du&nbsp; </td>
		<td><input type="text" id="date_debut" name="date_debut" value="<?php echo date("d-m-Y", mktime(0,0,0, date("m")-2, date("d"),date("Y")));?>" class="classinput_nsize" /></td>
		<td>&nbsp;</td>
		<td>au&nbsp; </td>
		<td><input type="text" id="date_fin" name="date_fin" value="<?php echo date("d-m-Y");?>" class="classinput_nsize" /></td>
		<td></td>
	</tr>
</table>

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
$i = 1;
foreach ($_SESSION['stocks'] as $stock) {
	?>
	<div style="height:25px; width:100%;<?php if ($stock->getId_stock() != $_SESSION['magasin']->getId_stock()) {echo 'display: none;';}?>" id="blc_<?php echo $stock->getId_stock();?>">

	</div>
	<?php
	$i++;
}
if (count($_SESSION['stocks']) > 1) {
	?>
	<div style="height:25px; width:100%;<?php if ($i != 0) {echo 'display: none;';}?>" id="blc_toutes">
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
		view_menu_1('blc_<?php echo $stock->getId_stock();?>', 'menu_<?php echo $i;?>', array_menu_cdc);  
	page.verify("documents_historique_ventes_content","documents_historique_ventes_content.php?id_stock=<?php echo $stock->getId_stock();?>&date_debut="+$('date_debut').value+"&date_fin="+$('date_fin').value+"","true","blc_<?php echo $stock->getId_stock();?>");
		Event.stop(evt);
});
	<?php
	$i++; 
}
if (count($_SESSION['stocks']) > 1) {
	?>
	Event.observe('menu_<?php echo $i;?>', "click", function(evt){
		view_menu_1('blc_toutes', 'menu_<?php echo $i;?>', array_menu_cdc);  
		page.verify("documents_historique_ventes_content","documents_historique_ventes_content.php?id_stock=&date_debut="+$('date_debut').value+"&date_fin="+$('date_fin').value+"'","true","blc_toutes");
		Event.stop(evt);
	});
	<?php
}
?>
//masque de date

	Event.observe("date_debut", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("date_fin", "blur", function(evt){
		datemask (evt);
	}, false);
	
//on affiche le contenu
	page.verify("documents_historique_ventes_content","documents_historique_ventes_content.php?id_stock=<?php echo $_SESSION['magasin']->getId_stock();?>&date_debut="+$('date_debut').value+"&date_fin="+$('date_fin').value+"","true","blc_<?php echo $_SESSION['magasin']->getId_stock();?>");
//on masque le chargement
H_loading();

</script>