<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "fiches", "form['page_to_show']", "form['fiches_par_page']", "nb_fiches");
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
																			 'page.compte_bancaire_moves()');



// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Formulaire de recherche
?>
<?php
//print_r ($_POST);
?>

<div  class="mt_size_optimise">
<span style=" font-weight:bolder">
Relevé du <?php echo date_Us_to_Fr(date("Y-m-d H:i:s", mktime(0, 0, 0, date ("m", strtotime($search['date_debut'])) , date ("d", strtotime($search['date_debut']))+1, date ("Y", strtotime($search['date_debut'])) ) ));?> au <?php echo date_Us_to_Fr($search['date_fin']);?>
</span>
	
<br /><?php
if (isset($id_compte_bancaire_releve)) {
	?>
	<div style=" width:223px; text-align:left" >
	Solde réél: <?php if (isset($releve_encours->solde_reel)) {echo  price_format($releve_encours->solde_reel)." ".$MONNAIE[1];}?>
	<br />
	Solde calculé: <?php if (isset($releve_encours->solde_calcule)) {echo  price_format($releve_encours->solde_calcule)." ".$MONNAIE[1];}?>

	</div>
	<script type="text/javascript">
	$("more_releve_infos").innerHTML = '<span id="maj_releve" class="grey_caisse" style="float:right; width:250px"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Modifier le relevé</span>';
	
	Event.observe("maj_releve", "click",  function(evt){ Event.stop(evt);S_loading();  page.verify("edit_releve_compte","compta_compte_bancaire_releves_edit.php?id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>&id_compte_bancaire_releve=<?php echo $id_compte_bancaire_releve;?>","true","edition_operation");	 $("edition_operation").show();	} ); 
	</script>
	<?php 
} else {
	?><script type="text/javascript">
	$("more_releve_infos").innerHTML = '';
	</script>
	<?php
}
?>

