<?php

// *************************************************************************************************************
// AFFICHAGE DE HISTORIQUE DES VENTES
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
								Event.observe('link_pagi_{cible}', 'click',  function(evt){Event.stop(evt);  page.verify('documents_historique_ventes_content','documents_historique_ventes_content.php?id_stock={idchange}&page_to_show={cibleb}&date_debut='+$(\"date_debut\").value+'&date_fin='+$(\"date_fin\").value+'&type_values='+$(\"type_values\").value+'','true','tb4_det_aff');}, false);
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
								Event.observe('link_txt_".$cpt."', 'click',  function(evt){Event.stop(evt); page.verify('documents_historique_ventes_content','documents_historique_ventes_content.php?id_stock=".$idformtochange."&page_to_show=".$cpt."&date_debut='+$(\"date_debut\").value+'&date_fin='+$(\"date_fin\").value+'&type_values='+$(\"type_values\").value+'','true','tb4_det_aff'); }, false);
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
	$barre_nav .= barre_navigation($GLOBALS['_INFOS']['HISTO_VENTES']['nb_fiches'] , $search['page_to_show'], 
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
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($histo_ventes)?> sur <?php echo $GLOBALS['_INFOS']['HISTO_VENTES']['nb_fiches'] ?></td>
	</tr>
</table>


</div>

<?php
foreach ($histo_ventes as $histo_vente) {
	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="border-bottom:1px solid #999999">
		<tr>
			<td style="width:88px">
			<div style="width:80px">
				<?php echo htmlentities(date_Us_to_Fr($histo_vente->getDate_creation ()));?>
			</div>
			</td>
			<td >
			<a href="#" id ="<?php echo $histo_vente->getRef_doc();?>" style="text-decoration:none; color:#000000; font-weight:bolder">
			<?php echo $histo_vente->getRef_doc();?>
			</a>&nbsp;
			
			<script type="text/javascript">
				Event.observe('<?php echo $histo_vente->getRef_doc();?>', 'click',  function(evt){ Event.stop(evt); window.open( "<?php echo $_ENV['CHEMIN_ABSOLU'].$_SESSION['profils'][$_SESSION['user']->getId_profil ()]->getDir_profil();?>#"+escape('documents_edition.php?ref_doc=<?php echo $histo_vente->getRef_doc()?>'),'_blank');}, false);
			</script> 
			
			
			<a href="#" id ="<?php echo $histo_vente->getRef_doc();?>ctc" style="text-decoration:none; color:#000000"><?php echo $histo_vente->getNom_contact ();?>
			</a>&nbsp;
			<script type="text/javascript">
				Event.observe('<?php echo $histo_vente->getRef_doc();?>ctc', 'click',  function(evt){ Event.stop(evt); window.open( "<?php echo $_ENV['CHEMIN_ABSOLU'].$_SESSION['profils'][$_SESSION['user']->getId_profil ()]->getDir_profil();?>#"+escape('annuaire_view_fiche.php?ref_contact=<?php echo htmlentities($histo_vente->getRef_contact())?>'),'_blank');}, false);
			</script>
			
			</td>
			<td style="font-weight:bolder; width:40px">
			</td>
			<td style="width:145px;  text-align:right">
				<?php 
				echo price_format($histo_vente->getMontant_ht ())." ".$MONNAIE[1]; 
				?> HT
			</td>
			<td  style="width:35px; text-align:right">
			<div style="width:35px">
				<a href="documents_editing.php?ref_doc=<?php echo $histo_vente->getRef_doc()?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="pdf" title="pdf"/></a>
			</div>
			</td>
		</tr>
		<?php
		$liste_contenu = $histo_vente->getContenu ();
		$i=0;
		foreach ($liste_contenu as $contenu) {
			if ($contenu->ref_doc_line_parent != "" || $contenu->type_of_line != "article") {continue;}
			$i++;
			?>
			<tr>
				<td style="width:88px">
				<div style="width:80px">
				</div>
				</td>
				<td >
		<div style="position:relative" >
				<span id="view_line_artdesc_<?php echo $histo_vente->getRef_doc().$i;?>" >
				<?php echo str_replace("€","&euro;",str_replace("<br />","\n",$contenu->lib_article)); ?>
				</span>
				<?php
				if ($contenu->desc_article) {
					?>
					<div style="position:absolute; top:1.1em; right:0px; width:450px; display:none; z-index:250 " class="roundedtable_over" id="view_more_<?php echo $histo_vente->getRef_doc().$i;?>">
					<?php echo str_replace("€","&euro;",str_replace("<br />","\n",$contenu->desc_article)); ?>
					</div>
					<script type="text/javascript">		
					Event.observe("view_line_artdesc_<?php echo $histo_vente->getRef_doc().$i;?>", "mouseover", function(evt){	
						$("view_more_<?php echo $histo_vente->getRef_doc().$i;?>").style.display = "";
					},false);
					Event.observe("view_line_artdesc_<?php echo $histo_vente->getRef_doc().$i;?>", "mouseout", function(evt){	
						$("view_more_<?php echo $histo_vente->getRef_doc().$i;?>").style.display = "none";
					},false);
					</script>
					
					<?php
				}
				?>
				</div>
				</td>
				<td style="width:80px; text-align:right"><?php 
				echo $contenu->qte; 
				?> x
				</td>
				<td style="width:115px;  text-align:right; padding-right: 20px">
				<?php 
				echo price_format($contenu->pu_ht)." ".$MONNAIE[1]; 
				?>
				</td>
				<td style="width:35px; text-align:right">
				</td>
			</tr>
			<?php
		}
		?>

		<tr>
			<td style="width:88px">
			<div style="width:80px">
			</div>
			</td>
			<td style="font-style:italic" >
			Statut: <?php echo $histo_vente->getLib_etat_doc();?>
			- <?php if (price_format($histo_vente->getMontant_to_pay()) > 0) { echo price_format($histo_vente->getMontant_to_pay ())." ".$MONNAIE[1]; ?> à régler <?php } ?>
			</td>
			<td style="font-weight:bolder; width:40px">
			</td>
			<td style="width:145px;  text-align:right">
			</td>
			<td style="width:35px; text-align:right">
			</td>
		</tr>

</table>
	<?php 
}
?>
<br />

<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo str_replace("link_", "link2_",$barre_nav);?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($histo_ventes)?> sur <?php echo $GLOBALS['_INFOS']['HISTO_VENTES']['nb_fiches'] ?></td>
	</tr>
</table>
</<br />
<br />
<br />
<br />
