<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "fiches", "form['ref_contact']", "form['page_to_show']", "form['fiches_par_page']", "nb_fiches", "form['orderby']", "form['orderorder']", "form['id_type_doc']", "form['id_etat_doc']");
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
                                       'page_to_show_m',
																			 'page.documents_recherche_mini()');




// Affichage des résultats
?>
<div   class="mt_size_optimise">
<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>
</div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:15%">
			<a href="#"  id="order_ref_doc">R&eacute;f&eacute;rence
			</a>
		</td>
		<td style="width:25%; text-align:left">
			<a href="#"  id="order_type_doc">Type de Document
			</a>
		</td>
		<td style=" text-align:left">
			<a href="#"  id="order_contact_doc">Contact
			</a>
		</td>
		<td style="width:15%; text-align:center">
			<a href="#"  id="order_montant_doc">
			Montant TTC
			</a>
		</td>
		<td style="width:10%; text-align:center">
			<a href="#"  id="order_date_doc">
			Date
			</a>
		</td>
	</tr>
<?php 
$colorise=0;
foreach ($fiches as $fiche) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
?>
<tr class="<?php  echo  $class_colorise?>">
	<td class="reference">
		<a  href="#" id="link_ref_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%">
		<?php	if ($fiche->ref_doc) { echo ($fiche->ref_doc)."&nbsp;";}?>		
		</a>
	<script type="text/javascript">
	Event.observe("link_ref_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt);
	<?php echo $_REQUEST['fonction_retour']?>(<?php echo $_REQUEST['param_retour']?>, '<?php echo ($fiche->ref_doc)?>');}, false);
	</script>
	</td>
	<td>
		<a  href="#" id="link_type_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%">
		<span class="r_doc_lib"><?php echo nl2br(($fiche->lib_type_doc))?></span><br />
		<?php	if ($fiche->lib_etat_doc) { echo ($fiche->lib_etat_doc); }?>
		</a>
	<script type="text/javascript">
	Event.observe("link_type_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); <?php echo $_REQUEST['fonction_retour']?>(<?php echo $_REQUEST['param_retour']?>, '<?php echo ($fiche->ref_doc)?>');}, false);
	</script>
	</td>
	<td style="text-align:left">
		<a  href="#" id="link_contact_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%" alt="<?php	if ($fiche->nom_contact) { echo ($fiche->nom_contact); }?>" title="<?php	if ($fiche->nom_contact) { echo str_replace("€", "&euro;", $fiche->nom_contact); }?>">
		<?php	if ($fiche->nom_contact) { echo substr(str_replace("€", "&euro;", $fiche->nom_contact), 0, 28); }?>&nbsp;
		</a>
	<script type="text/javascript">
	Event.observe("link_contact_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); <?php echo $_REQUEST['fonction_retour']?>(<?php echo $_REQUEST['param_retour']?>, '<?php echo ($fiche->ref_doc)?>');}, false);
	</script>
	</td>
	<td style="text-align:right; padding-right:5px">
		<a  href="#" id="link_montant_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%">
		<?php	if ($fiche->montant_ttc) { echo number_format($fiche->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; }?>&nbsp;
		</a>
	<script type="text/javascript">
	Event.observe("link_montant_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); <?php echo $_REQUEST['fonction_retour']?>(<?php echo $_REQUEST['param_retour']?>, '<?php echo ($fiche->ref_doc)?>');}, false);
	</script>
	</td>
	<td style="text-align:center">
		<a  href="#" id="link_date_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%">
		<?php	if ($fiche->date_doc) { echo (date_Us_to_Fr($fiche->date_doc)); }?>&nbsp;
		</a>
	<script type="text/javascript">
	Event.observe("link_date_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); <?php echo $_REQUEST['fonction_retour']?>(<?php echo $_REQUEST['param_retour']?>, '<?php echo ($fiche->ref_doc)?>');}, false);
	</script>
	</td>	
	</tr>
	
<?php
}
?></table>

<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat :</td>
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

<script type="text/javascript">
Event.observe("order_ref_doc", "click",  function(evt){Event.stop(evt); $('orderby_doc_m').value='ref_doc'; $('orderorder_doc_m').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="ref_doc") {echo "DESC";} else {echo "ASC";}?>'; page.documents_recherche_mini();}, false);

Event.observe("order_type_doc", "click",  function(evt){Event.stop(evt); $('orderby_doc_m').value='lib_type_doc'; $('orderorder_doc_m').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="lib_type_doc") {echo "DESC";} else {echo "ASC";}?>'; page.documents_recherche_mini();}, false);

Event.observe("order_contact_doc", "click",  function(evt){Event.stop(evt); $('orderby_doc_m').value='nom_contact'; $('orderorder_doc_m').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="nom_contact") {echo "DESC";} else {echo "ASC";}?>'; page.documents_recherche_mini();}, false);

Event.observe("order_montant_doc", "click",  function(evt){Event.stop(evt); $('orderby_doc_m').value='montant_ttc'; $('orderorder_doc_m').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="montant_ttc") {echo "DESC";} else {echo "ASC";}?>'; page.documents_recherche_mini();}, false);

Event.observe("order_date_doc", "click",  function(evt){Event.stop(evt); $('orderby_doc_m').value='date_doc'; $('orderorder_doc_m').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="date_doc") {echo "DESC";} else {echo "ASC";}?>'; page.documents_recherche_mini();}, false);


//on masque le chargement
H_loading();
</SCRIPT>