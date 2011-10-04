<?php
// *************************************************************************************************************
// commissionnements des catégories d'articles
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
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_commission_assistant.inc.php" ?>
<div class="emarge">
<div style=" float:right; text-align:right">
<span id="retour_compta_auto" style="cursor:pointer; text-decoration:underline">Retour au commissionnement des commerciaux</span>
<script type="text/javascript">
Event.observe('retour_compta_auto', 'click',  function(evt){
Event.stop(evt); 
page.verify('configuration_commission','configuration_commission.php','true','sub_content');
}, false);
</script>
</div>
<p class="titre">Commissionnement associés aux articles</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div style="padding-left:10px; padding-right:10px">

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
		<td><span class="labelled_text">R&eacute;f&eacute;rence, libell&eacute; ou code barre:</span></td>
		<td>
		<input type="text" name="lib_article_s" id="lib_article_s" value="<?php if (isset($_REQUEST["acc_ref_article"])) { echo htmlentities($_REQUEST["acc_ref_article"]);}
	?>"   class="classinput_xsize"/>
		</td>
		<td style="padding-left:35px">
		<div <?php if (!$GESTION_STOCK) {?> style="display:none"<?php } ?>>
				<input type="checkbox" name="in_stock_s" id="in_stock_s" value="1" />
				<span class="labelled_text">En Stock </span>
		</div>		
		</td>
		<td></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<span class="labelled_text">Cat&eacute;gorie:</span>
			<input type="hidden"value="" />
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
			</select>
			</td>
			<td style="padding-left:35px">
				
				<input type="checkbox" name="is_nouveau_s" id="is_nouveau_s" value="1" />
				<span class="labelled_text">Nouveaut&eacute;</span>
				</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><span class="labelled_text" <?php if(!$GESTION_CONSTRUCTEUR){?>style="display:none"<?php } ?>>Constructeur:</span></td>
			<td>
				<select name="ref_constructeur_s" id="ref_constructeur_s" class="classinput_xsize" style="width:100%; <?php if(!$GESTION_CONSTRUCTEUR){?> display:none;<?php } ?>"><option value=''>Tous</option></select>
			</td>
			<td style="padding-left:35px">
				<input type="checkbox" name="in_promotion_s" id="in_promotion_s" value="1" />
			<span class="labelled_text">Promotions</span>
				</td>
			<td></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right"><span style="text-align:right">
			<input name="submit2" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left" />
		</span></td>
		<td style="padding-left:35px">&nbsp;</td>
		<td>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_new_article.gif" id="create_new_article" style="cursor:pointer" />
		</td>
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
<div id="resultat_comm_art">
</div>
</div>
</td>
</tr>
</table>
<SCRIPT type="text/javascript">

//lance la recherche
Event.observe('form_recherche_s', "submit", function(evt){page.article_commission_recherche();  
	Event.stop(evt);});
	
Event.observe('ref_constructeur_s', "click", function(evt){
	if ($("ref_constructeur_s").innerHTML == "<option value=\"\">Tous</option>") {
		var constructeurUpdater = new SelectUpdater("ref_constructeur_s", "constructeurs_liste.php?ref_art_categ="+$("ref_art_categ_s").value);
		constructeurUpdater.run("");
	}
});


//observer le retour chariot lors de la saisie du code barre pour lancer la recherche
function submit_simple_if_Key_RETURN (event) {

	var key = event.which || event.keyCode; 
	switch (key) {   
	case Event.KEY_RETURN:     
	page.article_commission_recherche();   
	Event.stop(event);
	break;   
	}
}

//centrage de l'assistant commission

centrage_element("pop_up_assistant_comm_commission");
centrage_element("pop_up_assistant_comm_commission_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("pop_up_assistant_comm_commission_iframe");
centrage_element("pop_up_assistant_comm_commission");
});
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>