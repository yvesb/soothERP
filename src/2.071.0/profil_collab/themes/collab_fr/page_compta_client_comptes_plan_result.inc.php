<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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
	$barre= "";

	$lien_on 	= "&nbsp;<a href='#' id='link_pagi_{cible}'>{lien}</a>&nbsp;
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
		{
				$barre .= "<a href='#' id='link_txt_".$cpt."";
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
    return '<img src="'.$img.'"   border="0" >';
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
                                       'page_to_show',
																			 'page.compta_client_comptes_plan()');




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<div style="height:50px">
	<div id="affresult">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
				<td id="nvbar"><?php echo $barre_nav;?></td>
				<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
			</tr>
		</table>
	</div>
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div style="padding-left:10px; padding-right:10px">

	<table>
		<tr style="">
			<td>&nbsp;
			</td>
			<td style="text-align:center; font-weight:bolder;  width:15% ">
				<span>Numéro de compte:</span>
			</td>
			<td style="width:10%">&nbsp;
			</td>
			<td style="text-align:left; font-weight:bolder;  width:45% ">
				<span>Libellé:</span>
			</td>
		</tr>
<?php
foreach ($fiches as $fiche){
	?>
		<tr id="line_compte_comptable" style="">
			<td>
				<span><?php echo $fiche->nom;?></span>
			</td>
			<td style="text-align:center">
			<span style="text-decoration:underline; cursor:pointer" id="numero_compte_compta_client_<?php echo $fiche->ref_contact;?>"><?php if ($fiche->defaut_numero_compte) { echo $fiche->defaut_numero_compte;} else if($fiche->categ_defaut_numero_compte) { echo $fiche->categ_defaut_numero_compte;} else { echo $DEFAUT_COMPTE_TIERS_VENTE;}?></span>
			</td>
			<td>&nbsp;
			</td>
			<td>
			<span id="aff_numero_compte_compta_client_<?php echo $fiche->ref_contact;?>">
			<?php if ($fiche->defaut_numero_compte) { echo $fiche->defaut_lib_compte;} else if($fiche->categ_defaut_numero_compte) { echo $fiche->categ_defaut_lib_compte;} else {  $lcpt = new compta_plan_general($DEFAUT_COMPTE_TIERS_VENTE); echo $lcpt->getLib_compte();}?>
			</span>
			<script type="text/javascript">
			
			Event.observe('numero_compte_compta_client_<?php echo $fiche->ref_contact;?>', 'click',  function(evt){
				ouvre_compta_plan_mini_moteur(); 
		charger_compta_plan_mini_moteur ("compte_plan_comptable_search.php?cible=compta_client&cible_id=<?php echo $fiche->ref_contact;;?>&retour_value_id=numero_compte_compta_client_<?php echo $fiche->ref_contact;?>&retour_lib_id=aff_numero_compte_compta_client_<?php echo $fiche->ref_contact;?>&indent=numero_compte_compta_client_<?php echo $fiche->ref_contact;?>&num_compte=<?php echo($fiche->categ_defaut_numero_compte) ? $fiche->categ_defaut_numero_compte : $DEFAUT_COMPTE_TIERS_VENTE ;?>");
				Event.stop(evt);
			},false); 
			
			</script>
			</td>
		</tr>
		<tr >
			<td colspan="4">
	<hr />
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
<br />
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>
</div>