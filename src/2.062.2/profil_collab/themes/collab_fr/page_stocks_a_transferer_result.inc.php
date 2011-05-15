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
																			 'stock_a_transferer()');


// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Affichage des résultats
?><br />
<div   class="mt_size_optimise">


<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>



</div>


<table width=""  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:120px">
			<div style="width:120px">
			<a href="#"  id="order_simple_ref">R&eacute;f&eacute;rence
			</a>
			</div>
		</td>
		<td style="width:280px" >
			<div style="width:280px">
			<a href="#"  id="order_simple_lib">Libell&eacute;
			</a>
			</div>
		</td>
			<td style="width:15%; text-align:center"><?php echo $_SESSION['stocks'][$search['stock_depart']]->getLib_stock ();?></td>
			<td style="width:15%; text-align:center"><?php echo $_SESSION['stocks'][$search['stock_arrivee']]->getLib_stock ();?></td>
			<td style="width:15%; text-align:center">A Transférer</td>

	</tr>
<?php 
$colorise=0;
foreach ($fiches as $fiche) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
?>
<tr class="<?php  echo  $class_colorise?>" id="result_renouv_stock_<?php echo htmlentities($fiche->ref_article)?>">
	<td class="reference">
		<a  href="#" id="link_art_ref_<?php echo htmlentities($fiche->ref_article)?>" style="display:block; width:100%">
		<?php	if ($fiche->ref_interne!="") { echo htmlentities($fiche->ref_interne)."&nbsp;";}else{ echo htmlentities($fiche->ref_article)."&nbsp;";}?><br />
		<?php	if ($fiche->ref_oem) { echo htmlentities($fiche->ref_oem)."&nbsp;";}?>		
		</a>
		<script type="text/javascript">
		Event.observe("link_art_ref_<?php echo htmlentities($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo htmlentities($fiche->ref_article)?>'),'true','_blank');
		}, false);
		</script>
	</td>
	<td>
		<a  href="#" id="link_art_lib_<?php echo htmlentities($fiche->ref_article)?>" style="display:block; width:100%">
		
		<span class=""><?php echo nl2br(htmlentities($fiche->lib_article))?></span>
		</a>
		<script type="text/javascript">
		Event.observe("link_art_lib_<?php echo htmlentities($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo htmlentities($fiche->ref_article)?>'),'true','_blank');
		}, false);
		</script>
	</td>
			<td style="text-align:center">
			<span >
				<?php
				$en_stock_depart =  ($fiche->qted); 
				$en_stock_depart_prog = $en_stock_depart - ( $fiche->stocks_rsv_qted - $fiche->stocks_rsv_qte_livreed );
				$en_stock_depart_seuil = ($fiche->seuil_alerted);
				$en_stock_depart_dispo = $en_stock_depart_prog - $en_stock_depart_seuil;
				?>
				<?php echo $en_stock_depart;?> (<?php echo $en_stock_depart_prog;?>)
				</span>
			</td>
		<td style="text-align:center">
			<a href="#" id="aff_resume_stock_<?php echo ($fiche->ref_article);?>">
			<span >
				<?php
				$en_stock_arrivee =  $fiche->qte; 
				$en_stock_arrivee_prog = $en_stock_arrivee - ( $fiche->stocks_rsv_qte - $fiche->stocks_rsv_qte_livree );
				$en_stock_arrivee_seuil = $fiche->seuil_alerte;
				$en_stock_arrivee_besoin = $en_stock_arrivee_seuil - $en_stock_arrivee_prog;
				?>
				<?php echo $en_stock_arrivee;?> (<?php echo $en_stock_arrivee_prog;?>) 
				</span>
			</a>
			<script type="text/javascript">
			Event.observe("aff_resume_stock_<?php echo ($fiche->ref_article);?>", "click", function(evt){show_resume_stock_all("<?php echo $fiche->ref_article;?>", evt); Event.stop(evt);}, false);
			</script>
		</td>
			<td style="text-align:center; font-weight:bolder">
			<?php
				if ($en_stock_depart_dispo < 0) { $en_stock_depart_dispo = 0 ;}
				if ($en_stock_arrivee_besoin < 0) { $en_stock_arrivee_besoin = 0 ;}
				
				if ( $en_stock_depart_dispo >= $en_stock_arrivee_besoin) { 
					echo $en_stock_arrivee_besoin;
				}
				else {
					echo $en_stock_depart_dispo;
				}
				
				?>
			</td>
	</tr>
	
<?php
}
?></table>

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

//on masque le chargement
H_loading();
</SCRIPT>