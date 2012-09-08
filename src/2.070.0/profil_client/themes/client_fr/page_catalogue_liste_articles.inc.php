<?php
// *************************************************************************************************************
// ACCUEIL DU VISITEUR
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
global $app_tarifs_s;
	$barre= "";	$lien_on 	= "&nbsp;<a href='catalogue_liste_articles.php?page_to_show={cibleb}{fonctionlauch}' id='link_pagi_{cible}'>{lien}</a>&nbsp;";
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
		{				$barre .= "<a href='catalogue_liste_articles.php?page_to_show=".$cpt.$fonctiontolauch."' id='link_txt_".$cpt."";
				$barre .= "'>&nbsp;".$cpt."&nbsp;</a>";
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
	$param_link = "";
	if (isset($_REQUEST["id_catalogue_client_dir"])) {
		$param_link .= '&id_catalogue_client_dir='.$_REQUEST["id_catalogue_client_dir"] ;
	}
	$param_link .= '&app_tarifs_s='.$app_tarifs_s ;
	if (isset($_REQUEST["orderby"]) && isset($_REQUEST["orderorder"])) {
	$param_link .= '&orderby='.$_REQUEST["orderby"].'&orderorder='.$_REQUEST["orderorder"];
	}
	$barre_nav .= barre_navigation($nb_fiches, $form['page_to_show'], 
                                       $form['fiches_par_page'], 
                                       $debut, $cfg_nb_pages,
                                       'page_to_show_s',
																			 $param_link);



?>

<?php include("header.php"); ?>

<?php include("top.php"); ?>

<?php include("menu.php"); ?>

<?php include("content_before.php"); ?>


		<div style="float:right" >
		<form name="rechercher_av" id="rechercher_av" action="catalogue_liste_articles.php">
		<table width="75%" border="0" cellspacing="0" cellpadding="0" class="recherche_a_table">
			<tr>
				<td></td>
				<td>
				<span class="libelle_recherche_a">
					Libéllé:
					</span>
				</td>
				<td> <input type="text" name="lib_article" value="<?php if (isset($_REQUEST['lib_article'])) {echo $_REQUEST['lib_article']; }?>" class="classinput_xsize"/>
				</td>
				<td>
					<span class="libelle_recherche_a">
					Catégorie:
					</span>
				</td>
				<td>
				<select  name="id_catalogue_client_dir" id="id_catalogue_client_dir" class="classinput_xsize" >
					<option value="">Toutes</option>
					<?php
					foreach ($list_catalogue_dir  as $s_art_categ){
						?>
						<option value="<?php echo ($s_art_categ->id_catalogue_client_dir)?>" <?php if (isset($_REQUEST['id_catalogue_client_dir']) && $_REQUEST['id_catalogue_client_dir'] == $s_art_categ->id_catalogue_client_dir) { echo'selected="selected"';}?>>
						<?php for ($i=0; $i<$s_art_categ->indentation; $i++) {?>&nbsp;&nbsp;&nbsp;<?php }?><?php echo htmlentities($s_art_categ->lib_catalogue_client_dir)?>
						</option>
						<?php
					}
					reset($list_catalogue_dir);
					?>
					</select>
				</td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/recherche_av_bt.gif" id="start_recherche_av" style="cursor:pointer; padding-right:25px;" /></td>
			</tr>
		</table>
		</form>
		<script type="text/javascript">
		Event.observe('start_recherche_av', 'click',  function(evt){
			Event.stop(evt);
			$("rechercher_av").submit();
			}
		);
		</script>
		</div><br />
<br />

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="para">
	<tr>
		<td>
		
<div><br />

<div id="liste_categories_articles">

<ul>
<?php 
$main_categorie = 0;	
while ($catalogue_dir = current($list_catalogue_dir) ) {
next($list_catalogue_dir);
	if ($catalogue_dir->indentation == 0) {
		if ($main_categorie) {
			?>
			<li class="vide_categ">
			</li>
			<?php
		}
		
		?>
		<li class="main_categ">
		
		<div class="main_categ2">&nbsp;</div>
		<a href="catalogue_liste_articles.php?id_catalogue_client_dir=<?php echo $catalogue_dir->id_catalogue_client_dir;?>"><?php echo htmlentities($catalogue_dir->lib_catalogue_client_dir);?></a>
		</li>
		<?php
		$main_categorie = 1;
	}
	
	if ($catalogue_dir->indentation != 0) {
		if (key($list_catalogue_dir)=="" || current($list_catalogue_dir)->indentation <= 0 ) {
			?>
			<li class="sub_categ3">
			<?php
			for ($i=1; $i < $catalogue_dir->indentation; $i++) { echo "&nbsp;";}
			?>
			<div>&nbsp;</div>
			<a href="catalogue_liste_articles.php?id_catalogue_client_dir=<?php echo $catalogue_dir->id_catalogue_client_dir;?>"><?php echo htmlentities($catalogue_dir->lib_catalogue_client_dir);?></a>
			</li>
			<?php
		} else {
			?>
			<li class="sub_categ"><?php
			for ($i=1; $i < $catalogue_dir->indentation; $i++) { echo "&nbsp;";}
			?>
			<a href="catalogue_liste_articles.php?id_catalogue_client_dir=<?php echo $catalogue_dir->id_catalogue_client_dir;?>"><?php echo htmlentities($catalogue_dir->lib_catalogue_client_dir);?></a>
			</li>
		<?php
		}
		$main_categorie = 2;
	}
}
?>
</ul>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="liste_resultat_articles">
	<tr>
		<td class="lightbg_liste1">&nbsp;</td>
		<td class="lightbg_liste"></td>
		<td class="lightbg_liste2">&nbsp;</td>
	</tr>
	<tr>
		<td class="lightbg_liste">&nbsp;</td>
		<td class="lightbg_liste">

<table  border="0" cellspacing="0" cellpadding="0" style="width:100%">
	<tr>
		<td>
		<?php 
		if (count($catalogue_client_dir_parents)) {
			?>
			<div>
			<?php 
			for ($i = count($catalogue_client_dir_parents)-1; $i >= 0; $i--) {
				?>
				-- <span style=" <?php if (!$i) {?>font-weight:bolder<?php } ?>" class="catalogue">
				<a href="catalogue_liste_articles.php?id_catalogue_client_dir=<?php echo $catalogue_client_dir_parents[$i]->id_catalogue_client_dir;?>">
				<?php echo ($catalogue_client_dir_parents[$i]->lib_catalogue_client_dir);?>
				</a>
				</span>
	
				<?php
			}
			?>
			</div>
			<?php
		}
		?>

		<div class="catalogue">
		<table width="100%"  border="0" cellspacing="3" cellpadding="0" class="catalogue">
			<tr>
				<td width="49%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td width="2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td width="49%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
				<td colspan="3">
		<?php 
		if (count($catalogue_client_dir_parents)) {
			?>
				<?php 
				$row_tab= 0;
				$sous_categorie = 0;
				foreach ($catalogue_client_dir_childs as $catalogue_client_dir_child) {
					if ($sous_categorie) { echo ",";}
					?>
					<a href="catalogue_liste_articles.php?id_catalogue_client_dir=<?php echo $catalogue_client_dir_child->id_catalogue_client_dir;?>"><?php echo htmlentities($catalogue_client_dir_child->lib_catalogue_client_dir);?></a>
					<?php
					$sous_categorie ++;
				}
				?>
				<br />
			<?php
		}
		?>

				<div>
				
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
					<tr class="colorise0">
						<td style="width:15%" class="colorise0_debut" >&nbsp;
						
						</td>
						<td>
							<a href="catalogue_liste_articles.php?id_catalogue_client_dir=<?php  if (isset($_REQUEST["id_catalogue_client_dir"])){ echo $_REQUEST["id_catalogue_client_dir"];}?>&orderby=lib_article&orderorder=<?php if ((isset($_REQUEST["orderby"]) && isset($_REQUEST["orderorder"])) &&($_REQUEST['orderorder']=="ASC" && $_REQUEST['orderby']=="lib_article")) {echo "DESC";} else {echo "ASC";}?>"  id="order_simple_lib">Libell&eacute;
							</a>
						</td>
						<td style="width:15%; text-align:center">
							<a href="catalogue_liste_articles.php?id_catalogue_client_dir=<?php  if (isset($_REQUEST["id_catalogue_client_dir"])){ echo $_REQUEST["id_catalogue_client_dir"];}?>&orderby=ref_interne&orderorder=<?php if ((isset($_REQUEST["orderby"]) && isset($_REQUEST["orderorder"]))&& ($_REQUEST["orderorder"]=="ASC" && $_REQUEST['orderby']=="ref_interne")) {echo "DESC";} else {echo "ASC";}?>"  id="order_simple_ref">R&eacute;f&eacute;rence
							</a>
						</td>
						<td style="width:12%; text-align:center">Dispo</td>
						<td style="width:12%; text-align:right">
							Prix unitaire 
							<?php if ($app_tarifs_s == "HT") {echo "HT";} else { echo "TTC";}?>
						</td>
						<td style="width:10%; text-align:right; padding-right:10px;">Qté</td>
						<td style="width:12%; text-align:center" class="colorise0_fin" >&nbsp;
						</td>
					</tr>
				<?php 
				$colorise=0;
				foreach ($fiches as $fiche) {
				$colorise++;
				$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
				?>
				<tr class="<?php  echo  $class_colorise?>">
					<td class="colorise_td_deco" >
					<!--<a href="catalogue_article_view.php?ref_article=<?php echo $fiche->ref_article;?>">-->
					<table width="100" border="0" cellspacing="0" cellpadding="0" class="art_img_cadre">
						<tr>
							<td class="art_img_cadre1"> </td>
							<td class="art_img_cadrea"> </td>
							<td class="art_img_cadre2"> </td>
						</tr>
						<tr>
							<td class="art_img_cadreb"> </td>
							<td class="art_img_cadree">
								<?php 
								if (isset($fiche->lib_file) && $fiche->lib_file != "") {
								$size = getimagesize($ARTICLES_MINI_IMAGES_DIR.$fiche->lib_file);
								
									?>
									<img src="<?php echo $ARTICLES_MINI_IMAGES_DIR.$fiche->lib_file;?>" id="id_img_line_<?php echo ($fiche->ref_article)?>" <?php if ($size[0] > $size[1]) { ?> width="55"	<?php } else {?> height="55" <?php } ?> border="0" />
									<?php
								} else {
									?>
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" id="" width="55" height="55" border="0" />
									<?php 
								}
								?>
							</td>
							<td class="art_img_cadrec"> </td>
						</tr>
						<tr>
							<td class="art_img_cadre3"> </td>
							<td class="art_img_cadred"> </td>
							<td class="art_img_cadre4"> </td>
						</tr>
					</table>
					<!--</a>-->
					</td>
					<td class="colorise_td_deco">
						<span class="lib_categorie"><?php	if ($fiche->lib_art_categ) 				{ echo htmlentities($fiche->lib_art_categ); }?></span> - <span class="lib_constructor"><?php	if ($fiche->nom_constructeur) { echo htmlentities($fiche->nom_constructeur)."&nbsp;";}?></span><br />
						<span class="r_art_lib"><?php echo nl2br(($fiche->lib_article))?></span><br />

						<span class="r_art_desc_courte"><?php echo nl2br(($fiche->desc_courte))?></span>
						
					</td>
					<td class="colorise_td_deco">
						<div class="reference"><?php	if ($fiche->ref_interne!="") { echo htmlentities($fiche->ref_interne)."&nbsp;";}else{ echo htmlentities($fiche->ref_article)."&nbsp;";}?>
						</div>
					</td>
					<td class="colorise_td_deco" style="text-align:center">
						<a href="#" id="aff_resume_stock_<?php echo ($fiche->ref_article);?>">
						<?php	if (isset($fiche->stock)) { ?><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/stock_dispo.gif" /><?php } else { ?><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/stock_vide.gif" /><?php }?>
						</a>
					</td>
					<td class="colorise_td_deco">
					
					<div class="prix_unitaire" style="display:<?php if ((!$_SESSION['user']->getLogin() && !$AFF_CAT_PRIX_VISITEUR) || ($_SESSION['user']->getLogin() && !$AFF_CAT_PRIX_CLIENT)) {?>none;<?php }?>">
					<div id="aff_tarif_ht_<?php echo $colorise;?>" style="display:<?php if ($app_tarifs_s != "HT") { echo "none";}?>">
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
					<div id="aff_tarif_ttc_<?php echo $colorise;?>" style="display:<?php if ($app_tarifs_s != "TTC") { echo "none";}?>">
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
					</div>
					</td>
					<td class="colorise_td_deco" style="text-align:right">
					<input name="qte_art_<?php echo $colorise;?>" id="qte_art_<?php echo $colorise;?>" type="text" size="3" value="" class="input_add_panier" />
					</td>
					<td class="colorise_td_deco" style="vertical-align:middle; text-align:center">
					<a  href="#" id="link_art_add_panier_<?php echo htmlentities($fiche->ref_article)?>" style="display:block; width:100%; text-decoration:underline"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier.gif" title="Ajouter au panier" alt="Ajouter au panier" /></a>
					
				<script type="text/javascript">
			Event.observe('link_art_add_panier_<?php echo htmlentities($fiche->ref_article)?>', 'click',  function(evt){
				Event.stop(evt);
					if  (parseFloat($("qte_art_<?php echo $colorise;?>").value) != "" || !isNaN(parseFloat($("qte_art_<?php echo $colorise;?>").value))) {
						$("qte_art_<?php echo $colorise;?>").value = parseFloat($("qte_art_<?php echo $colorise;?>").value)+1;
					}
				if  (parseFloat($("qte_art_<?php echo $colorise;?>").value) == "" || isNaN(parseFloat($("qte_art_<?php echo $colorise;?>").value))) {
					$("qte_art_<?php echo $colorise;?>").value = "1";
				}
				
				var AppelAjax = new Ajax.Updater(
									"panier", 
									"catalogue_panier_add_article.php", 
									{
									method: 'post',
									asynchronous: true,
									contentType:  'application/x-www-form-urlencoded',
									encoding:     'UTF-8',
									parameters: { ref_article: '<?php echo htmlentities($fiche->ref_article)?>', qte_article: $("qte_art_<?php echo $colorise;?>").value },
									evalScripts:true
									}
									);
			}, false);
				</script>	
					</td>
					</tr>
					
				<?php
				}
				?></table>
				
				
				<div id="affresult">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="colorise0" >
					<tr>
						<td style="text-align:left; padding-left:5px" class="colorise0_debut" >R&eacute;sultat de la recherche :</td>
						<td id="nvbar"><?php echo str_replace("link_", "link2_",$barre_nav);?></td>
						<td style="text-align:right; padding-right:5px"  class="colorise0_fin" >R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($fiches)?> sur <?php echo $nb_fiches?></td>
					</tr>
				</table>
				</div>
				
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							Afficher les prix 
							<input  name="taxation" type="radio" id="taxation_ht" value="HT" <?php if ($app_tarifs_s == "HT") {?> checked="checked"<?php }?>>HT
							<input  name="taxation" id="taxation_ttc" type="radio" value="TTC" <?php if ($app_tarifs_s == "TTC") {?> checked="checked"<?php }?>>TTC
						</td>
						<td>&nbsp;</td>
						<td style="width:30%"></td>
						<td style="width:5%">&nbsp;</td>
						<td style="width:25%"></td>
					</tr>
				</table>
				</div>
				</td>
			</tr>
		</table>

		</div>
		
		</td>
	</tr>
</table>
<SCRIPT type="text/javascript">


Event.observe('taxation_ttc', "click", function(evt){
	window.open("catalogue_liste_articles.php?id_catalogue_client_dir=<?php  if (isset($_REQUEST["id_catalogue_client_dir"])){ echo $_REQUEST["id_catalogue_client_dir"];}?>&app_tarifs_s=TTC<?php 
	if (isset($_REQUEST["orderby"]) && isset($_REQUEST["orderorder"])) {
	echo  '&orderby='.$_REQUEST["orderby"].'&orderorder='.$_REQUEST["orderorder"];
	}?>", "_self");
	
});
Event.observe('taxation_ht', "click", function(evt){
	window.open("catalogue_liste_articles.php?id_catalogue_client_dir=<?php  if (isset($_REQUEST["id_catalogue_client_dir"])){ echo $_REQUEST["id_catalogue_client_dir"];}?>&app_tarifs_s=HT<?php 
	if (isset($_REQUEST["orderby"]) && isset($_REQUEST["orderorder"])) {
	echo  '&orderby='.$_REQUEST["orderby"].'&orderorder='.$_REQUEST["orderorder"];
	}?>", "_self");
});

</SCRIPT>
		</td>
		<td class="lightbg_liste">&nbsp;</td>
	</tr>
	<tr>
		<td class="lightbg_liste4"></td>
		<td class="lightbg_liste">&nbsp;</td>
		<td class="lightbg_liste3">&nbsp;</td>
	</tr>
</table>
</div><br />

</div>
		</td>
	</tr>
</table>
<?php include("content_after.php"); ?>

<?php include("bottom.php"); ?>

<?php include("footer.php"); ?>
