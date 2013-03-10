<?php

// *************************************************************************************************************
// VISUALISATION D'UN ARTICLE
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("Myarticle", "Mydoc", "qte_article", "liaisons_type_liste");
check_page_variables ($page_variables);

//******************************************************************
// Variables communes d'affichage
//******************************************************************

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<div class="articletview_corps" id="info_liaisons"  style="OVERFLOW-Y: auto; width:99%;" style="margin-left:5%; margin-right:5%;">
		<input type="hidden" name="serialisation_liaison" id="serialisation_liaison" value="0" />
		<?php
			$command_line_add_article = "";
			
			$num_serie = 0;
			foreach ($liaisons_type_liste as $liaison_type) {
				//echo "type liaison : ".$liaison_type->getId_liaison_type()."<br />";
				$liaisons_vers_autres_articles 		= $liaison_type->getArticle_liaisons_vers_autres_articles  ($Myarticle->getRef_article());
				$liaisons_depuis_autres_articles 	= $liaison_type->getArticle_liaisons_depuis_autres_articles($Myarticle->getRef_article());
				
				//echo $liaison_type->getId_liaison_type()."<br/>"; 
			?>
			<!-- ------------------ -->
			<!-- -------VERS------- -->
			<!-- ------------------ -->
			<div id="ligne_<?php echo $liaison_type->getId_liaison_type();?>_vers" style="width:100%; display:none;">
				<div class="liaison_type_title">
					<?php echo htmlentities(str_replace("%LIB_ARTICLE%", $Myarticle->getLib_article(), $liaison_type->getLib_liaison_type_vers())); ?>
				</div>
				<div style="width:100%;">
					<ul id="liaison_ul_<?php echo $liaison_type->getId_liaison_type(); ?>_vers" class="liste_liaison">
					<?php foreach ($liaisons_vers_autres_articles as $article_liaison_vers){
						//$liaisons_vers_autres_articles[n]["article"];
						//$liaisons_vers_autres_articles[n]["article_lie"];
						//$liaisons_vers_autres_articles[n]["id_liaison_type"];
						//$liaisons_vers_autres_articles[n]["ratio"]; 
						if ($liaison_type->getId_liaison_type() == 6) { //id_liaison_type : 6 => 	lib_liaison_type : Accessoires
							$Pack_liaison = Calcul_pack_equiv($Mydoc, $article_liaison_vers["article_lie"], $qte_article * $article_liaison_vers["ratio"]);
							//echo $article_liaison_vers["article_lie"]->getLib_article();
							//echo "<pre>";
							//var_dump($Pack_liaison);
							
							$count_pack = count($Pack_liaison);
							$debut_pack = $num_serie;
							$i = 1;
							
							//$Pack_liaison[ref_article_lie]["Ref_article"]
							//$Pack_liaison[ref_article_lie]["Ratio"]
							//$Pack_liaison[ref_article_lie]["Lib_article"]
							//$Pack_liaison[ref_article_lie]["Qte"]
							//$Pack_liaison[ref_article_lie]["Valo_indice"]
							//$Pack_liaison[ref_article_lie]["Prix"]
							?>
							<li id="liaison_li_<?php echo $num_serie;?>">
							<?php foreach($Pack_liaison as $Pack_liaison_ligne){ ?>
								<div id="liaison_div_<?php echo $num_serie;?>">
									<table width="100%" border="0">
										<tr>
											<td width="15%">
												<a href="#" id="link_to_article_<?php echo $num_serie;?>" style="text-decoration:none"><?php echo $Pack_liaison_ligne["Ref_article"];?></a>
												<script type="text/javascript">
													Event.observe("link_to_article_<?php echo $num_serie;?>", "click",  function(evt){
														Event.stop(evt);
														page.verify("catalogue_articles_view","index.php#"+escape("catalogue_articles_view.php?ref_article=<?php echo $Pack_liaison_ligne["Ref_article"];?>"),"true","_blank");
													}, false);
												</script>
											</td>
											<td width="27%">
												<?php echo $Pack_liaison_ligne["Lib_article"];?>
											</td>
											<td width="44%" align="right">
												ratio de 1 pour <?php echo round($Pack_liaison_ligne["Ratio"], $ARTICLE_QTE_NB_DEC); ?> : soit un total de <input type="text" id="new_art_qte_<?php echo $num_serie;?>" name="new_art_qte_<?php echo $num_serie;?>" value="<?php echo round($Pack_liaison_ligne["Qte"], $ARTICLE_QTE_NB_DEC);?>" class="classinput" size="5" />
												
												<input type="hidden"	id="liaison_ref_article_<?php echo $num_serie;?>"	name="liaison_ref_article_<?php echo $num_serie;?>" value="<?php echo $Pack_liaison_ligne["Ref_article"]?>">
												<input type="hidden"	id="ref_article_A_<?php echo $num_serie;?>"				name="ref_article_A_<?php echo $num_serie;?>" 			value="<?php //echo $liaison_type["article_lie"]->getRef_article();?>" />
												<input type="hidden"	id="ref_article_B_<?php echo $num_serie;?>"				name="ref_article_B_<?php echo $num_serie;?>" 			value="<?php //echo $liaison_type["article"]->getRef_article();?>" />
												<input type="hidden"	id="id_liaison_type_<?php echo $num_serie;?>" 		name="id_liaison_type_<?php echo $num_serie;?>"			value="<?php //echo $liaison_type["id_liaison_type"];?>" />
												<input type="hidden"	id="old_ratio_<?php echo $num_serie;?>" 					name="old_ratio_<?php echo $num_serie;?>"						value="<?php //echo $liaison_type["ratio"];?>" />
												<script type="text/javascript">
													<?php /*
													Event.observe("ratio_<?php echo $num_serie;?>", "blur", function(evt){
														//nummask(evt, 0, "X.X");
														var ratio =  parseFloat($("ratio_<?php echo $num_serie;?>").value.replace(",","."));
														var indice_valo = parseFloat(<?php echo $Pack_liaison_ligne["Valo_indice"]; ?>);
														
														if(indice_valo > 0 && $("appli_indice_valo").checked){
															//amélioration : appliquer l'indice de valorisation
														}
														
														var new_qte =  <?php echo $qte_article?> * ratio;
														$("new_art_qte_<?php echo $num_serie;?>").value =  new_qte.toFixed(<?php echo $ARTICLE_QTE_NB_DEC;?>);
													}, false);
													*/?>
												</script>
											</td>
											<td width="19%">
											<?php if($i == $count_pack) { ?>
												<img id="liaison_img_add_<?php echo $num_serie;?>" src="<?php echo $DIR.$_SESSION["theme"]->getDir_theme()?>images/bt-ajouter.gif"/>
												<script type="text/javascript">
													Event.observe("liaison_img_add_<?php echo $num_serie;?>", "click", function(evt){
														Event.stop(evt);
														//var new_art_qte = parseFloat($("new_art_qte_<?php echo $num_serie;?>").value.replace(",","."));
														liaisons_insert_pack(<?php echo '"'.$Mydoc->getRef_doc().'", '.$debut_pack.', '.count($Pack_liaison); ?>);
													}, false);
												</script>
											<?php } ?>
										</td>
									</tr>
								</table>
								</div>
							<?php $num_serie++; $i++; } ?>
							</li>
						<?php }else{ ?>
						<li id="liaison_li_<?php echo $num_serie;?>">
							<div id="liaison_div_<?php echo $num_serie;?>">
								<table width="100%" border="0">
									<tr>
										<td width="15%">
											<a href="#" id="link_to_article_<?php echo $num_serie;?>" style="text-decoration:none"><?php echo $article_liaison_vers["article_lie"]->getRef_article();?></a>
											<script type="text/javascript">
												Event.observe("link_to_article_<?php echo $num_serie;?>", "click",  function(evt){
													Event.stop(evt);
													page.verify("catalogue_articles_view","index.php#"+escape("catalogue_articles_view.php?ref_article=<?php echo $article_liaison_vers["article_lie"]->getRef_article();?>"),"true","_blank");
												}, false);
											</script>
										</td>
										<td width="27%">
											<?php echo $article_liaison_vers["article_lie"]->getLib_article();?>
										</td>
										<td width="44%" align="right">
											ratio de 1 pour <?php echo round($article_liaison_vers["ratio"], $ARTICLE_QTE_NB_DEC); ?> : soit un total de <input type="text"	id="new_art_qte_<?php echo $num_serie;?>"	name="new_art_qte_<?php echo $num_serie;?>"	value="<?php echo round($qte_article * $article_liaison_vers["ratio"], $ARTICLE_QTE_NB_DEC);?>" class="classinput" size="5" />
											<input type="hidden" id="ref_article_A_<?php echo $num_serie;?>"		name="ref_article_A_<?php echo $num_serie;?>" 		value="<?php echo $article_liaison_vers["article_lie"]->getRef_article();?>" />
											<input type="hidden" id="ref_article_B_<?php echo $num_serie;?>"		name="ref_article_B_<?php echo $num_serie;?>" 		value="<?php echo $article_liaison_vers["article"]->getRef_article();?>" />
											<input type="hidden" id="id_liaison_type_<?php echo $num_serie;?>" 	name="id_liaison_type_<?php echo $num_serie;?>"		value="<?php echo $article_liaison_vers["id_liaison_type"];?>" />
											<input type="hidden" id="old_ratio_<?php echo $num_serie;?>" 				name="old_ratio_<?php echo $num_serie;?>"					value="<?php echo $article_liaison_vers["ratio"];?>" />
											<script type="text/javascript">
											<?php /*
												Event.observe("ratio_<?php echo $num_serie;?>", "blur", function(evt){
													//nummask(evt, 0, "X.X");
													var ratio =  parseFloat($("ratio_<?php echo $num_serie;?>").value.replace(",","."));
													var indice_valo = parseFloat(<?php echo $Myarticle->getValo_indice(); ?>);
													
													if(indice_valo > 0 && $("appli_indice_valo").checked){
														//amélioration : appliquer l'indice de valorisation
													}
													
													var new_qte =  <?php echo $qte_article?> * ratio;
													$("new_art_qte_<?php echo $num_serie;?>").value =  new_qte.toFixed(<?php echo $ARTICLE_QTE_NB_DEC;?>);
												}, false);
												*/ ?>
											</script>
										</td>
										<td width="19%">
											<img id="liaison_img_add_<?php echo $num_serie;?>" src="<?php echo $DIR.$_SESSION["theme"]->getDir_theme()?>images/bt-ajouter.gif"/>
											<script type="text/javascript">
												Event.observe("liaison_img_add_<?php echo $num_serie;?>", "click", function(evt){
													Event.stop(evt);
													var new_art_qte = parseFloat($("new_art_qte_<?php echo $num_serie;?>").value.replace(",","."));
													add_new_line_article (<?php echo '"'.$Mydoc->getRef_doc().'", "'.$article_liaison_vers["article_lie"]->getRef_article().'", new_art_qte, '.$num_serie; ?>);
												}, false);
											</script>
									</td>
								</tr>
							</table>
							</div>
						</li>
						<?php $num_serie++;
						}
					} ?>
					</ul>
				</div>
				<?php if(count($liaisons_vers_autres_articles)>0) {?>				
				<script type="text/javascript">
						$("ligne_<?php echo $liaison_type->getId_liaison_type(); ?>_vers").show();
				</script>
				<?php }?>
				<br/>
			</div>
			<!-- ------------------ -->
			<!-- ------DEPUIS------ -->
			<!-- ------------------ -->
			<div id="ligne_<?php echo $liaison_type->getId_liaison_type(); ?>_depuis" style="width:100%; display:none;">
				<div class="liaison_type_title">
					<?php echo htmlentities(str_replace("%LIB_ARTICLE%", $Myarticle->getLib_article(), $liaison_type->getLib_liaison_type_depuis())); ?>
				</div>
				<div style="width:100%;">
					<ul id="liaison_ul_<?php echo $liaison_type->getId_liaison_type(); ?>_depuis" class="liste_liaison">
						<?php foreach ($liaisons_depuis_autres_articles as $article_liaison_depuis){ 
						//$liaisons_vers_autres_articles[n]["article"];
						//$liaisons_vers_autres_articles[n]["article_lie"];
						//$liaisons_vers_autres_articles[n]["id_liaison_type"];
						//$liaisons_vers_autres_articles[n]["ratio"];
						
						//id_liaison_type : 6 => 	lib_liaison_type : Accessoires
						if ($liaison_type->getId_liaison_type() == 6) { continue;} ?>
						<li id="liaison_li_<?php echo $num_serie;?>" >
							<div id="liaison_div_<?php echo $num_serie;?>" >
								<table width="100%" border="0">
									<tr>
										<td width="15%">
											<a href="#" id="link_to_article_<?php echo $num_serie;?>" style="text-decoration:none"><?php echo $article_liaison_depuis["article_lie"]->getRef_article();?></a>
											<script type="text/javascript">
												Event.observe("link_to_article_<?php echo $num_serie;?>", "click",  function(evt){
													Event.stop(evt);
													page.verify("catalogue_articles_view","index.php#"+escape("catalogue_articles_view.php?ref_article=<?php echo $article_liaison_depuis["article_lie"]->getRef_article();?>"),"true","_blank");
												}, false);
											</script>
										</td>
										<td width="27%">
											<?php echo $article_liaison_depuis["article_lie"]->getLib_article();?>
										</td>
										<td width="44%" align="right">
											ratio de <?php echo round($article_liaison_depuis["ratio"], $ARTICLE_QTE_NB_DEC);?> pour 1 : soit un total de <input type="text" id="new_art_qte_<?php echo $num_serie;?>"	name="new_art_qte_<?php echo $num_serie;?>"	value="<?php echo round($qte_article / $article_liaison_depuis["ratio"], $ARTICLE_QTE_NB_DEC);?>" class="classinput" size="5" />
										
											<input type="hidden"	id="ref_article_A_<?php echo $num_serie;?>" 	name="ref_article_A_<?php echo $num_serie;?>"		value="<?php echo $article_liaison_depuis["article"]->getRef_article();?>" />
											<input type="hidden"	id="ref_article_B_"<?php echo $num_serie;?>" 	name="ref_article_B_<?php echo $num_serie;?>"		value="<?php echo $article_liaison_depuis["article_lie"]->getRef_article();?>" />
											<input type="hidden"	id="id_liaison_type_<?php echo $num_serie;?>" name="id_liaison_type_<?php echo $num_serie;?>"	value="<?php echo $article_liaison_depuis["id_liaison_type"];?>" />
											<input type="hidden"	id="old_ratio_<?php echo $num_serie;?>" 			name="old_ratio_<?php echo $num_serie;?>"				value="<?php echo $article_liaison_depuis["ratio"];?>" />
											<script type="text/javascript">
												<?php /*
												Event.observe("ratio_<?php echo $num_serie;?>", "blur", function(evt){
													//nummask(evt, 0, "X.X");
													var ratio =  parseFloat($("ratio_<?php echo $num_serie;?>").value.replace(",","."));
													var indice_valo = parseFloat(<?php echo $Myarticle->getValo_indice(); ?>);
													
													if(indice_valo > 0 && $("appli_indice_valo").checked){
														//amélioration : appliquer l'indice de valorisation
													}
													
													var new_qte =  <?php echo $qte_article?> / ratio;
													$("new_art_qte_<?php echo $num_serie;?>").value =  new_qte.toFixed(<?php echo $ARTICLE_QTE_NB_DEC;?>);
												}, false);
												*/ ?>
											</script>
										</td>
										<td width="19%">
											<img id="liaison_img_add_<?php echo $num_serie;?>" src="<?php echo $DIR.$_SESSION["theme"]->getDir_theme()?>images/bt-ajouter.gif"/>
											<script type="text/javascript">
												Event.observe("liaison_img_add_<?php echo $num_serie;?>", "click", function(evt){
													Event.stop(evt);
													var new_art_qte = parseFloat($("new_art_qte_<?php echo $num_serie;?>").value.replace(",","."));
													add_new_line_article (<?php echo '"'.$Mydoc->getRef_doc().'", "'.$article_liaison_depuis["article_lie"]->getRef_article().'", new_art_qte, '.$num_serie; ?>);
												}, false);
											</script>
										</td>
									</tr>
								</table>
							</div>
						</li>
					<?php $num_serie++;
					} ?>
					</ul>
				</div>
				<?php if(count($liaisons_depuis_autres_articles) > 0 && $liaison_type->getId_liaison_type() != 6) {?>
				<script type="text/javascript">
					$("ligne_<?php echo $liaison_type->getId_liaison_type(); ?>_depuis").show();
				</script>
				<?php }?>
				<br/>
			</div>
		<?php 
			} ?>
			
			<div style="color:gray; display: none;">
				<?php if ($Myarticle->getValo_indice() > 0){ ?>
				<input id="appli_indice_valo" name="appli_indice_valo" type="checkbox" disabled="disabled" />
				Appliquer l'indice de valorisation : 
				<input type="text" disabled="disabled" style="width:50px;text-align:right;" value="<?php echo $Myarticle->getValo_indice(); ?>"/>	
				<?php }?>
			</div>
</div>
