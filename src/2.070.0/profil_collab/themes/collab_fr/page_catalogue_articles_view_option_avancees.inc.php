<?php

// *************************************************************************************************************
// OPTIONS AVANCEES D'UN ARTICLE 
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<script type="text/javascript">


</script>
<div style=" text-align:left; padding:20px">

<table style="width:100%">
	<tr class="smallheight">
		<td style="width:80%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td>
<form action="catalogue_articles_view_valide.php?ref_article=<?php echo $article->getRef_article();?>&step=0" target="formFrame" method="post" name="article_view_0" id="article_view_0">
<table style="width:100%">
	<tr class="smallheight">
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr><tr>
			<td class="labelled_text">Cat&eacute;gorie:</td>
			<td class="labelled_text"><?php echo ($article->getLib_art_categ ());?>			</td>
			<td colspan="2"><a href="#" id="modif_art_categ" style="color:#000000; <?php if  ($article->getVariante () != 0 || $article->getId_modele_spe ()) {?>		 display:none;<?php } ?>" >Modifier la cat&eacute;gorie</a></td>

		</tr>
		<tr>
			<td style="width:20%" class="labelled_text">Libell&eacute;:			</td>
			<td  style="width:25%"><textarea name="lib_article" class="classinput_xsize" id="lib_article"><?php echo str_replace("&curren;", "&euro;", $article->getLib_article ());?></textarea></td>
			<td>&nbsp;</td>
			
			<td>&nbsp;</td>
		</tr>
		<tr>
			<?php 
			if($GESTION_LIB_TICKET){
				?>
				<td class="labelled_text">
				Libell&eacute; court:			</td>
				<td>
					<input type="text" name="lib_ticket" id="lib_ticket" value="<?php echo str_replace("&curren;", "&euro;", $article->getLib_ticket ());?>"  class="classinput_xsize"/>			</td>
				<td>&nbsp;</td>
				<?php 
			}else{ 
				?>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<?php 
			}
			?>
			<td>&nbsp;</td>
		</tr>
		<tr> 
			<td class="labelled_text">Date de d&eacute;but de disponibilit&eacute;: </td>
			<td><input type="text" name="date_debut_dispo" id="date_debut_dispo" value="<?php if ($article->getDate_debut_dispo ()!=0000-00-00) {echo  (date_Us_to_Fr($article->getDate_debut_dispo ()));}?>"  class="classinput_xsize"/></td>
			<td>&nbsp;</td>
			<td class="labelled_text">&nbsp;</td>
		</tr>
		<tr>
			<td class="labelled_text">Date de fin de disponibilit&eacute;: <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/infinite.gif" style="cursor:pointer" id="infinite"/></td>
			<td>
			
			<input type="text" name="date_fin_dispo" id="date_fin_dispo" value="<?php 
			if ($article->getDate_fin_dispo()!=0000-00-00) {
				$an_fin_dispo = substr(($article->getDate_fin_dispo()), 0 , 4) ;
			
				echo (date_Us_to_Fr($article->getDate_fin_dispo()));
			} else { 
				$an_fin_dispo = substr(($article->getDate_fin_dispo()), 0 , 4) ;
				echo date("d-m-Y", mktime (date("m"),date("i"),date("s")+$art_categs->getDuree_dispo(), date("m"), date("d"), date("Y")))  ;
			} 
			?>"  class="classinput_xsize" style="<?php if ($an_fin_dispo >2099) {echo "display: none";}?>"/>
			<span id="infinite_choix" style="<?php if ($an_fin_dispo <2099) {echo "display: none;";}?> width:33%">Durée infinie &nbsp;</span>
			
			<script type="text/javascript">
			Event.observe('infinite', 'click',  function(evt){
			Event.stop(evt); 
			if ($('date_fin_dispo').style.display == "") {
				$('date_fin_dispo').value = "<?php echo date("d-m-2200", mktime (0 ,0 ,0 , date("m"), date("d"), date("Y"))) ;?>" ;
			}
			Element.toggle('infinite_choix'); 
			Element.toggle('date_fin_dispo');
			}, false);
			</script>
			</td>
			<td colspan="2">
				<span style="cursor:pointer" id="fin_dispo" name="fin_dispo" >Fin de vie</span>
				<script type="text/javascript">
				Event.observe("fin_dispo", "click", function(evt){
					Event.stop(evt);
					fin_dispo_va("<?php echo $article->getRef_article();?>", "art_in_arch");
				}, false);
				</script>			</td>
		</tr>
		<tr>
			<td class="labelled_text">Valorisation:</td>
			<td>
			<select name="id_valo" id="id_valo" class="classinput_xsize">
				<?php 
				$prev_grp = "";
				foreach (get_valorisations() as $valorisation) {
					if ($valorisation->groupe != $prev_grp) {
						?>
						<optgroup disabled="disabled" label="<?php echo $valorisation->groupe;?>"></optgroup>
						<?php 
						$prev_grp = $valorisation->groupe;
					}
					?>
					<option value="<?php echo $valorisation->id_valo;?>" <?php 
				if ($article->getId_valo()== $valorisation->id_valo) {echo 'selected="selected"';} ?>><?php echo $valorisation->lib_valo;?></option>
					<?php 
				}
				?>
			</select>
			</td>
			<td>&nbsp;</td>
			<td class="labelled_text">&nbsp;</td>
		</tr>
		<tr>
			<td class="labelled_text">Indice de valorisation: </td>
			<td><input type="text" name="valo_indice" id="valo_indice" value="<?php echo ($article->getValo_indice ());?>"  class="classinput_nsize"/></td>
			<td>&nbsp;</td>
			<td class="labelled_text">&nbsp;</td>
		</tr>
		<tr <?php if($art_categs->isRestrict_to_ventes()){ echo "style='display:none;'"; }  ?> >
			<td class="labelled_text">L'article peut &ecirc;tre achet&eacute;:</td>
			<td>
				<select name="is_achetable" id="is__achetable" class="classinput_nsize">
					<option value="1" <?php if ($article->isAchetable() == true) { echo 'selected="selected"'; } ?>>Oui</option>
					<option value="0" <?php if ($article->isAchetable() == false) { echo 'selected="selected"'; } ?>>Non</option>
					</select>
			</td>
		</tr>
		<tr <?php if($art_categs->isRestrict_to_achats()){ echo "style='display:none;'"; }  ?> >
			<td class="labelled_text">L'article peut &ecirc;tre commercialis&eacute;:</td>
			<td>
				<select name="is_vendable" id="is__vendable" class="classinput_nsize">
					<option value="1" <?php if ($article->isVendable() == true) { echo 'selected="selected"'; } ?>>Oui</option>
					<option value="0" <?php if ($article->isVendable() == false) { echo 'selected="selected"'; } ?>>Non</option>
					</select>
			</td>
		</tr>
		<tr>
			<td class="labelled_text">Article compos&eacute; :</td>
			<td>
			<select name="lot" id="lot" class="classinput_xsize">
				<option value="0" <?php if ($article->getLot () == 0) { ?> selected="selected"<?php } ?>>Article simple</option>
				<option value="1" <?php if ($article->getLot () == 1) { ?> selected="selected"<?php } ?>>Article à fabriquer</option>
				<option value="2" <?php if ($article->getLot () == 2) { ?> selected="selected"<?php } ?>>Composition Interne</option>
				<option value="3" <?php if ($article->getLot () == 3) { ?> selected="selected"<?php } ?>>Composition Fabriquant</option>
			</select>
			</td>
				
			<td>&nbsp;</td>
			<td class="labelled_text">&nbsp;</td>
		</tr>
		<tr>
			<?php 
			if ($GESTION_SN) {
				?>
			<td class="labelled_text">Identifiant de traçabilité:</td>
			<td>	
			
		<select name="gestion_sn" id="gestion_sn" class="classinput_hsize">
					<option value="0" <?php if ($article->getGestion_sn () == 0) {echo 'selected="selected"';} ?>>Aucun</option>
					<option value="1" <?php if ($article->getGestion_sn () == 1) {echo 'selected="selected"';} ?>>Numéro de s&eacute;rie</option>
					<option value="2" <?php if ($article->getGestion_sn () == 2) {echo 'selected="selected"';} ?>>Numéro de lot</option>
			</select>
			</td>
				<?php 
			}else{
				?>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<?php 
			} 
			?>
			<td>&nbsp;</td>
			<td class="labelled_text"></td>
		</tr>
		<tr>
			<td class="labelled_text"></td>
			<td style="text-align:right">
