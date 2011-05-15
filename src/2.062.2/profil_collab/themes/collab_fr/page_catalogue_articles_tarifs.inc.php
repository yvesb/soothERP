<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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
<div id="tarifs_info_under">
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
		<td><input type="text" name="prix_public_ht" id="prix_public_ht" value=""  class="classinput_hsize"/>&nbsp;<input  name="taxation_pp" type="radio" id="taxation_pp_ht" value="HT" checked="checked">HT&nbsp;<input  name="taxation_pp" id="taxation_pp_ttc" type="radio" value="TTC">TTC			</td>
		<td>&nbsp;</td>
		<td class="labelled_text"></td>
		<td>	</td>
		<td>&nbsp;</td>
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
							if ($art_categ->getDefaut_id_tva()==$tva['id_tva']) {echo ' selected="selected"'; $tva_presente=$tva['tva'];};
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
		<td>
		<input type="hidden" name="tarif_tva" id="tarif_tva" value="<?php echo htmlentities($tva_presente);?>" />
		</td>
		<td>&nbsp;</td>
	</tr>
		<tr>
		<td>&nbsp;</td>
		<td class="labelled_text"><span  <?php //permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6")) {?>style="display:none;"<?php } ?> >Prix d'achat actuel:</span> </td>
		<td><span <?php //permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6")) {?>style="display:none;"<?php } ?>><input type="text" name="paa_ht" id="paa_ht" value=""  class="classinput_hsize" />&nbsp;<input  name="taxation_paa" id="taxation_paa_ht" type="radio" value="HT" checked="checked" >HT&nbsp;<input  name="taxation_paa" id="taxation_paa_ttc" type="radio" value="TTC" >TTC			</span>
		</td>
		<td>&nbsp;</td>
		<td>
		</td>
		<td>&nbsp;</td>
	</tr>
		<tr>
		<td>&nbsp;</td>
		<td class="labelled_text"></td>
		<td><span style="display:none;"><input type="hidden" name="prix_achat_ht" id="prix_achat_ht" value="" />&nbsp;<input  name="taxation_pa"  type="hidden" value="HT">			</span>
		</td>
		<td>&nbsp;</td>
		<td>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="7">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="7" class="tarif_table">
			<div style=" width:100%">
		<?php 
		$tarifs_count= count($tarifs_liste);
		$style_widthpc=round(100/($tarifs_count+1));
		?>
			<div id="tableau_des_tarifs" style="display:block; width:100%">
			<table cellspacing="0" cellpadding="0" border="0" style="width:100%">
				<tr> 
					<td style=" text-align:center; border-right:1px solid #FFFFFF;  width:180px" class="labelled_bold"><br />
					<div style="width:180px;">
					<strong>GRILLE DE TARIFS</strong></div>
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
					<div style="width:180px;">
					Valeur par defaut: <br />
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
								echo $tarif_liste->marge_moyenne;
								}
								else 
								{ echo $tarif_liste->formule_tarif;
								}
							?>" />
							<br />

							<div id="aff_tarif_<?php echo $nb_liste_tarif?>_0" style="font-weight:bolder;color:#023668;">0 <?php echo $MONNAIE[1]?>
							</div>

							<div id="aff_formule_tarif_<?php echo $nb_liste_tarif?>_0" style="color:#7391a9">
							<?php
							if ($tarif_liste->formule_tarif=="") {
									echo $tarif_liste->marge_moyenne;
								}
								else 
								{
									echo $tarif_liste->formule_tarif;
							}
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
			</div>

		<input type="hidden" name="nb_liste_tarif" id="nb_liste_tarif" value="<?php echo $tarifs_count?>" />
		<input type="hidden" name="nb_ligne_prix" id="nb_ligne_prix" value="1" />
		</div>
		</td>
		</tr>
	</table>

	<a href="#" id="newqte" style="color:#000000; text-decoration:none"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" />  Ajouter une quantit&eacute;</a>
	
<table style="width:100%">
	<tr class="smallheight">
		<td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
		<td style="width:3%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="1" id="imgsizeform"/></td>
	</tr>
	<tr>
		<td colspan="6" style="text-align:right">
			<a href="#" id="bt_etape_3"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-continuer.gif" /></a>
		</td>
		<td></td>
	</tr>
