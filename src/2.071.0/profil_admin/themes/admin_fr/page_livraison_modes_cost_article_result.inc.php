<?php
// *************************************************************************************************************
// commissionnements des catégories d'articles
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************

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
																			 'page.article_livraison_modes_cost_recherche()');


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>



</div>
<div class="emarge" style="text-align:left">
<div >
<table >
<tr>
<td>
<div style="padding-left:10px; padding-right:10px">
<br />

	<table>
		<tr style="">
			<td>
			<div style="text-align:right; font-size:16px; padding-right:35px; font-weight:bolder">
			Valeurs par défaut:
			</div>
			</td>
			<td style="text-align:left; font-weight:bolder;  width:50%">
				<span><?php  echo $livraison_article->getLib_article();?></span>
				<div style="border-bottom:1px solid #999999; "></div>
				<?php
				foreach ($livraison_cost as $cost) {
					$fixe = substr($cost->formule, 0, strpos($cost->formule, "+"));
					$variab = substr($cost->formule, strpos($cost->formule, "+")+1);
					$nd=0;
					if ($fixe < 0 && $variab <0) {$nd = 1; $fixe = 0; $variab = 0 ;}
					
					if ($nd) {
						?>
						<?php echo $BASE_CALCUL_LIVRAISON[$cost->base_calcul][0];?> >= <?php echo $cost->indice_min;?> <?php echo $BASE_CALCUL_LIVRAISON[$cost->base_calcul][1];?> <br />
						Non disponible.
						<div style="border-bottom:1px solid #999999; "></div>
						<?php 
					} else {
						?>
						<?php echo $BASE_CALCUL_LIVRAISON[$cost->base_calcul][0];?> >= <?php echo $cost->indice_min;?> <?php echo $BASE_CALCUL_LIVRAISON[$cost->base_calcul][1];?> <br />
						Coût = <?php echo $fixe;?> + <?php echo $variab;?> x <?php echo $BASE_CALCUL_LIVRAISON[$cost->base_calcul][0];?> 
						<div style="border-bottom:1px solid #999999; "></div>
						<?php 
					}
				}
				?>
			</td>
			<td>&nbsp;
			</td>
		</tr>
		<tr style=" ">
			<td  style="border-bottom:1px solid #333333">&nbsp;
			</td>
			<td  style="border-bottom:1px solid #333333">&nbsp;
			</td>
		</tr>
		<?php
		foreach ($fiches as $fiche){
			?>
			<tr id="line_comm_article_<?php echo $fiche->ref_article;?>">
				<td style=" border-bottom:1px solid #FFFFFF">
					<span><?php echo $fiche->lib_article;?></span>
				</td>
				<td style="text-align:center; border-bottom:1px solid #FFFFFF;">
					<div id="mode_liv_cost_<?php echo $fiche->ref_article;?>">
						<?php if (!count($fiche->livraisons_tarifs)) { ?>
							<div id="more_mode_liv_<?php echo $fiche->ref_article;?>" style="cursor:pointer; display:inherit"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" /> Définir </div>
							
							<script type="text/javascript">
							Event.observe('more_mode_liv_<?php echo $fiche->ref_article;?>', 'click',  function(){
								page.traitecontent('livraison_modes_cost_article_det','livraison_modes_cost_article_det.php?id_livraison_mode=<?php echo $livraison_mode->getId_livraison_mode();?>&ref_article=<?php echo $fiche->ref_article;?>' ,"true" ,"mode_liv_cost_<?php echo $fiche->ref_article;?>");
							}, false);
							</script>
						<?php } else { 
							include $DIR.$_SESSION['theme']->getDir_theme()."page_livraison_modes_cost_article_det.inc.php";
						} ?>
					</div>
				</td>
				<td>&nbsp;
				</td>
			</tr>
			<?php
		}
		?>
	</table>

</div>
</td>
</tr>
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
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>