<a href="#" id="bt_etape_0"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" /></a></td>
			<td>&nbsp;</td>
			<td class="labelled_text"></td>
		</tr>
</table>
</form>
		</td>
		<td> 
		<?php if ($article->getVariante() == 0 && !$article->getId_modele_spe ()) { ?>
		<a  href="#" id="link_fusion" class="common_link">Fusionner cet article.</a><br />
Les documents et quantités en stock de l'article en cours seront attribués à l'article choisi.
			<script type="text/javascript">
			Event.observe("link_fusion", "click",  function(evt){
			Event.stop(evt); 
			show_mini_moteur_articles ('art_edition_fusion_choix', '"<?php echo $article->getRef_article ();?>"');
			
			}, false);
			</script>
		<?php } ?>
		<br /><br /><br />

		<?php 
		// Interdiction de dupliquer si interdit de voir prix d'achat
		if ($article->getVariante() == 0 && !$article->getId_modele_spe () && $_SESSION['user']->check_permission ("6")) { ?>
		<a  href="#" id="link_dupliquer_article" class="common_link">Dupliquer cet article </a>
		<script type="text/javascript">
		Event.observe("link_dupliquer_article", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_duplicate','catalogue_articles_duplicate.php?ref_article=<?php echo $article->getRef_article ();?>','true','sub_content');}, false);
		</script>
		<?php } ?>
		</td>
	</tr>
</table>
<br />
<br />
</div>
<SCRIPT type="text/javascript">

//fonction de validation de l'étape 0
function valide_etape_0() {
	if ($("lib_article").value!="") {	
		$("lib_article").className="classinput_xsize";
		submitform ("article_view_0"); 
	} else {
		$("lib_article").className="alerteform_xsize";
		$("lib_article").focus();
	}
}

Event.observe($("bt_etape_0"), "click", function(evt){Event.stop(evt); valide_etape_0 ();});

Event.observe('modif_art_categ', "click", function(evt){Event.stop(evt);  show_edition_art_categ ()});


//on masque le chargement
H_loading();
</SCRIPT>