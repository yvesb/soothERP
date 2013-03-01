<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "fiches", "form['lib_article']", "form['page_to_show']", "form['fiches_par_page']", "nb_fiches", "form['orderby']", "form['orderorder']", "form['ref_art_categ']", "form['ref_constructeur']");
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
																			 'page.document_recherche_article()');


// Affichage des résultats

//modification d'affichage du prix en fonction du type de doc
$aff_pa = 1;
if ($document->getId_type_doc() != $DEVIS_FOURNISSEUR_ID_TYPE_DOC && $document->getId_type_doc() != $COMMANDE_FOURNISSEUR_ID_TYPE_DOC && $document->getId_type_doc() != $LIVRAISON_FOURNISSEUR_ID_TYPE_DOC && $document->getId_type_doc() != $FACTURE_FOURNISSEUR_ID_TYPE_DOC ) { $aff_pa = 0; }

?>
<div class="mt_size_optimise" style="height:50px;">
<br />
<script type="text/javascript">
<?php
if (!count($fiches)) {
	?>
	$("message_r").innerHTML = "Aucun r&eacute;sultat";
	<?php
}

if (count($fiches)==1 && (isset($_REQUEST["from_rapide_search"]) && ($_REQUEST["from_rapide_search"] != ""))) {
	?>
	if ($("lib_article_r").style.display=="none") {
	$("lib_article_r").focus();
	}
	$("lib_article_r").value = "";
	add_new_line_article ($("ref_doc").value, "<?php echo ($fiches[0]->ref_article);?>", "1", "<?php	if (isset($fiches[0]->numero_serie)) { echo htmlentities($fiches[0]->numero_serie);}?>");
	<?php
}

if (count($fiches)>>1) {
	?>
	from_rapide_search = ""
	view_menu_1('rechercher_content', 'menu_2', array_menu_e_document);
	set_tomax_height('result_search_art' , -25); 
	set_tomax_height('rechercher_content' , -40); 
	set_tomax_height('resultat' , -40);  
	<?php
}


?>
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="width:30%">
			<span class="labelled_text" <?php if ($GESTION_STOCK) {?>style="display:none"<?php } ?>>Lieux de stockage:
			<?php
			foreach ($stocks_liste as $stock_liste) {
			 if($form['id_stock']==$stock_liste->getId_stock ()) {echo htmlentities($stock_liste->getLib_stock());}
			}
			?>
			</span>
		</td>
		<td style="width:5%">&nbsp;</td>
		<td style="width:25%">
			<span class="labelled_text">Tarifs:
			<?php
			foreach ($tarifs_liste as $tarif_liste) {
				if($form['id_tarif']==$tarif_liste->id_tarif) {echo htmlentities($tarif_liste->lib_tarif);}
			}
			?>
			</span>
		</td>
	</tr>
</table><br />


<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?>&nbsp;</td>
	</tr>
</table>



</div>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:2%"></td>
		<td style="width:10%">
		Qt&eacute;:
		</td>
		<td style="width:15%">
			<a href="#" id="order_ref_art">R&eacute;f&eacute;rence
			</a>
		</td>
		<td >
			<a href="#" id="order_lib_art">Libell&eacute;
			</a>
		</td>
		<?php
		$acommander_colum = false;
		foreach ($fiches as $fiche) {
			if (array_key_exists('qte', $fiche)) {
			$acommander_colum = true;
			} 
		}
		if ($acommander_colum) {
			?>
				<td style="width:120px; text-align:center;">A commander</td>
				<?php
		}
		?>
		<td style="width:5%; text-align:center;"><?php if ($GESTION_STOCK) {?>Stock<?php } ?></td>
		<td style="width:15%; text-align:center;">
			<?php
			if ($aff_pa) {
				?>
				<a href="#" id="order_tarif_art">PA <?php echo $document->getApp_tarifs();?>
				</a>
				<?php
			} else {
				?>
				PU <?php echo $document->getApp_tarifs();?>
				<?php
			}
			?>
		</td>
		<td style="width:5%"></td>
	</tr>
