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
																			 'page.compte_bancaire_recherche()');



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
			<td style="width:15%;">
			<a href="#"  id="order_date">
			Date
			</a>
				
			</td>
			<td style="width:35%;">
				<a href="#"  id="order_lib_compte">
				Libellé
				</a>
			</td>
			<td style="width:15%; text-align:right">
			<a href="#"  id="order_debit">Débit</a>
			</td>
			<td style="width:15%; text-align:right">
			<a href="#"  id="order_credit">Crédit</a>
			</td>
			<td style="width:15%;">
			
			</td>
			<td>
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
						page.verify('mody_mouvement_compte','compta_compte_bancaire_operations_edit.php?id_compte_bancaire_move=<?php echo ($fiche->id_compte_bancaire_move)?>&id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>&from_recherche=1','true','edition_operation');
						$("edition_operation").show();
					}, false);
					</script>
				</td>
				<td  style="width:40%; cursor:pointer" id="lib_<?php echo $fiche->id_compte_bancaire_move;?>" >
					<div><?php	if ($fiche->lib_move) { echo substr(nl2br(htmlentities($fiche->lib_move)),0,80);}?></div>
					<?php	if ($fiche->commentaire_move) { echo '<div style="font-style: italic">'.nl2br($fiche->commentaire_move).'</div>';}?>
					<script type="text/javascript">
					Event.observe("lib_<?php echo htmlentities($fiche->id_compte_bancaire_move)?>", "click",  function(evt){
						Event.stop(evt);
						page.verify('mody_mouvement_compte','compta_compte_bancaire_operations_edit.php?id_compte_bancaire_move=<?php echo ($fiche->id_compte_bancaire_move)?>&id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>&from_recherche=1','true','edition_operation');
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
					page.verify('mody_mouvement_compte','compta_compte_bancaire_operations_edit.php?id_compte_bancaire_move=<?php echo ($fiche->id_compte_bancaire_move)?>&id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>&from_recherche=1','true','edition_operation');
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
					page.verify('mody_mouvement_compte','compta_compte_bancaire_operations_edit.php?id_compte_bancaire_move=<?php echo ($fiche->id_compte_bancaire_move)?>&id_compte_bancaire=<?php echo $compte_bancaire->getId_compte_bancaire()?>&from_recherche=1','true','edition_operation');
					$("edition_operation").show();
				}, false);
				</script>
				</td>
				<td style="text-align:center; vertical-align:middle">
				
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
										parameters: {id_compte_bancaire_move: '<?php echo htmlentities($fiche->id_compte_bancaire_move)?>', id_compte_bancaire: '<?php echo $compte_bancaire->getId_compte_bancaire()?>', date_move: '<?php echo $fiche->date_move?>',from_recherche: 1},
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
<script type="text/javascript">
Event.observe("order_date", "click",  function(evt){
	Event.stop(evt);
	$('orderby').value='date_move'; 
	$('orderorder').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="date_move") {echo "DESC";} else {echo "ASC";}?>';
	page.compte_bancaire_recherche();
}, false);

Event.observe("order_lib_compte", "click",  function(evt){
	Event.stop(evt);
	$('orderby').value='lib_move'; 
	$('orderorder').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="lib_move") {echo "DESC";} else {echo "ASC";}?>';
	page.compte_bancaire_recherche();
}, false);

Event.observe("order_debit", "click",  function(evt){
	Event.stop(evt);
	$('orderby').value='montant_move'; 
	$('orderorder').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="montant_move") {echo "DESC";} else {echo "ASC";}?>';
	page.compte_bancaire_recherche();
}, false);
Event.observe("order_credit", "click",  function(evt){
	Event.stop(evt);
	$('orderby').value='montant_move'; 
	$('orderorder').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="montant_move") {echo "DESC";} else {echo "ASC";}?>';
	page.compte_bancaire_recherche();
}, false);

//on masque le chargement
H_loading();
</SCRIPT>