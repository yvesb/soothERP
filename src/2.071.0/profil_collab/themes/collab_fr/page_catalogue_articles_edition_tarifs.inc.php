<form action="catalogue_articles_edition_valide.php?step=3" target="formFrame" method="post" name="article_edit_3" id="article_edit_3">
<input type="hidden" name="ref_article" id="ref_article" value="<?php echo $article->getRef_article ();?>" />
	<table style="width:100%">
		<tr>
			<td style="width:2%">&nbsp;</td>
			<td style="width:20%">&nbsp;</td>
			<td style="width:25%">&nbsp;</td>
			<td style="width:5%">&nbsp;</td>
			<td style="width:20%">&nbsp;</td>
			<td style="width:25%">&nbsp;</td>
			<td style="width:3%">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text">Prix public: </td>
			<td>
				<input type="text" name="prix_public_ht" id="prix_public_ht" value="<?php echo number_format($article->getPrix_public_ht (),$TARIFS_NB_DECIMALES, ".", "");?>"  class="classinput_hsize"/>
				<input  name="taxation_pp" type="radio" id="taxation_pp_ht" value="HT" checked="checked">HT
				<input  name="taxation_pp" id="taxation_pp_ttc" type="radio" value="TTC">TTC			</td>
			<td>&nbsp;</td>
			<td class="labelled_text"></td>
			<td>
			</td>
			<td>
			</td>
		</tr>
			<tr>
			<td>&nbsp;</td>
			<td class="labelled_text"> Taux de T.V.A.: </td>
			<td>
				<select name="id_tva" id="id_tva"  class="classinput_hsize">
					<option value="">T.V.A. non applicable</option>
					<?php
					//liste des TVA par pays
					$tva_presente="";
					foreach ($tvas  as $tva){
						?>
						<option value="<?php echo $tva['id_tva'];?>" <?php
							if ($article->getId_tva()==$tva['id_tva']) {echo ' selected="selected"'; $tva_presente=$tva['tva'];};
						?>>
						<?php echo htmlentities($tva['tva']);?>%</option>
						<?php 
					}
					?>
				</select>
						<input value="" type="hidden" id="tva_value_"  name="tva_value_"/>
				<?php
					//liste des valeurs de tva pour calcul tarif à la volée
					foreach ($tvas  as $tva){
						?>
						<input value="<?php echo htmlentities($tva['tva']);?>" type="hidden" id="tva_value_<?php echo $tva['id_tva'];?>"  name="tva_value_<?php echo $tva['id_tva'];?>"/>
						<?php 
					}
					?>
			</td>
			<td>&nbsp;</td>
			<td style=" text-align:center" rowspan="3" colspan="2">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_maj_pv.gif"  id="force_maj_pv" style="cursor:pointer"/><br />
			<?php 
			if ($article->getPv_last_maj ()) {
				?>
				Dernière mise à jour le:<?php echo date_Us_to_Fr($article->getPv_last_maj ());?> à <?php echo getTime_from_date($article->getPv_last_maj ());?>
				<?php 
			}
			?>
			
			<input type="hidden" name="tarif_tva" id="tarif_tva" value="<?php echo htmlentities($tva_presente);?>" />
			</td>
			<td>&nbsp;</td>
		</tr>
			<tr>
			<td>&nbsp;</td>
			<td class="labelled_text"><span  <?php //permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6")) {?>style="visibility:hidden;"<?php } ?> >Prix d'achat actuel:</span> </td>
		<td><span <?php //permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6")) {?>style="visibility:hidden;"<?php } ?>><input type="text" name="paa_ht" id="paa_ht" value="<?php echo number_format($article->getPaa_ht (),$TARIFS_NB_DECIMALES, ".", "");?>"  class="classinput_hsize" />&nbsp;<input  name="taxation_paa" id="taxation_paa_ht" type="radio" value="HT" checked="checked" >HT&nbsp;<input  name="taxation_paa" id="taxation_paa_ttc" type="radio" value="TTC" >TTC			</span> 


			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text"><span  <?php //permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6") || $CALCUL_VAS == "3" || $article->getModele () != "materiel" || !$article->getIs_in_stock())  {?>style="visibility:hidden;"<?php } ?> >Valeur du produit en stock:</span> </td>
		<td><span <?php //permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6") || $CALCUL_VAS == "3" || $article->getModele () != "materiel" || !$article->getIs_in_stock()) {?>style="visibility:hidden;"<?php } ?>><input type="text" name="prix_achat_ht" id="prix_achat_ht" value="<?php echo number_format($article->getPrix_achat_ht (), $TARIFS_NB_DECIMALES, ".", "");?>"  class="classinput_hsize" />&nbsp;<input  name="taxation_pa" id="taxation_pa_ht" type="radio" value="HT" checked="checked" >HT&nbsp;<input  name="taxation_pa" id="taxation_pa_ttc" type="radio" value="TTC" >TTC			</span>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="labelled_text">Article en promotion:</td>
		<td><input type="checkbox" name="promo" id="promo" value="1" <?php if ($article->getPromo ()) { ?> checked="checked"<?php } ?> /></span>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td style="width:2%">&nbsp;</td>
			<td style="width:20%">&nbsp;</td>
			<td style="width:25%; text-align:left; padding-left:25px">
			<a href="#" id="bt_etape_3"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" /></a>
			</td>
			<td style="width:5%">&nbsp;</td>
			<td style="width:20%">&nbsp;<br /><br />