<?php 
$colorise=0;
foreach ($fiches as $fiche) {
	$colorise++;
	$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
	?>
	<tr class="<?php  echo  $class_colorise?>" id="line_art_<?php echo ($fiche->ref_article)?>">
		<td>
		
		</td>
		<td>
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td rowspan="2" style="vertical-align:middle">
					<input type="text" size="4" id="qte_moteur_article_<?php echo ($fiche->ref_article);?>" name="qte_moteur_article_<?php echo ($fiche->ref_article);?>" value="0"/>
					<input type="hidden" id="new_moteur_article_<?php echo ($fiche->ref_article);?>" name="new_moteur_article_<?php echo ($fiche->ref_article);?>" value="1"/>
					<input type="hidden" id="ref_doc_line_article_<?php echo ($fiche->ref_article);?>" name="ref_doc_line_article_<?php echo ($fiche->ref_article);?>" value=""/>
					<input type="hidden" id="ref_doc_line_indentation_<?php echo ($fiche->ref_article);?>" name="ref_doc_line_indentation_<?php echo ($fiche->ref_article);?>" value=""/>
					<input type="hidden" id="numero_serie_<?php echo ($fiche->ref_article);?>" name="numero_serie_<?php echo ($fiche->ref_article);?>" value="<?php	if (isset($fiche->numero_serie)) { echo htmlentities($fiche->numero_serie);}?>"/>
					</td>
					<td style="text-align:center; width:15px;"><a href="#" id="qte_add_one_<?php echo $fiche->ref_article;?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" /></a></td>
				</tr><tr>
					<td style="text-align:center; width:15px;"><a href="#" id="qte_sub_one_<?php echo $fiche->ref_article;?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/moins.gif" /></a></td>
				</tr>
			</table>
			
		<script type="text/javascript">
		Event.observe("qte_add_one_<?php echo ($fiche->ref_article);?>", "click", function(evt){Event.stop(evt);article_maj_from_moteur("<?php echo $fiche->ref_article;?>", "add");}, false);
		Event.observe("qte_sub_one_<?php echo ($fiche->ref_article);?>", "click", function(evt){Event.stop(evt);article_maj_from_moteur("<?php echo $fiche->ref_article;?>", "sub");}, false);
		Event.observe("qte_moteur_article_<?php echo ($fiche->ref_article);?>", "blur", function(evt){if (nummask(evt, 0, "X.X")) { article_maj_from_moteur("<?php echo $fiche->ref_article;?>", "blur");}}, false);
		</script>
		</td>
		<td>
		<span class="reference">
			<?php	if ($fiche->ref_interne!="") { echo ($fiche->ref_interne)."&nbsp;";}else{ echo ($fiche->ref_article)."&nbsp;";}?><br />
			<?php	if ($fiche->ref_oem) { echo ($fiche->ref_oem)."&nbsp;";}?>
		</span>
		</td>
		<td>
			<span class="lib_categorie"><?php	if ($fiche->lib_art_categ) 				{ echo ($fiche->lib_art_categ); }?></span> - <span class="lib_constructor"><?php	if ($fiche->nom_constructeur) { echo ($fiche->nom_constructeur)."&nbsp;";}?></span><br />
			<span class="r_art_lib"><?php echo nl2br(($fiche->lib_article))?></span>
		<div style="position:relative">
		<div id="line_aff_img_<?php echo ($fiche->ref_article)?>" style="display:none; position:absolute">
		<img src="" id="id_img_line_<?php echo ($fiche->ref_article)?>" />
		</div>
		</div>
		</td>
		<?php
		if ($acommander_colum) {
			?>
			<td style="text-align:center;">
			<?php	
			if (!isset($fiche->qte)) {	$fiche->qte = 0;}
			if (!isset($fiche->qte_livree)) {$fiche->qte_livree = 0;}
			if (!isset($fiche->seuil_alerte) && isset($fiche->qte_livree) && ($fiche->qte - $fiche->qte_livree) >0) { 
			
				?>
				<input type="button" id="qte_add_tocommande_<?php echo ($fiche->ref_article);?>" value="<?php echo round($fiche->qte - $fiche->qte_livree);?>" />
						
				<script type="text/javascript">
				Event.observe("qte_add_tocommande_<?php echo ($fiche->ref_article);?>", "click", function(evt){
				Event.stop(evt);
				$("qte_moteur_article_<?php echo ($fiche->ref_article);?>").value = "<?php echo $fiche->qte - $fiche->qte_livree;?>"
				article_maj_from_moteur("<?php echo $fiche->ref_article;?>", "blur");}, false);
				</script>
				<?php 
			
			};
			
			if (isset($fiche->seuil_alerte)) {
				?>
				<input type="button" id="qte_add_tocommande_<?php echo ($fiche->ref_article);?>" value="<?php echo $fiche->seuil_alerte - $fiche->qte;?>" />
				
				<script type="text/javascript">
				Event.observe("qte_add_tocommande_<?php echo ($fiche->ref_article);?>", "click", function(evt){
				Event.stop(evt);
				$("qte_moteur_article_<?php echo ($fiche->ref_article);?>").value = "<?php echo $fiche->seuil_alerte - $fiche->qte;?>"
				article_maj_from_moteur("<?php echo $fiche->ref_article;?>", "blur");}, false);
				</script>
				<?php 
			}
			
			?>
			</td>
			<?php
		}
		?>
		<td style="text-align:center">
		<?php if ($GESTION_STOCK) {?>
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
			<?php 
			}  else {
				echo "N/A";
			}
		}
		?>
		</td>
		<td style="text-align:right;">
		<span style=" <?php //permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6")) {?>display:none;<?php } ?>">
	<?php
	if ($aff_pa) {
		if ($document->getApp_tarifs() == "HT") {
			if (isset($fiche->pa_unitaire)) {
				echo htmlentities(" ".number_format($fiche->pa_unitaire,$TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]." <br/>";
			} else {
				echo htmlentities(" ".number_format($fiche->paa_ht,$TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]." <br/>";
			}
		} else {
			if (isset($fiche->pa_unitaire)) {
				echo htmlentities(" ".number_format($fiche->pa_unitaire*(1+$fiche->tva/100),$TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]." <br/>";
			} else {
				echo htmlentities(" ".number_format($fiche->paa_ht*(1+$fiche->tva/100),$TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]." <br/>";
			}
		
		}
	} else {
		foreach ($fiche->tarifs as $tarif) {
			if (count($fiche->tarifs) == 1) {
				if ($document->getApp_tarifs() == "HT") {
		 			echo htmlentities(number_format($tarif->pu_ht, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				} else {
		 			echo htmlentities(number_format($tarif->pu_ht*(1+$fiche->tva/100),$TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
		 	} else {
				if ($document->getApp_tarifs() == "HT") {
			 		echo htmlentities(" ".number_format($tarif->pu_ht,$TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]."  par ".$tarif->indice_qte."<br/>";
				} else {
		 			echo htmlentities(" ".number_format($tarif->pu_ht*(1+$fiche->tva/100),$TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]."  par ".$tarif->indice_qte."<br/>";
				}
			} 
		 }
	}
	?>
		</span>
		</td>
		<td style="vertical-align:middle; text-align:center">
		<a  href="#" id="link_view_art_<?php echo $fiche->ref_article;?>" style="display:block; width:100%; text-decoration:underline">Voir</a>	
		<script type="text/javascript">
	Event.observe("link_view_art_<?php echo $fiche->ref_article;?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo htmlentities($fiche->ref_article)?>'),'true','_blank');}, false);
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
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?>&nbsp;</td>
	</tr>
</table>


<iframe frameborder="0" scrolling="no" src="about:_blank" id="resume_stock_iframe" class="resume_stock_iframe"></iframe>
<div id="resume_stock" class="resume_stock">
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
Event.observe("order_ref_art", "click",  function(evt){Event.stop(evt); $('orderby_s').value='ref_interne'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="ref_interne") {echo "DESC";} else {echo "ASC";}?>'; page.document_recherche_article();}, false);
Event.observe("order_lib_art", "click",  function(evt){Event.stop(evt); $('orderby_s').value='lib_article'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="lib_article") {echo "DESC";} else {echo "ASC";}?>'; page.document_recherche_article();}, false);

<?php
if ($aff_pa) {
	?>
	Event.observe("order_tarif_art", "click",  function(evt){Event.stop(evt); $('orderby_s').value='prix_achat_ht'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="prix_achat_ht") {echo "DESC";} else {echo "ASC";}?>'; page.document_recherche_article();}, false);
	<?php
}
?>

//centrage du resume_stock

centrage_element("resume_stock");
centrage_element("resume_stock_iframe");

Event.observe(window, "resize", function(evt){
centrage_element("resume_stock_iframe");
centrage_element("resume_stock");
});
//on masque le chargement
H_loading();
</SCRIPT>
</div>


