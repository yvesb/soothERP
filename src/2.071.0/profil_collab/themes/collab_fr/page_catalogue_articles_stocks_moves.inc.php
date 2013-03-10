<?php

// *************************************************************************************************************
// AFFICHAGE DES MOUVEMENTS DE STOCK
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
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
	$debut =(($form['page_to_show']-1)*$form['fiches_par_page']);
	
	$barre_nav .= barre_navigation($nb_fiches, $form['page_to_show'], 
                                       $form['fiches_par_page'], 
                                       $debut, $cfg_nb_pages,
                                       'page_to_show_s',
																			 'page.article_stock_mouvements_result("'.$id_stock.'")');

?>
<script type="text/javascript">
</script>

<div   class="mt_size_optimise">
<input type="hidden" id="stock_move_id_stock" name="stock_move_id_stock" value="<?php echo $id_stock?>"/>
<div style="padding-left:10px; padding-right:10px">
<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo $barre_nav;?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($stocks_moves)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

	<tr class="colorize_1">
		<td style="font-size:10px; font-weight:bolder;text-align:left; width:100px;">
		<div style="width:100px">
		Date
		</div>
		</td>
		<td style="text-align:left; font-weight:bolder; width:120px;">
		<div style="width:120px; text-align:left">
		Référence
		</div>
		</td>
		<td style="text-align:left;font-weight:bolder;">
		<div style="width:120px">
		Etat
		</div>
		</td>
		<td style="text-align:left; font-weight:bolder;width:170px;">
		<div style="text-align:left; width:170px;">			
		Contact
		</div>
		</td>
		<td style="text-align:left;font-weight:bolder;">
			<div style="width:170px">
			Utilisateur
			</div>
		</td>
		<td style="font-size:10px;font-weight:bolder; padding-right:10px; text-align:right; width:35px">
			<div style="width:35px;">Entrée
			</div>
		</td>
		<td style="font-size:10px; font-weight:bolder;padding-right:10px; text-align:right; width:35px">
			<div style="width:35px;">Sortie
			</div>
		</td>
		<td style="font-size:10px; font-weight:bolder;padding-right:10px; text-align:right; width:35px">
			<div style="width:55px;">En stock
			</div>
		</td>
		<td style="font-size:10px; font-weight:bolder;text-align:right; width:120px">
		<div style="width:120px">
		Stock
		</div>
		</td>
	</tr>
