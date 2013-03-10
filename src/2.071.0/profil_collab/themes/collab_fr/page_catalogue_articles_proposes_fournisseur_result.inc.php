<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "fiches", "form['lib_article']", "form['page_to_show']", "form['fiches_par_page']", "nb_fiches", "form['orderby']", "form['orderorder']");
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
																			 'page.catalogue_recherche_articles_proposes_fournisseur()');



// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Affichage des résultats
?><br />
<div class="mt_size_optimise">
	<br />
	<div id="affresult">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
				<td id="nvbar"><?php echo $barre_nav;?></td>
				<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches+1; ?></td>
			</tr>
		</table>
	</div>

	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
		<tr class="colorise0">
			<td width="10%">
				<a href="#"  id="order_ref">R&eacute;f&eacute;rence</a>
			</td>
			<td width="15%">
				<a href="#"  id="order_ref_fournisseur">R&eacute;f&eacute;rence fournisseur</a>
			</td>
			<td>
				<a href="#"  id="order_lib">Libell&eacute;</a>
			</td>
			<td width="10%" align="center">
				<a href="#"  id="order_dernier_achat">Dernier achat</a>
			</td>
			<td width="10%" align="right">
				<a href="#"  id="order_dernier_PA_HT">Dernier PA HT</a>
			</td>
			<td width="10%" align="right">
				<a href="#"  id="order_prix_actuel_HT">Prix actuel HT</a>
			</td>
			<td width="5%"></td>
		</tr>
	<?php 
	$colorise=0;
	foreach ($fiches as $fiche) {
	$colorise++;
	$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2'; ?>
		<tr class="<?php  echo  $class_colorise?>" id="line_art_<?php echo ($fiche->ref_article)?>">
			<td class="reference">
				<a  href="#" id="link_art_ref_<?php echo ($fiche->ref_article)?>" style="display:block; width:100%">
					<?php	if ($fiche->ref_interne!="") { echo ($fiche->ref_interne)."&nbsp;";}else{ echo ($fiche->ref_article)."&nbsp;";}?><br />
					<?php	if ($fiche->ref_oem) { echo ($fiche->ref_oem)."&nbsp;";}?>		
				</a>
				<script type="text/javascript">
				Event.observe("link_art_ref_<?php echo ($fiche->ref_article)?>", "click",  function(evt){
					Event.stop(evt);
					page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo ($fiche->ref_article)?>'),'true','_blank')
				;}, false);
				</script>
			</td>
			<td id="Ref_fournisseur_<?php echo $fiche->ref_article; ?>">
				<?php	if ($fiche->ref_article_externe){ echo $fiche->ref_article_externe; }
							if ($fiche->lib_article_externe){ ?>
							<div style="position:relative">
								<div id="line_aff_lib_<?php echo $fiche->ref_article; ?>" style="display:none; position:absolute">
									<?php	if ($fiche->lib_article_externe){ echo $fiche->lib_article_externe; }?>
								</div>
							</div>
							<script type="text/javascript">
								Event.observe("Ref_fournisseur_<?php echo $fiche->ref_article; ?>", "mouseover", function(){
									$("line_aff_lib_<?php echo $fiche->ref_article; ?>").show();
								}, false);
								Event.observe("Ref_fournisseur_<?php echo $fiche->ref_article; ?>", "mouseout",  function(){
									$("line_aff_lib_<?php echo $fiche->ref_article; ?>").hide();
								}, false);
							</script>
				<?php } ?>
			</td>
			<td>
				<span class="lib_categorie"><?php	if ($fiche->lib_art_categ){ echo ($fiche->lib_art_categ); }?></span> - <span class="lib_constructor"><?php	if ($fiche->nom_constructeur && $_SESSION['user']-> check_permission("22",$CONSTRUCTEUR_ID_PROFIL)) { echo ($fiche->nom_constructeur)."&nbsp;";}?></span><br />
				<span class="r_art_lib"><?php echo nl2br(($fiche->lib_article))?></span>
				<?php /*
				<div style="position:relative">
					<div id="line_aff_img_<?php echo ($fiche->ref_article)?>" style="display:none; position:absolute">
						<img src="" id="id_img_line_<?php echo ($fiche->ref_article)?>" />
					</div>
				</div>
				*/?>
			</td>
			<td align="center">
				<?php	if ($fiche->date_dernier_achat){ echo date_Us_to_Fr($fiche->date_dernier_achat); }?>
			</td>

			<td align="right">
				<?php	if ($fiche->prix_achat_ht){ echo price_format($fiche->prix_achat_ht); }?>
			</td>
			<td align="right">
				<?php	if ($fiche->prix_achat_actuel_ht){ echo price_format($fiche->prix_achat_actuel_ht); }?>
			</td>
			<td style="vertical-align:middle; text-align:center">
				<a  href="#" id="link_art_voir_<?php echo ($fiche->ref_article)?>" style="display:block; width:100%; text-decoration:underline">Voir</a>
				<script type="text/javascript">
					Event.observe("link_art_voir_<?php echo ($fiche->ref_article)?>", "click",  function(evt){
						Event.stop(evt);
						page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo ($fiche->ref_article)?>'),'true','_blank');
					}, false);
					<?php /*
					<?php if (isset($fiche->lib_file) && $fiche->lib_file != "") { ?>
					Event.observe("line_art_<?php echo ($fiche->ref_article)?>", "mouseover",  function(evt){
						Event.stop(evt);
						$("line_aff_img_<?php echo ($fiche->ref_article)?>").style.display="";
						$("id_img_line_<?php echo ($fiche->ref_article)?>").src="<?php echo $ARTICLES_MINI_IMAGES_DIR.$fiche->lib_file;?>";
						//positionne_element(evt, "line_aff_img");
					}, false);
					Event.observe("line_art_<?php echo ($fiche->ref_article)?>", "mouseout",  function(evt){
						Event.stop(evt);
						$("line_aff_img_<?php echo ($fiche->ref_article)?>").style.display="none";
					}, false);
					<?php } ?>
					*/ ?>
				</script>
			</td>
		</tr>
	<?php } ?>
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

