<?php

// *************************************************************************************************************
// RECHERCHE DES ARTICLES DONT LE PRIX D'ACHAT N'EST PAS DÉFINI
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "fiches", "form['lib_article']", "form['page_to_show']", "form['fiches_par_page']", "nb_fiches", "form['orderby']", "form['orderorder']", "form['ref_art_categ']", "form['ref_constructeur']","form['in_pa_zero']");
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
																			 'page.catalogue_recherche_non_pa()');



// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Affichage des résultats
?><br />
<div   class="mt_size_optimise">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			Afficher les tarifs 
			<input  name="taxation" type="radio" id="taxation_ht" value="HT" <?php if ($_REQUEST["app_tarifs_s"] == "HT") {?> checked="checked"<?php }?>>HT
			<input  name="taxation" id="taxation_ttc" type="radio" value="TTC" <?php if ($_REQUEST["app_tarifs_s"] == "TTC") {?> checked="checked"<?php }?>>TTC
		</td>
		<td>&nbsp;</td>
		<td style="width:30%"><span class="labelled_text">Lieux de stockage:
			<select name="id_stock_l" id="id_stock_l" class="">
				<?php 
				if (count($stocks_liste) > 1) {
				?><option value="" >Tous</option><?php
				}
					foreach ($stocks_liste as $stock_liste) {
					?>
				<option value="<?php echo $stock_liste->getId_stock (); ?>" <?php if($form['id_stock']==$stock_liste->getId_stock ()) {echo 'selected="selected"';}?>><?php echo htmlentities($stock_liste->getLib_stock()); ?></option>
				<?php }
					?>
			</select>
		</span></td>
		<td style="width:5%">&nbsp;</td>
		<td style="width:25%"><span class="labelled_text">Tarifs:</span>
			<select name="id_tarif_l" id="id_tarif_l" class="">
			<?php
						foreach ($tarifs_liste as $tarif_liste) {
					?>
			<option value="<?php echo $tarif_liste->id_tarif; ?>" <?php if($form['id_tarif']==$tarif_liste->id_tarif) {echo 'selected="selected"';}?>><?php echo htmlentities($tarif_liste->lib_tarif); ?></option>
			<?php }
					?>
		</select></td>
	</tr>
</table><br />


<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>



</div>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:20%">
			<a href="#"  id="order_simple_ref">R&eacute;f&eacute;rence
			</a>
		</td>
		<td >
			<a href="#"  id="order_simple_lib">Libell&eacute;
			</a>
		</td>
		<td style="width:15%; text-align:center">Stock</td>
		<td style="width:15%; text-align:center">
			<span id="order_simple_tarif">Tarif
			<?php if ($_REQUEST["app_tarifs_s"] == "HT") {echo "HT";} else { echo "TTC";}?>
			</span>
		</td>
		<td style="width:15%; text-align:center">
			<a href="#"  id="order_simple_pa">
				PA HT
			</a>
		</td>
		<td style="width:5%"></td>
	</tr>
