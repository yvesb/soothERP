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
                                       'page_to_show',
																			 'page.catalogue_recherche_avancee()');



// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Affichage des résultats
?><br />
<div class="mt_size_optimise"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
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
		<td></td>
		<td>&nbsp;</td>
		<td style="width:5%">&nbsp;</td>
		<td style="width:25%"></td>
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
 
<table  cellspacing="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:20%"><a href="#"  id="order_simple_ref">R&eacute;f&eacute;rence</a></td>
		<td ><a href="#"  id="order_simple_lib">Libell&eacute;</a></td>
		<?php if($form['type'] == 'vente'){?>
		<td style="text-align:center">Compte Vente</td>
		<?php }?>
		<?php if($form['type'] == 'achat'){?>
		<td style="text-align:center">Compte Achat</td>
		<?php }?>
		<td style="text-align:center"></td>
	</tr>
<?php 
$colorise=0;
foreach ($fiches as $fiche) {
	$colorise++;
	$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
	?>
	<tr class="<?php  echo  $class_colorise?>" id="line_art_<?php echo ($fiche->ref_article)?>">
		<td class="reference">
			<a  href="#" id="link_ref_<?php echo ($fiche->ref_article)?>" style="display:block; width:100%">
			<?php	if ($fiche->ref_interne!="") { echo ($fiche->ref_interne)."&nbsp;";}else{ echo ($fiche->ref_article)."&nbsp;";}?><br />
			<?php	if ($fiche->ref_oem) { echo ($fiche->ref_oem)."&nbsp;";}?>		
			</a>
			<script type="text/javascript">
			Event.observe("link_ref_<?php echo ($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo ($fiche->ref_article)?>'),'true','_blank');}, false);
			</script>
		</td>
		<td>
			<a  href="#" id="link_lib_<?php echo ($fiche->ref_article)?>" style="display:block; width:100%">
			<span class="lib_categorie"><?php	if ($fiche->lib_art_categ) 				{ echo ($fiche->lib_art_categ); }?></span> - <span class="lib_constructor"><?php	if ($fiche->nom_constructeur) { echo ($fiche->nom_constructeur)."&nbsp;";}?></span><br />
			<span class="r_art_lib"><?php echo nl2br(($fiche->lib_article))?></span>
			</a>
			<script type="text/javascript">
			Event.observe("link_lib_<?php echo ($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo ($fiche->ref_article)?>'),'true','_blank');}, false);
			</script>
		<div style="position:relative">
		<div id="line_aff_img_<?php echo ($fiche->ref_article)?>" style="display:none; position:absolute">
		<img src="" id="id_img_line_<?php echo ($fiche->ref_article)?>" />
		</div>
		</div>
		</td>
	<!--  COMPTE COMPTABLE -->
	<?php if($form['type'] == 'vente'){?>
	<td style="text-align:center">
		<?php 
		$lib_cmpt_comment ="";
		if ( isset ($fiche->numero_compte_vente) && $fiche->numero_compte_vente != ""){ 
			//si l'article a un numero de compte vente par defaut
			$lcpt = new compta_plan_general($fiche->numero_compte_vente);
		} else if ( isset ($fiche->defaut_numero_compte_vente) && $fiche->defaut_numero_compte_vente != "" ){ 
			//sinon on prend le compte par defaut de la catégorie
			$lcpt = new compta_plan_general($fiche->defaut_numero_compte_vente);
			$lib_cmpt_comment .= "(par défaut) ";
		} else {
			//il est possible que la catégorie n'ai pas de compte assigné dans la BDD
			//on assigne alors le compte GLOBAL de VENTE HT
			$lcpt = new compta_plan_general($DEFAUT_COMPTE_HT_VENTE);
			$lib_cmpt_comment .= "(général) ";
		}
		$num_cmpt = $lcpt->getNumero_compte ();
		$lib_cmpt = $lcpt->getLib_compte();
		?>
		<span style="text-decoration:underline; cursor:pointer" id="numero_compte_compta_art_vente_<?php echo $fiche->ref_article;?>"><?php echo $num_cmpt;?></span>
		<br/>
		<span id="commentaire_<?php echo $fiche->ref_article;?>" class="reference"><?php echo $lib_cmpt_comment;?></span>
		<span id="aff_numero_compte_compta_art_vente_<?php echo $fiche->ref_article;?>" class="reference"><?php echo $lib_cmpt;?></span>
		<script type="text/javascript">
		Event.observe('numero_compte_compta_art_vente_<?php echo $fiche->ref_article;?>', 'click',  function(evt){
			ouvre_compta_plan_mini_moteur(); 
			charger_compta_plan_mini_moteur ("compte_plan_comptable_search.php?cible=article&cible_id=<?php echo $fiche->ref_article;?>&retour_value_id=numero_compte_compta_art_vente_<?php echo $fiche->ref_article;?>&retour_lib_id=aff_numero_compte_compta_art_vente_<?php echo $fiche->ref_article;?>&indent=numero_compte_compta_art_vente_<?php echo $fiche->ref_article;?>&type=vente&num_compte=<?php echo $DEFAUT_COMPTE_HT_VENTE;?>");
			Event.stop(evt);
		},false); 
		</script>
	</td>
	<?php }?>
	<?php if($form['type'] == 'achat'){?>
	<td style="text-align:center">
		<?php 
		$lib_cmpt_comment ="";
		if ( isset ($fiche->numero_compte_achat) && $fiche->numero_compte_achat != ""){ 
			//si l'article a un numero de compte par defaut
			$lcpt = new compta_plan_general($fiche->numero_compte_achat);
		} else if ( isset ($fiche->defaut_numero_compte_achat) && $fiche->defaut_numero_compte_achat != "" ){ 
			//sinon on prend le compte par defaut de la catégorie
			$lcpt = new compta_plan_general($fiche->defaut_numero_compte_achat);
			$lib_cmpt_comment .= "(par défaut) ";
		} else {
			//il est possible que la catégorie n'ai pas de compte assigné dans la BDD
			//on assigne alors le compte GLOBAL de ACHAT HT
			$lcpt = new compta_plan_general($DEFAUT_COMPTE_HT_ACHAT);
			$lib_cmpt_comment .= "(général) ";
		}
		$num_cmpt = $lcpt->getNumero_compte ();
		$lib_cmpt = $lcpt->getLib_compte();
		?>
		<span style="text-decoration:underline; cursor:pointer" id="numero_compte_compta_art_achat_<?php echo $fiche->ref_article;?>"><?php echo $num_cmpt;?></span>
		<br/>
		<span id="commentaire_<?php echo $fiche->ref_article;?>" class="reference"><?php echo $lib_cmpt_comment;?></span>
		<span id="aff_numero_compte_compta_art_achat_<?php echo $fiche->ref_article;?>" class="reference"><?php echo $lib_cmpt;?></span>
		<script type="text/javascript">
		Event.observe('numero_compte_compta_art_achat_<?php echo $fiche->ref_article;?>', 'click',  function(evt){
			ouvre_compta_plan_mini_moteur(); 
			charger_compta_plan_mini_moteur ("compte_plan_comptable_search.php?cible=article&cible_id=<?php echo $fiche->ref_article;?>&retour_value_id=numero_compte_compta_art_achat_<?php echo $fiche->ref_article;?>&retour_lib_id=aff_numero_compte_compta_art_achat_<?php echo $fiche->ref_article;?>&indent=numero_compte_compta_art_achat_<?php echo $fiche->ref_article;?>&type=achat&num_compte=<?php echo $DEFAUT_COMPTE_HT_ACHAT;?>");
			Event.stop(evt);
		},false); 
		</script>
	</td>
	<?php }?>
	<!-- END -->
		<td style="vertical-align:middle; text-align:center">
		<a  href="#" id="link_view_<?php echo ($fiche->ref_article)?>" style="display:block; width:100%; text-decoration:underline">Voir</a>
			<script type="text/javascript">
			Event.observe("link_view_<?php echo ($fiche->ref_article)?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo ($fiche->ref_article)?>'),'true','_blank');}, false);
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

<iframe frameborder="0" scrolling="no" src="about:_blank" id="resume_stock_iframe" class="resume_stock_iframe"></iframe>
<div id="resume_stock" class="resume_stock">
</div>


<SCRIPT type="text/javascript">

Event.observe("order_simple_ref", "click",  function(evt){Event.stop(evt); $('orderby_s').value='ref_interne'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="ref_interne") {echo "DESC";} else {echo "ASC";}?>'; page.compta_automatique_art_recherche_simple();}, false);
Event.observe("order_simple_lib", "click",  function(evt){Event.stop(evt); $('orderby_s').value='lib_article'; $('orderorder_s').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="lib_article") {echo "DESC";} else {echo "ASC";}?>'; page.compta_automatique_art_recherche_simple();}, false);
//on masque le chargement
H_loading();
</SCRIPT>