</table>

	<div >

		<div style="padding-left:10px">
	<?php
	$liste_taxes = taxes_pays($DEFAUT_ID_PAYS);
	if (count($liste_taxes)) {
		?>
		<span style="font-weight:bolder">Taxes applicables</span><br />
		<br />
	
		<?php
		$taxes_art_categ= $art_categ->getTaxes ();
		?>
		<?php
		foreach ($taxes_art_categ  as $taxep_art){
			$stop = 0;
			if (!$stop) {
				?>
		<div>
			
				<span style="width:120px; float:left;">	<input name="taxe_chk_<?php echo $taxep_art->id_taxe;?>" id="taxe_chk_<?php echo $taxep_art->id_taxe;?>" type="checkbox" value="<?php echo htmlentities($taxep_art->code_taxe);?>" /> <?php echo $taxep_art->lib_taxe;?></span>
				<input name="taxe_<?php echo $taxep_art->id_taxe;?>" id="taxe_<?php echo $taxep_art->id_taxe;?>" type="text" value="" class="" <?php if ($taxep_art->info_calcul) { ?> disabled="disabled"<?php } ?>/>
				<?php echo htmlentities($taxep_art->code_taxe);?> (<?php echo htmlentities($taxep_art->info_calcul);?>)<br />
				
				<input name="taxe_info_calcul_<?php echo $taxep_art->id_taxe;?>" id="taxe_info_calcul_<?php echo $taxep_art->id_taxe;?>" type="hidden" value="<?php echo htmlentities($taxep_art->info_calcul);?>" />
				<script type="text/javascript">
					Event.observe($('taxe_<?php echo $taxep_art->id_taxe;?>'), 'blur',  function(evt){
						Event.stop(evt); 
						nummask(evt, 0, "X.X");
					}, true);
				</script>
		</div>
				<?php
			}
			?>
		<?php
		}
		
		if ( count($liste_taxes) > count ($taxes_art_categ)) {
		?>
		<span id="aff_more_taxes" style=" cursor:pointer; display:"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" /> <span style="text-decoration:underline">Ajouter des taxes</span></span>
		<div id="more_taxes" style="display:none">
		<?php
		foreach ($liste_taxes  as $taxep){
			$stop = 0;
			foreach ($taxes_art_categ  as $taxe_categ){
				if ($taxe_categ->id_taxe == $taxep['id_taxe']) {$stop = 1;}
			}
			if (!$stop) {
				?>
				<span style="width:120px; float:left;">
				<input name="taxe_chk_<?php echo $taxep['id_taxe'];?>" id="taxe_chk_<?php echo $taxep['id_taxe'];?>" type="checkbox" value="<?php echo htmlentities($taxep['code_taxe']);?>"  /> <?php echo $taxep['lib_taxe'];?></span>
				<input name="taxe_<?php echo $taxep['id_taxe'];?>" id="taxe_<?php echo $taxep['id_taxe'];?>" type="text" value="" class="" <?php if ($taxep['info_calcul']) { ?> disabled="disabled"<?php } ?>/>
				<?php echo htmlentities($taxep['code_taxe']);?> (<?php echo htmlentities($taxep['info_calcul']);?>)<br />
				
				<input name="taxe_info_calcul_<?php echo $taxep['id_taxe'];?>" id="taxe_info_calcul_<?php echo $taxep['id_taxe'];?>" type="hidden" value="<?php echo htmlentities($taxep['info_calcul']);?>" />
				<script type="text/javascript">
					Event.observe($('taxe_<?php echo $taxep['id_taxe'];?>'), 'blur',  function(evt){
						Event.stop(evt); 
						nummask(evt, 0, "X.X");
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
	</div>
	<br />
	<br />
<SCRIPT type="text/javascript">
new_ligne_tarif();
Event.observe($('newqte'), 'click',  function(evt){Event.stop(evt);  new_ligne_tarif();}, true);
Event.observe($("bt_etape_3"), "click", function(evt){Event.stop(evt); goto_etape (4);});
Event.observe('prix_public_ht', "blur", function(evt){grille_calcul_tarif();});
Event.observe('paa_ht', "blur", function(evt){grille_calcul_tarif();});
Event.observe('taxation_pp_ht', "click", function(evt){grille_calcul_tarif();});
Event.observe('taxation_pp_ttc', "click", function(evt){grille_calcul_tarif();});
Event.observe('taxation_paa_ht', "click", function(evt){grille_calcul_tarif();});
Event.observe('taxation_paa_ttc', "click", function(evt){grille_calcul_tarif();});
Event.observe('id_tva', "change", function(evt){for(var i=0;i<$("id_tva").options.length;i++){ if($("id_tva").options[i].selected){ $("tarif_tva").value = $("tva_value_"+$("id_tva").options[i].value).value;}};grille_calcul_tarif();});
//on masque le chargement
H_loading();
</SCRIPT>
</div>