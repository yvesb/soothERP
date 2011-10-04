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

<table style="width:100%">
<tr>
	<td>
		<div class="titre" id="titre_crea_art">Historique par mouvement</div>
	</td>
	<td style="width:20%; vertical-align: bottom;">
		<?php 
			if(isset($stock)){
				?>
				<p class="retour_tdb" id="retour_tdb" class="grey_caisse">Retour au tableau de bord</p>
				<?php
			}
		?>
	</td>
</tr>
</table>

<div id="recherche" class="corps_moteur">
<div id="recherche_simple" class="menu_link_affichage">
	<table style="width:97%">
		<tr class="smallheight">
			<td style="width:2%">&nbsp;</td>
			<td style="width:18%">&nbsp;</td>
			<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:12%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:3%; text-align: right"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<span class="labelled_text">Cat&eacute;gorie:</span>	</td>
			<td>
			<select  name="ref_art_categ_s" id="ref_art_categ_s" class="classinput_xsize">
			<option value="">Toutes</option>
			<?php
				$select_art_categ =	get_articles_categories();
				foreach ($select_art_categ  as $s_art_categ){
			?>
			<option value="<?php echo ($s_art_categ->ref_art_categ)?>">
			<?php for ($i=0; $i<$s_art_categ->indentation; $i++) {?>&nbsp;&nbsp;&nbsp;<?php }?><?php echo htmlentities($s_art_categ->lib_art_categ)?>
			</option>
			<?php
				}
			?>
			</select>	</td>
			<td ><div class="labelled_text" style=" text-align:right">Lieux de stockage:</div>
			</td>
			<td >
			<select name="id_stock_l"  class="classinput_xsize" id="id_stock_l">
				<?php 
				if (count($stocks_liste) > 1) {
				?><option value=""  <?php if (!isset($_REQUEST["id_stock"])) {?>selected="selected"<?php } ?>>Tous</option><?php
				}
					foreach ($stocks_liste as $stock_liste) {
					?>
				<option value="<?php echo $stock_liste->getId_stock (); ?>" <?php if (isset($_REQUEST["id_stock"]) && $_REQUEST["id_stock"] == $stock_liste->getId_stock ()) {?>selected="selected"<?php } ?>><?php echo htmlentities($stock_liste->getLib_stock()); ?></option>
				<?php }
					?>
			</select>			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><span class="labelled_text"  <?php if(!$GESTION_CONSTRUCTEUR){?>style="display:none"<?php } ?>>Constructeur:</span></td>
			<td>
				<select name="ref_constructeur_s" id="ref_constructeur_s" class="classinput_xsize" style=" <?php if(!$GESTION_CONSTRUCTEUR){?> display:none<?php } ?>"><option value=''>Tous</option></select>	
			</td>
			<td class="labelled_text" style=" text-align:right" >du&nbsp; :</td>
			<td >
				
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><input type="text" id="date_debut" name="date_debut" value="" class="classinput_nsize" /></td>
					<td>&nbsp;</td>
					<td class="labelled_text" style="width:23px" >au&nbsp; </td>
					<td><input type="text" id="date_fin" name="date_fin" value="" class="classinput_nsize" /></td>
					<td>
					<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
					</td>
				</tr>
			</table>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="text-align:right"><span style="text-align:right">
				<input name="form_recherche_s" id="form_recherche_s" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
			</span></td>
			<td style="padding-left:35px">&nbsp;</td>
			<td style="text-align:right">
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5"></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</div>



</div><br />
<br />


<div style="height:50px; width:99%">

<div id="stock_moves_liste" class="articletview_corps"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%;">

</div>

<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
</div>
<SCRIPT type="text/javascript">

function setheight_stock_move(){
set_tomax_height("stock_moves_liste" , -32);
}
Event.observe(window, "resize", setheight_stock_move, false);
setheight_stock_move();


//lance la recherche
Event.observe('form_recherche_s', "click", function(evt){
	page.stock_mouvements_result ($("id_stock_l").value);  
	Event.stop(evt);});

//
Event.observe('ref_constructeur_s', "click", function(evt){
	if ($("ref_constructeur_s").innerHTML == "<option value=\"\">Tous</option>") {
		var constructeurUpdater = new SelectUpdater("ref_constructeur_s", "constructeurs_liste.php?ref_art_categ="+$("ref_art_categ_s").value);
		constructeurUpdater.run("");
	}
});

Event.observe("retour_tdb", "click",  function(evt){
	Event.stop(evt);
	page.verify('stocks_gestion2','stocks_gestion2.php?id_stock=<?php echo $stock->getId_stock(); ?>','true','sub_content');
}, false);

//masque de date

	Event.observe("date_debut", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("date_fin", "blur", function(evt){
		datemask (evt);
	}, false);
	
//on charge le premier affichage
page.stock_mouvements_result ("<?php if (isset($_REQUEST["id_stock"])) { echo $_REQUEST["id_stock"];} else {echo $_SESSION['magasin']->getId_stock();}?>");
//on masque le chargement
H_loading();
</SCRIPT>