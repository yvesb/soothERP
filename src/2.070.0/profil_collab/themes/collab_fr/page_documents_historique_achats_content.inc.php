<?php

// *************************************************************************************************************
// AFFICHAGE DE HISTORIQUE DES ACHATS
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
								Event.observe('link_pagi_{cible}', 'click',  function(evt){Event.stop(evt);  page.verify('documents_historique_achats_content','documents_historique_achats_content.php?id_stock={idchange}&page_to_show={cibleb}&date_debut='+$(\"date_debut\").value+'&date_fin='+$(\"date_fin\").value+'','true','blf_{fonctionlauch}');}, false);
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
				$barre .= "<span class='off'><b>&nbsp;".$cpt."&nbsp;</b></span> ";
		}
		else
		{				$barre .= "<a href='#' id='link_txt_".$cpt."";
				$barre .= "'>&nbsp;".$cpt."&nbsp;</a>
								<script type='text/javascript'>
								Event.observe('link_txt_".$cpt."', 'click',  function(evt){Event.stop(evt); page.verify('documents_historique_achats_content','documents_historique_achats_content.php?id_stock=".$idformtochange."&page_to_show=".$cpt."&date_debut='+$(\"date_debut\").value+'&date_fin='+$(\"date_fin\").value+'','true','blf_".$fonctiontolauch."'); }, false);
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
	$debut =(($search['page_to_show']-1)*$fiches_par_page);
	$id_cible = $stock_vu;
	if ($stock_vu == "" ) {
		$id_cible = "toutes";
	}
	$barre_nav .= barre_navigation($GLOBALS['_INFOS']['HISTO_ACHATS']['nb_fiches'] , $search['page_to_show'], 
                                       $fiches_par_page, 
                                       $debut, $cfg_nb_pages,
                                       $stock_vu,
																			 $id_cible);

?>

<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($histo_achats)?> sur <?php echo $GLOBALS['_INFOS']['HISTO_ACHATS']['nb_fiches'] ?></td>
	</tr>
</table>


</div>

<?php
$indentation_commande  = 0;
$indentation_article = 0;
foreach ($histo_achats as $histo_achat) {
	
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="document_box_head">
		<tr>
			<td style="width:188px">
			<a href="#" id ="<?php echo htmlentities($stock_vu."_".$histo_achat->ref_doc);?>" style="text-decoration:none; color:#000000">
			<?php echo htmlentities($histo_achat->ref_doc);?>
			</a>
			<script type="text/javascript">
				Event.observe('<?php echo htmlentities($stock_vu."_".$histo_achat->ref_doc);?>', 'click',  function(evt){ Event.stop(evt); window.open( "<?php echo $_ENV['CHEMIN_ABSOLU'].$_SESSION['profils'][$_SESSION['user']->getId_profil ()]->getDir_profil();?>#"+escape('documents_edition.php?ref_doc=<?php echo htmlentities($histo_achat->ref_doc)?>'),'_blank');}, false);
			</script>
			</td>
			<td style="font-weight:bolder">
			<a href="#" id ="<?php echo htmlentities($stock_vu."_".$histo_achat->ref_doc);?>ctc" style="text-decoration:none; color:#000000"><?php echo htmlentities($histo_achat->nom_contact);?>
			</a>&nbsp;
			<script type="text/javascript">
				Event.observe('<?php echo htmlentities($stock_vu."_".$histo_achat->ref_doc);?>ctc', 'click',  function(evt){ Event.stop(evt); window.open( "<?php echo $_ENV['CHEMIN_ABSOLU'].$_SESSION['profils'][$_SESSION['user']->getId_profil ()]->getDir_profil();?>#"+escape('annuaire_view_fiche.php?ref_contact=<?php echo htmlentities($histo_achat->ref_contact)?>'),'_blank');}, false);
			</script>
			
			</td>
			<td style="font-weight:bolder; width:140px">
			<div style="width:140px; <?php if ($histo_achat->id_etat_doc == 11 || $histo_achat->id_etat_doc == 13 || $histo_achat->id_etat_doc == 14) {echo "color:#FF0000";}?>">
				<?php echo htmlentities($histo_achat->lib_etat_doc);?>
			</div>
			</td>
			<td style="width:145px;  text-align:right">
			<?php 
			if (isset($_REQUEST["id_stock"]) && !$_REQUEST["id_stock"]) {echo htmlentities($histo_achat->lib_stock);}
			?>
			</td>

			<td style=" text-align:right; width:80px">
			<div style="width:80px">
				<?php echo htmlentities(date_Us_to_Fr($histo_achat->date_doc));?>
			</div>
			</td>
			<td class="document_border_right" style="width:35px; text-align:right">
			<div style="width:35px">
				<a href="documents_editing.php?ref_doc=<?php echo $histo_achat->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="pdf" title="pdf"/></a>
			</div>
			</td>
		</tr>
	</table>
	<table cellpadding="0" cellspacing="0" border="0" style="border-bottom:1px solid #9dabb3; border-left:1px solid #9dabb3; border-right:1px solid #9dabb3; width:100%">
	<tr><td>
	<?php 
	$liste_contenu = $histo_achat->lines ;
	$colorise=0;
	foreach ($liste_contenu as $contenu) {
	$colorise++;
	$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="<?php  echo  $class_colorise?>">
				<tr>
					<td style="width:28px;">
						
					</td>
					<td style="width:110px" class="document_border_right">
						<div style="width:107px;">
						<a href="#" id="<?php echo htmlentities($stock_vu."_".$histo_achat->ref_doc);?><?php echo htmlentities($contenu->ref_article)?>" style="text-decoration:none; color:#000000">
						<?php if ($contenu->ref_interne != "") { echo $contenu->ref_interne;} else { echo $contenu->ref_article;} ?></a><br />
						<?php echo $contenu->ref_oem;?>
						</div>
						<script type="text/javascript">
							Event.observe('<?php echo htmlentities($stock_vu."_".$histo_achat->ref_doc);?><?php echo htmlentities($contenu->ref_article)?>', 'click',  function(evt){ Event.stop(evt); window.open( "<?php echo $_ENV['CHEMIN_ABSOLU'].$_SESSION['profils'][$_SESSION['user']->getId_profil ()]->getDir_profil();?>#"+escape('catalogue_articles_view.php?ref_article=<?php echo htmlentities($contenu->ref_article)?>'),'_blank');}, false);
						</script>
					</td>
					<td style=" padding-left:3px">
						<div style="">&nbsp;
							<?php
								echo htmlentities(str_replace("<br />","\n",$contenu->lib_article));
							?>
						</div>
						<div style="height:3px; line-height:3px;"></div>
						<div style=" font-style:italic">
						<?php
								echo htmlentities(str_replace("<br />","\n",$contenu->desc_article));
							?>
						</div>
					</td>
					<td style="width:70px; text-align:center;" >
						<div style="width:70px; cursor:pointer">
						<?php
								echo $contenu->qte;
							?>
						</div>
					</td>
					<td style="width:70px; text-align:right;" >
						<div style="width:70px; cursor:pointer">
						<?php
								echo price_format($contenu->montant).$MONNAIE[1];
							?>
						</div>
					</td>
					<td style="width:10px; text-align:center;" >
						<div style="width:10px">
						
						</div>
						
					</td>
				</tr>
			</table>
			<?php 
	$indentation_article ++;
	}
	?>

</td>
</tr>
</table>
<?php 
	$indentation_fac = 0;
	$liste_fac = $histo_achat->liaison_fac ;
	foreach ($liste_fac as $fac) {
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="width:28px;">
						
					</td>
					<td style="width:110px">
						<div style="width:107px;">&nbsp;
						</div>
					</td>
					<td style=" padding-left:3px">
						<div style="">&nbsp;
						</div>
					</td>
					<td style="width:140px; text-align:left;" >
						<div style="width:140px; cursor:pointer">
							<a href="#" id ="<?php echo htmlentities($stock_vu."_".$indentation_fac."_".$fac->ref_doc_destination);?>" style="text-decoration:none; <?php if ($fac->id_etat_doc == 16 || $fac->id_etat_doc == 17 || $fac->id_etat_doc == 18) {echo "color:#FF0000;";} else {echo "color:#000000;";}?>" title="<?php echo $fac->lib_etat_doc;?>">
							<?php echo $fac->ref_doc_destination;?>
							</a>
							<script type="text/javascript">
								Event.observe('<?php echo htmlentities($stock_vu."_".$indentation_fac."_".$fac->ref_doc_destination);?>', 'click',  function(evt){ Event.stop(evt); window.open( "<?php echo $_ENV['CHEMIN_ABSOLU'].$_SESSION['profils'][$_SESSION['user']->getId_profil ()]->getDir_profil();?>#"+escape('documents_edition.php?ref_doc=<?php echo htmlentities($fac->ref_doc_destination)?>'),'_blank');}, false);
							</script>
						</div>
					</td>
					<td style="width:70px; text-align:right;" >
						<div style="width:70px; cursor:pointer">
						<?php
							echo price_format($fac->montant_ttc).$MONNAIE[1];
							?>
						</div>
					</td>
					<td style="width:10px; text-align:center;" >
						<div style="width:10px">
						
						</div>
						
					</td>
				</tr>
			</table>
			<?php 
	$indentation_fac ++;
	}
	?><br />

	<?php 
$indentation_commande++;
}
?>

<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo str_replace("link_", "link2_",$barre_nav);?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($histo_achats)?> sur <?php echo $GLOBALS['_INFOS']['HISTO_ACHATS']['nb_fiches'] ?></td>
	</tr>
</table>
</<br />
<br />
<br />
<br />
