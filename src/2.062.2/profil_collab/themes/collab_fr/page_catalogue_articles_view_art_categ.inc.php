
<iframe frameborder="0" scrolling="no" src="about:_blank" id="pop_up_edition_art_categ_iframe" class="edition_art_iframe"></iframe>
<div id="pop_up_edition_art_categ" class="edition_art_table" style="OVERFLOW-Y: auto; OVERFLOW-X: auto;">
<div style="display:block">
<a href="#" id="link_close_pop_up_art_categ" style="float:right"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
<script type="text/javascript">
Event.observe("link_close_pop_up_art_categ", "click",  function(evt){Event.stop(evt); close_edition_art_categ('pop_up_edition_art', 'pop_up_edition_art_iframe', 'form_edition_art');}, false);
</script>
	<p class="edition_art_titre">Modifier la cat&eacute;gorie</p>


<form id="form_edition_art" name="form_edition_art" method="post" action="catalogue_view_maj_art_categ.php" target="formFrame">
<input type="hidden" name="old_ref_art_categ" id="old_ref_art_categ" value="<?php echo $article->getRef_art_categ ();?>" />
<input type="hidden" name="mod_ref_article" id="mod_ref_article" value="<?php echo $article->getRef_article ();?>" />
<input type="hidden" name="mod_modele" id="mod_modele" value="<?php echo $art_categs->getModele();?>" />
<input type="hidden" name="old_lib_art_categ" id="old_lib_art_categ" value="<?php echo htmlentities($article->getLib_art_categ ());?>" />
	<table style="width:100%">
		<tr >
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:45%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:45%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text">Nouvelle cat&eacute;gorie:</td>
			<td>
			<select  name="mod_ref_art_categ" id="mod_ref_art_categ" class="classinput_xsize">
			<?php
				$select_art_categ =	get_articles_categories("", array($LIVRAISON_MODE_ART_CATEG));
				foreach ($select_art_categ  as $s_art_categ){
			?>
			<option value="<?php echo ($s_art_categ->ref_art_categ)?>" <?php if ($s_art_categ->ref_art_categ == $article->getRef_art_categ ()) {?> selected="selected"<?php }?>>
			<?php for ($i=0; $i<$s_art_categ->indentation; $i++) {?>&nbsp;&nbsp;&nbsp;<?php }?><?php echo htmlentities($s_art_categ->lib_art_categ)?>
			</option>
			<?php
				}
			?>
			</select>
			</td>
		</tr>
	</table>
	<div id="new_modele_info">
	<?php include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_articles_edition_new_modele_".$art_categs->getModele().".inc.php");?>
	</div>
	<div style="width:100%; background-color:#FF0000; color:#000000; text-align:center">
		<p><span style="font-weight:bolder">ATTENTION!</span><br />
			Le changement de cat&eacute;gorie de cet article 
			va provoquer la r&eacute;initialisation des caract&eacute;ristiques ainsi que des tarifs. </p>
		<p>Cette action n'est pas r&eacute;versible. </p>
	</div>
	<div style="text-align:center">
		<input type="image" name="modifier_categ" id="modifier_categ" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
	</div>
</form>
</div>
<script type="text/javascript">
//------------------------------------------------------------------------------------
// select de la catégorie
//
//------------------------------------------------------------------------------------

function changeref_art_categ() { 
var AppelAjax = new Ajax.Request(
							"catalogue_articles_edition_test_modele_info.php", 
							{
							parameters: {ref_art_categ: $("mod_ref_art_categ").value, old_ref_art_categ: $("old_ref_art_categ").value},
							evalScripts:true, 
							onLoading:S_loading, onException: function () {S_failure();},
							onSuccess: function (requester){
								if (requester.responseText == "new") {
									page.traitecontent('catalogue_articles_modele_info_bis','catalogue_articles_edition_new_modele_info.php?ref_art_categ='+$("mod_ref_art_categ").value,'true','new_modele_info'); 
									$("old_ref_art_categ").value = $("mod_ref_art_categ").value;
								}
								H_loading();
							
							}
							}
							);
}

function show_info(){
//$("info_gene_art").style.display="block";
}


Event.observe('mod_ref_art_categ', 'change',  function(evt){
	Event.stop(evt); 
	changeref_art_categ3();
}, false);
					
//
//fin de la gestion du select de catégorie
//
</script>
</div>