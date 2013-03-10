<?php

// *************************************************************************************************************
// FENÊTRE D'AFFICHAGE DES NUMÉROS DE SÉRIE D'UNE LIGNE D'ARTICLE
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
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
		$lien = str_replace('{cible}', $cible, $lien);
		$lien = str_replace('{cibleb}', $cible-1, $lien);
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
	
	$barre_nav .= barre_navigation($infos_doc_line->qte, $page_to_show+1, 
                                       $DOC_AFF_QTE_SN, 
                                       $debut, $cfg_nb_pages,
                                       'page_to_show_up_sn',
																			 'show_mini_pop_up_article_sn("'.$document->getRef_doc().'", "'. $_REQUEST['ref_doc_line'].'", $(\'page_to_show_up_sn\').value)');




?>
<script type="text/javascript" language="javascript">
</script>

<div class="mt_size_optimise">
<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+$count_aff_sn?> sur <?php echo $infos_doc_line->qte?></td>
	</tr>
</table>


</div>
<input value="<?php echo $page_to_show;?>" type="hidden" id="page_to_show_up_sn" name="page_to_show_up_sn"/>
<input value="<?php echo $_REQUEST['ref_doc_line'];?>" type="hidden" id="ref_doc_line_pop_list" name="ref_doc_line_pop_list"/>
<input value="<?php echo $infos_doc_line->qte;?>" type="hidden" id="qte_pop_list" name="qte_pop_list"/>
<table>
<tr>
<?php
for ($i = 0; $i<$count_aff_sn ; $i++) {
	$saut_ligne="";
	$saut_ligne= ($i % 4)? '' : '</tr><tr>';
	echo $saut_ligne;
	?>
	<td>
	<div id="num_sn_pop_list_<?php echo $i;?>">
	<span id="more_sn_pop_list_<?php echo $i;?>" class="more_sn_class">sn:</span>
	<input value="<?php if (isset($liste_sn[$i])) { echo $liste_sn[$i]->numero_serie;} ?>" type="text" id="art_sn_pop_list_<?php echo $i;?>" name="art_sn_pop_list_<?php echo $i;?>" <?php if (isset($liste_sn[$i]->sn_exist) && !($liste_sn[$i]->sn_exist)) { echo "style=\"color: #FF0000;\"";}?>/> 
	<input value="<?php if (isset($liste_sn[$i])) { echo $liste_sn[$i]->numero_serie;} ?>" type="hidden" id="old_art_sn_pop_list_<?php echo $i;?>" name="old_art_sn_pop_list_<?php echo $i;?>"/>
	<a href="#" id="sup_sn_pop_list_<?php echo $i;?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">		
	</a>
	<div class="sn_block_choix" id="block_choix_sn_pop_list_<?php echo $i;?>">
	<iframe id="iframe_liste_choix_sn_pop_list_<?php echo $i;?>" frameborder="0" scrolling="no" src="about:_blank"  class="choix_liste_choix_sn" style="display:none"></iframe>
	<div id="choix_liste_choix_sn_pop_list_<?php echo $i;?>"  class="choix_liste_choix_sn" style="display:none"></div>
	</div>
	<script type="text/javascript">
	pre_start_observer_sn ("pop_list", "<?php echo $i;?>", "<?php echo $_REQUEST['ref_doc_line'];?>", "art_sn_pop_list_<?php echo $i;?>" ,"old_art_sn_pop_list_<?php echo $i;?>", "sup_sn_pop_list_<?php echo $i;?>", "more_sn_pop_list_<?php echo $i;?>", "<?php echo $infos_doc_line->ref_article;?>", "choix_liste_choix_sn_pop_list_<?php echo $i;?>", "iframe_liste_choix_sn_pop_list_<?php echo $i;?>" );
	</script>
	</div>
	</td>
	<td>&nbsp;&nbsp;&nbsp;
	</td>
	<?php
}
?>
</tr>
</table>
<SCRIPT type="text/javascript">


//on masque le chargement
H_loading();
</SCRIPT>
</div>