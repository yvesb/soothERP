<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "form['nom']", "form['id_profil']", "form['page_to_show']", "form['fiches_par_page']", "nb_fiches",  "form['orderby']", "form['orderorder']");
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
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/gauche_on.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_on);
		$lien = str_replace('{cible}', $cible-1, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	}
	else
	{
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/gauche_off.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_off);
	}
	$barre .= $lien."&nbsp;<strong>&middot;</strong>";


	// précédent < .
	// --------------------------------------------------------------------
	if ($debut >= $cfg_nbres_ppage)
	{
		$cible = ($nbenr-1);
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/gauche_on.gif');
		$lien = str_replace('{lien}', $image, $lien_on);
		$lien = str_replace('{cible}', $cible, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	}
	else
	{
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/gauche_off.gif');
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
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/droite_on.gif');
		$lien = str_replace('{lien}', $image, $lien_on);
		$lien = str_replace('{cible}', $cible, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	}
	else
	{
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/droite_off.gif');
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
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/droite_on.gif');
		$lien = str_replace('{lien}', $image.$image, $lien_on);
		$lien = str_replace('{cible}', $cible+1, $lien);
		$lien = str_replace('{cibleb}', $cible, $lien);
		$lien = str_replace('{fonctionlauch}', $fonctiontolauch, $lien);
		$lien = str_replace('{idchange}', $idformtochange, $lien);
	}
	else
	{
		$image = image_html('themes/'.$_SESSION['theme']->getCode_theme().'/images/droite_off.gif');
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
									  									 'annuaire_import()');



// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

?>
<div class="mt_size_optimise">
<div id="affresult" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left; font-weight:bolder">Liste des contacts à générer</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+$nb_affiche?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>
<br></br>
<table border="0" cellspacing="0" cellpadding="0">
	<tr class="colorise0">
		<td style="width:45px"><div style="width:45px; text-align:left">&nbsp;</div>
		</td>
		<td style="width:45px"><div style="width:45px; text-align:left">&nbsp;</div>
		</td>
		<td style="width:45px"><div style="width:45px; text-align:left">&nbsp;</div>
	<?php
	if (count($array_retour)) {
		for ($i=0; $i < 1; $i++) {
			?>
			<?php 
			foreach ($array_retour[$i] as $k=>$fiche) {
				if ($k == "averti") { continue;}
				?>
				
				<td style="font-weight:bolder;" ><div style="width:135px"><?php
				foreach ($import_annuaire_csv['liste_entete']  as $entete) {
					foreach ($entete["champs"] as $champ) {
					if (isset($champ["id"]) && $champ["id"] == $k) {echo $champ["lib"]; break;}
					}
				}
				 ?></div></td>
				<?php
			}
			?>
			<?php
		}
	}
	?>
	</tr>
	<?php
	$colorise=0;
	for ($i=0; $i < count($array_retour); $i++) {
		if ($i<$debut || $i >=$debut+$nb_affiche) {continue;}
		$colorise++;
		$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
		?>
		<tr id="ligne_<?php echo $i;?>" class="<?php  echo  $class_colorise?>">
			<td style="text-align:left" >
	<input id="check_s_<?php echo $i;?>" name="check_s_<?php echo $i;?>" type="checkbox" value="<?php echo ($i);?>"/>
			</td>
			<td style="text-align:left" >
			 <?php if (isset($array_retour[$i]["averti"])) {?><img src="modules/<?php echo $import_annuaire_csv['folder_name'];?>themes/<?php echo $_SESSION['theme']->getCode_theme();?>/images/ding.gif" title="Cette ligne pourrait ne pas être totalement importée"/><?php } ?>
			 <?php if (isset($array_retour[$i]["alerte"])) {?><img src="modules/<?php echo $import_annuaire_csv['folder_name'];?>themes/<?php echo $_SESSION['theme']->getCode_theme();?>/images/alerte.gif" title="Cette ligne ne sera pas importée"/><?php } ?>
			</td>
			<td style="text-align:left" >
			<img src="../<?php echo $_SESSION['theme']->getDir_theme()?>images/supprime.gif" style="cursor:pointer" id="del_ligne_<?php echo $i;?>"/>
			
<script type="text/javascript">

Event.observe("del_ligne_<?php echo $i;?>", "click", function(evt){
	Event.stop(evt); 
	supprime_import_ligne ("<?php echo $i;?>");
});
</script>
			</td>
			<?php 
			foreach ($array_retour[$i] as $key=>$fiche) {
			if ($key == "averti") { continue;}
			if ($key == "alerte") { continue;}
				?>
				<td >
				<div style=" <?php if (isset($array_retour[$i]["averti"]) && $array_retour[$i]["averti"] == $key) {?>color:#FF0000;<?php } ?>">
				<?php echo $fiche;?>
				</div>
				</td>
				<?php
			}
			?>
		</tr>
		<?php 
	}
	?>
</table>

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
			<a href="#" id="all_coche_s" class="imp_link_simple">Tout cocher</a> / <a href="#" id="all_decoche_s" class="imp_link_simple">Tout d&eacute;cocher</a> / <a href="#" id="all_inv_coche_s" class="imp_link_simple">Inverser la s&eacute;lection</a> 
		</td>
		<td style="" >
			<select id="coche_action_s" name="coche_action_s" class="classinput_nsize">
				<option value="">Pour la s&eacute;lection</option>
				<option value="import">Importer</option>
				<option value="supprimer">Supprimer</option>
			</select>
		</td>
	</tr>
</table><br />
<script type="text/javascript">

Event.observe("all_coche_s", "click", function(evt){
	Event.stop(evt); 
	coche_line_annuaire_import ("coche", "_s", <?php echo $i;?>);
});
Event.observe("all_decoche_s", "click", function(evt){
	Event.stop(evt); 
	coche_line_annuaire_import ("decoche", "_s", <?php echo $i;?>);
});
Event.observe("all_inv_coche_s", "click", function(evt){
	Event.stop(evt); 
	coche_line_annuaire_import ("inv_coche", "_s", <?php echo $i;?>);
});
	
Event.observe("coche_action_s", "change", function(evt){
if ($("coche_action_s").value != "") {
action_annuaire_import($("coche_action_s").value, "_s" , <?php echo $i;?>);
}
});		
</script>
</div>

<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>