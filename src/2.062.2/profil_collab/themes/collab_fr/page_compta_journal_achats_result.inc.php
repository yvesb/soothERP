<?php

// ***********************************************************************************************************
// journal des achats
// ***********************************************************************************************************

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
	

if (isset($search['date_exercice'])) {

	$barre_nav .= barre_navigation($nb_fiches, $form['page_to_show'], 
                                       $form['fiches_par_page'], 
                                       $debut, $cfg_nb_pages,
                                       'page_to_show_s',
																			 'compta_journal_achats_result_byexercice ()');
	} else {

	$barre_nav .= barre_navigation($nb_fiches, $form['page_to_show'], 
                                       $form['fiches_par_page'], 
                                       $debut, $cfg_nb_pages,
                                       'page_to_show_s',
																			 'compta_journal_achats_result()');
}

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
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($nb_doc_aff)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>



</div>
<div   class="mt_size_optimise">

<table width="97%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:9%; text-align:center">Date</td>
		<td style="width:15%; text-align:center">N° pièce / Réf Doc</td>
		<td style="width:17%; text-align:left">Tiers</td>
		<td style="width:3%; text-align:center"></td>
		<td style="width:10%; text-align:right; padding-right:10px">Montant</td>
		<td style="width:10%; text-align:center">N° de Compte</td>
		<td style="width:27%; text-align:left">Libellé</td>
		<td style="width:8%"></td>
	</tr>
<?php 
$solde_page = 0;
$colorise=0;
$previous_ref_doc ="";
foreach ($fiches as $fiche) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';

if ($fiche->ref_doc != $previous_ref_doc) {
?>
	<tr>
		<td style="border-bottom:1px solid #333333" colspan="9"></td>
	</tr>
<?php
}
?>
<tr class="<?php  echo  $class_colorise?>">
	<td style="text-align:center; font-weight:bolder">
		<?php	if (isset($fiche->date_creation_doc) && ($fiche->ref_doc != $previous_ref_doc)) { echo date_Us_to_Fr($fiche->date_creation_doc); } ?>
	</td>
	<td style="text-align:center; font-weight:bolder">
	<a href="#" id="link_doc__<?php echo $colorise;?>" style="display:block; width:100%">
		<span>
		<?php	if (isset($fiche->ref_doc) && ($fiche->ref_doc != $previous_ref_doc)) { echo $fiche->ref_doc; }	?>
		</span>
		</a>
		<script type="text/javascript">
		Event.observe("link_doc__<?php echo $colorise;?>", "click",  function(evt){
		Event.stop(evt);
		page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $fiche->ref_doc;?>'),'true','_blank');
		}, false);
		</script>
	</td>
	<td style="text-align:left; font-weight:bolder">
	<a href="#" id="link_contact_<?php echo $colorise;?>" style="display:block; width:100%">
		<span>
		<?php	if (isset($fiche->nom) && ($fiche->ref_doc != $previous_ref_doc)) { echo $fiche->nom; }	?>
		</span>
		</a>
		<script type="text/javascript">
		Event.observe("link_contact_<?php echo $colorise;?>", "click",  function(evt){
		Event.stop(evt);
		page.verify('annuaire_view_fiche','index.php#'+escape('annuaire_view_fiche.php?ref_contact=<?php echo $fiche->ref_contact;?>'),'true','_blank');
		}, false);
		</script>
	</td>
	<td style="text-align:center;  padding-right:10px; font-weight:bolder">
		<span>
		<?php	if (isset($fiche->lib_journal)) { echo $fiche->lib_journal; }?>
		</span>
	</td>
	<td style="text-align:right; padding-right:10px">
		<span <?php	if (isset($fiche->montant)) { 
		if ($fiche->montant < 0) { ?>style=" color: #FF0000"<?php  }
		echo ">".number_format($fiche->montant, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; }
		?>
		</span>
	</td>
	<td style="text-align:left; padding-left:10px; padding-right:10px">
		<span>
		<?php	if (isset($fiche->numero_compte)) { echo $fiche->numero_compte; }?>
		</span>
	</td>
	<td style="text-align:left">
		<span>
			<?php	if (isset($fiche->lib_compte)) {
			 if (strlen($fiche->lib_compte)>45) { 
			 echo substr($fiche->lib_compte, 0, 45)."..."; } else { echo $fiche->lib_compte;} 
			 }?>
		</span>
	</td>
	<td style="text-align:center; font-weight:bolder">
	<?php 
	if ((!isset($last_date_before_cloture) || (strtotime($fiche->date_creation_doc) - strtotime(date_Us_to_Fr($last_date_before_cloture)) >0)) && ($fiche->ref_doc != $previous_ref_doc) ) {
		?>
		<a href="#" id="edit_compta_facture_<?php echo $colorise;?>">
		Editer
		</a>
			<script type="text/javascript">
			Event.observe("edit_compta_facture_<?php echo $colorise;?>", "click",  function(evt){
				Event.stop(evt);
				page.traitecontent('compta_doc','documents_compta.php?ref_doc=<?php echo $fiche->ref_doc; ?>&from_grand_livre=<?php if (isset($search['date_exercice'])) {?>_byexercice<?php } ?>','true','compta_facture');
				$("pop_up_compta_facture_mini_moteur").style.display = "block";
			}, false);
			</script>
		<?php 
	}
	?>
	
	</td>
	</tr>
	
<?php
		$previous_ref_doc = $fiche->ref_doc;
}
?>
</table>

<br />
<br />
<div style="font-weight:bolder; border-bottom:1px solid #000000">
Synthèse de la période en cours
</div><br />

<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:25%; text-align:center"></td>
		<td style="width:17%; text-align:left"></td>
		<td style="width:10%; text-align:right"></td>
		<td style="width:18%; text-align:left"></td>
		<td style="width:10%; text-align:left">N° de Compte</td>
		<td style="width:10%; text-align:right">Montant </td>
		<td style="width:5%"></td>
	</tr>
<?php 
$colorise=0;
foreach ($synthese as $synt) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
	?>
	<tr class="<?php  echo  $class_colorise?>">
		<td style="width:25%; text-align:left; font-weight:bolder">Synthèse du compte</td>
		<td style="width:10%; text-align:right"></td>
		<td style="width:35%; text-align:left" colspan="2">
		<?php	if (isset($synt->numero_compte)) { echo $synt->lib_compte; }?></td>
		<td style="width:10%; text-align:left">
		<span id="reload_cpt_<?php echo $colorise;?>" style="cursor:pointer">
		<?php	if (isset($synt->numero_compte)) { echo $synt->numero_compte; }?>
		</span>
		<script type="text/javascript">
		Event.observe("reload_cpt_<?php echo $colorise;?>", "click",  function(evt){
			Event.stop(evt);
			$("numero_compte").value = "<?php	if (isset($synt->numero_compte)) { echo $synt->numero_compte; }?>";
			$("page_to_show_s").value = "1";
			compta_journal_achats_result_byexercice ();
		}, false);
		</script>
		</td>
		<td style="width:10%; text-align:right">
		<?php echo number_format($synt->toto_montant, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; ?>
		</td>
		<td style="width:5%"></td>
	</tr>
	<?php
}
?>
</table>
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