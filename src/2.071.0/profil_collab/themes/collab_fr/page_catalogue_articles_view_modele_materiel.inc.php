<form action="catalogue_articles_view_valide.php?ref_article=<?php echo $article->getRef_article();?>&step=3" target="formFrame" method="post" name="article_view_3" id="article_view_3">
	<input type="hidden" name="modele" id="modele" value="<?php echo $art_categs->getModele()?>" />
	<table style="width:100%; display:none" id="edit_info_step3" >
		<tr>
			<td style="width:40%" class="labelled_text">Poids: </td>
			<td style="width:16%"><input type="text" name="poids" id="poids" value="<?php echo $article->getPoids ();?>"  class="classinput_xsize"/></td>
			<td style="width:49%">Kg</td>
		</tr>
		<tr>
			<td class="labelled_text">Colisage:</td>
			<td>
				<input type="text" name="colisage" id="colisage" value="<?php echo $article->getColisage ();?>"  class="classinput_xsize"/>			</td>
			<td >Ex: 1;5;20</td>
		</tr>
		<tr>
			<td class="labelled_text">Dur&eacute;e de Garantie: </td>
			<td><input type="text" name="dure_garantie" id="dure_garantie" value="<?php echo $article->getDuree_garantie ();?>"  class="classinput_xsize"/></td>
			<td >mois</td>
		</tr>
		
	</table>
	<table style="width:100%" id="view_info_step3">
		<tr>
			<td style="width:40%" class="labelled_text">Poids: </td>
			<td style="width:16%; text-align:right">
			
				<a href="#" id="link_show_poids" class="modif_textarea3">
				<?php echo $article->getPoids ();?>
				</a>
				<script type="text/javascript">
				Event.observe("link_show_poids", "click",  function(evt){Event.stop(evt); showform('edit_info_step3', 'view_info_step3'); $("edit_etape_3").hide(); $("bt_etape_3b").show();}, false);
				</script>
			</td>
			<td style="width:49%">Kg</td>
		</tr>
		<tr>
			<td class="labelled_text">Colisage:</td>
			<td style="text-align:right">
				<a href="#" id="link_show_colisage" class="modif_textarea3">
				<?php echo $article->getColisage ();?>
				</a>
				<script type="text/javascript">
				Event.observe("link_show_colisage", "click",  function(evt){Event.stop(evt); showform('edit_info_step3', 'view_info_step3'); $("edit_etape_3").hide(); $("bt_etape_3b").show();}, false);
				</script>
			</td>
			<td ></td>
		</tr>
		<tr>
			<td class="labelled_text">Dur&eacute;e de Garantie: </td>
			<td style="text-align:right">
			
				<a href="#" id="link_show_duree_garantie" class="modif_textarea3">
				<?php echo $article->getDuree_garantie ();?>
				</a>
				<script type="text/javascript">
				Event.observe("link_show_duree_garantie", "click",  function(evt){Event.stop(evt); showform('edit_info_step3', 'view_info_step3'); $("edit_etape_3").hide(); $("bt_etape_3b").show();}, false);
				</script>
			</td>
			<td >mois</td>
		</tr>
		
	</table>
				<div style="text-align:right; padding-right:5px">
				<a href="#" id="bt_etape_3b" style="display:none"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" /></a>
				<a href="#" id="edit_etape_3" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" /></a>
				</div>
					<script type="text/javascript">
					Event.observe("edit_etape_3", "focus",  function(evt){Event.stop(evt); showform('edit_info_step3', 'view_info_step3'); $("edit_etape_3").hide(); $("bt_etape_3b").show();}, false);
					</script>
</form>
<SCRIPT type="text/javascript">
Event.observe("poids", "blur", function(evt){nummask(evt,"0", "X.X");}, false);
Event.observe("dure_garantie", "blur", function(evt){nummask(evt,"<?php echo $article->getDuree_garantie ();?>", "X");}, false);
 Event.observe("colisage", "blur", function(evt){
	 nummask(evt,"<?php echo $article->getColisage ();?>", "X.XX;X.XX");
	 
	 }, false);		

//fonction de validation de l'étape 0
function valide_etape_3() {
		submitform ("article_view_3"); 
}

Event.observe($("bt_etape_3b"), "click", function(evt){Event.stop(evt); valide_etape_3 ();});
//on masque le chargement
H_loading();
</SCRIPT>