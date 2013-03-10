<?php

// *************************************************************************************************************
// AFFICHAGE DES STOCKS A RENOUVELER
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

</script>
<div id="main_doc_div" style="" class="emarge">

<table style="width:100%">
<tr>
	<td>
		<p class="titre">Stocks à renouveler</p>
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
<form>
<div id="recherche" class="corps_moteur">
<div id="recherche_simple" class="menu_link_affichage">
	<table style="width:97%">
		<tr class="smallheight">
			<td style="width:2%">&nbsp;</td>
			<td style="width:18%">&nbsp;</td>
			<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:17%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:3%; text-align: right"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<span class="labelled_text">Cat&eacute;gorie:</span>
			<input type="hidden" name="orderby_s" id="orderby_s" value="lib_article" />
			<input type="hidden" name="orderorder_s" id="orderorder_s" value="ASC" />
			</td>
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
			</select></td>
			<td style="padding-right:15px"><div class="labelled_text" style="text-align:right">Lieux de stockage:</div>		</td>
			<td rowspan="2">
			<select name="id_stock" class="classinput_lsize" id="id_stock">
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
			<td><span class="labelled_text" <?php if(!$GESTION_CONSTRUCTEUR){?>style="display:none"<?php } ?>>Constructeur:</span></td>
			<td>
				<select name="ref_constructeur_s" id="ref_constructeur_s" class="classinput_xsize" style=" <?php if(!$GESTION_CONSTRUCTEUR){?> display:none<?php } ?>"><option value=''>Tous</option></select>			</td>
			<td style="padding-left:35px">
			</td>
			<td>&nbsp;</td>
		</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right"><span style="text-align:right">
			<input name="form_recherche_s" id="form_recherche_s" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
		</span></td>
		<td style="padding-left:35px">
		<div style="height:5px"></div>
		<span id="print_stock_a_renouveller_span" style="display:block;  text-decoration:underline;cursor:pointer">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-imprimer.gif" alt="Imprimer" title="Imprimer" style="cursor:pointer" id="print_stock_a_renouveller"/>
		</span></td>
		<td style="text-align:right"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5"></td>
		<td>&nbsp;</td>
	</tr>
</table>
<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>

</div>


</div>
</form>
<div id="a_renouveller_resultat" class=""  style="width:100%;">
</div>

<script type="text/javascript">


//lance la recherche
Event.observe('form_recherche_s', "click", function(evt){
	stock_a_renouveller();  
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

Event.observe('print_stock_a_renouveller', "click", function(evt){
	Event.stop(evt);
	window.open("stocks_a_renouveller_result.php?recherche=1&print=1&page_to_show_s="+$("page_to_show_s").value+"&orderby="+$("orderby_s").value+"&orderorder="+$("orderorder_s").value+"&id_stock="+$("id_stock").value+"&ref_art_categ="+$("ref_art_categ_s").value+"&ref_constructeur="+$("ref_constructeur_s").value+"&id_stock="+$("id_stock").value, "_blank");
	
}, false);

	stock_a_renouveller();
//on masque le chargement
H_loading();

</script>