<?php 
$colorise=0;
$indentation=0;
foreach ($stocks_moves as $stock_move) {
$id_type_groupe = document::Id_type_groupe($stock_move->id_type_doc);
if ( ($_SESSION['user']->check_permission ("25", $stock_move->id_type_doc) && $id_type_groupe==1) || ($_SESSION['user']->check_permission ("28", $stock_move->id_type_doc) && $id_type_groupe==2) || ($_SESSION['user']->check_permission ("31", $stock_move->id_type_doc) && $id_type_groupe==3)){
	
if (	isset($stocks_moves[$indentation - 1]) && $stocks_moves[$indentation - 1]->ref_doc == $stock_move->ref_doc	&& isset($stocks_moves[$indentation - 1]->id_type_doc)	&& $stocks_moves[$indentation - 1]->id_type_doc == $INVENTAIRE_ID_TYPE_DOC 
			) {$indentation++; continue;}
$indentation++;
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
	?>
	
	<tr class="<?php  echo  $class_colorise?>" style=" ">
		<td style="font-size:10px; text-align:left; width:100px;">
		<div style="width:100px;<?php 
	if (isset($stock_move->id_type_doc)	&& $stock_move->id_type_doc == $INVENTAIRE_ID_TYPE_DOC ) {
		echo 'font-weight:bolder;';
	}
	?>">
		<?php echo date_Us_to_Fr($stock_move->date);?> <?php echo getTime_from_date($stock_move->date);?>
		</div>
		</td>
		<td style="text-align:left; font-weight:bolder; width:120px;">
		<div style="width:120px; text-align:left;<?php 
	if (isset($stock_move->id_type_doc)	&& $stock_move->id_type_doc == $INVENTAIRE_ID_TYPE_DOC ) {
		echo 'font-weight:bolder;';
	}
	?>">
		<a href="#" id="doc_stock_move_<?php echo htmlentities($stock_move->ref_stock_move);?>" style="color:#000000; text-decoration:none"><?php echo htmlentities($stock_move->ref_doc);?></a>
		</div>
		<script type="text/javascript">
		Event.observe("doc_stock_move_<?php echo htmlentities($stock_move->ref_stock_move);?>", "click",  function(evt){
			Event.stop(evt); 
			page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($stock_move->ref_doc)?>'),'true','_blank');
		}, false);
		</script>
		</td>
		<td style="text-align:left;">
		<div style="width:120px;<?php 
	if (isset($stock_move->id_type_doc)	&& $stock_move->id_type_doc == $INVENTAIRE_ID_TYPE_DOC ) {
		echo 'font-weight:bolder;';
	}
	?>">
			<?php echo htmlentities($stock_move->lib_etat_doc);?>
		</div>
		</td>
		<td style="text-align:left; width:170px;">
		<div style="text-align:left; width:170px;">			
		<?php if (isset($stock_move->nom_contact_doc)) { 
			?>
			<div style="width:170px;<?php 
	if (isset($stock_move->id_type_doc)	&& $stock_move->id_type_doc == $INVENTAIRE_ID_TYPE_DOC ) {
		echo 'font-weight:bolder;';
	}
	?>">
			<a href="#" id="contact_doc_stock_move_<?php echo htmlentities($stock_move->ref_stock_move);?>" style="color:#000000; text-decoration:none">
				<?php echo htmlentities($stock_move->nom_contact_doc); ?></a>
			</div>
			<script type="text/javascript">
			Event.observe("contact_doc_stock_move_<?php echo htmlentities($stock_move->ref_stock_move);?>", "click",  function(evt){
				Event.stop(evt); 
				page.verify('annuaire_view_fiche','index.php#'+escape('annuaire_view_fiche.php?ref_contact=<?php echo htmlentities($stock_move->ref_contact_doc)?>'),'true','_blank');
			}, false);
			</script>
			<?php
		}
		?>
		</div>
		</td>
		<td style="text-align:left;">
		<?php if (isset($stock_move->nom)) { 
			?>
			<div style="width:170px;<?php 
	if (isset($stock_move->id_type_doc)	&& $stock_move->id_type_doc == $INVENTAIRE_ID_TYPE_DOC ) {
		echo 'font-weight:bolder;';
	}
	?>">
			<a href="#" id="contact_stock_move_<?php echo htmlentities($stock_move->ref_stock_move);?>" style="color:#000000; text-decoration:none">
				<?php echo htmlentities($stock_move->nom); ?></a>
			</div>
			<script type="text/javascript">
			Event.observe("contact_stock_move_<?php echo htmlentities($stock_move->ref_stock_move);?>", "click",  function(evt){
				Event.stop(evt); 
				page.verify('annuaire_view_fiche','index.php#'+escape('annuaire_view_fiche.php?ref_contact=<?php echo htmlentities($stock_move->ref_contact)?>'),'true','_blank');
			}, false);
			</script>
			<?php
		}
		?>
		</td>
		<td style="font-size:10px; padding-right:10px; text-align:right; width:35px">
			<div style="width:35px;<?php 
	if (isset($stock_move->id_type_doc)	&& $stock_move->id_type_doc == $INVENTAIRE_ID_TYPE_DOC ) {
		echo 'font-weight:bolder;';
	}
	?>" id="aff_resume_stock_sn_<?php echo qte_format($stock_move->ref_stock_move);?>">
			<?php if ($stock_move->qte >=0 && $stock_move->id_type_doc != $INVENTAIRE_ID_TYPE_DOC) { echo htmlentities($stock_move->qte);}?>
			</div>
			<script type="text/javascript">
			//Event.observe("aff_resume_stock_sn_<?php echo $stock_move->ref_stock_move;?>", "click", function(evt){
			//	show_resume_stock_sn("<?php echo $stock_move->ref_stock_move;?>", evt); 
			//	Event.stop(evt);
			//}, false);
			</script>
		</td>
		<td style="font-size:10px; padding-right:10px; text-align:right; width:35px">
			<div style="width:35px;<?php 
	if (isset($stock_move->id_type_doc)	&& $stock_move->id_type_doc == $INVENTAIRE_ID_TYPE_DOC ) {
		echo 'font-weight:bolder;';
	}
	?>" id="aff_resume_stock_sn2_<?php echo qte_format($stock_move->ref_stock_move);?>">
			<?php if ($stock_move->qte <0 && $stock_move->id_type_doc != $INVENTAIRE_ID_TYPE_DOC) { echo htmlentities($stock_move->qte);}?>
			</div>
			<script type="text/javascript">
			//Event.observe("aff_resume_stock_sn2_<?php echo $stock_move->ref_stock_move;?>", "click", function(evt){
			//	show_resume_stock_sn("<?php echo $stock_move->ref_stock_move;?>", evt); 
			//	Event.stop(evt);
			//}, false);
			</script>
		</td>
		<td style="font-size:10px; padding-right:10px; text-align:right; width:55px">
			<div style="width:55px;<?php 
	if (isset($stock_move->id_type_doc)	&& $stock_move->id_type_doc == $INVENTAIRE_ID_TYPE_DOC ) {
		echo 'font-weight:bolder;font-size:11px;';
	}
	?>">
			<?php
			if ($stock_move->id_type_doc == $INVENTAIRE_ID_TYPE_DOC) {
				echo "<span style='";
				$decompte_stock = $stock_move->qte;
				if ((isset($stocks_moves[$indentation]) && abs($stocks_moves[$indentation]->qte) != abs($stock_move->qte)) ||( isset($var_line_inv_erreur) && $var_line_inv_erreur) || ( isset($var_line_inv_last_erreur) )) {
					$var_line_inv_errreur = false;
					
					echo "color: #FF0000' title='stock attendu ";
					if (isset($var_line_inv_last_erreur)) {
						echo ($var_line_inv_last_erreur);
						$qte_stock = $var_line_inv_last_erreur;
					} else {
						echo (($stocks_moves[$indentation]->qte)*-1);
						$qte_stock = (($stocks_moves[$indentation]->qte)*-1);
					}
					echo "'>".qte_format($decompte_stock)."</span>";
					$decompte_stock = $qte_stock;
				} else {
					echo "color: #00FF00";
					echo "'>".qte_format($decompte_stock)."</span>";
				}
				
			} else {
				echo qte_format($decompte_stock);
				$decompte_stock -= $stock_move->qte;
			} 
			?>
			</div>
		</td>
		<td style="font-size:10px; text-align:right; width:120px">
		<div style="width:120px;<?php 
	if (isset($stock_move->id_type_doc)	&& $stock_move->id_type_doc == $INVENTAIRE_ID_TYPE_DOC ) {
		echo 'font-weight:bolder;';
	}
	?>">
			<?php
			if ($stock_move->abrev_stock) {
			echo htmlentities($stock_move->abrev_stock);
			} else {
			echo htmlentities($stock_move->lib_stock);
			}
			?>
		</div>
		</td>
	</tr>
	<?php
	}
}
?>
</table>
<div id="affresult">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
		<td id="nvbar"><?php echo str_replace("link_", "link2_",$barre_nav);?></td>
		<td style="text-align:right;">R&eacute;ponse <?php echo $debut+1?> &agrave; <?php echo $debut+count($stocks_moves)?> sur <?php echo $nb_fiches?></td>
	</tr>
</table>
</div>
</div>

<iframe frameborder="0" scrolling="no" src="about:_blank" id="resume_stock_move_sn_iframe" class="resume_stock_iframe"></iframe>
<div id="resume_stock_move_sn" class="resume_stock">
</div>
</div>