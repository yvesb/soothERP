<?php

// *************************************************************************************************************
// RECHERCHE DES ARTICLES DONT LE PRIX D'ACHAT N'EST PAS DÉFINI
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
<p class="titre">Prix d'achat non définis</p>

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
			<input type="hidden" name="id_tarif_s" id="id_tarif_s" value="<?php echo $_SESSION['magasin']->getId_tarif()?>" />
			<input type="hidden" name="id_stock_s" id="id_stock_s" value="<?php echo $_SESSION['magasin']->getId_stock()?>" />
			<input type="hidden" name="orderby_s" id="orderby_s" value="lib_article" />
			<input type="hidden" name="orderorder_s" id="orderorder_s" value="ASC" />
			<input type="hidden" name="app_tarifs_s" id="app_tarifs_s" value="<?php echo $DEFAUT_APP_TARIFS_CLIENT;?>" />
			<input type=hidden name="recherche" value="1" />
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
			<td style="padding-left:35px">
				<input type="checkbox" name="in_pa_zero_s" id="in_pa_zero_s" value="1" />
				<span class="labelled_text">Prix d'achat à zéro </span>			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr <?php if(!$GESTION_CONSTRUCTEUR){?>style="display:none"<?php } ?>>
			<td>&nbsp;</td>
			<td><span class="labelled_text">Constructeur:</span></td>
			<td>
				<select name="ref_constructeur_s" id="ref_constructeur_s" class="classinput_xsize" style="width:100%"><option value=''>Tous</option></select>
			</td>
			<td style="padding-left:35px">			</td>
			<td></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	<tr>
		<td>&nbsp;</td>
		<td><span class="labelled_text">R&eacute;f&eacute;rence, libell&eacute; ou code barre:</span></td>
		<td>
		<input type="text" name="lib_article_s" id="lib_article_s" value="<?php if (isset($_REQUEST["acc_ref_article"])) { echo htmlentities($_REQUEST["acc_ref_article"]);}
	?>"   class="classinput_xsize"/>
		</td>
		<td style="padding-left:35px"></td>
		<td></td>
		<td>&nbsp;</td>
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
		<td>&nbsp;</td>
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

<div id="resultat"></div>

</div>
<script type="text/javascript">


//focus sur champ code barre
$('lib_article_s').focus();


//remise à zero du formulaire
Event.observe('annuler_recherche_s', "click", function(evt){Event.stop(evt); reset_moteur_s ('form_recherche_s', 'ref_art_categ_s');	});

//lance la recherche
Event.observe('form_recherche_s', "submit", function(evt){page.catalogue_recherche_non_pa();  
	Event.stop(evt);});
	
//
Event.observe('ref_constructeur_s', "click", function(evt){
	if ($("ref_constructeur_s").innerHTML == "<option value=\"\">Tous</option>") {
		var constructeurUpdater = new SelectUpdater("ref_constructeur_s", "constructeurs_liste.php?ref_art_categ="+$("ref_art_categ_s").value);
		constructeurUpdater.run("");
	}
});

//blocage du retour chariot automatique à la saisie du code barre
function stopifcode_barre (event) {

	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:     
	Event.stop(event);
	break;   
	}
}
//observer le retour chariot lors de la saisie du code barre pour lancer la recherche
function submit_simple_if_Key_RETURN (event) {

	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:     
	page.catalogue_recherche_non_pa();   
	Event.stop(event);
	break;   
	}
}

Event.observe('lib_article_s', "keypress", function(evt){submit_simple_if_Key_RETURN (evt);});

//on masque le chargement
H_loading();
</SCRIPT>