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

<p class="titre">Stocks à Transférer</p>

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
			<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
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
			<td style="padding-right:15px"><div class="labelled_text" style="text-align:right">De:</div>		</td>
			<td rowspan="2">
				<select id="stock_depart" name="stock_depart" class="classinput_nsize" >
				<?php 
				foreach ($_SESSION['stocks'] as $stocks) {
					?>
					<option value="<?php echo $stocks->getId_stock ();?>"><?php echo htmlentities($stocks->getLib_stock ());?></option>
					<?php
				}
				?>
				
				</select>
				 vers 
				<select id="stock_arrivee" name="stock_arrivee" class="classinput_nsize" >
				<?php 
				foreach ($_SESSION['stocks'] as $stocks) {
					?>
					<option value="<?php echo $stocks->getId_stock ();?>"><?php echo htmlentities($stocks->getLib_stock ());?></option>
					<?php
				}
				?>
				
				</select>
			</td>
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
		<td style="padding-left:35px">&nbsp;</td>
		<td style="text-align:right"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5"></td>
		<td>&nbsp;</td>
	</tr>
</table>

</div>


</div>
</form>



<div id="a_transferer_resultat" class=""  style="width:100%;">
</div>

<script type="text/javascript">

//lance la recherche
Event.observe('form_recherche_s', "click", function(evt){
	$("page_to_show_s").value = "1";
	stock_a_transferer();  
	Event.stop(evt);});

//
Event.observe('ref_constructeur_s', "click", function(evt){
	if ($("ref_constructeur_s").innerHTML == "<option value=\"\">Tous</option>") {
		var constructeurUpdater = new SelectUpdater("ref_constructeur_s", "constructeurs_liste.php?ref_art_categ="+$("ref_art_categ_s").value);
		constructeurUpdater.run("");
	}
});


//on masque le chargement
H_loading();

</script>