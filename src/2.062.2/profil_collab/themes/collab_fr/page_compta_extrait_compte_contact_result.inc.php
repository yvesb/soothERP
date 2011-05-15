<?php

// *************************************************************************************************************
// AFFICHAGE DU GRAND LIVRE D'UN CONTACT
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
																			 'page.grand_livre_result("'.$ref_contact.'")');




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
</script>

<div   class="mt_size_optimise">
<div style="padding-left:10px; padding-right:10px" >
<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php if (count($grand_livre) > 1) { echo $debut+1; } else {echo $debut;}?> &agrave; <?php if (isset($grand_livre[0]->id_exercice_ran)) {echo $debut+count($grand_livre)-1;}else {echo $debut+count($grand_livre);}?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>



</div>



<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#CCCCCC">
	<tr>
		<td style="text-align:left; width:100px; font-weight:bolder">
		<div style="width:100px">Date
		</div>
		</td>
		<td style="text-align:left; font-weight:bolder"  >
		<div>
		Libellé
		</div>
		</td>
		<td style="text-align:right; font-weight:bolder">
		<div>
		
		</div>
		</td>
		<td style="text-align:right; font-weight:bolder">
		<div>
		
		</div>
		</td>
		<td style="text-align:right; width:120px; font-weight:bolder">
		<div style="width:120px">
		Débit
		</div>
		</td>
		<td style="padding-right:10px; width:55px; font-weight:bolder">
			<div style="width:55px; text-align:right;">
			Lt
			</div>
		</td>
		<td style="text-align:right; width:120px; font-weight:bolder">
		<div style="width:120px">
		Crédit
		</div>
		</td>
		<td style="text-align:right; width:120px; font-weight:bolder">
		<div style="width:120px">
		Solde
		</div>
		</td>
	</tr>
