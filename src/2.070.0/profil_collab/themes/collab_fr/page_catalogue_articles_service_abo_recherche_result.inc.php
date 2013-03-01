<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
// ------------------------------------------------------------------------
// barre_navigation
// ------------------------------------------------------------------------
function barre_navigation($nbtotal,
                          $nbenr, 
                          $cfg_nbres_ppage, 
                          $debut, 
													$cfg_nb_pages,
                          $idformtochange,
													$fonctiontolauch)
													
{
	// --------------------------------------------------------------------
	global $cfg_nb_pages; // Nb de n° de pages affichées dans la barre
global $DIR;
	$barre= "";	$lien_on 	= "&nbsp;<a href='#' id='link_pagi_{cible}'>{lien}</a>&nbsp;
								<script type='text/javascript'>
								Event.observe('link_pagi_{cible}', 'click',  function(evt){Event.stop(evt); $(\"{idchange}\").value={cibleb}; {fonctionlauch};}, false);
								</script>";
	$lien_off = "&nbsp;{lien}&nbsp;";
	// --------------------------------------------------------------------
    

	// début << .
	// --------------------------------------------------------------------
	if ($debut >= $cfg_nbres_ppage)
	{
		$cible = 1;
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/gauche_on.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_on);
		$lien = str_replace('{cible}', $cible-1, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	}
	else
	{
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/gauche_off.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_off);
	}
	$barre .= $lien."&nbsp;<strong>&middot;</strong>";


	// précédent < .
	// --------------------------------------------------------------------
	if ($debut >= $cfg_nbres_ppage)
	{
		$cible = ($nbenr-1);
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/gauche_on.gif');
		$lien = str_replace('{lien}', $image, $lien_on);
		$lien = str_replace('{cible}', $cible, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	}
	else
	{
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/gauche_off.gif');
		$lien = str_replace('{lien}', $image, $lien_off);
	}
	$barre .= $lien."&nbsp;<B>&middot;</B>";
    

	// pages 1 . 2 . 3 . 4 . 5 . 6 . 7 . 8 . 9 . 10
	// -------------------------------------------------------------------

	if ($debut >= ($cfg_nb_pages * $cfg_nbres_ppage))
	{
		$cpt_fin = ($debut / $cfg_nbres_ppage) + 1;
		$cpt_deb = $cpt_fin - $cfg_nb_pages + 1;
	}
	else
	{
		$cpt_deb = 1;
        
		$cpt_fin = (int)($nbtotal / $cfg_nbres_ppage);
		if (($nbtotal % $cfg_nbres_ppage) != 0) $cpt_fin++;
        
		if ($cpt_fin > $cfg_nb_pages) $cpt_fin = $cfg_nb_pages;
	}

	for ($cpt = $cpt_deb; $cpt <= $cpt_fin; $cpt++)
	{
		if ($cpt == ($debut / $cfg_nbres_ppage) + 1)
		{
				$barre .= "<A CLASS='off'>&nbsp;".$cpt."&nbsp;</A> ";
		}
		else
		{				$barre .= "<a href='#' id='link_txt_".$cpt."";
				$barre .= "'>&nbsp;".$cpt."&nbsp;</a>
								<script type='text/javascript'>
								Event.observe('link_txt_".$cpt."', 'click',  function(evt){Event.stop(evt); $(\"".$idformtochange."\").value=".$cpt."; ".$fonctiontolauch.";}, false);
								</script>";
		}
	}
    

	// suivant . >
	// --------------------------------------------------------------------
	if ($debut + $cfg_nbres_ppage < $nbtotal)
	{
		$cible = ($nbenr+1);
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/droite_on.gif');
		$lien = str_replace('{lien}', $image, $lien_on);
		$lien = str_replace('{cible}', $cible, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	}
	else
	{
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/droite_off.gif');
		$lien = str_replace('{lien}', $image, $lien_off);
	}
	$barre .= "&nbsp;<B>&middot;</B>".$lien;

	// fin . >>
	// --------------------------------------------------------------------
	$fin = ($nbtotal - ($nbtotal % $cfg_nbres_ppage));
	if (($nbtotal % $cfg_nbres_ppage) == 0) $fin = $fin - $cfg_nbres_ppage;

	if ($fin != $debut)
	{
		$cible = (int)($nbtotal/$cfg_nbres_ppage)+1;
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/droite_on.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_on);
		$lien = str_replace('{cible}', $cible+1, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	}
	else
	{
		$image = image_html(  $DIR.$_SESSION['theme']->getDir_theme().'images/droite_off.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_off);
	}
	$barre .= "<B>&middot;</B>&nbsp;".$lien;
	return($barre);
}
// ------------------------------------------------------------------------
// image_html          
// ------------------------------------------------------------------------
function image_html($img)
{
    return '<img src="'.$img.'"    border="0" >';
}

//
//
//création de la barre de nav
//
//

	$cfg_nb_pages = 10;
	$barre_nav = "";
	$debut =(($form['page_to_show']-1)*$form['fiches_par_page']);
	
	$barre_nav .= barre_navigation($nb_fiches, $form['page_to_show'], 
                                       $form['fiches_par_page'], 
                                       $debut, $cfg_nb_pages,
                                       'page_to_show_s',
																			 'page.article_recherche_abo()');



// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Formulaire de recherche
?><br />
<div class="mt_size_optimise">
<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>


</div>

<table id="tableresult" border="0" cellpadding="0" cellspacing="0">
	<tr class="colorise0">
		<td style="width:27%">
			<a href="#"  id="order_nom">
			Nom
			</a>
		</td>
		<td style="width:13%; text-align:left">
			<a href="#"  id="order_souscription">
			Souscription le:
			</a>
		</td>
		<td style="width:13%; text-align:left">
			<a href="#"  id="order_echeance">
			Echéance:
			</a>
		</td>
		<td style="width:13%; text-align:left">
			<a href="#"  id="order_fin_eng">
			Fin&nbsp;d'engagement:
			</a>
		</td>
		<td style="width:13%; text-align:left">
			<a href="#"  id="order_fin_abo">
			Fin&nbsp;d'abonnement:
			</a>
		</td>
		<td style="width:10%; text-align:center">
		Etat:
		</td>
		<td>
		</td>
	</tr>
	</table>

	<table id="tableresult" border="0" cellpadding="0" cellspacing="0">
	<?php 
	$colorise=0;
	foreach ($fiches as $fiche) {
		$colorise++;
		$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
		?>
		<tr class="<?php  echo  $class_colorise?>">
			<td style="width:3%">
				<input type="checkbox"  name ="abo_renouvellement_<?php echo $colorise;?>" id ="abo_renouvellement_<?php echo $colorise;?>" value="<?php echo $fiche->id_abo;?>"/>
			</td>
			<td style="width:25%">
				<a  href="#" id="nom_<?php echo $fiche->id_abo;?>" style="display:block; width:100%;"> <?php echo nl2br(($fiche->nom))?> (<?php echo ($fiche->lib_civ_court)?>)
				</a>
				<script type="text/javascript">
				Event.observe("nom_<?php echo $fiche->id_abo;?>", "click",  function(evt){Event.stop(evt);page.verify('affaires_affiche_fiche','annuaire_view_fiche.php?ref_contact=<?php echo ($fiche->ref_contact)?>','true','sub_content');}, false);
				</script>
			</td>
			<td  style="width:13%; text-align:left">
				<div id="link_reg_ref_0_<?php echo $colorise;?>" style="cursor:pointer">
				<?php	if ($fiche->date_souscription) { echo Date_Us_to_Fr($fiche->date_souscription);}?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_0_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->id_abo) { ?>
					page.traitecontent('catalogue_articles_abonnement_edition','catalogue_articles_abonnement_edition.php?id_abo=<?php echo $fiche->id_abo;?>&ref_article=<?php echo $fiche->ref_article;?>','true','edition_abonnement');
					$("edition_abonnement").show();
					<?php } ?>
				});
				</script>
			</td>
			<td style="width:13%; text-align:left">
				<div id="link_reg_ref_1_<?php echo $colorise;?>" style="cursor:pointer">
				<?php	if ($fiche->date_echeance) { echo Date_Us_to_Fr($fiche->date_echeance);}?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_1_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->id_abo) { ?>
					page.traitecontent('catalogue_articles_abonnement_edition','catalogue_articles_abonnement_edition.php?id_abo=<?php echo $fiche->id_abo;?>&ref_article=<?php echo $fiche->ref_article;?>','true','edition_abonnement');
					$("edition_abonnement").show();
					<?php } ?>
				});
				</script>
			</td>
			<td style="width:13%; text-align:left">
				<div id="link_reg_ref_2_<?php echo $colorise;?>" style="cursor:pointer">
				<?php	if ($fiche->fin_engagement) { echo Date_Us_to_Fr($fiche->fin_engagement);}?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_2_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->id_abo) { ?>
					page.traitecontent('catalogue_articles_abonnement_edition','catalogue_articles_abonnement_edition.php?id_abo=<?php echo $fiche->id_abo;?>&ref_article=<?php echo $fiche->ref_article;?>','true','edition_abonnement');
					$("edition_abonnement").show();
					<?php } ?>
				});
				</script>
			</td>
			<td style="width:13%; text-align:left">
				<div id="link_reg_ref_3_<?php echo $colorise;?>" style="cursor:pointer">
				<?php	if ($fiche->fin_abonnement != "0000-00-00 00:00:00") { echo Date_Us_to_Fr($fiche->fin_abonnement);}?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_3_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->id_abo) { ?>
					page.traitecontent('catalogue_articles_abonnement_edition','catalogue_articles_abonnement_edition.php?id_abo=<?php echo $fiche->id_abo;?>&ref_article=<?php echo $fiche->ref_article;?>','true','edition_abonnement');
					$("edition_abonnement").show();
					<?php } ?>
				});
				</script>
			</td>
			<td style="width:10%;text-align:center; ">
			<?php
				if ($fiche->date_echeance > date("Y-m-d H:i:s", time())) { echo "en&nbsp;cours<br />";}
				if ($fiche->fin_abonnement > date("Y-m-d H:i:s", time()) && $fiche->date_echeance < date("Y-m-d H:i:s", time())) { echo "à&nbsp;renouveller<br />";}
				if ($fiche->fin_abonnement < date("Y-m-d H:i:s", time()) && $fiche->fin_abonnement != '0000-00-00 00:00:00') { echo "expiré<br />";}
				if ($fiche->date_preavis != '0000-00-00 00:00:00') { echo "préavis&nbsp;déposé<br />";}
			?>
			</td>
			<td style="text-align:right; vertical-align:middle; padding-left:8px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_renouveller.gif"  border="0"  vspace="5" id="renouveller_<?php echo $fiche->id_abo;?>"/>
				<form method="post" action="catalogue_articles_service_abo_renouveller.php" id="service_renouveller_<?php echo $fiche->id_abo;?>" name="service_renouveller_<?php echo $fiche->id_abo;?>" target="formFrame">
					<input type="hidden" name="ref_article_service_renouveller_<?php echo $fiche->id_abo;?>" id="ref_article_service_renouveller_<?php echo $fiche->id_abo;?>" value="<?php echo $article->getRef_article();?>"/>
					<input type="hidden" name="ref_contact_service_renouveller_<?php echo $fiche->id_abo;?>" id="ref_contact_service_renouveller_<?php echo $fiche->id_abo;?>" value="<?php echo $fiche->ref_contact;?>"/>
					<input type="hidden" name="reconduction_service_renouveller_<?php echo $fiche->id_abo;?>" id="reconduction_service_renouveller_<?php echo $fiche->id_abo;?>" value="1"/>
					<input type="hidden" name="id_abo_<?php echo $colorise;?>" id="id_abo_<?php echo $colorise;?>" value="<?php echo $fiche->id_abo;?>"/>
					<input type="hidden" name="id_abo" id="id_abo" value="<?php echo $fiche->id_abo;?>"/>
				</form>
				<script type="text/javascript">
				Event.observe("renouveller_<?php echo $fiche->id_abo;?>", "click",  function(evt){
					Event.stop(evt);
					 
					$("titre_alert").innerHTML = 'Confirmer';
					$("texte_alert").innerHTML = 'Confirmer le renouvellement de cet abonnement';
					$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Confirmer" /><input type="submit" id="bouton1" name="bouton1" value="Annuler" />';
					
					$("alert_pop_up_tab").style.display = "block";
					$("framealert").style.display = "block";
					$("alert_pop_up").style.display = "block";
					
					$("bouton0").onclick= function () {
					$("framealert").style.display = "none";
					$("alert_pop_up").style.display = "none";
					$("alert_pop_up_tab").style.display = "none";
					$("service_renouveller_<?php echo $fiche->id_abo;?>").submit();
					}
					
					$("bouton1").onclick= function () {
					$("framealert").style.display = "none";
					$("alert_pop_up").style.display = "none";
					$("alert_pop_up_tab").style.display = "none";
					} 
				}, false);
				</script>
			</td>
		</tr>
		<?php
	}
	?>
