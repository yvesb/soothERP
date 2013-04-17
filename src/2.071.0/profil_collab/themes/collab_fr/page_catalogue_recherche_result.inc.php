<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "fiches", "form['lib_article']", "form['page_to_show']", "form['fiches_par_page']", "nb_fiches", "form['orderby']", "form['orderorder']", "form['ref_art_categ']", "form['ref_constructeur']","form['in_stock']" , "form['is_nouveau']", "form['in_promotion']");
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
																			 'page.catalogue_recherche_simple()');



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
		<td style="width:30%"><span class="labelled_text" <?php if (!$GESTION_STOCK) {?> style="display:none"<?php } ?>>Lieux de stockage:
			<select name="id_stock_l" id="id_stock_l" class="">
				<?php 
				if (count($stocks_liste) > 1) {
				?><option value="" >Tous</option><?php
				}
					foreach ($stocks_liste as $stock_liste) {
					?>
				<option value="<?php echo $stock_liste->getId_stock (); ?>" <?php if($form['id_stock']==$stock_liste->getId_stock ()) {echo 'selected="selected"';}?>><?php echo ($stock_liste->getLib_stock()); ?></option>
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
			<option value="<?php echo $tarif_liste->id_tarif; ?>" <?php if($form['id_tarif']==$tarif_liste->id_tarif) {echo 'selected="selected"';}?>><?php echo ($tarif_liste->lib_tarif); ?></option>
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
		<td style="width:30%" >
			<a href="#"  id="order_simple_lib">Libell&eacute;
			</a>
		</td>
		<td style="width:15%; text-align:center"><?php if ($GESTION_STOCK) {?>Stock<?php } ?></td>
		<td style="width:15%; text-align:center"><?php if ($GESTION_STOCK) {?>Emplacement<?php } ?></td>
		
		<td style="width:15%; text-align:center">
			<a href="#"  id="order_simple_tarif">Tarif
			<?php if ($_REQUEST["app_tarifs_s"] == "HT") {echo "HT";} else { echo "TTC";}?>
			</a>
		</td>
		<td style="width:5%"></td>
	</tr>
<?php 
$colorise=0;
foreach ($fiches as $fiche) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
$article = new article($fiche->ref_article);
?>
<tr class="<?php  echo  $class_colorise?>" id="line_art_<?php echo ($fiche->ref_article)?>">
	<td class="reference" style="width:20%">
		<a  href="#" id="link_art_ref_<?php echo ($fiche->ref_article)?>" style="display:block; width:100%">
		<?php	if ($fiche->ref_interne!="") { echo ($fiche->ref_interne)."&nbsp;";}else{ echo ($fiche->ref_article)."&nbsp;";}?><br />
		<?php	if ($fiche->ref_oem) { echo ($fiche->ref_oem)."&nbsp;";}?>		
		</a>
		<script type="text/javascript">
		Event.observe("link_art_ref_<?php echo ($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo ($fiche->ref_article)?>'),'true','_blank');}, false);
		</script>
	</td>
	<td style="width:30%">
		<a  href="#" id="link_art_lib_<?php echo ($fiche->ref_article)?>" style="display:block; width:100%">
		<span class="lib_categorie"><?php	if ($fiche->lib_art_categ) 				{ echo ($fiche->lib_art_categ); }?></span> - <span class="lib_constructor"><?php	if ($fiche->nom_constructeur && $_SESSION['user']-> check_permission("22",$CONSTRUCTEUR_ID_PROFIL)) { echo ($fiche->nom_constructeur)."&nbsp;";}?></span><br />
		<span class="r_art_lib"><?php echo nl2br(($fiche->lib_article))?></span>
		</a>
		<script type="text/javascript">
		Event.observe("link_art_lib_<?php echo ($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo ($fiche->ref_article)?>'),'true','_blank');}, false);
		</script>
		<div style="position:relative">
		<div id="line_aff_img_<?php echo ($fiche->ref_article)?>" style="display:none; position:absolute">
		<img src="" id="id_img_line_<?php echo ($fiche->ref_article)?>" />
		</div>
		</div>
	</td>
	<td style="text-align:center; width:15%; ">
	<?php if ($GESTION_STOCK) {?>
		<?php if (isset($fiche->modele) &&  $fiche->modele == "materiel") {?>
		<a href="#" id="aff_resume_stock_<?php echo ($fiche->ref_article);?>">
				<?php
				if ($fiche->lot != 2 ) {
					if (isset($fiche->stock)) {
						echo qte_format($fiche->stock); 
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
		<?php }  else {
				echo "N/A";
			}
	}
	?>
	</td>
	<td style="width:15%; text-align:center">
	<?php //emplacement
	if ($GESTION_STOCK) { 
	
		 echo $article->getStocks_emplacement($_SESSION['magasin']->getId_stock()); 
	 }	?>
	</td>
        <?php if(isset($TAXE_IN_PU) && $TAXE_IN_PU ==0){
                    $taxes = get_article_taxes($fiche->ref_article);
                    $montant_taxe =0;
                    if(count($taxes)>0){
                        foreach($taxes as $taxe)
                        {
                            $montant_taxe += $taxe->montant_taxe;
                        }
                    }
                } ?>
	<td style="text-align:right; width:15%;">
	<div id="aff_tarif_ht_<?php echo $colorise;?>" style="display:<?php if ($_REQUEST["app_tarifs_s"] != "HT") { echo "none";}?>">
		<?php	
		//echo $colorise;
		foreach ($fiche->tarifs as $tarif) {
			if (count($fiche->tarifs) == 1) {
                            if(isset($TAXE_IN_PU) && $TAXE_IN_PU ==0)
		 			echo (number_format($tarif->pu_ht+$montant_taxe, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		 	else
                            echo (number_format($tarif->pu_ht, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        } else {
                            if(isset($TAXE_IN_PU) && $TAXE_IN_PU ==0)
		 			echo (number_format($tarif->pu_ht+$montant_taxe, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]." par ".$tarif->indice_qte."<br/>";
                                        else
                            echo (number_format($tarif->pu_ht, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]." par ".$tarif->indice_qte."<br/>";
                        }
		 }
		?>
	</div>
	<div id="aff_tarif_ttc_<?php echo $colorise;?>" style="display:<?php if ($_REQUEST["app_tarifs_s"] != "TTC") { echo "none";}?>">
		<?php
		//echo $colorise;
                //_vardump($fiche);
                
                
		foreach ($fiche->tarifs as $tarif) {
			if (count($fiche->tarifs) == 1) {
                                if(isset($TAXE_IN_PU) && $TAXE_IN_PU ==0)
                                    echo (number_format($tarif->pu_ht*(1+$fiche->tva/100)+$montant_taxe, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                else
                                    echo (number_format($tarif->pu_ht*(1+$fiche->tva/100), $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		 	} else {
                            if(isset($TAXE_IN_PU) && $TAXE_IN_PU ==0)
		 			echo (number_format($tarif->pu_ht*(1+$fiche->tva/100)+$montant_taxe, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]." par ".$tarif->indice_qte."<br/>";
                                        else
                            echo (number_format($tarif->pu_ht*(1+$fiche->tva/100), $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]." par ".$tarif->indice_qte."<br/>";
                        }
		 }
		?>
	</div>
	</td>
	<td style="vertical-align:middle; text-align:center; width:5%">
	<a  href="#" id="link_art_voir_<?php echo ($fiche->ref_article)?>" style="display:block; width:100%; text-decoration:underline">Voir</a>
		<script type="text/javascript">
		Event.observe("link_art_voir_<?php echo ($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo ($fiche->ref_article)?>'),'true','_blank');}, false);
		
		<?php 
		if (isset($fiche->lib_file) && $fiche->lib_file != "") {
			?>
			Event.observe("line_art_<?php echo ($fiche->ref_article)?>", "mouseover",  function(evt){
				Event.stop(evt);
				$("line_aff_img_<?php echo ($fiche->ref_article)?>").style.display="";
				$("id_img_line_<?php echo ($fiche->ref_article)?>").src="<?php echo $ARTICLES_MINI_IMAGES_DIR.$fiche->lib_file;?>";
				//positionne_element(evt, "line_aff_img");
			}, false);
			Event.observe("line_art_<?php echo ($fiche->ref_article)?>", "mouseout",  function(evt){
				Event.stop(evt);
				$("line_aff_img_<?php echo ($fiche->ref_article)?>").style.display="none";
			}, false);
			<?php
		}
		?>
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

Event.observe("order_simple_ref", "click",  function(evt){Event.stop(evt); $('orderby_s').value='ref_interne'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="ref_interne") {echo "DESC";} else {echo "ASC";}?>'; page.catalogue_recherche_simple();}, false);
Event.observe("order_simple_lib", "click",  function(evt){Event.stop(evt); $('orderby_s').value='lib_article'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="lib_article") {echo "DESC";} else {echo "ASC";}?>'; page.catalogue_recherche_simple();}, false);
Event.observe("order_simple_tarif", "click",  function(evt){Event.stop(evt); $('orderby_s').value='lib_article'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="lib_article") {echo "DESC";} else {echo "ASC";}?>'; page.catalogue_recherche_simple();}, false);


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


Event.observe('id_stock_l', "change", function(evt){$('id_stock_s').value=$('id_stock_l').value; page.catalogue_recherche_simple();});
Event.observe('id_tarif_l', "change", function(evt){$('id_tarif_s').value=$('id_tarif_l').value; page.catalogue_recherche_simple();});
//on masque le chargement
H_loading();
</SCRIPT>