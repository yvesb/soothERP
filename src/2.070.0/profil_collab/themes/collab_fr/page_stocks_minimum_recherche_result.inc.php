<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "fiches", "form['page_to_show']", "form['fiches_par_page']", "nb_fiches", "form['orderby']", "form['orderorder']", "form['ref_art_categ']", "form['ref_constructeur']","form['aff_pa']");
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
																			 'page.stock_minimum_recherche_simple()');



// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Affichage des résultats
?><br />
<div   class="mt_size_optimise">


<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>



</div>

<table width=""  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:120px">
			<div style="width:120px">
			<a href="#"  id="order_simple_ref">R&eacute;f&eacute;rence
			</a>
			</div>
		</td>
		<td style="width:280px" >
			<div style="width:280px">
			<a href="#"  id="order_simple_lib">Libell&eacute;
			</a>
			</div>
		</td>
		<td>&nbsp;
		</td>
		<?php
		if ($search['aff_pa']) {
			?>
		<td style="width:80px; text-align:center">
		<div style="width:80px">
			<a href="#"  id="order_simple_tarif">Prix d'achat
			</a>
			</div>
		</td>
		<?php
		}
		?>
		<?php 
		if ($search['id_stock'] && $search['id_stock'][0] != "") {
			foreach ($search['id_stock'] as $stock) {
			?>
			<td style="width:15%; text-align:center"><?php echo $_SESSION['stocks'][$stock]->getLib_stock();?></td>
			<?php
			}
		} else {
			foreach ($_SESSION['stocks'] as $stock) {
				?>
				<td style="width:150px; text-align:center"><div style="width:150px"><?php echo $stock->getLib_stock();?></div></td>
				<?php
			}
		}
		?>
			<td style="width:15%;text-align:center">
			</td>
	</tr>