</td>
			<td style="width:25%; text-align:right">&nbsp;</td>
			<td style="width:3%">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="7" class="tarif_table">

			<div style="width:100%">
			<?php 
			$tarifs_count= count($tarifs_liste);
			$style_widthpc=round(100/($tarifs_count+1));
			?>
				<div id="tableau_des_tarifs" style="width:100%; display:block">
				<table cellspacing="0" cellpadding="0" border="0" style="width:100%">
					<tr> 
						<td style=" text-align:center; border-right:1px solid #FFFFFF;  width:180px" class="labelled_bold"><br />
						<div style="width:180px;">
						<strong>GRILLE DE TARIFS</strong>
						</div>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
						</td>
						<?php 
						foreach ($tarifs_liste as $tarif_liste) {
							?>
							<td style=" text-align:center;  width:180px;<?php if(key($tarifs_liste)<$tarifs_count){?>border-right:1px solid #FFFFFF;<?php }?>" class="assist_labelled_bold"><br />
							<div style="width:180px;">
	
							<?php echo htmlentities($tarif_liste->lib_tarif); ?>
							</div>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
							</td>
							<?php
							next($tarifs_liste);
						}
						?>
					</tr>
					</table>
				<table cellspacing="0" cellpadding="0" border="0" style="width:100%">
					<tr>
						<td class="assist_labelled_bold" style="border-right:1px solid #FFFFFF; border-top:1px solid #FFFFFF;  width:180px; text-align:center;"><br />
					<div style="width:180px; display:block">
					Valeur par defaut:<br />
					<span style="color:#7391a9">De la cat&eacute;gorie </span>

						<input type="hidden" name="qte_tarif_0" id="qte_tarif_0" value="1" />
						</div>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
						</td>
						<?php 
							reset($tarifs_liste);
							$nb_liste_tarif=0;
							foreach ($tarifs_liste as $tarif_liste) {
								?>
								<td style=" text-align:center; border-top:1px solid #FFFFFF;<?php if(key($tarifs_liste)<$tarifs_count){?> border-right:1px solid #FFFFFF; <?php }?>  width:180px;">
								<div style="width:180px;">
								
									<input type="hidden" name="id_tarif_<?php echo $nb_liste_tarif?>_0" id="id_tarif_<?php echo $nb_liste_tarif?>_0" value="<?php echo $tarif_liste->id_tarif?>" />
									<input type="hidden" name="formule_tarif_<?php echo $nb_liste_tarif?>_0" id="formule_tarif_<?php echo $nb_liste_tarif?>_0" value="<?php
									if ($tarif_liste->formule_tarif=="") {
										$formule_calcul_tarif = $tarif_liste->marge_moyenne;
										echo $formule_calcul_tarif;
									}
									else 
									{ 
										$formule_calcul_tarif = $tarif_liste->formule_tarif;
										echo $formule_calcul_tarif;
									}
									?>" />
									<br />
		
									<div id="aff_tarif_<?php echo $nb_liste_tarif?>_0" style="font-weight:bolder;color:#023668; cursor:pointer">
									<?php 
																	
									$used_pa = $article->getPrix_achat_ht();
									if (!$article->getPrix_achat_ht() || $article->getPrix_achat_ht() == NULL || $CALCUL_VAS == "3" || $article->getModele () != "materiel" || !$article->getIs_in_stock()) { $used_pa = $article->getPaa_ht();}
									
									$calcul_tarif = new formule_tarif ($formule_calcul_tarif);
									$calcul_tarif->calcul_tarif_article (1, $used_pa, $article->getPrix_public_ht (), $tva_presente);
									
									$aff_tarif=$calcul_tarif->define_affichage_tarif(1);
									$debut 	= strpos($aff_tarif, "_") + 1;
									$fin = strlen ($aff_tarif);
									$taxation 	= substr($aff_tarif, $debut, $fin);
									
									echo number_format(round($calcul_tarif->tarifs[$aff_tarif],$TARIFS_NB_DECIMALES	),$TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]." ".$taxation;
									?>
									</div>
		
			<span style="position:relative; width:100%;" >
				<div id="show_info_marge_<?php echo $nb_liste_tarif?>_0" style="display:none; z-index:250; position:absolute;  top: 0em; left: 0px; background-color:#FFFFFF; border:1px solid #809eb6; filter:alpha(opacity=90); -moz-opacity:.90; opacity:.90; width:105px; height:29px; overflow:auto; font-size:9px; text-align:left; padding:1px">
				</div>
			</span>
			<script type="text/javascript">
			Event.observe('aff_tarif_<?php echo $nb_liste_tarif?>_0', "click", function(evt){
				Event.stop(evt); 
				<?php 
				if ($_SESSION['user']->check_permission ("6")) {?>
				if ($("show_info_marge_<?php echo $nb_liste_tarif?>_0").style.display == "") {
					$("show_info_marge_<?php echo $nb_liste_tarif?>_0").hide();
				}else {
					$("show_info_marge_<?php echo $nb_liste_tarif?>_0").show();
					calcul_tarif_cell_marge("<?php echo $nb_liste_tarif?>", "0");
				}
				<?php 
				}
				?>
				
			});
			</script>
									<div id="aff_formule_tarif_<?php echo $nb_liste_tarif?>_0" style="color:#7391a9;  <?php //permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6")) {?>display:none;<?php } ?>">
									<?php if ($tarif_liste->formule_tarif=="")
									{echo $tarif_liste->marge_moyenne;
									}
			
									else 
									{ echo $tarif_liste->formule_tarif;}
									?>
									</div>
								</div>
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>

								</td>
								<?php
								$nb_liste_tarif= $nb_liste_tarif+1;
								next($tarifs_liste);
							}
						?>
						</tr>
				</table>
