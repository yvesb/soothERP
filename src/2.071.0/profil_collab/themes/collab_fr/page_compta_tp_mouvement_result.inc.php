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
																			 'etat_tp_result()');



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
		<td style="width:15%; font-weight:bolder">
			Référence
		</td>
		<td style=" text-align:left; font-weight:bolder">Contact</td>
		<td style="width:15%; text-align:left; font-weight:bolder">Document</td>
		<td style="width:15%; text-align:right; font-weight:bolder">Montant</td>
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
		<?php	if (isset($fiche->date_reglement)) { echo date_Us_to_Fr($fiche->date_reglement)." ".getTime_from_date($fiche->date_reglement); } ?>
	</td>
	<td>
		<a  href="#" id="link_reg_ref_<?php echo htmlentities($fiche->ref_reglement)?>" style="display:block; width:100%">
		<span style="font-weight:bolder"></span> 
		<?php	if (isset($fiche->ref_reglement)) {?>
		<?php echo nl2br(($fiche->ref_reglement))?>
		<?php }	?>
		</a>
		<script type="text/javascript">
		Event.observe("link_reg_ref_<?php echo htmlentities($fiche->ref_reglement)?>", "click",  function(evt){
			Event.stop(evt);
			page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->ref_reglement;?>','true','edition_reglement');
			$("edition_reglement").show();
			$("edition_reglement_iframe").show();
				
			}, false);
		</script>
	</td>
	<td>
		<?php	if (isset($fiche->ref_contact)) {?>
			<a  href="#" id="link_reg_ctc_<?php echo htmlentities($fiche->ref_reglement)?>" style="display:block; width:100%">
			
			<?php echo nl2br(($fiche->nom))?>
			</a>
			<script type="text/javascript">
			Event.observe("link_reg_ctc_<?php echo htmlentities($fiche->ref_reglement)?>", "click",  function(evt){
				Event.stop(evt);
				page.traitecontent('affaires_affiche_fiche','index.php#annuaire_view_fiche.php?ref_contact=<?php echo $fiche->ref_contact;?>','true','_blank');
					
				}, false);
			</script>
		<?php }	?>
	</td>
	<td>
		<?php	if (isset($fiche->ref_doc)) {?>
			<a  href="#" id="link_reg_doc_<?php echo htmlentities($fiche->ref_reglement)?>" style="display:block; width:100%">
			
			<?php echo (($fiche->ref_doc))?>
			</a>
			<script type="text/javascript">
			Event.observe("link_reg_doc_<?php echo htmlentities($fiche->ref_reglement)?>", "click",  function(evt){
				Event.stop(evt);
				page.traitecontent('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $fiche->ref_doc;?>'),'true','_blank');
					
				}, false);
			</script>
		<?php }	?>
	</td>
	<?php
	$solde_page += number_format($fiche->montant_reglement, $TARIFS_NB_DECIMALES, ".", ""	);
	?>
	<td style="text-align:right">
		<?php	if (isset($fiche->montant_reglement)) { 
		echo number_format($fiche->montant_reglement, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; }
		?>
	</td>
	</tr>
	
<?php
}
?>

	<tr style="background:#CCCCCC; font-weight:bolder">
		<td>
		</td>
		<td>
		</td>
		<td style=" text-align:center; font-weight:bolder">Solde de la page</td>
		<td style=" text-align:right; color:#FF0000; font-weight:bolder">
		<?php if ($solde_page < 0 ) {?>
		<?php echo $solde_page." ".$MONNAIE[1];?>
		<?php } ?>
		</td>
		<td style="text-align:right; font-weight:bolder">
		<?php if ($solde_page >= 0 ) {?>
		<?php echo $solde_page." ".$MONNAIE[1];?>
		<?php } ?>
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
<br />
</div>



<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>