</table>

<div id="affresult">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
			<td id="nvbar"><?php echo str_replace("link_", "link2_",$barre_nav);?></td>
			<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
		</tr>
	</table>
</div>
<br />
<input name="nb_checkbox_abo" id="nb_checkbox_abo" type="hidden" value="<?php echo $colorise; ?>" />
<div id="affresult">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="3%" ></td>
			<td width="35%" style="text-align:left;" >
				<span id="all_coche_abo"  style="cursor:pointer">Tout cocher</span>
				&nbsp;&frasl;&nbsp;
				<span id="all_decoche_abo" style="cursor:pointer">Tout d&eacute;cocher</span>
				&nbsp;&frasl;&nbsp;
				<span id="all_inv_coche_abo" style="cursor:pointer">Inverser la s&eacute;lection</span>&nbsp;</td>
			<td style="text-align:left;" width="3%"></td>
			<td style="text-align:right;">
					
				<select id="renouveler_abos_cochees" name="renouveler_abos_cochees">
					<option selected="selected"> action pour la sélection</option>
					<option>Renouveler</option>
				</select>
				<form method="post" action="catalogue_articles_service_abo_renouveller_all_checked.php" id="form_renouvler_abos_coches" name="form_renouvler_abos_coches" target="formFrame">
					<input type="hidden" id="tab_ref_article" name="tab_ref_article" value=""/>
					<input type="hidden" id="tab_id_abo" name="tab_id_abo" value=""/>
					<input type="hidden" id="tab_ref_contact" name="tab_ref_contact" value=""/>
				</form>
				<script type="text/javascript">
				Event.observe("renouveler_abos_cochees", "change",  function(evt){
					Event.stop(evt);
					$("renouveler_abos_cochees").selectedIndex = 0;
					
					var tab_ref_article = new Array;
					var tab_id_abo = new Array;
					var tab_ref_contact = new Array;
						
					tab_ref_article.clear();
					tab_id_abo.clear();
					tab_ref_contact.clear();
					
					for( i=1; i<= ($("nb_checkbox_abo").value); i++) {
						if ($("abo_renouvellement_"+i).checked) {
							tab_ref_article.push($("ref_article_service_renouveller_"+$("abo_renouvellement_"+i).value).value);
							tab_id_abo.push($("abo_renouvellement_"+i).value);
							tab_ref_contact.push($("ref_contact_service_renouveller_"+$("abo_renouvellement_"+i).value).value);
						}
					}
	
					//alert(tab_id_abo.length);
					
					if (tab_id_abo.length >0){
						$("titre_alert").innerHTML = 'Confirmer';
						$("texte_alert").innerHTML = 'Confirmer le renouvellement de ces abonnements';
						$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Confirmer" /><input type="submit" id="bouton1" name="bouton1" value="Annuler" />';
	
						$("alert_pop_up_tab").style.display = "block";
						$("framealert").style.display = "block";
						$("alert_pop_up").style.display = "block";
						
						$("bouton0").onclick= function () {
							$("framealert").style.display = "none";
							$("alert_pop_up").style.display = "none";
							$("alert_pop_up_tab").style.display = "none";
							$("tab_ref_article").value = tab_ref_article.join(";");
							$("tab_id_abo").value = tab_id_abo.join(";");
							$("tab_ref_contact").value = tab_ref_contact.join(";");
							//alert($("tab_ref_article").value);
							//alert($("tab_id_abo").value);
							//alert($("tab_ref_contact").value);
							$("form_renouvler_abos_coches").submit();
						}
						
						$("bouton1").onclick= function () {
							$("framealert").style.display = "none";
							$("alert_pop_up").style.display = "none";
							$("alert_pop_up_tab").style.display = "none";
						}
					}
				}, false);
				</script>
			</td>
		</tr>
	</table>
