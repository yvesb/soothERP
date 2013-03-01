<?php

// *************************************************************************************************************
// LISTE DES TACHES ATTRIBUEES
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("liste_taches");
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
	$debut =(($page_to_show-1)*$taches_par_page);
	
	$barre_nav .= barre_navigation($nb_taches, $page_to_show, 
                                       $taches_par_page, 
                                       $debut, $cfg_nb_pages,
                                       'page_to_show',
																			 'tache_reload_todo()');

?>
<script type="text/javascript">
</script>

<table width="100%" border="0"  cellspacing="0">
	<tr class="document_box_head">
		<td style="width:25px">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/tache_urgente.gif" width="25px" height="20px" id="order_by_urgence_l_ord" style="cursor:pointer" alt="Urgent"/>
		</td>
		<td style="width:25px">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/tache_important.gif" width="25px" height="20px" id="order_by_importance_l_ord" style="cursor:pointer" alt="Important"/>
		</td>
		<td style="font-weight:bolder;width:25%">
		 T&acirc;che
		</td>
		<td style="font-weight:bolder;">
			Contacts et fonctions concern&eacute;s
		</td>
		<td style="font-weight:bolder;width:10%">
			<span id="order_by_date_l_ord" style="cursor:pointer">Date</span></td>
		<td style="font-weight:bolder;width:20%">
			Notes</td>
		<td style="font-weight:bolder;width:10%">
			Etat</td>
		<td style="width:25px">
		</td>
	</tr>
	<tr>
		<td style="width:25px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:25px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
		<td style="width:25px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
	</tr>
<?php
foreach ($liste_taches as $tache) {
	?>
	<tr id="tache_<?php echo $tache->getId_tache();?>_l">
		<td style="border-bottom:1px solid #999999;">
		<?php if ($tache->getUrgence ()) {?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/tache_urgente.gif" width="25px" height="20px" alt="Urgent"/>
		<?php } else { ?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="20px" />
		<?php } ?>
		</td>
		<td style="border-bottom:1px solid #999999;">
		<?php if ($tache->getImportance ()) {?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/tache_important.gif" width="25px" height="20px" alt="Important"/>
		<?php } else { ?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="20px" />
		<?php } ?>
		</td>
		<td style="border-bottom:1px solid #999999;">
			<span style="font-weight:bolder;"><?php echo htmlentities($tache->getLib_tache ());?></span>&nbsp;<br />
			<span style="font-style:italic;"><?php echo nl2br(htmlentities($tache->getText_tache ()));?></span>
		</td>
		<td style="border-bottom:1px solid #999999;">
		<?php 
		foreach ($tache->getCollabs () as $collab) {
			echo htmlentities($collab->nom)."<br/>";
		}
		?>
		<div style="height:12px; line-height:12px; "></div>
		<?php 
		foreach ($tache->getCollabs_fonctions () as $fonctions) {
			echo htmlentities($fonctions->lib_fonction)."<br/>";
		}
		?>
		</td>
		<td style="border-bottom:1px solid #999999;">
			<span style="font-weight:bolder;"><?php echo date_Us_to_Fr($tache->getDate_creation ());?></span>&nbsp;
		</td>
		<td style="border-bottom:1px solid #999999;">
			<textarea class="classinput_xsize" name="note_<?php echo $tache->getId_tache();?>_l" id="note_<?php echo $tache->getId_tache();?>_l"><?php echo htmlentities($tache->getNote ());?></textarea>
			<textarea style="display:none" name="note_old_<?php echo $tache->getId_tache();?>_l" id="note_old_<?php echo $tache->getId_tache();?>_l"><?php echo htmlentities($tache->getNote());?></textarea>
			<script type="text/javascript">
				Event.observe("note_<?php echo $tache->getId_tache();?>_l", "blur", function(evt){
					if ($("note_<?php echo $tache->getId_tache();?>_l").value != $("note_old_<?php echo $tache->getId_tache();?>_l").value) { 
						$("note_old_<?php echo $tache->getId_tache();?>_l").value = $("note_<?php echo $tache->getId_tache();?>_l").value;
						maj_tache_note ("note_<?php echo $tache->getId_tache();?>_l", "<?php echo $tache->getId_tache();?>");
					}
				}, false);
				
				Event.observe("note_<?php echo $tache->getId_tache();?>_l" , "keypress", function(evt){
					setToMaxRow_if_Key_RETURN (evt, 3, 70)	
				}, false);
				setToMaxRow ("note_<?php echo $tache->getId_tache();?>_l", 3, 70)	;	
			</script>
		</td>
		<td style="text-align:right;border-bottom:1px solid #999999;">
		<div id="etat_tache_<?php echo $tache->getId_tache();?>_l" style="cursor:pointer">
		<?php
		if ($tache->getEtat_tache () == 0) {
			?>
			A effectuer
			<?php 
		}
		if ($tache->getEtat_tache () == 1) {
			?>
			En cours
			<?php 
		}
		if ($tache->getEtat_tache () == 2) {
			?>
			Effectu&eacute;e
			<?php 
		}
		?>
		</div>
		<div style="position:relative;top:0px; left:0px; width:100%;">
		<div id="choix_etat_tache_<?php echo $tache->getId_tache();?>_l" style="display:none; text-align: left; border:1px solid #000000; background-color:#FFFFFF; position: absolute; left:0px;">
			<a class="choix_etat" id="choix_etat_0_tache_<?php echo $tache->getId_tache();?>_l">A effectuer</a>
			<a class="choix_etat" id="choix_etat_1_tache_<?php echo $tache->getId_tache();?>_l">En cours</a>
			<a class="choix_etat" id="choix_etat_2_tache_<?php echo $tache->getId_tache();?>_l">Effectu&eacute;e</a>
		</div>
		</div>
			<script type="text/javascript">
				Event.observe("etat_tache_<?php echo $tache->getId_tache();?>_l", "click", function(evt){
					$("choix_etat_tache_<?php echo $tache->getId_tache();?>_l").toggle();
				}, false);
				Event.observe("choix_etat_0_tache_<?php echo $tache->getId_tache();?>_l", "click", function(evt){
					Event.stop(evt);
					maj_etat_tache ("0", "<?php echo $tache->getId_tache();?>");
					$("etat_tache_<?php echo $tache->getId_tache();?>_l").innerHTML = "A effectuer";
					$("choix_etat_tache_<?php echo $tache->getId_tache();?>_l").toggle();
				}, false);
				Event.observe("choix_etat_1_tache_<?php echo $tache->getId_tache();?>_l", "click", function(evt){
					Event.stop(evt);
					maj_etat_tache ("1", "<?php echo $tache->getId_tache();?>");
					$("etat_tache_<?php echo $tache->getId_tache();?>_l").innerHTML = "En cours";
					$("choix_etat_tache_<?php echo $tache->getId_tache();?>_l").toggle();
				}, false);
				Event.observe("choix_etat_2_tache_<?php echo $tache->getId_tache();?>_l", "click", function(evt){
					Event.stop(evt);
					maj_etat_tache ("2", "<?php echo $tache->getId_tache();?>");
					$("etat_tache_<?php echo $tache->getId_tache();?>_l").innerHTML = "Effectu&eacute;e";
					$("choix_etat_tache_<?php echo $tache->getId_tache();?>_l").toggle();
				}, false);
			
			</script>
		</td>
		<td style="border-bottom:1px solid #999999;">&nbsp;
			
		</td>
	</tr>
	<?php
}
?>
</table>
<form>
<input type="hidden" value="<?php echo $page_to_show;?>" id="page_to_show" name="page_to_show" />