<iframe frameborder="0" scrolling="no" src="about:_blank" id="resume_stock_iframe" class="resume_stock_iframe"></iframe>

<div id="resume_stock" class="resume_stock">
</div>

<SCRIPT type="text/javascript">
	
	Event.observe("order_ref", "click",  function(evt){
		Event.stop(evt);
		$('orderby_s').value='a.ref_article';
		$('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="a.ref_article") {echo "DESC";} else {echo "ASC";}?>';
		page.catalogue_recherche_articles_proposes_fournisseur();
	}, false);
	
	Event.observe("order_ref_fournisseur", "click",  function(evt){
		Event.stop(evt);
		$('orderby_s').value='a.lib_article';
		$('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="a.lib_article") {echo "DESC";} else {echo "ASC";}?>';
		page.catalogue_recherche_articles_proposes_fournisseur();
	}, false);
	
	Event.observe("order_lib", "click",  function(evt){
		Event.stop(evt);
		$('orderby_s').value='a.lib_article';
		$('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="a.lib_article") {echo "DESC";} else {echo "ASC";}?>';
		page.catalogue_recherche_articles_proposes_fournisseur();
	}, false);
	
	Event.observe("order_dernier_achat", "click",  function(evt){
		Event.stop(evt);
		$('orderby_s').value='date_dernier_achat';
		$('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="date_dernier_achat") {echo "DESC";} else {echo "ASC";}?>';
		page.catalogue_recherche_articles_proposes_fournisseur();
	}, false);
	
	Event.observe('order_dernier_PA_HT', "click", function(evt){
		Event.stop(evt);
		$('orderby_s').value='prix_achat_ht';
		$('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="prix_achat_ht") {echo "DESC";} else {echo "ASC";}?>';
		page.catalogue_recherche_articles_proposes_fournisseur();
	});
	
	Event.observe('order_prix_actuel_HT', "click", function(evt){
		Event.stop(evt);
		$('orderby_s').value='prix_achat_actuel_ht';
		$('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="prix_achat_actuel_ht") {echo "DESC";} else {echo "ASC";}?>';
		page.catalogue_recherche_articles_proposes_fournisseur();
	});
	
	//on masque le chargement
	H_loading();
</SCRIPT>