</div>
<br />
<span id="export_csv_resultats" class="common_link">Exporter le résultat de la recherche au format csv</span>

<br />
<br />
<br />
<br />
<br />
<br />
</div>
<SCRIPT type="text/javascript">
Event.observe("export_csv_resultats", "click",  function(evt){
	Event.stop(evt);

	var ref_article = $("ref_article").options[$("ref_article").selectedIndex].value;
	var etat_abo = $("etat_abo").options[$("etat_abo").selectedIndex].value;
	var date_souscription_min = $("date_souscription_min").value;
	var date_souscription_max = $("date_souscription_max").value;
	var date_echeance_min = $("date_echeance_min").value;
	var date_echeance_max = $("date_echeance_max").value;
	var date_fin_min = $("date_fin_min").value;
	var date_fin_max = $("date_fin_max").value;
	var id_client_categ = $("id_client_categ").options[$("id_client_categ").selectedIndex].value;
	var ref_client = $("ref_client").value;
	var adresse_ville = $("adresse_ville").value;
	var adresse_code = $("adresse_code").value;
	var adresse_pays = $("adresse_pays").value;

	page.article_recherche_abo_export_csv(ref_article, etat_abo, date_souscription_min, date_souscription_max, date_echeance_min, date_echeance_max, date_fin_min, date_fin_max, id_client_categ, ref_client, adresse_ville, adresse_code, adresse_pays);	
}, false);

