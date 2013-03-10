<?php

// *************************************************************************************************************
// LISTE DES TACHES CREES
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("liste_taches_crees");
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
																			 'tache_reload_crees()');

?>
<script type="text/javascript">
</script>


<table width="100%" border="0"  cellspacing="0">
	<tr class="document_box_head">
		<td style="width:25px">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/tache_urgente.gif" width="25px" height="20px" id="order_by_urgence_ord" style="cursor:pointer" alt="Urgent"/>
		</td>
		<td style="width:25px">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/tache_important.gif" width="25px" height="20px" id="order_by_importance_ord" style="cursor:pointer" alt="Important"/>
		</td>
		<td style="font-weight:bolder;width:25%">
		 T&acirc;che
		</td>
		<td style="font-weight:bolder;">
			Contacts et fonctions concern&eacute;s
		</td>
		<td style="font-weight:bolder;width:10%">
			<span id="order_by_date_ord" style="cursor:pointer">Date</span></td>
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
foreach ($liste_taches_crees as $tache_cree) {
	?>
	<tr id="tache_cree_<?php echo $tache_cree->getId_tache();?>">
		<td style="border-bottom:1px solid #999999;">
		<?php if ($tache_cree->getUrgence ()) {?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/tache_urgente.gif" width="25px" height="20px" alt="Urgent"/>
		<?php } else { ?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="20px" />
		<?php } ?>
		</td>
		<td style="border-bottom:1px solid #999999;">
		<?php if ($tache_cree->getImportance ()) {?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/tache_important.gif" width="25px" height="20px" alt="Important"/>
		<?php } else { ?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="25px" height="20px" />
		<?php } ?>
		</td>
		<td style="border-bottom:1px solid #999999;">
			<span style="font-weight:bolder;"><?php echo htmlentities($tache_cree->getLib_tache ());?></span>&nbsp;<br />
			<span style="font-style:italic;"><?php echo nl2br(htmlentities($tache_cree->getText_tache ()));?></span>
		</td>
		<td style="border-bottom:1px solid #999999;">
		<?php 
		foreach ($tache_cree->getCollabs () as $collab) {
			echo htmlentities($collab->nom)."<br/>";
		}
		?>
		<div style="height:12px; line-height:12px; "></div>
		<?php 
		foreach ($tache_cree->getCollabs_fonctions () as $fonctions) {
			echo htmlentities($fonctions->lib_fonction)."<br/>";
		}
		?>
		</td>
		<td style="border-bottom:1px solid #999999;">
			<span style="font-weight:bolder;"><?php echo date_Us_to_Fr($tache_cree->getDate_creation ());?></span>

			<div id="edition_tache_<?php echo $tache_cree->getId_tache();?>">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" style="cursor:pointer" />
			</div>
		</td>
		<td style="border-bottom:1px solid #999999;">
			<textarea class="classinput_xsize" name="note_<?php echo $tache_cree->getId_tache();?>" id="note_<?php echo $tache_cree->getId_tache();?>"><?php echo htmlentities($tache_cree->getNote ());?></textarea>
			<textarea style="display:none" name="note_old_<?php echo $tache_cree->getId_tache();?>" id="note_old_<?php echo $tache_cree->getId_tache();?>"><?php echo htmlentities($tache_cree->getNote());?></textarea>
			<script type="text/javascript">
				Event.observe("note_<?php echo $tache_cree->getId_tache();?>", "blur", function(evt){
					if ($("note_<?php echo $tache_cree->getId_tache();?>").value != $("note_old_<?php echo $tache_cree->getId_tache();?>").value) { 
						$("note_old_<?php echo $tache_cree->getId_tache();?>").value = $("note_<?php echo $tache_cree->getId_tache();?>").value;
						maj_tache_note ("note_<?php echo $tache_cree->getId_tache();?>", "<?php echo $tache_cree->getId_tache();?>");
					}
				}, false);
				
				Event.observe("note_<?php echo $tache_cree->getId_tache();?>" , "keypress", function(evt){
					setToMaxRow_if_Key_RETURN (evt, 3, 70)	
				}, false);
				setToMaxRow ("note_<?php echo $tache_cree->getId_tache();?>", 3, 70)	;	
			</script>
		</td>
		<td style="text-align:right;border-bottom:1px solid #999999;">
		<div id="etat_tache_<?php echo $tache_cree->getId_tache();?>" style="cursor:pointer">
		<?php
		if ($tache_cree->getEtat_tache () == 0) {
			?>
			A effectuer
			<?php 
		}
		if ($tache_cree->getEtat_tache () == 1) {
			?>
			En cours
			<?php 
		}
		if ($tache_cree->getEtat_tache () == 2) {
			?>
			Effectu&eacute;e
			<?php 
		}
		?>
		</div>
		<div style="position:relative;top:0px; left:0px; width:100%;">
		<div id="choix_etat_tache_<?php echo $tache_cree->getId_tache();?>" style="display:none; text-align: left; border:1px solid #000000; background-color:#FFFFFF; position: absolute; left:0px;">
			<a class="choix_etat" id="choix_etat_0_tache_<?php echo $tache_cree->getId_tache();?>">A effectuer</a>
			<a class="choix_etat" id="choix_etat_1_tache_<?php echo $tache_cree->getId_tache();?>">En cours</a>
			<a class="choix_etat" id="choix_etat_2_tache_<?php echo $tache_cree->getId_tache();?>">Effectu&eacute;e</a>
		</div>
		</div>
			<script type="text/javascript">
				Event.observe("etat_tache_<?php echo $tache_cree->getId_tache();?>", "click", function(evt){
					$("choix_etat_tache_<?php echo $tache_cree->getId_tache();?>").toggle();
				}, false);
				Event.observe("choix_etat_0_tache_<?php echo $tache_cree->getId_tache();?>", "click", function(evt){
					Event.stop(evt);
					maj_etat_tache ("0", "<?php echo $tache_cree->getId_tache();?>");
					$("etat_tache_<?php echo $tache_cree->getId_tache();?>").innerHTML = "A effectuer";
					$("choix_etat_tache_<?php echo $tache_cree->getId_tache();?>").toggle();
				}, false);
				Event.observe("choix_etat_1_tache_<?php echo $tache_cree->getId_tache();?>", "click", function(evt){
					Event.stop(evt);
					maj_etat_tache ("1", "<?php echo $tache_cree->getId_tache();?>");
					$("etat_tache_<?php echo $tache_cree->getId_tache();?>").innerHTML = "En cours";
					$("choix_etat_tache_<?php echo $tache_cree->getId_tache();?>").toggle();
				}, false);
				Event.observe("choix_etat_2_tache_<?php echo $tache_cree->getId_tache();?>", "click", function(evt){
					Event.stop(evt);
					maj_etat_tache ("2", "<?php echo $tache_cree->getId_tache();?>");
					$("etat_tache_<?php echo $tache_cree->getId_tache();?>").innerHTML = "Effectu&eacute;e";
					$("choix_etat_tache_<?php echo $tache_cree->getId_tache();?>").toggle();
				}, false);
			
			</script>
		</td>
		<td style="border-bottom:1px solid #999999;">
				<form method="post" action="planning_taches_sup.php" id="planning_taches_sup_<?php echo $tache_cree->getId_tache();?>" name="planning_taches_sup_<?php echo $tache_cree->getId_tache();?>" target="formFrame">
					<input name="id_tache" id="id_tache" type="hidden" value="<?php echo $tache_cree->getId_tache();?>" />
				</form>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="supp_tache_<?php echo $tache_cree->getId_tache();?>" style="cursor:pointer" /><br />

			<script type="text/javascript">
			
				Event.observe("edition_tache_<?php echo $tache_cree->getId_tache();?>", "click", function(evt){
					tache_edition("<?php echo $tache_cree->getId_tache();?>");
				}, false);
				Event.observe("supp_tache_<?php echo $tache_cree->getId_tache();?>", "click", function(evt){
					alerte.confirm_supprimer('planning_tache_sup', 'planning_taches_sup_<?php echo $tache_cree->getId_tache();?>');
				}, false);
				
			</script>
			
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
		<td style="text-align:right;">Taches <?php echo $debut+1?> &agrave; <?php echo $debut+count($liste_taches_crees)?> sur <?php echo $nb_taches?></td>
	</tr>
</table>
</div>
</form>

<iframe frameborder="0" scrolling="no" src="about:_blank" id="edition_tache_iframe" class="edition_tache_iframe" style="display:none"></iframe>
<div id="edition_tache" class="edition_tache" style="display:none">
</div>


<SCRIPT type="text/javascript">
Event.observe("all_etat_tache", "click", function(evt){
	tache_reload_crees();
}, false);

Event.observe("order_by_date_ord", "click", function(evt){
	$("order_by_date").value = "<?php if (isset($_REQUEST["order_by_date"]) && $_REQUEST["order_by_date"] =="DESC") {echo "ASC";} else {echo "DESC";}?>";
	tache_reload_crees();
}, false);
Event.observe("order_by_urgence_ord", "click", function(evt){
	$("order_by_urgence").value = "<?php if (isset($_REQUEST["order_by_urgence"]) && $_REQUEST["order_by_urgence"] =="DESC") {echo "ASC";} else {echo "DESC";}?>";
	tache_reload_crees();
}, false);
Event.observe("order_by_importance_ord", "click", function(evt){
	$("order_by_importance").value = "<?php if (isset($_REQUEST["order_by_importance"]) && $_REQUEST["order_by_importance"] =="DESC") {echo "ASC";} else {echo "DESC";}?>";
	tache_reload_crees();
}, false);

//centrage de l'editeur

centrage_element("edition_tache");
centrage_element("edition_tache_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("edition_tache_iframe");
centrage_element("edition_tache");
});

//on masque le chargement
H_loading();
</SCRIPT>