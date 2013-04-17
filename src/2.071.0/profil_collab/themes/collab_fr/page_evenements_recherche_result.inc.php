<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "fiches", "form['id_comm_event_type']","form['page_to_show']", "form['fiches_par_page']", "nb_fiches", "form['orderby']", "form['orderorder']");
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
																			 'page.evenements_recherche()');



// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Formulaire de recherche
?><br />
<div style="text-align:right"><a href="planning_evenements_recherche_csv.php?recherche=1&orderby=<?php echo $form['orderby'];?>&orderorder=<?php echo $form['orderorder'];?>&id_comm_event_type=<?php echo $form['id_comm_event_type'];?>" target="_blank" style="color:#000000">Exporter les résultats</a></div>
<div class="mt_size_optimise">
<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>


</div>

<div style="border-bottom:1px solid #999999">
		<table class="main_table">
			<tr>
				<td style="width:200px; text-align:center; font-weight:bolder;">Contact</td>
				<td style="width:140px; text-align:center; font-weight:bolder;">Date</td>
				<td style="width:140px; text-align:center; font-weight:bolder;">Heure</td>
				<td style="width:140px; text-align:center; font-weight:bolder;">Durée</td>
				<td  style="width:200px; font-weight:bolder;">Utilisateur</td>
				<td style="width:200px; font-weight:bolder;">Type</td>
				<td style="width:120px; text-align:center; font-weight:bolder;">Rappel</td>
			</tr>
		</table>
		</div>
	<?php 
	$colorise=0;
	foreach ($fiches as $fiche) {
		$colorise++;
		$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
		?>
				<div style="border-bottom:1px solid #999999;"  class="<?php  echo  $class_colorise?>">
				<table style="width:100%">
				<tr>
				<td>
				<div id="open_event_<?php echo $fiche->id_comm_event;?>"  style="cursor:pointer">
				<table class="main_table" style="width:100%">
					<tr>
						<td style="width:200px; text-align:center; font-weight:bolder"><?php echo $fiche->nom;?></td>
						<td style="width:140px; text-align:center;"><?php echo date_Us_to_Fr($fiche->date_event);?></td>
						<td style="width:140px; text-align:center;"><?php echo getTime_from_date($fiche->date_event);?></td>
						<td style="width:140px; text-align:center;"><?php echo substr($fiche->duree_event,0,5);?></td>
						<td style="width:200px;"><?php echo ($fiche->pseudo);?></td>
						<td style="width:200px;"><?php echo ($fiche->lib_comm_event_type);?></td>
					
					</tr>
					<tr>
						<td style="width:200px; text-align:center;">&nbsp;</td>
						<td colspan="5">
						<?php echo nl2br($fiche->texte);?>
						</td>
					</tr>
				</table>
				</div>
				</td>
				<td style="width:120px; text-align:center;">
				<?php if ($fiche->date_rappel != "0000-00-00 00:00:00" && (strtotime(date("Y-m-d H:i:s")) > strtotime($fiche->date_rappel)) ) {?>
				
				<span class="common_link" id="id_comm_event_contact_fin_<?php echo $fiche->id_comm_event; ?>">[fin de rappel]</span>
				<script type="text/javascript">
				Event.observe("id_comm_event_contact_fin_<?php echo $fiche->id_comm_event; ?>", "click",  function(evt){
					Event.stop(evt); 
					
					var AppelAjax = new Ajax.Request(
													"annuaire_view_evenements_fin.php", 
													{
													parameters: {ref_contact: "<?php echo $fiche->ref_contact;?>", id_comm_event: "<?php echo $fiche->id_comm_event;?>"}
													}
													);
													
					$("id_comm_event_contact_fin_<?php echo $fiche->id_comm_event; ?>").style.display = "none";
				}, false);
				</script>
				<?php }?>
				</td>
				
				</tr>
				</table>
				<script type="text/javascript">
				
				Event.observe("open_event_<?php echo $fiche->id_comm_event;?>", "click", function(evt) {
					Event.stop(evt);
	page.verify("annuaire_view_fiche","index.php#annuaire_view_fiche.php?ref_contact=<?php echo $fiche->ref_contact;?>&id_comm_event=<?php echo $fiche->id_comm_event;?>", "true", "_blank");
					$("edition_event").show();
				 }, false);
				</script>
				</div>
				</div>
		<?php
	}
	?>

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