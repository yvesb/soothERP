<li id="composant_li_<?php echo $_REQUEST['serie_composant']?>">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td style="width:5%">
				<input id="ref_article_composant_<?php echo $_REQUEST['serie_composant']?>" name="ref_article_composant_<?php echo $_REQUEST['serie_composant']?>" value="<?php echo $_REQUEST['ref_article']?>" type="hidden"/>
			</td>
			<td style="width:15%" class="composant_li_qte">
				<input id="qte_composant_<?php echo $_REQUEST['serie_composant']?>" name="qte_composant_<?php echo $_REQUEST['serie_composant']?>" value="<?php echo $_REQUEST['valo_indice']?>" type="text"/>
				<input id="valo_indice_<?php echo $_REQUEST['serie_composant']?>" name="valo_indice_<?php echo $_REQUEST['serie_composant']?>" value="<?php echo $_REQUEST['valo_indice']?>" type="hidden"/>
			</td>
			<td style="width:55%" class="composant_li_lib">
				<span class="composant_li_lib_handle"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/main.gif"/></span>
				<span>
				<?php 
				if (count($composants_article)>>0) {
					?>
					<a href="#" id="link_compo_art_<?php echo $_REQUEST['serie_composant']?>"><?php echo ($_REQUEST['lib_article'])?></a>
					<script type="text/javascript">
					Event.observe("link_compo_art_<?php echo $_REQUEST['serie_composant']?>", "click",  function(evt){Event.stop(evt); Element.toggle('liste_de_sous_compo_<?php echo $_REQUEST['serie_composant']?>');}, false);
					</script>
					<div id="liste_de_sous_compo_<?php echo $_REQUEST['serie_composant']?>" style="display:none">
					<?php
					$under_compo_indet=0;
					while ($compo_list = current($composants_article) ){
						$under_compo_indet++;
						next($composants_article);
						?>
						<table cellpadding="0" cellspacing="0"  id="<?php echo ($compo_list->ref_article_lot.$_REQUEST['serie_composant'].$under_compo_indet)?>" style="width:96%">
							<tr id="tr_<?php echo ($compo_list->ref_article_lot.$_REQUEST['serie_composant'].$under_compo_indet)?>" class="list_art_categs"><td width="5px">
								<table cellpadding="0" cellspacing="0" width="5px"><tr><td>
								<?php 
								for ($i=0; $i<=$compo_list->indentation; $i++) {
									if ($i==$compo_list->indentation) {
									 
										if (key($composants_article)!="") {
											if ($compo_list->indentation < current($composants_article)->indentation) {
												
												?><a href="#" id="link_liste_compo_art_<?php echo $_REQUEST['serie_composant'].$i;?>">
												
												<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/extend.gif" width="14px" id="extend_<?php echo $compo_list->ref_article_lot.$_REQUEST['serie_composant'].$under_compo_indet?>"/>
												<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/collapse.gif" width="14px" id="collapse_<?php echo $compo_list->ref_article_lot.$_REQUEST['serie_composant'].$under_compo_indet?>" style="display:none"/>
												</a>
												<script type="text/javascript">
												Event.observe("link_liste_compo_art_<?php echo $_REQUEST['serie_composant'].$i;?>", "click",  function(evt){Event.stop(evt); Element.toggle('div_<?php echo $compo_list->ref_article_lot.$_REQUEST['serie_composant'].$under_compo_indet?>') ; Element.toggle('extend_<?php echo $compo_list->ref_article_lot.$_REQUEST['serie_composant'].$under_compo_indet?>'); Element.toggle('collapse_<?php echo $compo_list->ref_article_lot.$_REQUEST['serie_composant'].$under_compo_indet?>');}, false);
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
								echo '<div id="div_'.$compo_list->ref_article_lot.$_REQUEST['serie_composant'].$under_compo_indet.'" style="display:none;">';
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
				 echo ($_REQUEST['lib_article']);
				}
					?>
				</span>
			</td>
			<td style="width:20%" class="" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="composant_img_del_<?php echo $_REQUEST['serie_composant']?>" class="cursor_pointer"/></td>
			<td style="width:5%">&nbsp;</td>
		</tr>			
	</table>
	<script type="text/javascript">
	Event.observe( $("composant_img_del_<?php echo $_REQUEST['serie_composant']?>") , "click", function(){remove_tag("composant_li_<?php echo $_REQUEST['serie_composant']?>");});
	Event.observe("qte_composant_<?php echo $_REQUEST['serie_composant']?>", "blur", function(evt){verif_composant_valo(evt, "valo_indice_<?php echo $_REQUEST['serie_composant']?>");}, false);
	</script>
</li>