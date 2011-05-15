<?php
include('page_catalogue_recherche_mini.inc.php');
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "form['page_to_show']", "form['fiches_par_page']", "nb_fiches", "form['orderby']", "form['orderorder']");
check_page_variables ($page_variables);

//******************************************************************
// Variables communes d'affichage
//******************************************************************


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

// ------------------------------------------------------------------------
// barre_navigation
// ------------------------------------------------------------------------
function barre_navigation(	$nbtotal,
							$nbenr, 
							$cfg_nbres_ppage, 
							$debut, 
							$cfg_nb_pages,
							$idformtochange,
							$fonctiontolauch){
	// --------------------------------------------------------------------
	global $cfg_nb_pages; // Nb de n° de pages affichées dans la barre
	global $DIR;
	$barre= "";	
	$lien_on = "&nbsp;<a href='#' id='link_pagi_{cible}'>{lien}</a>&nbsp;
					<script type='text/javascript'>
					Event.observe('link_pagi_{cible}', 'click',  function(evt){Event.stop(evt); $(\"{idchange}\").value={cibleb}; {fonctionlauch};}, false);
					</script>";
	$lien_off = "&nbsp;{lien}&nbsp;";
	// --------------------------------------------------------------------
    
	// début << .
	// --------------------------------------------------------------------
	if ($debut >= $cfg_nbres_ppage) {
		$cible = 1;
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/gauche_on.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_on);
		$lien = str_replace('{cible}', $cible-1, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	} else {
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/gauche_off.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_off);
	}
	$barre .= $lien."&nbsp;<strong>&middot;</strong>";


	// précédent < .
	// --------------------------------------------------------------------
	if ($debut >= $cfg_nbres_ppage) {
		$cible = ($nbenr-1);
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/gauche_on.gif');
		$lien = str_replace('{lien}', $image, $lien_on);
		$lien = str_replace('{cible}', $cible, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	} else {
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/gauche_off.gif');
		$lien = str_replace('{lien}', $image, $lien_off);
	}
	$barre .= $lien."&nbsp;<B>&middot;</B>";
    
	// pages 1 . 2 . 3 . 4 . 5 . 6 . 7 . 8 . 9 . 10
	// -------------------------------------------------------------------
	if ($debut >= ($cfg_nb_pages * $cfg_nbres_ppage)) {
		$cpt_fin = ($debut / $cfg_nbres_ppage) + 1;
		$cpt_deb = $cpt_fin - $cfg_nb_pages + 1;
	} else {
		$cpt_deb = 1;
		$cpt_fin = (int)($nbtotal / $cfg_nbres_ppage);
		if (($nbtotal % $cfg_nbres_ppage) != 0) 
			$cpt_fin++;
		if ($cpt_fin > $cfg_nb_pages)
			$cpt_fin = $cfg_nb_pages;
	}
	for ($cpt = $cpt_deb; $cpt <= $cpt_fin; $cpt++) {
		if ($cpt == ($debut / $cfg_nbres_ppage) + 1) {
				$barre .= "<A CLASS='off'>&nbsp;".$cpt."&nbsp;</A> ";
		} else {
			$barre .= "<a href='#' id='link_txt_".$cpt."";
			$barre .= "'>&nbsp;".$cpt."&nbsp;</a>
							<script type='text/javascript'>
							Event.observe('link_txt_".$cpt."', 'click',  
												function(evt){
													Event.stop(evt); 
													$(\"".$idformtochange."\").value=".$cpt."; 
													".$fonctiontolauch.";
												}, false);
							</script>";
		}
	}

	// suivant . >
	// --------------------------------------------------------------------
	if ($debut + $cfg_nbres_ppage < $nbtotal) {
		$cible = ($nbenr+1);
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/droite_on.gif');
		$lien = str_replace('{lien}', $image, $lien_on);
		$lien = str_replace('{cible}', $cible, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	} else {
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/droite_off.gif');
		$lien = str_replace('{lien}', $image, $lien_off);
	}
	$barre .= "&nbsp;<B>&middot;</B>".$lien;

	// fin . >>
	// --------------------------------------------------------------------
	$fin = ($nbtotal - ($nbtotal % $cfg_nbres_ppage));
	if (($nbtotal % $cfg_nbres_ppage) == 0)
		$fin = $fin - $cfg_nbres_ppage;
	if ($fin != $debut) {
		$cible = (int)($nbtotal/$cfg_nbres_ppage)+1;
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/droite_on.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_on);
		$lien = str_replace('{cible}', $cible+1, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	} else {
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/droite_off.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_off);
	}
	$barre .= "<B>&middot;</B>&nbsp;".$lien;
	return($barre);
}

// ------------------------------------------------------------------------
// image_html          
// ------------------------------------------------------------------------
function image_html($img){
    return '<img src="'.$img.'"    border="0" >';
}

//
//
// Création de la barre de nav
//
//
$cfg_nb_pages = 10;
$debut =(($form['page_to_show']-1)*$form['fiches_par_page']);
$barre_nav = barre_navigation($nb_fiches, $form['page_to_show'], 
									$form['fiches_par_page'], 
									$debut, $cfg_nb_pages,
									'page_to_show_s',
									'tarifs_fournisseur_import()');

// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<div class="mt_size_optimise">
<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left; font-weight:bolder">Liste des tarifs fournisseur à importer</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+$nb_affiche?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>
<br />
<table border="0" cellspacing="0" cellpadding="0" style="width:100%;">
	<tr class="colorise0">
		<td style="width:30px">
			<div style="width:30px; text-align:center">&nbsp;</div>
		</td>
		<td style="width:35px">
			<div style="width:35px; text-align:center">&nbsp;</div>
		</td>
		<td style="width:35px">
			<div style="width:35px; text-align:center">&nbsp;</div>
		</td>
		<?php
		foreach($array_retour as $ret){
			foreach ($ret as $k=>$fiche) {
				if ($k == "averti" || $k == "ref_article_existant" || $k == "") { continue;}
				?>
				<td style="font-weight:bolder;" >
					<?php
					foreach ($import_tarifs_fournisseur_csv['liste_entete']  as $entete) {
						foreach ($entete["champs"] as $champ) {
							if (isset($champ["id"]) && $champ["id"] == $k) {
								echo $champ["lib"];
								break;
							}
						}
					}
				 	?>
				 </td>
				<?php
			}
			break;
		}
		?>
		<td>
			Article trouvé
		</td>
	</tr>
	<?php
	$colorise=0;
	$nb_lignes = 0;
	foreach ($array_retour as $key=>$fiche) {
		if($nb_lignes < $debut - 1){ continue; }
		if($nb_lignes > $debut - 1 + $nb_affiche){break; }
		$colorise++;
		$class_colorise=($colorise % 2)? 'colorise1' : 'colorise2';
		?>
		<tr id="ligne_<?php echo $nb_lignes;?>" class="<?php echo $class_colorise; ?>">
			<td style="text-align:center;" >
				<input id="check_s_<?php echo $nb_lignes;?>" name="check_s_<?php echo $nb_lignes;?>" type="checkbox" value="<?php echo ($key);?>"/>
			</td>
			<td style="text-align:center;">
				<?php if (isset($fiche["averti"])) {?>
					<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>/images/ding.gif" 
							title="Cette ligne pourrait ne pas être totalement importée"/>
				<?php }elseif (isset($fiche["alerte"])) {?>
					<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>/images/alerte.gif" title="Cette ligne ne sera pas importée."/>
				<?php } elseif (isset($fiche["ref_article_existant"]) && $fiche["ref_article_existant"] != "") { ?>
					<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>/images/point_vert.gif" title="La correspondance a été trouvée ! Cette ligne sera importée."/>
				<?php } else {?>
					<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>/images/point_rouge.gif" title="Aucune correspondance trouvée. Cet article sera créé."/>
				<?php } ?>
			</td>
			<td style="text-align:center;" >
				<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>images/supprime.gif" 
					style="cursor:pointer" id="del_ligne_<?php echo $nb_lignes;?>"/>
				<script type="text/javascript">
					Event.observe("del_ligne_<?php echo $nb_lignes;?>", "click", function(evt){
						Event.stop(evt); 
						supprime_import_ligne_tarifs_fournisseur ("<?php echo $key;?>");
					});
				</script>
			</td>
			<?php 
			foreach($fiche as $k=>$f){
				if($k != "alerte" && $k != "averti" && $k != "ref_article_existant"){
				?>
				<td style="<?php if(isset($fiche["alerte"]) || isset($fiche["averti"])){?>color:#FF0000;<?php } ?>">
					<label for="check_s_<?php echo $nb_lignes;?>">
					<?php echo $f;?>
					</label>
				</td>
			<?php }
			} ?>
				<td style="<?php if(isset($fiche["alerte"]) || isset($fiche["averti"])){?>color:#FF0000;<?php } ?>">
				<?php // On affiche la réf ok ?>
					<a id="ref_article_existant_<?php echo $nb_lignes; ?>"><?php echo $fiche["ref_article_existant"]; ?></a><br />
				<?php // On affiche le lien vers le mini moteur de recherche d'article ?>
					<a href="#" id="show_mini_moteur_articles<?php echo $nb_lignes; ?>">Choisir un article</a>
					<script type="text/javascript">
						Event.observe("show_mini_moteur_articles<?php echo $nb_lignes; ?>", "click",  function(evt){
							Event.stop(evt);
							show_mini_moteur_articles('choix_ref_article_existant', '<?php echo $nb_lignes; ?>', 'true', 'subcontent');
						}, false);
					</script>
				</td>
		</tr>
		<?php
		$nb_lignes++;
	}
	?>
</table>
<script type="text/javascript">
Event.observe("all_coche_s", "click", function(evt){
	Event.stop(evt); 
	coche_line_tarifs_fournisseur_import ("coche", "check_s_", <?php echo $nb_lignes;?>);
});
Event.observe("all_decoche_s", "click", function(evt){
	Event.stop(evt); 
	coche_line_tarifs_fournisseur_import ("decoche", "check_s_", <?php echo $nb_lignes;?>);
});
Event.observe("all_inv_coche_s", "click", function(evt){
	Event.stop(evt); 
	coche_line_tarifs_fournisseur_import ("inv_coche", "check_s_", <?php echo $nb_lignes;?>);
});
Event.observe("coche_action_s", "change", function(evt){
	if ($("coche_action_s").value != "") {
		action_tarifs_fournisseur_import($("coche_action_s").value, "check_s_" , <?php echo $nb_lignes;?>);
	}
});
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
	<tr>
		<td rowspan="2" style="width:33px">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/arrow_ltr.png" />
		</td>
		<td style="height:4px; line-height:4px">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="4px" width="100%"/>
		</td>
		<td style="height:4px; line-height:4px">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="4px" width="100%"/>
		</td>
	</tr>
	<tr>
		<td style="width:325px;">
			<a href="#" id="all_coche_s" class="imp_link_simple">Tout cocher</a> / 
			<a href="#" id="all_decoche_s" class="imp_link_simple">Tout d&eacute;cocher</a> / 
			<a href="#" id="all_inv_coche_s" class="imp_link_simple">Inverser la s&eacute;lection</a> 
		</td>
		<td style="" >
			<select id="coche_action_s" name="coche_action_s" class="classinput_nsize">
				<option value="">Pour la s&eacute;lection</option>
				<option value="import">Importer</option>
				<option value="supprimer">Supprimer</option>
			</select>
		</td>
	</tr>
</table>
</div>

<SCRIPT type="text/javascript">
	//centrage du mini_moteur
	centrage_element("pop_up_mini_moteur_cata");
	centrage_element("pop_up_mini_moteur_cata_iframe");
	
	Event.observe(window, "resize", function(evt){
		centrage_element("pop_up_mini_moteur_cata_iframe");
		centrage_element("pop_up_mini_moteur_cata");
	});
	//on masque le chargement
	H_loading();
</SCRIPT>