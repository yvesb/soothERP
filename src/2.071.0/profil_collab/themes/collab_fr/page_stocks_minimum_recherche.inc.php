<?php

// *************************************************************************************************************
// RECHERCHE DES MINIMUMS DE STOCK
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Formulaire de recherche
?>

<script type="text/javascript" language="javascript">
</script>
<div class="emarge">
<p class="titre">Alertes des stocks Minimum</p>

<div id="recherche" class="corps_moteur">
<div id="recherche_simple" class="menu_link_affichage">
<form action="#" method="GET" id="form_recherche_s" name="form_recherche_s">
	<table style="width:97%">
		<tr class="smallheight">
			<td style="width:2%">&nbsp;</td>
			<td style="width:25%">&nbsp;</td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:10%">&nbsp;</td>
			<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:3%">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<span class="labelled_text">Cat&eacute;gorie:</span>
			<input type="hidden" name="id_stock_s" id="id_stock_s" value="" />
			<input type="hidden" name="orderby_s" id="orderby_s" value="lib_article" />
			<input type="hidden" name="orderorder_s" id="orderorder_s" value="ASC" />
			<input type=hidden name="recherche" value="1" />			</td>
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
			<td style="padding-left:35px">
				<input type="checkbox" name="aff_pa_s" id="aff_pa_s" value="1" />
				<span class="labelled_text">Afficher Prix d'achat</span>			</td>
			<td><span class="labelled_text">Lieux de stockage:</span></td>
			<td rowspan="2">
			<select name="id_stock_l" size="3" multiple="multiple" class="" id="id_stock_l">
				<?php 
				if (count($stocks_liste) > 1) {
				?><option value="" >Tous</option><?php
				}
					foreach ($stocks_liste as $stock_liste) {
					?>
				<option value="<?php echo $stock_liste->getId_stock (); ?>"><?php echo htmlentities($stock_liste->getLib_stock()); ?></option>
				<?php }
					?>
			</select>
			<td>&nbsp;</td>
		</tr>
		
		<tr <?php if(!$GESTION_CONSTRUCTEUR){?>style="display:none"<?php } ?>>
			<td>&nbsp;</td>
			<td><span class="labelled_text">Constructeur:</span></td>
			<td>
				<select name="ref_constructeur_s" id="ref_constructeur_s" class="classinput_xsize" style="width:100%"><option value=''>Tous</option></select>			</td>
			<td style="padding-left:35px">			</td>
			<td></td>
			<td>&nbsp;</td>
		</tr>
		
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right"><span style="text-align:right">
			<input name="submit2" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
			<input type="image" name="annuler_recherche_s" id="annuler_recherche_s" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
		</span></td>
		<td style="padding-left:35px">&nbsp;</td>
		<td>		</td>
		<td style="text-align:right">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5"></td>
		<td>&nbsp;</td>
	</tr>
</table>
<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
</form>
</div>



</div>

<div id="resultat" ></div>

</div>
<script type="text/javascript">
//remise à zero du formulaire
Event.observe('annuler_recherche_s', "click", function(evt){Event.stop(evt); reset_moteur_s ('form_recherche_s', 'ref_art_categ_s');	});

//lance la recherche
Event.observe('form_recherche_s', "submit", function(evt){page.stock_minimum_recherche_simple();  
	Event.stop(evt);});
	
	
//
Event.observe('ref_constructeur_s', "click", function(evt){
	if ($("ref_constructeur_s").innerHTML == "<option value=\"\">Tous</option>") {
		var constructeurUpdater = new SelectUpdater("ref_constructeur_s", "constructeurs_liste.php?ref_art_categ="+$("ref_art_categ_s").value);
		constructeurUpdater.run("");
	}
});



//remplissage si on fait un retour dans l'historique
if (historique_request[5][0] == historique[0] && (default_show_id == "from_histo" || default_show_id == "to_histo")) {
	//history sur recherche simple
	if (historique_request[5][1] == "simple") {
	//$("lib_art_categ_s").innerHTML = historique_request[5]["lib_art_categ_s"];
	//$('ref_art_categ_s').value = 		historique_request[5]["ref_art_categ_s"];
	
	preselect ((historique_request[5]["ref_art_categ_s"]), 'ref_art_categ_s') ;
	preselect ((historique_request[5]["ref_constructeur_s"]), 'ref_constructeur_s') ;
	
	if (historique_request[5]["in_stock_s"] == "1") {	$('page_to_show_s').checked = true;	}
	
	$('page_to_show_s').value = 	historique_request[5]["page_to_show_s"];  
	$('orderby_s').value = 	historique_request[5]["orderby_s"]; 
	$('orderorder_s').value = 	historique_request[5]["orderorder_s"];
	
	$('id_stock_s').value = 	historique_request[5]["id_stock_s"];
	
	page.stock_minimum_recherche_simple();
	}
	
}
//on masque le chargement
H_loading();
</SCRIPT>