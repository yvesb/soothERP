<?php

// *************************************************************************************************************
// historique des controle de la caisse
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
																			 'controle_caisse_historique_result()');



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

<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise1">
		<td style="width:19%; text-align:center">
			<a href="#"  id="">Date
			</a>
		</td>
		<td>
			Type
		</td>
		<td style="width:15%; text-align:left">Utilisateur</td>
		<td style="width:15%; text-align:right">Débit</td>
		<td style="width:15%; text-align:right">Crédit</td>
		<td style="width:2%">&nbsp;</td>
	</tr>
<?php 
$solde_page = 0;
$colorise=0;
foreach ($fiches as $fiche) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise3' : 'colorise1';
?>
<tr class="<?php  echo  $class_colorise?>">
	<td style="text-align:center">
		<?php	if (isset($fiche->date_move)) { echo date_Us_to_Fr($fiche->date_move)." ".getTime_from_date($fiche->date_move); } ?>
	</td>
	<td class="reference">
		<a  href="#" id="link_reg_ref_<?php echo htmlentities($fiche->id_compte_caisse_move)?>" style="display:block; width:100%">
		<?php	 echo htmlentities($fiche->lib_move_type);?>		
		<?php	if (isset($fiche->lib_reglement_mode)) {?>
		<?php echo nl2br(htmlentities($fiche->lib_reglement_mode))?>
		<?php }	?>
		</a>
		<?php 
		if (isset($fiche->id_move_type) && $fiche->id_move_type == "7") {
			?><div id="info_7_<?php echo htmlentities($fiche->id_compte_caisse_move)?>" style="display:none"></div>
			<?php
		}
		?>
		<script type="text/javascript">
		Event.observe("link_reg_ref_<?php echo htmlentities($fiche->id_compte_caisse_move)?>", "click",  function(evt){Event.stop(evt);
			<?php 
			if (isset($fiche->id_reglement_mode) && ($fiche->id_reglement_mode == 1 || $fiche->id_reglement_mode == 7 || $fiche->id_reglement_mode == 2 || $fiche->id_reglement_mode == 3)) {
				?>
			page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->Info_supp;?>','true','edition_reglement');
			$("edition_reglement").show();
			$("edition_reglement_iframe").show();
				<?php
			}
			?>
			<?php 
			if (isset($fiche->id_move_type) && $fiche->id_move_type == "6") {
				?>
				page.verify("compta_controle_caisse_imprimer", "compta_controle_caisse_imprimer.php?id_caisse=<?php echo $form['id_compte_caisse']?>&id_compte_caisse_controle=<?php echo $fiche->Info_supp; ?>", "true", "_blank");
				<?php
			}
			?>
			<?php 
			if (isset($fiche->id_move_type) && $fiche->id_move_type == "2") {
				?>
				page.verify("compta_transfert_caisse_imprimer", "compta_transfert_caisse_imprimer.php?id_caisse=<?php echo $form['id_compte_caisse'];?>&id_compte_caisse_transfert=<?php echo $fiche->Info_supp; ?>", "true", "_blank");
				<?php
			}
			?>
			<?php 
			if (isset($fiche->id_move_type) && $fiche->id_move_type == "4") {
				?>
				page.verify("compta_depot_caisse_imprimer", "compta_depot_caisse_imprimer.php?id_caisse=<?php echo $form['id_compte_caisse'];?>&id_compte_caisse_depot=<?php echo $fiche->Info_supp; ?>", "true", "_blank");
				<?php
			}
			?>
			<?php 
			if (isset($fiche->id_move_type) && $fiche->id_move_type == "3") {
				?>
				page.verify("compta_retrait_bancaire_caisse_imprimer", "compta_retrait_bancaire_caisse_imprimer.php?id_caisse=<?php echo $form['id_compte_caisse'];?>&id_compte_caisse_retrait=<?php echo $fiche->Info_supp; ?>", "true", "_blank");
				<?php
			}
			?>
			<?php 
			if (isset($fiche->id_move_type) && $fiche->id_move_type == "7") {
				?>
				$("info_7_<?php echo ($fiche->id_compte_caisse_move)?>").show();
				if ($("info_7_<?php echo ($fiche->id_compte_caisse_move)?>").innerHTML == "") {
					page.verify("compta_ar_fonds_caisse_affiche", "compta_ar_fonds_caisse_affiche.php?id_compte_caisse=<?php echo $form['id_compte_caisse'];?>&id_compte_caisse_ar=<?php echo $fiche->Info_supp; ?>", "true", "info_7_<?php echo ($fiche->id_compte_caisse_move)?>");
				}
				<?php
			}
			?>

			}, false);
		</script>
	</td>
	<td class="reference">
		<div style="display:block; width:100%">
		<?php	 echo htmlentities($fiche->pseudo);?>		
		</div>
		<script type="text/javascript">
		Event.observe("link_reg_ref_<?php echo htmlentities($fiche->id_compte_caisse_move)?>", "click",  function(evt){Event.stop(evt);
			}, false);
		</script>
	</td>

	<?php
	$solde_page += number_format($fiche->montant_move, $TARIFS_NB_DECIMALES, ".", ""	);
	?>
	<td style="text-align:right">
	<?php if ($fiche->montant_move < 0 ) {?>
		<span style="color:#FF0000">
		<?php	if (isset($fiche->montant_move)) { 
		echo number_format($fiche->montant_move, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; }
		?>
		</span>
	<?php } ?>
	</td>
	<td style="text-align:right">
	<?php if ($fiche->montant_move >= 0 ) {?>
		<span>
		<?php	if (isset($fiche->montant_move)) { 
		echo number_format($fiche->montant_move, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; }
		?>
		</span>
	<?php } ?>
	</td>
	<td style="text-align:right">
	<div>
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