<?php 
$nb_ligne_prix = 1;
$liste_tarifs_ByQte = array();
$liste_formules_tarifs_ByQte = array();
if ($liste_tarifs  && $liste_formules_tarifs) {
	foreach ($liste_formules_tarifs as $f) {
		$liste_formules_tarifs_ByQte[$f->indice_qte][$f->id_tarif] = $f->formule_tarif;
	}
	foreach ($liste_tarifs as $f) {
		$liste_tarifs_ByQte[$f->indice_qte][$f->id_tarif] = $f->pu_ht;
	}

}

foreach ($liste_formules_tarifs_ByQte as $formule_qte=>$formule_tarif) {
	?>	
				<table style="width:100%" cellspacing="0" cellpadding="0" border="0" id="tarif_newqte_<?php echo $nb_ligne_prix?>">
					<tr>
						<td class="assist_labelled_bold" style="border-right:1px solid #FFFFFF; border-top:1px solid #FFFFFF;  width:180px;">
							<a href="#" style="float:left" id="tarif_newqte_bt_del_<?php echo $nb_ligne_prix?>">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
					<div style="width:180px; display:block">
	
							<div style=" text-align:center;">
							Quantit&eacute;: 
							<input type="text" name="qte_tarif_<?php echo $nb_ligne_prix?>" id="qte_tarif_<?php echo $nb_ligne_prix?>" value="<?php echo $formule_qte;?>"  size="8" class="assistant_input"/>
							<input type="hidden" name="qte_tarif_old_<?php echo $nb_ligne_prix?>" id="qte_tarif_old_<?php echo $nb_ligne_prix?>" value="<?php echo $formule_qte;?>" class="assistant_input"/>
							</div>
						</div>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
						</td>
						<?php 
						reset($tarifs_liste);
						$nb_liste_tarif=0;
						foreach ($tarifs_liste as $tarif_liste) {
							?>
							<td style="  width:180px; text-align:center; border-top:1px solid #FFFFFF;<?php if(key($tarifs_liste)<$tarifs_count){?> border-right:1px solid #FFFFFF; <?php }?>">
							<a href="#" style="float:right; <?php if (!isset ($formule_tarif[$tarif_liste->id_tarif]))	{?>display:none;<?php }?>" id="tarif_del_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" title="Supprimer la formule">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
							</a>
							<div style="width:180px; display:block">
							
								<input type="hidden" name="formule_cree_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" id="formule_cree_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" value="<?php if (isset ($formule_tarif[$tarif_liste->id_tarif])) { echo "2";} else { echo "0";}?>" />
								
								<input type="hidden" name="formule_exist_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" id="formule_exist_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" value="<?php if (isset ($formule_tarif[$tarif_liste->id_tarif])) { echo "1";} else { echo "0";}?>" />
								
								<input type="hidden" name="id_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" id="id_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" value="<?php echo $tarif_liste->id_tarif?>" />
								
								<input type="hidden" name="formule_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" id="formule_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" value="<?php
								if (isset ($formule_tarif[$tarif_liste->id_tarif])) {
								 echo $formule_tarif[$tarif_liste->id_tarif];
								}
								else {
									if ($tarif_liste->formule_tarif=="") {
										$formule_calcul_tarif = $tarif_liste->marge_moyenne;
										echo $formule_calcul_tarif;
									}
									else 
									{ 
										$formule_calcul_tarif = $tarif_liste->formule_tarif;
										echo $formule_calcul_tarif;
									}
								}
								?>" />
	
								<div id="aff_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" style="font-weight:bolder;color:#023668;cursor:pointer;">
								<?php 
								if (isset ($formule_tarif[$tarif_liste->id_tarif]))	{
									if (isset ($liste_tarifs_ByQte[$formule_qte][$tarif_liste->id_tarif]) && isset($formule_tarif[$tarif_liste->id_tarif])) {
									
										$calcul_tarif = new formule_tarif ($formule_tarif[$tarif_liste->id_tarif]);
										$calcul_tarif->calcul_tarif_article ($formule_qte, $used_pa, $article->getPrix_public_ht (), $tva_presente);
										$aff_tarif=$calcul_tarif->define_affichage_tarif($formule_qte);
										$debut 	= strpos($aff_tarif, "_") + 1;
										$fin = strlen ($aff_tarif);
										$taxation 	= substr($aff_tarif, $debut, $fin);
										foreach ($liste_tarifs as $liste_tarif) {
											if ($liste_tarif->indice_qte == $formule_qte && $liste_tarif->id_tarif == $tarif_liste->id_tarif) {
												if ($aff_tarif == "PU_TTC") {
													echo number_format(round($liste_tarif->pu_ht *  (1+$tva_presente/100),$TARIFS_NB_DECIMALES),$TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]." ".$taxation;
													if ($formule_qte>1) {
													echo " (".number_format(round($liste_tarif->pu_ht * (1+$tva_presente/100),$TARIFS_NB_DECIMALES)*$formule_qte,$TARIFS_NB_DECIMALES, ".", ""	).")";
													}
												} else {
													echo number_format(round($liste_tarif->pu_ht,$TARIFS_NB_DECIMALES),$TARIFS_NB_DECIMALES, ".", ""		)." ".$MONNAIE[1]." ".$taxation;
													if ($formule_qte>1) {
													echo " (".number_format(round($liste_tarif->pu_ht,$TARIFS_NB_DECIMALES)*$formule_qte,$TARIFS_NB_DECIMALES	, ".", ""	).")";
													}
												}
											}
										}
										
									} else {
										$calcul_tarif = new formule_tarif ($formule_calcul_tarif);
										$calcul_tarif->calcul_tarif_article ($formule_qte, $used_pa, $article->getPrix_public_ht (), $tva_presente);
										$aff_tarif=$calcul_tarif->define_affichage_tarif($formule_qte);
										$debut 	= strpos($aff_tarif, "_") + 1;
										$fin = strlen ($aff_tarif);
										$taxation 	= substr($aff_tarif, $debut, $fin);
										foreach ($liste_tarifs as $liste_tarif) {
											if ($liste_tarif->indice_qte == $formule_qte && $liste_tarif->id_tarif == $tarif_liste->id_tarif) {
												if ($aff_tarif == "PU_TTC") {
													echo number_format(round($liste_tarif->pu_ht *  (1+$tva_presente/100),$TARIFS_NB_DECIMALES),$TARIFS_NB_DECIMALES, ".", ""		)." ".$MONNAIE[1]." ".$taxation;
													if ($formule_qte>1) {
													echo " (".number_format(round($liste_tarif->pu_ht * (1+$tva_presente/100),$TARIFS_NB_DECIMALES)*$formule_qte,$TARIFS_NB_DECIMALES, ".", ""		).")";
													}
												} else {
													echo number_format(round($liste_tarif->pu_ht,$TARIFS_NB_DECIMALES),$TARIFS_NB_DECIMALES	, ".", ""	)." ".$MONNAIE[1]." ".$taxation;
													if ($formule_qte>1) {
													echo " (".number_format(round($liste_tarif->pu_ht,$TARIFS_NB_DECIMALES)*$formule_qte,$TARIFS_NB_DECIMALES	, ".", ""	).")";
													}
												}
											}
										}
									}
								}
								?>&nbsp;
								</div>
	
			<span style="position:relative; width:100%;" >
				<div id="show_info_marge_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" style="display:none; z-index:250; position:absolute;  top: 0em; left: 0px; background-color:#FFFFFF; border:1px solid #809eb6; filter:alpha(opacity=90); -moz-opacity:.90; opacity:.90; width:105px; height:29px; overflow:auto; font-size:9px; text-align:left; padding:1px">
				</div>
			</span>
			<script type="text/javascript">
			Event.observe('aff_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>', "click", function(evt){
				Event.stop(evt); 
				<?php 
				if ($_SESSION['user']->check_permission ("6")) {?>
				if ($("show_info_marge_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>").style.display == "") {
					$("show_info_marge_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>").hide();
				}else {
					$("show_info_marge_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>").show();
					calcul_tarif_cell_marge("<?php echo $nb_liste_tarif?>", "<?php echo $nb_ligne_prix?>");
				}
				<?php 
				}
				?>				
			});
			</script>
								<a href="#" id="aff_formule_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>" style="color:#7391a9;  <?php //permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6")) {?> display:none; <?php } ?>">
								<?php
									if (isset ($formule_tarif[$tarif_liste->id_tarif])) {
									 echo $formule_tarif[$tarif_liste->id_tarif];
									} else {
										?>D&eacute;finir un nouveau tarif<?php
									}
								?>
								</a>
							</div>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/>
							</td>
							<?php
							$nb_liste_tarif= $nb_liste_tarif+1;
							next($tarifs_liste);
						}
						?>
					</tr>
					</table>
				
	<SCRIPT type="text/javascript">
	<?php 
	reset($tarifs_liste);
	$nb_liste_tarif=0;
	foreach ($tarifs_liste as $tarif_liste) {
		?>
		Event.observe('aff_formule_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>', "click", function(evt){
			Event.stop(evt); 
			$('pop_up_assistant_tarif').style.display='block'; 
			$('pop_up_assistant_tarif_iframe').style.display='block'; 
			$('assistant_cellule').value='<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>';
			$('assistant_indice_qte').value	= $("qte_tarif_<?php echo $nb_ligne_prix?>").value;
			$('assistant_id_tarif').value		= "<?php echo $tarif_liste->id_tarif;?>";
			edition_formule_tarifaire ("formule_tarif_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>");
		});
		 
		 
		Event.observe('tarif_del_<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>', "click", function(evt){
			Event.stop(evt); 
			alerte.confirm_supprimer_formule('tarif_del_art_formule', 'catalogue_articles_edition_tarifs_sup.php', 'ref_article=<?php echo $article->getRef_article ();?>&indice_qte=<?php echo $formule_qte;?>&id_tarif=<?php echo $tarif_liste->id_tarif;?>&n_liste=<?php echo $nb_liste_tarif?>_<?php echo $nb_ligne_prix?>&nb_ligne_prix=<?php echo $nb_ligne_prix?>&reset_formule=<?php
							if ($tarif_liste->formule_tarif=="") {
										$formule_calcul_tarif = $tarif_liste->marge_moyenne;
										echo urlencode($formule_calcul_tarif);
									}
									else 
									{ 
										$formule_calcul_tarif = $tarif_liste->formule_tarif;
										echo urlencode($formule_calcul_tarif);
									}
							?>');
		});
		<?php
		$nb_liste_tarif= $nb_liste_tarif+1;
		next($tarifs_liste);
	}
	?>
	Event.observe('qte_tarif_<?php echo $nb_ligne_prix?>', "blur", function(evt){nummask(evt,"<?php echo $nb_ligne_prix+1;?>", "X");
	if ($("qte_tarif_<?php echo $nb_ligne_prix?>").value != $("qte_tarif_old_<?php echo $nb_ligne_prix?>").value) {
	submitform ("article_edit_3");
	}
	});
	
	Event.observe('tarif_newqte_bt_del_<?php echo $nb_ligne_prix?>', "click", function(evt){Event.stop(evt); alerte.confirm_supprimer_tag_and_callpage('tarif_delqte', 'tarif_newqte_<?php echo $nb_ligne_prix?>', 'catalogue_articles_edition_tarifs_supp.php?ref_article=<?php echo $article->getRef_article ();?>&indice_qte=<?php echo $formule_qte;?>');});
	</SCRIPT>

	<?php 
$nb_ligne_prix++;
} 
?>
				</div>

			<input type="hidden" name="nb_liste_tarif" id="nb_liste_tarif" value="<?php echo $tarifs_count?>" />
			<input type="hidden" name="nb_ligne_prix" id="nb_ligne_prix" value="<?php echo $nb_ligne_prix;?>" />
			</div>
			</td>
			</tr>
		</table>

		<?php 