<br />

	
	<div id="affresult">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td style="text-align:left;">R&eacute;sultats:</td>
			<td id="nvbar"><?php echo $barre_nav;?></td>
			<td style="text-align:right;">R&eacute;p <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
		</tr>
	</table>
	</div>

	<table  cellspacing="0" id="tableresult">
		<tr class="colorise0">
			<td style="width:11%;">
				Date
			</td>
			<td style="width:35%;">
				Libellé
			</td>
			<td style="width:15%; text-align:right">Débit
			</td>
			<td style="width:15%; text-align:right">Crédit
			</td>
			<td style="width:15%; text-align:right">Solde
			</td>
			<td>&nbsp;
			</td>
			<td>&nbsp;
			</td>
		</tr>
		<tr class="colorise_2" style="background-color: #D6C9F1">
			<td >&nbsp;
				
			</td>
			<td  style="font-weight:bolder" >
				Solde:
			</td>
			<td style="width:15%; text-align:right; font-weight:bolder">
			<?php	if ($solde_haut_page < 0) 				{ ?>
				<?php	 echo price_format(abs($solde_haut_page))." ".$MONNAIE[1]; ?>&nbsp;
			<?php } ?>
			</td>
			<td style="width:15%; text-align:right; font-weight:bolder" >
			<?php	if ($solde_haut_page >= 0) 				{ ?>
				<?php	echo price_format($solde_haut_page)." ".$MONNAIE[1]; ?>&nbsp;
			<?php } ?>
			</td>
			<td style="text-align:center; vertical-align:middle">
			
			</td>
			<td style="text-align:center; vertical-align:middle;">
			</td>
			<td style="text-align:center; vertical-align:middle;">
			</td>
		</tr>
		<?php 
		$colorise=0;
		foreach ($fiches as $fiche) {
			$colorise++;
			$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
			?>
			<tr class="<?php  echo  $class_colorise?>">
				<td id="date_move<?php echo htmlentities($fiche->id_compte_bancaire_move)?>" style="cursor:pointer" >
					<?php echo date_Us_to_Fr($fiche->date_move)?>
					<script type="text/javascript">
					Event.observe("date_move<?php echo htmlentities($fiche->id_compte_bancaire_move)?>", "click",  function(evt){
						Event.stop(evt);
						page.verify('mody_mouvement_compte','compta_compte_bancaire_operations_edit.php?id_compte_bancaire_move=<?php echo ($fiche->id_compte_bancaire_move)?>&id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>','true','edition_operation');
						$("edition_operation").show();
					}, false);
					</script>
				</td>
				<td  style=" cursor:pointer" id="lib_<?php echo $fiche->id_compte_bancaire_move;?>" >
					<div><?php	if ($fiche->lib_move) { echo substr(nl2br(htmlentities($fiche->lib_move)),0,80);}?></div>
					<?php	if ($fiche->commentaire_move) { echo '<div style="font-style: italic">'.nl2br($fiche->commentaire_move).'</div>';}?>
					<script type="text/javascript">
					Event.observe("lib_<?php echo htmlentities($fiche->id_compte_bancaire_move)?>", "click",  function(evt){
						Event.stop(evt);
						page.verify('mody_mouvement_compte','compta_compte_bancaire_operations_edit.php?id_compte_bancaire_move=<?php echo ($fiche->id_compte_bancaire_move)?>&id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>','true','edition_operation');
						$("edition_operation").show();
					}, false);
					</script>
				</td>
				<td style="width:15%; text-align:right; cursor:pointer" id="debit_<?php echo htmlentities($fiche->id_compte_bancaire_move)?>">
				<?php	if ($fiche->montant_move < 0) 				{ ?>
					<?php	 echo price_format(abs($fiche->montant_move))." ".$MONNAIE[1]; ?>&nbsp;
				<?php } ?>
				<script type="text/javascript">
				Event.observe("debit_<?php echo htmlentities($fiche->id_compte_bancaire_move)?>", "click",  function(evt){
					Event.stop(evt);
					page.verify('mody_mouvement_compte','compta_compte_bancaire_operations_edit.php?id_compte_bancaire_move=<?php echo ($fiche->id_compte_bancaire_move)?>&id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>','true','edition_operation');
					$("edition_operation").show();
				}, false);
				</script>
				</td>
				<td style="width:15%; text-align:right; cursor:pointer" id="credit_<?php echo htmlentities($fiche->id_compte_bancaire_move)?>" >
				<?php	if ($fiche->montant_move >= 0) 				{ ?>
					<?php	echo price_format($fiche->montant_move)." ".$MONNAIE[1]; ?>&nbsp;
				<?php } ?>
				<script type="text/javascript">
				Event.observe("credit_<?php echo htmlentities($fiche->id_compte_bancaire_move)?>", "click",  function(evt){
					Event.stop(evt);
					page.verify('mody_mouvement_compte','compta_compte_bancaire_operations_edit.php?id_compte_bancaire_move=<?php echo ($fiche->id_compte_bancaire_move)?>&id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>','true','edition_operation');
					$("edition_operation").show();
				}, false);
				</script>
				</td>
				<td style="text-align:right; color:#999999">
				
					<?php
					echo price_format($solde_haut_page)." ".$MONNAIE[1];
					$solde_haut_page -=$fiche->montant_move;
					?>
				</td>
				<td style="text-align:center; vertical-align:middle; width:75px">
				
					<?php
					if (isset($fiche->id_operation) && $fiche->id_operation) {
						?>
						<span id="link_view_ope_<?php echo htmlentities($fiche->id_compte_bancaire_move)?>" style="cursor:pointer; width:65px; padding-left:5px; text-align:left">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/info_marge.gif"/>
						
						</span>
						<script type="text/javascript">
						Event.observe("link_view_ope_<?php echo htmlentities($fiche->id_compte_bancaire_move)?>", "click",  function(evt){
						Event.stop(evt);
						
						<?php 
						switch ($fiche->id_operation_type) { 
							case 1: case 2:?>
							page.verify("compta_depot_caisse_imprimer", "compta_depot_caisse_imprimer.php?id_caisse=<?php echo $fiche->id_compte_caisse;?>&id_compte_caisse_depot=<?php echo $fiche->ref_operation; ?>", "true", "_blank");
							<?php
							break;
							case 3: case 4:?>
							page.verify("compta_retrait_bancaire_caisse_imprimer", "compta_retrait_bancaire_caisse_imprimer.php?id_caisse=<?php echo $fiche->id_compte_caisse;?>&id_compte_caisse_retrait=<?php echo $fiche->ref_operation; ?>", "true", "_blank");
							<?php
							break;
							case 5: case 6:?>
							page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->ref_operation;?>','true','edition_reglement');
						$("edition_reglement").show();
						$("edition_reglement_iframe").show();
							<?php
							break;
							case 7: case 8:?>
							page.verify("compta_tp_telecollecte_imprimer", "compta_tp_telecollecte_imprimer.php?id_compte_tp=<?php echo $fiche->id_compte_tp; ?>&tp_type=<?php echo $fiche->tp_type;?>&id_compte_tp_telecollecte=<?php echo $fiche->ref_operation; ?>", "true", "_blank");
							<?php
							break;
							case 9: case 10:?>
							page.verify("compta_transfert_caisse_imprimer", "compta_transfert_caisse_imprimer.php?id_caisse=<?php echo $fiche->id_compte_caisse;?>&id_compte_caisse_transfert=<?php echo $fiche->ref_operation; ?>", "true", "_blank");
							<?php
							break;
						} 
						?>
						}, false);
						</script>
						<?php	
					}
					?>
				
				
				</td>
				<td style="text-align:center; vertical-align:middle">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="del_<?php echo htmlentities($fiche->id_compte_bancaire_move)?>" style="cursor:pointer; float:right"/>
				<script type="text/javascript">
				Event.observe('del_<?php echo htmlentities($fiche->id_compte_bancaire_move)?>', 'click',  function(evt){
					Event.stop(evt); 
					$("titre_alert").innerHTML = 'Confirmation de la suppression';
					$("texte_alert").innerHTML = 'Suppression d\'une opération';
					$("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Supprimer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />';
						
					show_pop_alerte ();
					
					$("bouton0").onclick= function () {
					hide_pop_alerte ();
					}
					
					$("bouton1").onclick= function () {
					hide_pop_alerte ();	
					var AppelAjax = new Ajax.Request(
										"compta_compte_bancaire_operations_del.php", 
										{
										parameters: {id_compte_bancaire_move: '<?php echo htmlentities($fiche->id_compte_bancaire_move)?>', id_compte_bancaire: '<?php echo $compte_bancaire->getId_compte_bancaire()?>', date_move: '<?php echo $fiche->date_move?>'},
										evalScripts:true, 
										onLoading:S_loading, onException: function () {S_failure();},
										onSuccess: function (requester){
										requester.responseText.evalScripts();
										H_loading();
										}
										}
										);
					
					}
				}, false);
				</script>
				</td>
			</tr>
			<?php
		}
		?>
		<tr class="colorise_2" style="background-color: #D6C9F1 ">
			<td >&nbsp;
				
			</td>
			<td  style=" font-weight:bolder" >
				REPORT:
			</td>
			<td style="width:15%; text-align:right; font-weight:bolder">
			<?php	if ($report_solde < 0) 				{ ?>
				<?php	 echo price_format(abs($report_solde))." ".$MONNAIE[1]; ?>&nbsp;
			<?php } ?>
			</td>
			<td style="width:15%; text-align:right; font-weight:bolder" >
			<?php	if ($report_solde >= 0) 				{ ?>
				<?php	echo price_format($report_solde)." ".$MONNAIE[1]; ?>&nbsp;
			<?php } ?>
			</td>
			<td style="text-align:center; vertical-align:middle">
			</td>
			<td style="text-align:center; vertical-align:middle">
			</td>
			<td style="text-align:center; vertical-align:middle">
			</td>
		</tr>
	</table>
	<div id="affresult">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="text-align:left;">R&eacute;sultats:</td>
				<td id="nvbar"><?php echo str_replace("link_", "link2_",$barre_nav);?></td>
				<td style="text-align:right;">R&eacute;p <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
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


//on masque le chargement
H_loading();
</SCRIPT>