<input type="hidden" value="<?php
if(isset($_REQUEST["order_by_date"]) && ($_REQUEST["order_by_date"] == "ASC" || $_REQUEST["order_by_date"] == "DESC")) { echo $_REQUEST["order_by_date"]; }
?>" id="order_by_date" name="order_by_date" />


<input type="hidden" value="<?php
if(isset($_REQUEST["order_by_urgence"]) && ($_REQUEST["order_by_urgence"] == "ASC" || $_REQUEST["order_by_urgence"] == "DESC")) { echo $_REQUEST["order_by_urgence"]; }
?>" id="order_by_urgence" name="order_by_urgence" />


<input type="hidden" value="<?php
if(isset($_REQUEST["order_by_importance"]) && ($_REQUEST["order_by_importance"] == "ASC" || $_REQUEST["order_by_importance"] == "DESC" )) { echo $_REQUEST["order_by_importance"]; }
?>" id="order_by_importance" name="order_by_importance" />

<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">
		<input type="checkbox" value="1" id="all_etat_tache" name="all_etat_tache" <?php if(isset($_REQUEST["all_etat_tache"]) && $_REQUEST["all_etat_tache"] == "1") {echo 'checked="checked"';}?> />Afficher les archives
		</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">Taches <?php echo $debut+1?> &agrave; <?php echo $debut+count($liste_taches)?> sur <?php echo $nb_taches?></td>
	</tr>
</table>
</div>
</form>



<SCRIPT type="text/javascript">

Event.observe("all_etat_tache", "click", function(evt){
	tache_reload_todo();
}, false);

Event.observe("order_by_date_l_ord", "click", function(evt){
	$("order_by_date").value = "<?php if (isset($_REQUEST["order_by_date"]) && $_REQUEST["order_by_date"] =="DESC") {echo "ASC";} else {echo "DESC";}?>";
	tache_reload_todo();
}, false);
Event.observe("order_by_urgence_l_ord", "click", function(evt){
	$("order_by_urgence").value = "<?php if (isset($_REQUEST["order_by_urgence"]) && $_REQUEST["order_by_urgence"] =="DESC") {echo "ASC";} else {echo "DESC";}?>";
	tache_reload_todo();
}, false);
Event.observe("order_by_importance_l_ord", "click", function(evt){
	$("order_by_importance").value = "<?php if (isset($_REQUEST["order_by_importance"]) && $_REQUEST["order_by_importance"] =="DESC") {echo "ASC";} else {echo "DESC";}?>";
	tache_reload_todo();
}, false);


//on masque le chargement
H_loading();
</SCRIPT>