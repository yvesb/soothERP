<div id="lot_info">
<form action="catalogue_articles_view_valide.php?step=4" target="formFrame" method="post" name="article_edit_4" id="article_edit_4">
<input type="hidden" name="ref_article" id="ref_article" value="<?php echo $article->getRef_article ();?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width:5%">&nbsp;</td>
				<td colspan="2">&nbsp;</td>
				<td style="width:5%">&nbsp;</td>
			</tr>
			<tr>
				<td style="width:5%">&nbsp;</td>
				<td style="width:12%" class="composant_titre_qte">Quantit&eacute;</td>
				<td style="width:15%" class="composant_titre_ref">R&eacute;f&eacute;rence</td>
				<td style="width:75%" class="composant_titre_lib">Libell&eacute; du composant</td>
				<td style="width:5%">&nbsp;</td>
			</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width:5%">&nbsp;</td>
				<td colspan="2" style="width:90%"><div class="composant_type_title">Niveau 1</div>
					<input id="composant_niveau_1" name="composant_niveau_1" value="1" type="hidden"/>
				</td>
				<td style="width:5%">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="width:70%">				
				</td>
				<td style="width:20%" class="composant_add_art" >
			<a href="#" id="link_art_edition_composant">Ajouter un composant</a>
				<script type="text/javascript">
				Event.observe("link_art_edition_composant", "click",  function(evt){Event.stop(evt); show_mini_moteur_articles ('art_edition_add_composant', '1, 0');}, false);
				</script>
				</td>
				<td>&nbsp;</td>
			</tr>			
		</table>
	<ul id="composant_ul" class="liste_composant">
	<?php 
	$serialisation_composant = 2;
	$serialisation_niveau_composant = 1;
	$niveau_reel_composant = 1;
	foreach ($article_composants as $article_composant) {
		if ($niveau_reel_composant != 1) {
			$niveau_reel_composant = 1;
			$serialisation_niveau_composant++;
			?>
			<li id="composant_li_<?php echo $serialisation_composant;?>">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="width:5%">&nbsp;</td>
					<td colspan="2" style="width:90%">
						<div class="composant_type_title">
							Niveau <?php echo $serialisation_niveau_composant;?>
						</div>
						<input id="composant_niveau_<?php echo $serialisation_composant;?>" name="composant_niveau_<?php echo $serialisation_composant;?>" value="<?php echo $serialisation_niveau_composant;?>" type="hidden"/>
					</td>
					<td style="width:5%">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="width:70%">			
					</td>
					<td style="width:20%" class="composant_add_art" >
						<a href="#" id="link_art_edition_composant_<?php echo $serialisation_niveau_composant;?>_<?php echo $serialisation_composant;?>">Ajouter un composant</a>
						<script type="text/javascript">
						Event.observe("link_art_edition_composant_<?php echo $serialisation_niveau_composant;?>_<?php echo $serialisation_composant;?>", "click",  function(evt){Event.stop(evt); show_mini_moteur_articles ('art_edition_add_composant', '<?php echo $serialisation_niveau_composant;?>, <?php echo $serialisation_composant;?>');}, false);
						</script>
					</td>
					<td><span class="composant_li_lib_handle"></span>&nbsp;</td>
				</tr>			
			</table>
			</li>
			<?php 
		$serialisation_composant++;
	}
		?>
		<span class="composant_li_lib_handle"></span>
		<li id="composant_li_<?php echo $serialisation_composant;?>">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width:0%">
					<input id="ref_lot_contenu_<?php echo $serialisation_composant;?>" name="ref_lot_contenu_<?php echo $serialisation_composant;?>" value="<?php echo $article_composant->ref_lot_contenu?>" type="hidden"/>
					<input id="ref_article_composant_<?php echo $serialisation_composant;?>" name="ref_article_composant_<?php echo $serialisation_composant;?>" value="<?php echo $article_composant->ref_article_composant?>" type="hidden"/>
				</td>
				<td style="width:15%" class="composant_li_qte">
					<input id="qte_composant_<?php echo $serialisation_composant;?>" name="qte_composant_<?php echo $serialisation_composant;?>" value="<?php echo $article_composant->qte;?>" type="text"/>
					<input id="valo_indice_<?php echo $serialisation_composant;?>" name="valo_indice_<?php echo $serialisation_composant;?>" value="<?php echo $article_composant->valo_indice;?>" type="hidden"/>
					<input id="modif_composant_<?php echo $serialisation_composant;?>" name="modif_composant_<?php echo $serialisation_composant;?>" value="0" type="hidden"/>
					<input id="modif_ordre_composant_<?php echo $serialisation_composant;?>" name="modif_ordre_composant_<?php echo $serialisation_composant;?>" value="0" type="hidden"/>
				</td>
				<td style="width:auto" class="composant_li_ref">
					<div id="link_art_ref_<?php echo $serialisation_composant;?>" style="display:block; width:100%; cursor:pointer">
					<?php echo $article_composant->ref_article_composant?> </div>
					<script type="text/javascript">
					Event.observe("link_art_ref_<?php echo $serialisation_composant;?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo $article_composant->ref_article_composant?>'),'true','_blank');}, false);
					</script>
				</td>
				<td style="width:46%" class="composant_li_lib">
					<span class="composant_li_lib_handle"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/main.gif" id="move_composant_<?php echo $serialisation_composant;?>"/></span>
					
					<?php
					$composants_article = composant_order_by_lot ($composants_article, get_article_composants ($article_composant->ref_article_composant), "ref_article_lot", "lot", "ref_article_composant");
					if (count($composants_article)>0) {?>
					<a href="#" id="link_sous__composant_<?php echo $serialisation_composant;?>"><?php echo htmlentities($article_composant->lib_article)?></a>
					<script type="text/javascript">
Event.observe("link_sous__composant_<?php echo $serialisation_composant;?>", "click",  function(evt){Event.stop(evt); Element.toggle('liste_de_sous_compo_<?php echo $serialisation_composant;?>');}, false);
</script>
					<div id="liste_de_sous_compo_<?php echo $serialisation_composant;?>" style="display:none">
						<?php
						$under_compo_indet=0;
						while ($compo_list = current($composants_article) ){
							$under_compo_indet++;
							
							next($composants_article);
							?>
						<table cellpadding="0" cellspacing="0"  id="<?php echo ($compo_list->ref_article_lot.$serialisation_composant.$under_compo_indet)?>" style="width:96%">
							<tr id="tr_<?php echo ($compo_list->ref_article_lot.$serialisation_composant.$under_compo_indet)?>" class="list_art_categs"><td width="5px">
								<table cellpadding="0" cellspacing="0" width="5px"><tr><td>
								<?php 
								for ($i=0; $i<=$compo_list->indentation; $i++) {
									if ($i==$compo_list->indentation) {
										if (key($composants_article)!="") {
											if ($compo_list->indentation < current($composants_article)->indentation) {
												?><a href="#" id="link_art_categ_show_unshow<?php echo $serialisation_composant."_".$i;?>">
												<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/extend.gif" width="14px" id="extend_<?php echo $compo_list->ref_article_lot.$serialisation_composant.$under_compo_indet?>"/>
												<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/collapse.gif" width="14px" id="collapse_<?php echo $compo_list->ref_article_lot.$serialisation_composant.$under_compo_indet?>" style="display:none"/></a>
												<script type="text/javascript">
												Event.observe("link_art_categ_show_unshow<?php echo $serialisation_composant."_".$i;?>", "click",  function(evt){Event.stop(evt); Element.toggle('div_<?php echo $compo_list->ref_article_lot.$serialisation_composant.$under_compo_indet?>') ; Element.toggle('extend_<?php echo $compo_list->ref_article_lot.$serialisation_composant.$under_compo_indet?>'); Element.toggle('collapse_<?php echo $compo_list->ref_article_lot.$serialisation_composant.$under_compo_indet?>');}, false);
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
									<?php echo htmlentities($compo_list->lib_article)?>
								</td>
							</tr>
						</table>
						<?php 
						if (key($composants_article)!="") {
							if ($compo_list->indentation < current($composants_article)->indentation) {
								echo '<div id="div_'.$compo_list->ref_article_lot.$serialisation_composant.$under_compo_indet.'" style="display:none;">';
							}
							if ($compo_list->indentation > current($composants_article)->indentation) {
								for ($a=$compo_list->indentation; $a>current($composants_article)->indentation ; $a--) {
									echo '</div>';
								}
							}
						}
					}
					?>
					</div>
					<?php 
				} else {
				echo htmlentities($article_composant->lib_article);
				}
				?>
				
				</td>
				<td style="width:20%" class="" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="composant_img_del_<?php echo $serialisation_composant;?>" class="cursor_pointer"/></td>
				<td style="width:5%">&nbsp;</td>
			</tr>			
		</table>
		<script type="text/javascript">
		Event.observe( $("composant_img_del_<?php echo $serialisation_composant;?>") , "click", function(){alerte.confirm_supprimer_tag_and_callpage ( "composant_new_del", "composant_li_<?php echo $serialisation_composant;?>", "catalogue_articles_edition_composant_supp.php?ref_article=<?php echo $article->getRef_article ();?>&ref_lot_contenu=<?php echo $article_composant->ref_lot_contenu;?>");});
		
 		Event.observe("qte_composant_<?php echo $serialisation_composant;?>", "blur", function(evt){verif_composant_valo(evt, "valo_indice_<?php echo $serialisation_composant;?>"); $("modif_composant_<?php echo $serialisation_composant;?>").value="1";}, false);
		
		Event.observe( $("move_composant_<?php echo $serialisation_composant;?>") , "click", function(){ $("modif_ordre_composant_<?php echo $serialisation_composant;?>").value="1";});

                
		
                </script>
		</li>
		<?php 
	$serialisation_composant++;
	}$serialisation_niveau_composant++;
	?>
	</ul>
	<input type="hidden" name="serialisation_composant" id="serialisation_composant" value="<?php echo $serialisation_composant;?>" />
	<input type="hidden" name="serialisation_niveau_composant" id="serialisation_niveau_composant" value="<?php echo $serialisation_niveau_composant;?>" />
	<input type="hidden" name="liste_composant" id="liste_composant" value="" />
	<br />
	<table style="width:100%">
		<tr class="smallheight">
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td colspan="5" style="text-align:right">
				<a href="#" id="bt_etape_4"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" /></a>
			</td>
			<td></td>
		</tr>
	</table>
	</form>
<script type="text/javascript">
Sortable.create('composant_ul',{dropOnEmpty:true, ghosting:true, handle: 'composant_li_lib_handle'});
//fonction de validation de l'étape 4
function valide_etape_4() {
if (!$("composant_ul").empty()) {
var liste = Sortable.serialize('composant_ul');
liste = liste.replace(/composant_ul\[\]=/g,"");
		t_liste = liste.split("&");
		$("liste_composant").value=t_liste;
}
 	submitform ("article_edit_4"); 
} 
	
Event.observe($("bt_etape_4"), "click", function(evt){Event.stop(evt); valide_etape_4 ();});
</script>
</div>