// Interdit si prix d'achat interdit		
		if($_SESSION['user']->check_permission ("6")){?>
		<a href="#" id="newqte" style="color:#000000; text-decoration:none"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" />  Ajouter une quantit&eacute;</a>
		<?php }?>
	<table style="width:100%">
		<tr class="smallheight">
			<td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
			<td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		</tr>
		<tr>
			<td colspan="6" style="text-align:right">
			</td>
			<td></td>
		</tr>
	</table>
</form>
<?php
if ($USE_COTATIONS){
?>
<div style="padding-left:10px">
	<a href="#" id="show_cotations" class="common_link">Cotations en cours pour cet article</a>
	<SCRIPT type="text/javascript">
	Event.observe("show_cotations", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view_cotations','index.php#'+escape('catalogue_articles_view_cotations.php?ref_article=<?php echo $_REQUEST["ref_article"];?>'),'true','_blank');}, false);
	</script>
</div>
<?php
}
?>
<br>
	<div >
	<?php
	$liste_taxes = taxes_pays($DEFAUT_ID_PAYS);
	if (count($liste_taxes)) {
		?>
		<div style="padding-left:10px">
		<span style="font-weight:bolder">Taxes applicables</span><br />
		<br />
	
		<?php
		$taxes= $article-> getTaxes ();
		$taxes_art_categ= $art_categs-> getTaxes ();
		// liste des taxes par pays
		foreach ($liste_taxes  as $taxep){
			foreach ($taxes  as $taxe){
				if ($taxe->id_taxe == $taxep['id_taxe']) {
					?>
					<span style="width:120px; float:left;"><?php echo htmlentities($taxe->lib_taxe);?></span> 
					<input name="taxe_<?php echo $taxe->id_taxe;?>" id="taxe_<?php echo $taxe->id_taxe;?>" type="text" value="<?php echo $taxe->montant_taxe;?>" class="classinput_nsize"/>
					<?php echo htmlentities($taxe->code_taxe);?> (<?php echo htmlentities($taxep['info_calcul']);?>)<br />
				<script type="text/javascript">
					Event.observe($('taxe_<?php echo $taxe->id_taxe;?>'), 'blur',  function(evt){
						Event.stop(evt); 
						if (nummask(evt, 0, "X.X")) {
							var AppelAjax = new Ajax.Request(
																"catalogue_articles_edition_taxes_maj.php", 
																{
																parameters: {ref_article: "<?php echo $article->getRef_article();?>", id_taxe: "<?php echo $taxe->id_taxe;?>", montant_taxe: $('taxe_<?php echo $taxep['id_taxe'];?>').value},
																onLoading:S_loading,  
																onComplete:H_loading
																
																}
																);
						}
					}, true);
				</script>
					<?php 
				}
			}
		}
		
		if (count($taxes_art_categ) > count ($taxes)) {
		?>
		<span id="aff_more_categ_taxes" style=" cursor:pointer; display:"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" /> <span style="text-decoration:underline">Taxes de catégorie</span></span>
		<div id="more_categ_taxes" style="display:none">
		<?php
		foreach ($taxes_art_categ  as $taxep_art){
		$stop = 0;
			foreach ($taxes  as $taxe){
				if ($taxe->id_taxe == $taxep_art->id_taxe) {$stop = 1;}
			}
			if (!$stop) {
				?>
				<span style="width:120px; float:left;"><?php echo $taxep_art->lib_taxe;?></span>
				<input name="taxe_<?php echo $taxep_art->id_taxe;?>" id="taxe_<?php echo $taxep_art->id_taxe;?>" type="text" value="" class="classinput_nsize"/>
				<?php echo htmlentities($taxep_art->code_taxe);?> (<?php echo htmlentities($taxep_art->info_calcul);?>)<br />
				
				<script type="text/javascript">
					Event.observe($('taxe_<?php echo $taxep_art->id_taxe;?>'), 'blur',  function(evt){
						Event.stop(evt); 
						if (nummask(evt, 0, "X.X")) {
							var AppelAjax = new Ajax.Request(
																"catalogue_articles_edition_taxes_maj.php", 
																{
																parameters: {ref_article: "<?php echo $article->getRef_article();?>", id_taxe: "<?php echo $taxep_art->id_taxe;?>", montant_taxe: $('taxe_<?php echo $taxep_art->id_taxe;?>').value},
																onLoading:S_loading,  
																onComplete:H_loading
																}
																);
						}
					}, true);
				</script>
				<?php
			}
		}
		?>
		<script type="text/javascript">
			Event.observe($('aff_more_categ_taxes'), 'click',  function(evt){
			Event.stop(evt);  $("aff_more_categ_taxes").hide();   $("more_categ_taxes").show(); 
			}, true);
		</script>
		</div>
		<?php
		}
		
		if (count($liste_taxes) > count ($taxes) && count($liste_taxes) > count ($taxes_art_categ)) {
		?>
		<span id="aff_more_taxes" style=" cursor:pointer; display:"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" /> <span style="text-decoration:underline">Ajouter des taxes</span></span>
		<div id="more_taxes" style="display:none">
		<?php
		foreach ($liste_taxes  as $taxep){
		$stop = 0;
			foreach ($taxes  as $taxe){
				if ($taxe->id_taxe == $taxep['id_taxe']) {$stop = 1;}
			}
			foreach ($taxes_art_categ  as $taxe_categ){
				if ($taxe_categ->id_taxe == $taxep['id_taxe']) {$stop = 1;}
			}
			if (!$stop) {
				?>
				<span style="width:120px; float:left;"><?php echo $taxep['lib_taxe'];?></span>
				<input name="taxe_<?php echo $taxep['id_taxe'];?>" id="taxe_<?php echo $taxep['id_taxe'];?>" type="text" value="" class="classinput_nsize"/>
				<?php echo htmlentities($taxep['code_taxe']);?> (<?php echo htmlentities($taxep['info_calcul']);?>)<br />
				
				<script type="text/javascript">
					Event.observe($('taxe_<?php echo $taxep['id_taxe'];?>'), 'blur',  function(evt){
						Event.stop(evt); 
						if (nummask(evt, 0, "X.X")) {
							var AppelAjax = new Ajax.Request(
																"catalogue_articles_edition_taxes_maj.php", 
																{
																parameters: {ref_article: "<?php echo $article->getRef_article();?>", id_taxe: "<?php echo $taxep['id_taxe'];?>", montant_taxe: $('taxe_<?php echo $taxep['id_taxe'];?>').value},
																onLoading:S_loading,  
																onComplete:H_loading
																}
																);
						}
					}, true);
				</script>
				<?php
				}
			}
		?>
		<script type="text/javascript">
			Event.observe($('aff_more_taxes'), 'click',  function(evt){
			Event.stop(evt);  $("aff_more_taxes").hide();   $("more_taxes").show(); 
			}, true);
		</script>
		</div>
		<?php
		}
	}
	?>
	</div>
	<br />
	<br />
	<div>
	<script type="text/javascript">
		swfobject.embedSWF("open-flash-chart.swf", "stat_aff4", "100%", "110", "9.0.0", "expressInstall.swf", {"data-file":"<?php echo urlencode("catalogue_articles_view_stats_prix_data.php?ref_article=".$article->getRef_article());  if ($CALCUL_VAS == "3" || $article->getModele () != "materiel" || !$article->getIs_in_stock()) {echo urlencode("&no_vas=1");}?>", loading : "Chargement.." },{wmode: "transparent", quality: "high"}, {});
	</script>
	<div style="border:1px solid #999999" >
	<div style="text-align:center; margin:30px;"id="stat_aff4">
		<a href="http://www.adobe.com/go/getflashplayer">
				<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
		</a>
	
	</div>
	</div>
	</div>
	
	
<SCRIPT type="text/javascript">

//fonction de validation de l'étape 3
function valide_etape_3() {
 	submitform ("article_edit_3"); 
} 

// Interdit si prix d'achat interdit
<?php if($_SESSION['user']->check_permission ("6")){?>
Event.observe($('newqte'), 'click',  function(evt){Event.stop(evt);  edition_new_ligne_tarif("<?php echo $article->getRef_article ();?>");}, true);
<?php }?>
Event.observe($('force_maj_pv'), 'click',  function(evt){Event.stop(evt);  
window.open ("catalogue_articles_edition_valide.php?ref_article=<?php echo $article->getRef_article ();?>&step=8", "formFrame");

}, true);



Event.observe('prix_public_ht', "blur", function(evt){<?php if ($MAJ_PV == "2") {?>grille_calcul_tarif();<?php } else {?>grille_calcul_tarif_edition();<?php } ?>});
Event.observe('prix_achat_ht', "blur", function(evt){<?php if ($MAJ_PV == "2") {?>grille_calcul_tarif();<?php }  else {?>grille_calcul_tarif_edition();<?php } ?>});
Event.observe('paa_ht', "blur", function(evt){<?php if ($MAJ_PV == "2") {?>grille_calcul_tarif();<?php }  else {?>grille_calcul_tarif_edition();<?php } ?>});
Event.observe('taxation_pp_ht', "click", function(evt){<?php if ($MAJ_PV == "2") {?>grille_calcul_tarif();<?php }  else {?>grille_calcul_tarif_edition();<?php } ?>});
Event.observe('taxation_pp_ttc', "click", function(evt){<?php if ($MAJ_PV == "2") {?>grille_calcul_tarif();<?php }  else {?>grille_calcul_tarif_edition();<?php } ?>});
Event.observe('taxation_pa_ht', "click", function(evt){<?php if ($MAJ_PV == "2") {?>grille_calcul_tarif();<?php }  else {?>grille_calcul_tarif_edition();<?php } ?>});
Event.observe('taxation_pa_ttc', "click", function(evt){<?php if ($MAJ_PV == "2") {?>grille_calcul_tarif();<?php }  else {?>grille_calcul_tarif_edition();<?php } ?>});
Event.observe('taxation_paa_ht', "click", function(evt){<?php if ($MAJ_PV == "2") {?>grille_calcul_tarif();<?php }  else {?>grille_calcul_tarif_edition();<?php } ?>});
Event.observe('taxation_paa_ttc', "click", function(evt){<?php if ($MAJ_PV == "2") {?>grille_calcul_tarif();<?php }  else {?>grille_calcul_tarif_edition();<?php } ?>});
Event.observe('id_tva', "change", function(evt){for(var i=0;i<$("id_tva").options.length;i++){ if($("id_tva").options[i].selected){ $("tarif_tva").value = $("tva_value_"+$("id_tva").options[i].value).value;}};<?php if ($MAJ_PV == "2") {?>grille_calcul_tarif();<?php }  else {?>grille_calcul_tarif_edition();<?php } ?>});
Event.observe($("bt_etape_3"), "click", function(evt){Event.stop(evt); valide_etape_3 ();});
//on masque le chargement
H_loading();
</SCRIPT>


		</div>