<?php 
$colorise=0;
foreach ($fiches as $fiche) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
?>
<tr class="<?php  echo  $class_colorise?>">
	<td class="reference">
		<a  href="#" id="link_art_ref_<?php echo htmlentities($fiche->ref_article)?>" style="display:block; width:100%">
		<?php	if ($fiche->ref_interne!="") { echo htmlentities($fiche->ref_interne)."&nbsp;";}else{ echo htmlentities($fiche->ref_article)."&nbsp;";}?><br />
		<?php	if ($fiche->ref_oem) { echo htmlentities($fiche->ref_oem)."&nbsp;";}?>		
		</a>
		<script type="text/javascript">
		Event.observe("link_art_ref_<?php echo htmlentities($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo htmlentities($fiche->ref_article)?>'),'true','_blank');}, false);
		</script>
	</td>
	<td>
		<a  href="#" id="link_art_lib_<?php echo htmlentities($fiche->ref_article)?>" style="display:block; width:100%">
		<span class="lib_categorie"><?php	if ($fiche->lib_art_categ) 				{ echo htmlentities($fiche->lib_art_categ); }?></span> - <span class="lib_constructor"><?php	if ($fiche->nom_constructeur) { echo htmlentities($fiche->nom_constructeur)."&nbsp;";}?></span><br />
		<span class="r_art_lib"><?php echo nl2br(htmlentities($fiche->lib_article))?></span>
		</a>
		<script type="text/javascript">
		Event.observe("link_art_lib_<?php echo htmlentities($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo htmlentities($fiche->ref_article)?>'),'true','_blank');}, false);
		</script>
	</td>
	<td style="text-align:center">
		<?php if (isset($fiche->modele) &&  $fiche->modele == "materiel") {?>
		<a href="#" id="aff_resume_stock_<?php echo ($fiche->ref_article);?>">
		<?php	
		if ($fiche->lot != 2 ) {
			if (isset($fiche->stock)) {
				echo ($fiche->stock); 
			} else { 
				echo "0";
			}
		} else {
			echo "N/A";
		}
		?>
		</a>
		<script type="text/javascript">
		Event.observe("aff_resume_stock_<?php echo ($fiche->ref_article);?>", "click", function(evt){show_resume_stock("<?php echo $fiche->ref_article;?>", evt); Event.stop(evt);}, false);
		</script>
		<?php } ?>
	</td>
	<td style="text-align:right">
	<div id="aff_tarif_ht_<?php echo $colorise;?>" style="display:<?php if ($_REQUEST["app_tarifs_s"] != "HT") { echo "none";}?>">
		<?php	
		foreach ($fiche->tarifs as $tarif) {
			if (count($fiche->tarifs) == 1) {
		 			echo htmlentities(number_format($tarif->pu_ht, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		 	} else {
		 			echo htmlentities(number_format($tarif->pu_ht, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]." par ".$tarif->indice_qte."<br/>";
			} 
		 }
		?>
	</div>
	<div id="aff_tarif_ttc_<?php echo $colorise;?>" style="display:<?php if ($_REQUEST["app_tarifs_s"] != "TTC") { echo "none";}?>">
		<?php	
		foreach ($fiche->tarifs as $tarif) {
			if (count($fiche->tarifs) == 1) {
		 			echo htmlentities(number_format($tarif->pu_ht*(1+$fiche->tva/100), $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		 	} else {
		 			echo htmlentities(number_format($tarif->pu_ht*(1+$fiche->tva/100), $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]." par ".$tarif->indice_qte."<br/>";
			} 
		 }
		?>
	</div>
	</td>
	<td style="text-align:right; padding-right:29px">
	<div id="aff_pa_ht_<?php echo $colorise;?>" style=" <?php //permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6")) {?>display:none;<?php } ?>" >
		<input type="text" name="pa_ht_<?php echo $colorise;?>" id="pa_ht_<?php echo $colorise;?>" size="5" value="<?php	
			if(!is_null($fiche->prix_achat_ht)) {
			echo htmlentities(number_format($fiche->prix_achat_ht, $TARIFS_NB_DECIMALES, ".", ""	));
			}
		?>"/>
		<?php echo " ".$MONNAIE[1];?>
		<script type="text/javascript">
		Event.observe("pa_ht_<?php echo $colorise;?>", "blur",  function(evt){
		Event.stop(evt); 
		if (nummask(evt, $("pa_ht_<?php echo $colorise;?>" ).value, "X.X")) {
			maj_pa_ht ("<?php echo htmlentities($fiche->ref_article)?>", $("pa_ht_<?php echo $colorise;?>").value, "pa_ht_<?php echo $colorise;?>");
		}
		}, false);
		</script>
	</div>
	</td>
	<td style="vertical-align:middle; text-align:center">
	<a  href="#" id="link_art_voir_<?php echo htmlentities($fiche->ref_article)?>" style="display:block; width:100%; text-decoration:underline">Voir</a>
		<script type="text/javascript">
		Event.observe("link_art_voir_<?php echo htmlentities($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo htmlentities($fiche->ref_article)?>'),'true','_blank');}, false);
		</script>
	
	</td>
	</tr>
	
<?php
}
?></table>

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

<iframe frameborder="0" scrolling="no" src="about:_blank" id="resume_stock_iframe" class="resume_stock_iframe"></iframe>
<div id="resume_stock" class="resume_stock">
</div>


<SCRIPT type="text/javascript">

Event.observe("order_simple_ref", "click",  function(evt){Event.stop(evt); $('orderby_s').value='ref_interne'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="ref_interne") {echo "DESC";} else {echo "ASC";}?>'; page.catalogue_recherche_non_pa();}, false);

Event.observe("order_simple_lib", "click",  function(evt){Event.stop(evt); $('orderby_s').value='lib_article'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="lib_article") {echo "DESC";} else {echo "ASC";}?>'; page.catalogue_recherche_non_pa();}, false);

Event.observe("order_simple_pa", "click",  function(evt){Event.stop(evt); $('orderby_s').value='prix_achat_ht'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="prix_achat_ht") {echo "DESC";} else {echo "ASC";}?>'; page.catalogue_recherche_non_pa();}, false);


Event.observe('taxation_ttc', "click", function(evt){
 $("app_tarifs_s").value = "TTC";
 for (i=1; i <= <?php echo $colorise;?>; i++) {
 $("aff_tarif_ttc_"+i).show();
 $("aff_tarif_ht_"+i).hide();
 $("order_simple_tarif").innerHTML = "Tarif TTC";
 }
});
Event.observe('taxation_ht', "click", function(evt){
 $("app_tarifs_s").value = "HT";
 for (i=1; i <= <?php echo $colorise;?>; i++) {
 $("aff_tarif_ttc_"+i).hide();
 $("aff_tarif_ht_"+i).show();
 $("order_simple_tarif").innerHTML = "Tarif HT";
 }
});


Event.observe('id_stock_l', "change", function(evt){$('id_stock_s').value=$('id_stock_l').value; page.catalogue_recherche_non_pa();});
Event.observe('id_tarif_l', "change", function(evt){$('id_tarif_s').value=$('id_tarif_l').value; page.catalogue_recherche_non_pa();});
//on masque le chargement
H_loading();
</SCRIPT>