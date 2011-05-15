<?php

// *************************************************************************************************************
// AFFICHAGE DES MOUVEMENTS DE STOCK
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
																			 'page.stock_mouvements_result("'.$id_stock.'")');

?>
<script type="text/javascript">
</script>

<div   class="mt_size_optimise">
<input type="hidden" id="stock_move_id_stock" name="stock_move_id_stock" value="<?php echo $id_stock?>"/>
<div style="padding-left:10px; padding-right:10px">
<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($stocks_moves)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

<?php 
$colorise=0;
foreach ($stocks_moves as $stock_move) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
	?>
	
	<tr class="<?php  echo  $class_colorise?>">
		<td style="font-size:10px; text-align:left; width:100px;">
		<div style="width:100px">
		<?php echo date_Us_to_Fr($stock_move->date);?> <?php echo getTime_from_date($stock_move->date);?>
		</div>
		</td>
		<td style="font-size:10px; text-align:left; width:90px">
		<div style="width:90px">
			<?php
			if ($stock_move->abrev_stock) {
			echo htmlentities($stock_move->abrev_stock);
			} else {
			echo htmlentities($stock_move->lib_stock);
			}
			?>
		</div>
		</td>
		<td style="font-size:10px; padding-right:20px; text-align:right; width:45px">
			<div style="width:45px;" id="aff_resume_stock_sn_<?php echo $stock_move->ref_stock_move;?>">
			<?php echo htmlentities(qte_format($stock_move->qte));?>
			</div>
			<script type="text/javascript">
			//Event.observe("aff_resume_stock_sn_<?php echo $stock_move->ref_stock_move;?>", "click", function(evt){
			//	show_resume_stock_sn("<?php echo $stock_move->ref_stock_move;?>", evt); 
			//	Event.stop(evt);
			//}, false);
			</script>
		</td>
		<td style="text-align:left;  width:120px;">
		<div style="width:120px">
		<a href="#" id="art_stock_move_<?php echo htmlentities($stock_move->ref_stock_move);?>" style="color:#000000; text-decoration:none"><?php echo htmlentities($stock_move->ref_article);?></a>
		</div>
		<script type="text/javascript">
		Event.observe("art_stock_move_<?php echo htmlentities($stock_move->ref_stock_move);?>", "click",  function(evt){
			Event.stop(evt); 
			page.verify('article_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo htmlentities($stock_move->ref_article)?>'),'true','_blank');
		}, false);
		</script>
		</td>
		<td style="text-align:left; ">
		<div>
		<a href="#" id="art_stock_move2_<?php echo htmlentities($stock_move->ref_stock_move);?>" style="color:#000000; text-decoration:none"><?php echo ($stock_move->lib_article);?></a>
		</div>
		<script type="text/javascript">
		Event.observe("art_stock_move2_<?php echo htmlentities($stock_move->ref_stock_move);?>", "click",  function(evt){
			Event.stop(evt); 
			page.verify('article_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo htmlentities($stock_move->ref_article)?>'),'true','_blank');
		}, false);
		</script>
		</td>
		<td style="text-align:right; padding-right:10px">
		<?php if (isset($stock_move->nom)) { 
			?>
			<div style="width:170px">
			<a href="#" id="contact_stock_move_<?php echo htmlentities($stock_move->ref_stock_move);?>" style="color:#000000; text-decoration:none">
				<?php echo htmlentities($stock_move->nom); ?></a>
			</div>
			<script type="text/javascript">
			Event.observe("contact_stock_move_<?php echo htmlentities($stock_move->ref_stock_move);?>", "click",  function(evt){
				Event.stop(evt); 
				page.verify('annuaire_view_fiche','index.php#'+escape('annuaire_view_fiche.php?ref_contact=<?php echo htmlentities($stock_move->ref_contact)?>'),'true','_blank');
			}, false);
			</script>
			<?php
		}
		?>
		</td>
		<td style="text-align:left; width:120px;">
		<div style="width:120px; text-align:left">
		<a href="#" id="doc_stock_move_<?php echo htmlentities($stock_move->ref_stock_move);?>" style="color:#000000; text-decoration:none"><?php echo htmlentities($stock_move->ref_doc);?></a>
		</div>
		<script type="text/javascript">
		Event.observe("doc_stock_move_<?php echo htmlentities($stock_move->ref_stock_move);?>", "click",  function(evt){
			Event.stop(evt); 
			page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($stock_move->ref_doc)?>'),'true','_blank');
		}, false);
		</script>
		</td>
		<td style="text-align:left; width:120px">
		<div style="width:120px">
			<?php echo htmlentities($stock_move->lib_etat_doc);?>
		</div>
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
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($stocks_moves)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>
</div>
</div>

<iframe frameborder="0" scrolling="no" src="about:_blank" id="resume_stock_move_sn_iframe" class="resume_stock_iframe"></iframe>
<div id="resume_stock_move_sn" class="resume_stock">
</div>
</div>