<?php 
$colorise=0;
foreach ($fiches as $fiche) {
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
?>
<tr class="<?php  echo  $class_colorise?>" id="result_minimum_stock_<?php echo htmlentities($fiche->ref_article)?>">
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
		<span class="r_art_lib"><?php echo nl2br(($fiche->lib_article))?></span>
		</a>
		<div style="position:relative">
		<div id="line_aff_img_<?php echo ($fiche->ref_article)?>" style="display:none; position:absolute">
		<img src="" id="id_img_line_<?php echo ($fiche->ref_article)?>" />
		</div>
		</div>
		<script type="text/javascript">
		Event.observe("link_art_lib_<?php echo htmlentities($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo htmlentities($fiche->ref_article)?>'),'true','_blank');}, false);
		<?php 
		if (isset($fiche->lib_file) && $fiche->lib_file != "") {
			?>
			Event.observe("result_minimum_stock_<?php echo ($fiche->ref_article)?>", "mouseover",  function(evt){
				Event.stop(evt);
				$("line_aff_img_<?php echo ($fiche->ref_article)?>").style.display="";
				$("id_img_line_<?php echo ($fiche->ref_article)?>").src="<?php echo $ARTICLES_MINI_IMAGES_DIR.$fiche->lib_file;?>";
				//positionne_element(evt, "line_aff_img");
			}, false);
			Event.observe("result_minimum_stock_<?php echo ($fiche->ref_article)?>", "mouseout",  function(evt){
				Event.stop(evt);
				$("line_aff_img_<?php echo ($fiche->ref_article)?>").style.display="none";
			}, false);
			<?php
		}
		?>
		</script>
	</td>
		<td>
		</td>
	<?php
	if ($search['aff_pa']) {
		?>
		<td style="text-align:right">
		<div style="padding-right:25px;  <?php //permission (6) Accès Consulter les prix d’achat
if (!$_SESSION['user']->check_permission ("6")) {?>display:none;<?php } ?>">
			<?php	
			if (isset($fiche->prix_achat_ht)) {
				echo htmlentities(number_format($fiche->prix_achat_ht, $TARIFS_NB_DECIMALES, ".", ""	))." ".$MONNAIE[1]."";
			}
			?>
		</div>
		</td>
		<?php
	}
	?>
	<?php 
	if ($search['id_stock'] && $search['id_stock'][0] != "") {
		foreach ($search['id_stock'] as $stock) {
		?>
		<td style="text-align:center">
			<input type="text" name="stock_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock );?>" id="stock_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock);?>" value="<?php
			$seuil_exist = "0";
			if (isset($fiche->stocks[$stock]->seuil_alerte)) {
				$seuil_exist = htmlentities($fiche->stocks[$stock]->seuil_alerte);
			}
			echo $seuil_exist;?>"  class="classinput_nsize" style="text-align:center" size="5"/>
				<input type="hidden" name="stock_old_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock );?>" id="stock_old_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock);?>" value="<?php echo $seuil_exist;?>"  class="classinput_xsize"/>
					<SCRIPT type="text/javascript">
						Event.observe("stock_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock);?>", "blur", function(evt){
							nummask(evt,"<?php echo $seuil_exist;?>", "X.X");
							if ($("stock_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock);?>").value != $("stock_old_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock);?>").value) {
							$("stock_old_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock);?>").value = $("stock_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock);?>").value;
							maj_stock_alerte ("<?php echo $fiche->ref_article;?>", "<?php echo $stock;?>", $("stock_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock);?>").value);
							}
						}, false);
					</SCRIPT>
		</td>
		<?php
		}
	} else {
		foreach ($_SESSION['stocks'] as $stock) {
			?>
			<td style="text-align:center">
			<input type="text" name="stock_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock->getId_stock() );?>" id="stock_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock->getId_stock());?>" value="<?php
			$seuil_exist = "0";
			if (isset($fiche->stocks[$stock->getId_stock()]->seuil_alerte)) {
				$seuil_exist = htmlentities($fiche->stocks[$stock->getId_stock()]->seuil_alerte);
			}
			echo $seuil_exist;?>"  class="classinput_nsize" style="text-align:center" size="5"/>
				<input type="hidden" name="stock_old_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock->getId_stock() );?>" id="stock_old_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock->getId_stock());?>" value="<?php echo $seuil_exist;?>"  class="classinput_xsize"/>
					<SCRIPT type="text/javascript">
						Event.observe("stock_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock->getId_stock ());?>", "blur", function(evt){
							nummask(evt,"<?php echo $seuil_exist;?>", "X.X");
							if ($("stock_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock->getId_stock ());?>").value != $("stock_old_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock->getId_stock ());?>").value) {
							$("stock_old_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock->getId_stock ());?>").value = $("stock_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock->getId_stock ());?>").value;
							maj_stock_alerte ("<?php echo $fiche->ref_article;?>", "<?php echo $stock->getId_stock ();?>", $("stock_<?php echo $fiche->ref_article;?>_<?php echo htmlentities($stock->getId_stock ());?>").value);
							}
						}, false);
					</SCRIPT>
			</td>
			<?php
		}
	}
	?>
			<td style="text-align:center">
			<?php 
			if ($fiche->date_fin_dispo > date ("Y-m-d H:i:s.", time())) { ?>
			<span style="cursor:pointer" id="fin_dispo_<?php echo ($fiche->ref_article);?>" name="fin_dispo_<?php echo ($fiche->ref_article);?>" >Fin de vie</span>
			
			<script type="text/javascript">
			Event.observe("fin_dispo_<?php echo ($fiche->ref_article);?>", "click", function(evt){
				Event.stop(evt);
				fin_dispo("<?php echo $fiche->ref_article;?>", "result_minimum_stock_");
			}, false);
			</script>
			<?php } ?>
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

Event.observe("order_simple_ref", "click",  function(evt){Event.stop(evt); $('orderby_s').value='ref_interne'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="ref_interne") {echo "DESC";} else {echo "ASC";}?>'; page.stock_minimum_recherche_simple();}, false);
Event.observe("order_simple_lib", "click",  function(evt){Event.stop(evt); $('orderby_s').value='lib_article'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="lib_article") {echo "DESC";} else {echo "ASC";}?>'; page.stock_minimum_recherche_simple();}, false);

<?php
if ($search['aff_pa']) {
	?>
	Event.observe("order_simple_tarif", "click",  function(evt){Event.stop(evt); $('orderby_s').value='prix_achat_ht'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="prix_achat_ht") {echo "DESC";} else {echo "ASC";}?>'; page.stock_minimum_recherche_simple();}, false);
	<?php
}
?>

//on masque le chargement
H_loading();
</SCRIPT>