Event.observe("order_nom", "click",  function(evt){Event.stop(evt);$('orderby_s').value='nom'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="nom") {echo "DESC";} else {echo "ASC";}?>'; page.article_recherche_abo();}, false);

Event.observe("order_souscription", "click",  function(evt){Event.stop(evt);$('orderby_s').value='date_souscription'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="date_souscription") {echo "DESC";} else {echo "ASC";}?>'; page.article_recherche_abo();}, false);

Event.observe("order_echeance", "click",  function(evt){Event.stop(evt);$('orderby_s').value='date_echeance'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="date_echeance") {echo "DESC";} else {echo "ASC";}?>'; page.article_recherche_abo();}, false);

Event.observe("order_fin_eng", "click",  function(evt){Event.stop(evt);$('orderby_s').value='fin_engagement'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="fin_engagement") {echo "DESC";} else {echo "ASC";}?>'; page.article_recherche_abo();}, false);

Event.observe("all_coche_abo", "click", function(evt){
	Event.stop(evt); 
	coche_line_variantes ("coche", "abo_renouvellement", parseFloat($("nb_checkbox_abo").value));
});
Event.observe("all_decoche_abo", "click", function(evt){
	Event.stop(evt); 
	coche_line_variantes ("decoche", "abo_renouvellement", parseFloat($("nb_checkbox_abo").value));
});
Event.observe("all_inv_coche_abo", "click", function(evt){
	Event.stop(evt); 
	coche_line_variantes ("inv_coche", "abo_renouvellement", parseFloat($("nb_checkbox_abo").value));
});


//on masque le chargement
H_loading();
</SCRIPT>