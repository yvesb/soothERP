<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


// Formulaire de recherche
?>
<script type="text/javascript" language="javascript">
</script>
<iframe frameborder="0" scrolling="no" src="about:_blank" id="pop_up_mini_moteur_cata_iframe" class="mini_moteur_iframe"></iframe>
<div id="pop_up_mini_moteur_cata" class="mini_moteur">
<div id="recherche" class="corps_mini_moteur">
<div id="recherche_simple" >
	<a href="#" id="link_close_pop_up_mini_moteur_cata" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
	<script type="text/javascript">
	Event.observe("link_close_pop_up_mini_moteur_cata", "click",  function(evt){Event.stop(evt); close_mini_moteur_cata();}, false);
	</script>
<p style="font-weight:bolder">Recherche d'un article </p>
<form action="#" method="GET" id="form_mini_recherche_cata" name="form_mini_recherche_cata">
	<table style="width:97%">
		<tr class="smallheight">
			<td style="width:45%">
			<input type=hidden name="recherche" value="1" />
			<input type="hidden" name="id_tarif_cata_m" id="id_tarif_cata_m" value="" />
			<input type="hidden" name="id_stock_cata_m" id="id_stock_cata_m" value="<?php echo $_SESSION['magasin']->getId_stock();?>" />
			<input type="hidden" name="orderby_cata_m" id="orderby_cata_m" value="lib_article" />
			<input type="hidden" name="orderorder_cata_m" id="orderorder_cata_m" value="ASC" />
			<input type="hidden" name="fonction_retour_cata_m" id="fonction_retour_cata_m" value="" />
			<input type="hidden" name="param_retour_cata_m" id="param_retour_cata_m" value="" />
				<span class="labelled_text">Cat&eacute;gorie:</span></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			<td style="width:50%"><span class="labelled_text">R&eacute;f&eacute;rence, libell&eacute; ou code barre:</span></td>
		</tr>
		<tr>
			<td>
			<select  name="ref_art_categ_cata_m" id="ref_art_categ_cata_m" class="classinput_xsize">
			<option value="">Toutes</option>
			<?php
				$select_art_categ =	get_articles_categories("", array($LIVRAISON_MODE_ART_CATEG));
				foreach ($select_art_categ  as $s_art_categ){
			?>
			<option value="<?php echo ($s_art_categ->ref_art_categ)?>">
			<?php for ($i=0; $i<$s_art_categ->indentation; $i++) {?>&nbsp;&nbsp;&nbsp;<?php }?><?php echo htmlentities($s_art_categ->lib_art_categ)?>
			</option>
			<?php
				}
			?>
			</select>	</td>
			<td></td>
			<td><input type="text" name="lib_article_cata_m" id="lib_article_cata_m" value=""   class="classinput_xsize"/></td>
		</tr>
		<tr>
			<td><span class="labelled_text" <?php if(!$GESTION_CONSTRUCTEUR){?>style="display:none"<?php } ?>>Constructeur:</span></td>
			<td></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<select name="ref_constructeur_cata_m" id="ref_constructeur_cata_m" class="classinput_xsize" <?php if(!$GESTION_CONSTRUCTEUR){?>style="display:none"<?php } ?>><option value=''>Tous</option></select>
			</td>
			<td>
			</td>
			<td style="text-align:right">
			
				<input name="submit" type="image" onclick="$('page_to_show_cata_m').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif" style="float:left"/>
				<input type="image" name="annuler_mini_moteur" id="annuler_mini_moteur_cata_m" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>
			</td>
		</tr>
	</table>
	<input type="hidden" name="page_to_show_cata_m" id="page_to_show_cata_m" value="1"/>
</form>
</div>
</div>

<div id="resultat_cata" style="overflow:auto; height:215px"></div>

<SCRIPT type="text/javascript">
// bouton reset du formulaire

Event.observe('annuler_mini_moteur_cata_m', "click", function(evt){	Event.stop(evt); reset_mini_moteur_cata ('form_mini_recherche_cata', 'ref_art_categ_cata_m', "lib_article_cata_m", "ref_constructeur_cata_m", 'resultat_cata');});

//envois de la recherche
Event.observe('form_mini_recherche_cata', "submit", function(evt){page.catalogue_recherche_mini_simple();  
	Event.stop(evt);});

//
Event.observe('ref_constructeur_cata_m', "click", function(evt){
	if ($("ref_constructeur_cata_m").innerHTML == "<option value=\"\">Tous</option>") {
		var constructeurUpdater = new SelectUpdater("ref_constructeur_cata_m", "constructeurs_liste.php?ref_art_categ="+$("ref_art_categ_cata_m").value);
		constructeurUpdater.run("");
	}
});

//observer le retour chariot lors de la saisie du code barre pour lancer la recherche
function submit_simple_mini_if_Key_RETURN (event) {

	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:     
	page.catalogue_recherche_mini_simple();   
	Event.stop(event);
	break;   
	}
}
Event.observe('lib_article_cata_m', "keypress", function(evt){submit_simple_mini_if_Key_RETURN (evt);});
//on masque le chargement
H_loading();
</SCRIPT>
</div>