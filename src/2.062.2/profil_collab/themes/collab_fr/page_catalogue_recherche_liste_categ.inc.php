<?php

// *************************************************************************************************************
// RECHERCHE D'UN ARTICLE LISTE DES CATEGORIES
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
				<table cellspacing="0"  id="table_categ_tous_s" style="width:100%"  class="simule_champ_content">
					<tr id="tr_tous_s" class="list_art_categs"><td width="5px">
						<td>
						<a href="#" id="mod_tous_s" style="display:block; width:100%">Toutes</a>
						</td></tr></table>
				<?php
				$list_art_categ =	get_articles_categories();
				while ($art_categ = current($list_art_categ) ){
					next($list_art_categ);
					?>
					
					<table cellspacing="0"  id="<?php echo ($art_categ->ref_art_categ)?>_s" style="width:100%"  class="simule_champ_content">
					<tr id="tr_<?php echo ($art_categ->ref_art_categ)?>_s" class="list_art_categs"><td width="5px">
						<table cellspacing="0" cellpadding="0" width="5px"><tr><td>
						<?php 
						for ($i=0; $i<=$art_categ->indentation; $i++) {
							if ($i==$art_categ->indentation) {
								if (key($list_art_categ)!="") {
									if ($art_categ->indentation < current($list_art_categ)->indentation) {
										?>
										<a href="#" id="link_art_categ_show_0<?php echo $art_categ->ref_art_categ;?>">
										<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/<?php if ($DEFAUT_LEVEL_CATEG_AFFICHED > $i) {echo "collapse";} else {echo "extend";}?>.gif" width="14px" id="extend_<?php echo $art_categ->ref_art_categ?>_s"/>
										<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/<?php if ($DEFAUT_LEVEL_CATEG_AFFICHED > $i) {echo "extend";} else {echo "collapse";}?>.gif" width="14px" id="collapse_<?php echo $art_categ->ref_art_categ?>_s" style="display:none"/></a>
										<script type="text/javascript">
										Event.observe("link_art_categ_show_0<?php echo $art_categ->ref_art_categ;?>", "click",  function(evt){Event.stop(evt); Element.toggle('div_<?php echo $art_categ->ref_art_categ?>_s') ; Element.toggle('extend_<?php echo $art_categ->ref_art_categ?>_s'); Element.toggle('collapse_<?php echo $art_categ->ref_art_categ?>_s');}, false);
										</script>
										<?php
									}
									else 
									{
										?>
										<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/>
										<?php
									}
								}
								else 
								{
									?>
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/>
									<?php
								}
							}
							else
							{
								?>
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/></td><td>
								<?php 
							}
						}
						?></td>
						</tr>
						</table>
						</td><td>
						<a href="#" id="mod_<?php echo ($art_categ->ref_art_categ)?>_s" style="display:block; width:100%"><?php echo htmlentities($art_categ->lib_art_categ)?>						</a>
						</td>
					</tr>
				</table>
				<?php 
				if (key($list_art_categ)!="") {
					if ($art_categ->indentation < current($list_art_categ)->indentation) {
						?>
						<div id="div_<?php echo $art_categ->ref_art_categ;?>_s" style=" <?php if ($DEFAUT_LEVEL_CATEG_AFFICHED <= $art_categ->indentation) {echo "display: none";} else {echo "";}?>">
						<?php
					}
					if ($art_categ->indentation > current($list_art_categ)->indentation) {
						for ($a=$art_categ->indentation; $a>current($list_art_categ)->indentation ; $a--) {
							echo '</div>';
						}
					}
				}
				
			}
			?>
<script type="text/javascript">

Event.observe('tr_tous_s', 'mouseover',  function(){changeclassname ('tr_tous_s', 'list_art_categs_hover');}, false);

Event.observe('tr_tous_s', 'mouseout',  function(){changeclassname ('tr_tous_s', 'list_art_categs');}, false);

Event.observe('mod_tous_s', 'click',  function(evt){
	Event.stop(evt);  
	$("ref_art_categ_s").value=""; 
	Element.toggle('liste_de_categorie_selectable_s'); 
	Element.toggle('iframe_liste_de_categorie_selectable_s'); 
	$("lib_art_categ_s").innerHTML="Toutes";
	var constructeurUpdater = new SelectUpdater("ref_constructeur_s", "constructeurs_liste.php?ref_art_categ="+$("ref_art_categ_s").value);
	constructeurUpdater.run("");
}, false);
<?php
foreach ($list_art_categ  as $art_categ){
	?>
	pre_start_art_categ ("<?php echo ($art_categ->ref_art_categ)?>", "<?php echo htmlentities($art_categ->lib_art_categ)?>", "_s");
	<?php 
}
?>
</script>