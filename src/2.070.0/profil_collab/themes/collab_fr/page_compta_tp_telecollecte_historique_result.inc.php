<?php

// *************************************************************************************************************
// TP
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "fiches");
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
																			 'etat_telecollecte_result()');



// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Affichage des résultats
?><br />


<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>


</div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise1">
		<td style="width:19%; text-align:center; font-weight:bolder">
			<a href="#"  id="">Date
			</a>
		</td>
		<td style="width:20%; font-weight:bolder; text-align:right;">
			Montant télécollecte
		</td>
		<td style="text-align:right; font-weight:bolder">Utilisateur</td>
		<td style="width:20%; text-align:right; font-weight:bolder">Montant commissions</td>
		<td style="width:15%; text-align:right; font-weight:bolder"></td>
	</tr>
<?php 
$solde_page = 0;
$colorise=0;
foreach ($fiches as $fiche) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise3' : 'colorise1';
?>
<tr class="<?php echo $class_colorise;?>">
	<td style="text-align: left">
		<?php	if (isset($fiche->date_telecollecte)) { echo date_Us_to_Fr($fiche->date_telecollecte)." ".getTime_from_date($fiche->date_telecollecte); } ?>
	</td>
	<td style="text-align: right">
		<a  href="#" id="link_reg_ref_<?php echo htmlentities($fiche->id_compte_tp_telecollecte)?>" style="display:block; width:100%">
		<span style="font-weight:bolder"></span> 
		<?php	if (isset($fiche->montant_telecollecte)) {?>
		<?php echo (($fiche->montant_telecollecte))?> 
			<?php echo $MONNAIE[1];?>
		<?php }	?>
		</a>
		<script type="text/javascript">
			Event.observe("link_reg_ref_<?php echo htmlentities($fiche->id_compte_tp_telecollecte)?>", "click", function(evt){
				Event.stop(evt);
				page.verify("compta_tp_telecollecte_imprimer", "compta_tp_telecollecte_imprimer.php?id_compte_tp=<?php echo $_REQUEST["id_compte_tp"]; ?>&tp_type=<?php echo $_REQUEST["tp_type"];?>&id_compte_tp_telecollecte=<?php echo $fiche->id_compte_tp_telecollecte; ?>", "true", "_blank");
			}, false);
		</script>
	</td>
	<td style="text-align: right">
		<?php	if (isset($fiche->pseudo)) {?>
			<a  href="#" id="link_reg_ctc_<?php echo htmlentities($fiche->id_compte_tp_telecollecte)?>" style="display:block; width:100%">
			
			<?php echo nl2br(($fiche->pseudo))?>
			</a>
			<script type="text/javascript">
			Event.observe("link_reg_ctc_<?php echo htmlentities($fiche->id_compte_tp_telecollecte)?>", "click",  function(evt){
				Event.stop(evt);
				page.verify("compta_tp_telecollecte_imprimer", "compta_tp_telecollecte_imprimer.php?id_compte_tp=<?php echo $_REQUEST["id_compte_tp"]; ?>&tp_type=<?php echo $_REQUEST["tp_type"];?>&id_compte_tp_telecollecte=<?php echo $fiche->id_compte_tp_telecollecte; ?>", "true", "_blank");
				}, false);
			</script>
		<?php }	?>
	</td>
	<td style="text-align: right">
		<?php	if (isset($fiche->montant_commission)) {?>
			<a  href="#" id="link_reg_doc_<?php echo htmlentities($fiche->id_compte_tp_telecollecte)?>" style="display:block; width:100%">
			
			<?php echo (($fiche->montant_commission))?> 
			<?php echo $MONNAIE[1];?>
			</a>
			<script type="text/javascript">
			Event.observe("link_reg_doc_<?php echo htmlentities($fiche->id_compte_tp_telecollecte)?>", "click",  function(evt){
				Event.stop(evt);
				page.verify("compta_tp_telecollecte_imprimer", "compta_tp_telecollecte_imprimer.php?id_compte_tp=<?php echo $_REQUEST["id_compte_tp"]; ?>&tp_type=<?php echo $_REQUEST["tp_type"];?>&id_compte_tp_telecollecte=<?php echo $fiche->id_compte_tp_telecollecte; ?>", "true", "_blank");
				}, false);
			</script>
		<?php }	?>
	</td>
	<td style="text-align:right">
	
	<a href="compta_tp_telecollecte_imprimer.php?id_compte_tp=<?php echo $_REQUEST["id_compte_tp"]; ?>&tp_type=<?php echo $_REQUEST["tp_type"];?>&id_compte_tp_telecollecte=<?php echo $fiche->id_compte_tp_telecollecte; ?>" target="_blank" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif"/></a> 
	<a href="compta_tp_telecollecte_imprimer.php?id_compte_tp=<?php echo $_REQUEST["id_compte_tp"]; ?>&tp_type=<?php echo $_REQUEST["tp_type"];?>&id_compte_tp_telecollecte=<?php echo $fiche->id_compte_tp_telecollecte; ?>&print=1" target="_blank" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/icone_imprime.gif" alt="Imprimer" title="Imprimer"/></a>
	
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

//on masque le chargement
H_loading();
</SCRIPT>