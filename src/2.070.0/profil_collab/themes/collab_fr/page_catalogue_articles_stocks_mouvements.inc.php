<?php

// *************************************************************************************************************
// RESUME DES STOCK D'UN ARTICLE (affichage dans les moteurs de recherche article)
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">

array_menu_sm	=	new Array();
<?php 
$i = 0;
foreach ($_SESSION['stocks'] as $stock) {
	?>
	array_menu_sm[<?php echo $i;?>] 	=	new Array('stock_moves_liste', 'stock_move_menu_<?php echo $i;?>');
	<?php
	$i++;
}
if (count($_SESSION['stocks']) > 1) {
	?>
	array_menu_sm[<?php echo $i;?>] 	=	new Array('stock_moves_liste', 'stock_move_menu_<?php echo $i;?>');
	<?php 
}
?>
	
</script>
<div class="titre" id="titre_crea_art">Mouvements des stocks pour <?php echo htmlentities($article->getLib_article());?></div>
<div style=" float:right">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>du&nbsp; </td>
		<td><input type="text" id="date_debut" name="date_debut" value="" class="classinput_nsize" /></td>
		<td>&nbsp;</td>
		<td>au&nbsp; </td>
		<td><input type="text" id="date_fin" name="date_fin" value="" class="classinput_nsize" /></td>
		<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_ok.gif" id="reload_stock_move" style="cursor:pointer;"/></td>
	</tr>
</table>
</div>
<br />
<br />

<div style="height:50px; width:99%">
<ul id="menu_recherche" class="menu" >
<?php 
$i = 0;
foreach ($_SESSION['stocks'] as $stock) {
	?>
	<li id="stock_move_<?php echo $i;?>">
		<a href="#" id="stock_move_menu_<?php echo $i;?>" class="menu_<?php if ($stock->getId_stock() != $_SESSION['magasin']->getId_stock()) {echo "un";}?>select"><?php echo htmlentities($stock->getLib_stock());?></a>
	</li>
	<?php
	$i++;
}
if (count($_SESSION['stocks']) > 1) {
	?>
	<li id="stock_move_<?php echo $i;?>">
		<a href="#" id="stock_move_menu_<?php echo $i;?>" class="menu_<?php if ($i != 0) {echo "un";}?>select">Tous</a>
	</li>
	<?php
	}
?>
</ul>
<div id="stock_moves_liste" class="articletview_corps"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%;">

</div>

<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
<input type="hidden" name="ref_article_s" id="ref_article_s" value="<?php echo $article->getRef_article();?>"/>
</div>
<SCRIPT type="text/javascript">

function setheight_stock_move(){
set_tomax_height("stock_moves_liste" , -32);
}
Event.observe(window, "resize", setheight_stock_move, false);
setheight_stock_move();



<?php 
$i = 0;
foreach ($_SESSION['stocks'] as $stock) {
	?>
	Event.observe('stock_move_menu_<?php echo $i;?>', "click", function(evt){
		view_menu_1('stock_moves_liste', 'stock_move_menu_<?php echo $i;?>', array_menu_sm);  
		$("page_to_show_s").value = "1";
		page.article_stock_mouvements_result ("<?php echo $stock->getId_stock();?>");
		Event.stop(evt);
});
	<?php
	$i++; 
}
if (count($_SESSION['stocks']) > 1) {
?>
	Event.observe('stock_move_menu_<?php echo $i;?>', "click", function(evt){
		view_menu_1('stock_moves_liste', 'stock_move_menu_<?php echo $i;?>', array_menu_sm);  
		$("page_to_show_s").value = "1";
		page.article_stock_mouvements_result ("");
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
	Event.observe("reload_stock_move", "click", function(evt){
		Event.stop(evt);
		if ($("stock_move_id_stock")) {
			page.article_stock_mouvements_result ($("stock_move_id_stock").value);
		}
	}, false);
	
//on charge le premier affichage
page.article_stock_mouvements_result ("<?php echo $_SESSION['magasin']->getId_stock();?>");
//on masque le chargement
H_loading();
</SCRIPT>