<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "fiches", "form['nom']", "form['id_profil']", "form['page_to_show']", "form['fiches_par_page']", "nb_fiches", "profils", "form['orderby']", "form['orderorder']");
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
																			 'page.utilisateur_recherche_histo()');



// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Formulaire de recherche
?><br />
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

<table  cellspacing="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:25%">
			<a href="#"  id="order_pseudo">
			Pseudo
			</a>
		</td>
		<td style="width:20%">
			<a href="#"  id="order_nom">
			Nom du contact
			</a>
		</td>
		<td style="width:15%; text-align:center">
			<a href="#"  id="order_date">
		Date
		</a>
		</td>
		<td style="width:10%; text-align:center">
			<a href="#"  id="order_ip">
		Adresse IP
		</a>
		</td>
		<td>
		</td>
		<td style="width:10%; text-align:center">
		</td>
	</tr>
	<?php 
	$colorise=0;
	foreach ($fiches as $fiche) {
		$colorise++;
		$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
		?>
		<tr class="<?php  echo  $class_colorise?>">
			<td>
				<a  href="#" id="pseudo_<?php echo htmlentities($fiche->id_log)?>" style="display:block; width:100%;"> <?php echo nl2br(htmlentities($fiche->pseudo))?> / <?php echo $fiche->email;?>
				</a>
				<script type="text/javascript">
				Event.observe("pseudo_<?php echo htmlentities($fiche->id_log)?>", "click",  function(evt){Event.stop(evt);page.verify('utilisateur_details','index.php#utilisateur_details.php?ref_user=<?php echo htmlentities($fiche->ref_user)?>','true','_blank');}, false);
				</script>
			</td>
			<td>
				<a  href="#" id="nom_<?php echo htmlentities($fiche->id_log)?>" style="display:block; width:100%;"> <?php echo nl2br(htmlentities($fiche->nom))?> (<?php echo htmlentities($fiche->lib_civ_court)?>)
				</a>
				<script type="text/javascript">
				Event.observe("nom_<?php echo htmlentities($fiche->id_log)?>", "click",  function(evt){Event.stop(evt);page.verify('affaires_affiche_fiche','index.php#'+escape('annuaire_view_fiche.php?ref_contact=<?php echo htmlentities($fiche->ref_contact)?>'),'true','_blank');}, false);
				</script>
			</td>
			<td style="text-align:center">
				<a  href="#" id="date_<?php echo htmlentities($fiche->id_log)?>" style="display:block; width:100%;"> <?php echo (date_US_to_Fr($fiche->date))?> <?php echo (getTime_from_date($fiche->date))?>
				</a>
				<script type="text/javascript">
				Event.observe("date_<?php echo htmlentities($fiche->id_log)?>", "click",  function(evt){Event.stop(evt);page.verify('utilisateur_details','index.php#utilisateur_details.php?ref_user=<?php echo htmlentities($fiche->ref_user)?>','true','_blank');}, false);
				</script>
			</td>
			<td  style=" text-align:center">
				<a  href="#" id="ip_<?php echo htmlentities($fiche->id_log)?>" style="display:block; width:100%;"> <?php echo $fiche->ip?>
				</a>
				<script type="text/javascript">
				Event.observe("ip_<?php echo htmlentities($fiche->id_log)?>", "click",  function(evt){Event.stop(evt);page.verify('utilisateur_details','index.php#utilisateur_details.php?ref_user=<?php echo htmlentities($fiche->ref_user)?>','true','_blank');}, false);
				</script>
			</td>
		<td style="text-align:center"><?php if ($fiche->email && $fiche->email != "") {?>
				<a href="mailto:<?php echo $fiche->email;?>"> <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/mail.gif" width="15" border="0" vspace="5"/> </a>
				<?php } ?>
		</td>
			<td style="text-align:center; vertical-align:middle">
				<a  href="#" id="voir_<?php echo htmlentities($fiche->id_log)?>" style="display:block; width:100%; text-decoration:underline">Voir
				</a>
				<script type="text/javascript">
				Event.observe("voir_<?php echo htmlentities($fiche->id_log)?>", "click",  function(evt){Event.stop(evt);page.verify('utilisateur_details','index.php#utilisateur_details.php?ref_user=<?php echo htmlentities($fiche->ref_user)?>','true','_blank');}, false);
				</script>
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

Event.observe("order_nom", "click",  function(evt){Event.stop(evt);$('orderby_s').value='nom'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="nom") {echo "DESC";} else {echo "ASC";}?>'; page.utilisateur_recherche_histo();}, false);

Event.observe("order_pseudo", "click",  function(evt){Event.stop(evt);$('orderby_s').value='pseudo'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="pseudo") {echo "DESC";} else {echo "ASC";}?>'; page.utilisateur_recherche_histo();}, false);


Event.observe("order_date", "click",  function(evt){Event.stop(evt);$('orderby_s').value='date'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="date") {echo "DESC";} else {echo "ASC";}?>'; page.utilisateur_recherche_histo();}, false);

Event.observe("order_ip", "click",  function(evt){Event.stop(evt);$('orderby_s').value='ip'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="ip") {echo "DESC";} else {echo "ASC";}?>'; page.utilisateur_recherche_histo();}, false);

//on masque le chargement
H_loading();
</SCRIPT>