<?php 
$colorise=0;
$montant_total_credit = 0;
$montant_total_debit = 0;
$montant_total_solde = 0;
foreach ($grand_livre as $line) {
$montant_en_credit = 0;
$montant_en_debit = 0;
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
	?>
	
	<tr  class="<?php echo $class_colorise;?>" id="ligne_<?php echo $colorise;?>">
		<td style="font-size:10px; text-align:left; width:100px;" class="<?php echo htmlentities($line->lettrage);?>">
		<div style="width:100px">
		<?php echo date_Us_to_Fr($line->date);?>
		</div>
		</td>
		<td style="text-align:left;" class="<?php echo htmlentities($line->lettrage);?>">
		<div>
		<?php if (isset($line->id_exercice_ran)) {?>
		Report
		<?php } 
		?>
		
		<?php if (isset($line->ref_doc) && !is_array($line->ref_doc) ) {?>
		<a href="#" id="grand_livre_line_<?php echo $colorise;?>" style="color:#000000; text-decoration:none">
		<span style="font-weight:bolder"><?php echo htmlentities($line->lib_type_doc);?></span> <span style="font-size:10px"><?php echo htmlentities($line->ref_doc);?></span>
		</a>
		</div>
		<script type="text/javascript">
		Event.observe("grand_livre_line_<?php echo $colorise;?>", "click",  function(evt){
			Event.stop(evt); 
			page.verify('article_view','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($line->ref_doc)?>'),'true','_blank');
		}, false);
		</script>
		<?php } 
		if (isset($line->ref_reglement)) { ?>
		<a href="#" id="grand_livre_line_<?php echo $colorise;?>" style="color:#000000; text-decoration:none">
		<span style="font-weight:bolder">Règlement</span>  <span style="font-size:10px">(<?php echo htmlentities($line->lib_reglement_mode);?> <?php if (isset($line->nchq_s) && $line->nchq_s != "") {echo " n°".$line->nchq_s;}?><?php if (isset($line->nchq_e) && $line->nchq_e != "") {echo " n°".$line->nchq_e;}?>)</span>
		</a><br />
		<?php //  print_r($line->ref_doc);?>
		</div>
		<SCRIPT type="text/javascript">
		Event.observe("grand_livre_line_<?php echo $colorise;?>", "click", function(evt){
			Event.stop(evt); 
			page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $line->ref_reglement;?>&ref_contact=<?php echo htmlentities($contact->getRef_contact())?>','true','edition_reglement');
			$("edition_reglement").show();
			$("edition_reglement_iframe").show();
		}, false);
		</SCRIPT>
		
		<?php } ?>
		</td>
		<td style="text-align:right; width:100px;" class="<?php echo htmlentities($line->lettrage);?>">
		<div style="text-align:right; width:100px;">
		<?php 
		if (isset($line->ref_doc) && !is_array($line->ref_doc) ) {
			?>
			 <span style="font-size:10px; <?php if ($line->id_etat_doc == "16") { ?>color: #FF0000;<?php }?>"><?php echo htmlentities($line->lib_etat_doc);?></span><br />
			<?php 
		} 
		?>
		</div>
		</td>
		<td style="text-align:right; font-weight:bolder" class="<?php echo htmlentities($line->lettrage);?>">
		<div>
		<?php 
		if (isset($line->lib_niveau_relance) ) {
			?>
			 <span style="font-size:10px"><?php echo htmlentities($line->lib_niveau_relance);?></span>
			<?php 
		} 
		?>
		</div>
		</td>
		<td style="text-align:right; width:120px;" class="<?php echo htmlentities($line->lettrage);?>">
		<div style="text-align:right; width:120px;">
		<?php 
		if (isset($line->ref_doc) && !is_array($line->ref_doc) && (($line->id_type_doc == 4 && $line->montant_ttc >= 0) || ($line->id_type_doc == 8 && $line->montant_ttc < 0))) {
			$montant_en_debit = abs(number_format($line->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			echo price_format($montant_en_debit);
		} 
		if (isset($line->ref_reglement) && $line->type_reglement == "sortant") {
			$montant_en_debit = abs(number_format($line->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			echo price_format($montant_en_debit);
		} 
		if (isset($line->montant_ran) && $line->montant_ran < 0) {
			$montant_en_debit = abs(number_format($line->montant_ran, $TARIFS_NB_DECIMALES, ".", ""	));
			echo price_format($montant_en_debit);
		} 
		$montant_total_debit += $montant_en_debit;
		?>
		</div>
		</td>
		<td style="font-size:10px; padding-right:10px; text-align:right; width:55px" class="<?php echo htmlentities($line->lettrage);?>">
			<div style="width:55px;" id="grand_livre_line_lt_<?php echo $colorise;?>">
				<div style="cursor:pointer">
					<?php echo htmlentities($line->lettrage);?>
				</div>
			</div>
		<script type="text/javascript">
		Event.observe($("grand_livre_line_lt_<?php echo $colorise;?>"), "mouseover",  function(evt){
			show_lettrage("<?php echo htmlentities($line->lettrage);?>", "grand_livre_liste"); 
		}, false);
		Event.observe($("grand_livre_line_lt_<?php echo $colorise;?>"), "mouseout",  function(evt){
			hide_lettrage("<?php echo htmlentities($line->lettrage);?>", "grand_livre_liste"); 
		}, false);
		</script>
			
		</td>
		<td style="text-align:right; width:120px" class="<?php echo htmlentities($line->lettrage);?>">
		<div style="width:120px">
		<?php 
		if (isset($line->ref_doc) && !is_array($line->ref_doc) && (($line->id_type_doc == 4 && $line->montant_ttc < 0) || ($line->id_type_doc == 8 && $line->montant_ttc >= 0)) ) { 
			$montant_en_credit = abs(number_format($line->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			echo price_format($montant_en_credit);
		} 
		
		if (isset($line->ref_reglement) && $line->type_reglement == "entrant") { 
			$montant_en_credit = abs(number_format($line->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			echo price_format($montant_en_credit);
		} 
		if (isset($line->montant_ran) && $line->montant_ran > 0) {
			$montant_en_credit = abs(number_format($line->montant_ran, $TARIFS_NB_DECIMALES, ".", ""	));
			echo price_format($montant_en_credit);
		} 
		$montant_total_credit += $montant_en_credit;
		?>
		
		</div>
		</td>
		<td style="text-align:right; width:120px" class="<?php echo htmlentities($line->lettrage);?>">
		<div style="width:120px">
		<?php
		$montant_total_solde = $montant_total_solde + $montant_en_credit - $montant_en_debit;
		echo price_format($montant_total_solde);
		?>
		</div>
		</td>
	</tr>
	<?php
}
?>
	<tr>
		<td style="text-align:left; width:100px; font-weight:bolder" colspan="4">
		<div>
		TOTAL DU COMPTE <?php echo htmlentities($contact->getNom())?>
		</div>
		</td>
		<td style="text-align:right; width:120px; font-weight:bolder">
		<div style="width:120px">
		<?php echo htmlentities(price_format($montant_total_debit));?>
		</div>
		</td>
		<td style="padding-right:10px; width:55px; font-weight:bolder">
			<div style="width:55px; text-align:right;">

			</div>
		</td>
		<td style="text-align:right; width:120px; font-weight:bolder">
		<div style="width:120px">
		<?php echo htmlentities(price_format($montant_total_credit));?>
		</div>
		</td>
		<td style="text-align:right; width:120px; font-weight:bolder">
		<div style="width:120px">
		<?php echo htmlentities(price_format($montant_total_solde));?>
		</div>
		</td>
	</tr>
</table>
<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo str_replace("link_", "link2_",$barre_nav);?></td>
		<td style="text-align:right;">R&eacute;ponse <?php if (count($grand_livre) > 1) { echo $debut+1; } else {echo $debut;}?> &agrave; <?php if (isset($grand_livre[0]->id_exercice_ran)) {echo $debut+count($grand_livre)-1;}else {echo $debut+count($grand_livre);}?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>


</div>
</div>

</div>