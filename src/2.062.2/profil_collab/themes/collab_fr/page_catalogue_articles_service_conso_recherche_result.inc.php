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
																			 'page.article_recherche_conso()');



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

<table  cellspacing="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:28%">
			<a href="#"  id="order_nom">
			Nom
			</a>
		</td>
		<td style="width:12%; text-align:left">
			<a href="#"  id="order_souscription">
			Souscription le:
			</a>
		</td>
		<td style="width:12%; text-align:left">
			<a href="#"  id="order_echeance">
			Echéance:
			</a>
		</td>
		<td style="width:12%; text-align:left">
			<a href="#"  id="order_credits">
			Crédits restants:
			</a>
		</td>
		<td>
		</td>
	</tr>
	<?php 
	$colorise=0;
	foreach ($fiches as $fiche) {
		$colorise++;
		$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
		?>
		<tr class="<?php  echo  $class_colorise?>">
			<td>
				<a  href="#" id="nom_<?php echo $fiche->id_compte_credit;?>" style="display:block; width:100%;"> <?php echo nl2br(($fiche->nom))?> (<?php echo ($fiche->lib_civ_court)?>)
				</a>
				<script type="text/javascript">
				Event.observe("nom_<?php echo $fiche->id_compte_credit;?>", "click",  function(evt){Event.stop(evt);page.verify('affaires_affiche_fiche','annuaire_view_fiche.php?ref_contact=<?php echo ($fiche->ref_contact)?>','true','sub_content');}, false);
				</script>
			</td>
			<td  style="width:25%; text-align:left">
				<div id="link_reg_ref_0_<?php echo $colorise;?>" style="cursor:pointer">
				<?php	if ($fiche->date_souscription) { echo Date_Us_to_Fr($fiche->date_souscription);}?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_0_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->id_compte_credit) { ?>
					page.traitecontent('catalogue_articles_consommation_edition','catalogue_articles_consommation_edition.php?id_compte_credit=<?php echo $fiche->id_compte_credit;?>&ref_article=<?php echo $fiche->ref_article;?>','true','edition_consommation');
					$("edition_consommation").show();
					<?php } ?>
				});
				</script>
			</td>
			<td style="width:20%; text-align:left">
				<div id="link_reg_ref_1_<?php echo $colorise;?>" style="cursor:pointer; <?php	if (strtotime($fiche->date_echeance) < time()) {?>color:#FF0000<?php }?>">
				<?php	if ($fiche->date_echeance) { echo Date_Us_to_Fr($fiche->date_echeance);}?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_1_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->id_compte_credit) { ?>
					page.traitecontent('catalogue_articles_consommation_edition','catalogue_articles_consommation_edition.php?id_compte_credit=<?php echo $fiche->id_compte_credit;?>&ref_article=<?php echo $fiche->ref_article;?>','true','edition_consommation');
					$("edition_consommation").show();
					<?php } ?>
				});
				</script>
			</td>
			<td style="width:20%; text-align:left">
				<div id="link_reg_ref_2_<?php echo $colorise;?>" style="cursor:pointer">
				<?php	 echo ($fiche->credits_restants);?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_2_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->id_compte_credit) { ?>
					page.traitecontent('catalogue_articles_consommation_edition','catalogue_articles_consommation_edition.php?id_compte_credit=<?php echo $fiche->id_compte_credit;?>&ref_article=<?php echo $fiche->ref_article;?>','true','edition_consommation');
					$("edition_consommation").show();
					<?php } ?>
				});
				</script>
			</td>
		
			<td style="text-align:right; vertical-align:middle; padding-left:8px">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_consommer.gif"  border="0"  vspace="5" id="consommer_<?php echo $fiche->id_compte_credit;?>" <?php if (!$fiche->credits_restants) {?> style="display:none"<?php } ?>/>
				<form method="post" action="catalogue_articles_service_conso_renouveller.php" id="service_renouveller_<?php echo $fiche->id_compte_credit;?>" name="service_renouveller_<?php echo $fiche->id_compte_credit;?>" target="formFrame">
				<input type="hidden" name="ref_article_service_renouveller_<?php echo $fiche->id_compte_credit;?>" value="<?php echo $article->getRef_article();?>"/>
				<input type="hidden" name="ref_contact_service_renouveller_<?php echo $fiche->id_compte_credit;?>" value="<?php echo $fiche->ref_contact;?>"/>
				<input type="hidden" name="reconduction_service_renouveller_<?php echo $fiche->id_compte_credit;?>" value="1"/>
				<input type="hidden" name="id_compte_credit" value="<?php echo $fiche->id_compte_credit;?>"/>
				</form>
				<script type="text/javascript">
				Event.observe("consommer_<?php echo $fiche->id_compte_credit;?>", "click",  function(evt){
					Event.stop(evt);
					 
					page.traitecontent('catalogue_articles_consommation_use','catalogue_articles_consommation_use.php?id_compte_credit=<?php echo $fiche->id_compte_credit;?>&ref_article=<?php echo $fiche->ref_article;?>','true','edition_consommation');
					$("edition_consommation").show();
					
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
<br />
<br />
<br />
<br />
<br />
<br />
</div>
<SCRIPT type="text/javascript">

Event.observe("order_nom", "click",  function(evt){Event.stop(evt);$('orderby_s').value='nom'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="nom") {echo "DESC";} else {echo "ASC";}?>'; page.article_recherche_conso();}, false);

Event.observe("order_souscription", "click",  function(evt){Event.stop(evt);$('orderby_s').value='date_souscription'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="date_souscription") {echo "DESC";} else {echo "ASC";}?>'; page.article_recherche_conso();}, false);

Event.observe("order_echeance", "click",  function(evt){Event.stop(evt);$('orderby_s').value='date_echeance'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="date_echeance") {echo "DESC";} else {echo "ASC";}?>'; page.article_recherche_conso();}, false);

Event.observe("order_credits", "click",  function(evt){Event.stop(evt);$('orderby_s').value='credits_restants'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="credits_restants") {echo "DESC";} else {echo "ASC";}?>'; page.article_recherche_conso();}, false);


//on masque le chargement
H_loading();
</SCRIPT>