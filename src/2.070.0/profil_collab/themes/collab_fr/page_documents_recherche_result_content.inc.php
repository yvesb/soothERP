<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "fiches",  "form['page_to_show']", "form['fiches_par_page']", "nb_fiches", "form['orderby']", "form['orderorder']");
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
																			 'page.documents_recherche_avancee()');





// Affichage des résultats
$montant_total_page = 0;
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

<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:25px">
		</td>
		<td style="width:10%">
			<a href="#"  id="order_ref_doc">R&eacute;f&eacute;rence
			</a>
		</td>
		<td style="width:18%; text-align:left">
			<a href="#"  id="order_type_doc">Type de Document
			</a>
		</td>
		<td style="width:14%; text-align:center">
			<a href="#"  id="order_etat_doc">&Eacute;tat
			</a>
		</td>
		<td style=" text-align:left">
			<a href="#"  id="order_contact_doc">Contact
			</a>
		</td>
		<td style="width:9%; text-align:center">
			<a href="#"  id="order_montant_doc">
			Montant TTC
			</a>
		</td>
		<td style="width:10%; text-align:center">
			<a href="#"  id="order_date_doc">
			Date
			</a>
		</td>
		<td style="width:5%"></td>
		<td style="width:95px"></td>
	</tr>
<?php 
$colorise=0;
$indentation = 0;
$montant_taxe = 0;
foreach ($fiches as $fiche) {
		if($_SESSION['user']->check_permission ("6") || $fiche->id_type_groupe!=2){
$colorise++;
$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
?>
<tr class="<?php  echo  $class_colorise?>">
	<td style="width:25px">
	<input id="check_<?php echo $indentation;?>" name="check_<?php echo $indentation;?>" type="checkbox" value="<?php	if ($fiche->ref_doc) { echo ($fiche->ref_doc);}?>"/>
	</td>
	<td class="reference">
		<a  href="#" id="link_ref_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%">
		<?php	if ($fiche->ref_doc) { echo ($fiche->ref_doc)."&nbsp;";}?>		
		</a>
	<script type="text/javascript">
	Event.observe("link_ref_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','documents_edition.php?ref_doc=<?php echo ($fiche->ref_doc)?>','true','sub_content');}, false);
	</script>
	</td>
	<td>
		<a  href="#" id="link_type_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%">
		<span class="r_doc_lib"><?php echo nl2br(($fiche->lib_type_doc))?></span>
		</a>
	<script type="text/javascript">
	Event.observe("link_type_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','documents_edition.php?ref_doc=<?php echo ($fiche->ref_doc)?>','true','sub_content');}, false);
	</script>
	</td>
	<td style="text-align:center">
		<a  href="#" id="link_etat_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%">
		<?php	if ($fiche->lib_etat_doc) { echo ($fiche->lib_etat_doc); }?>&nbsp;
		</a>
	<script type="text/javascript">
	Event.observe("link_etat_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','documents_edition.php?ref_doc=<?php echo ($fiche->ref_doc)?>','true','sub_content');}, false);
	</script>
	</td>
	<td style="text-align:left">
		<a  href="#" id="link_contact_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%" alt="<?php	if ($fiche->nom_contact) { echo ($fiche->nom_contact); }?>" title="<?php	if ($fiche->nom_contact) { echo ($fiche->nom_contact); }?>">
		<?php	if ($fiche->nom_contact) { echo (substr(str_replace("€", "&euro;", $fiche->nom_contact), 0, 38)); }?>&nbsp;
		</a>
	<script type="text/javascript">
	Event.observe("link_contact_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','documents_edition.php?ref_doc=<?php echo ($fiche->ref_doc)?>','true','sub_content');}, false);
	</script>
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
	<td style="text-align:right; padding-right:5px">
		<a  href="#" id="link_montant_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%">
		<?php	if ($fiche->montant_ttc) { echo number_format($fiche->montant_ttc+$montant_taxe, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; $montant_total_page +=$fiche->montant_ttc; }?>&nbsp;
		</a>
	<script type="text/javascript">
	Event.observe("link_montant_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','documents_edition.php?ref_doc=<?php echo ($fiche->ref_doc)?>','true','sub_content');}, false);
	</script>
	</td>
	<td style="text-align:center">
		<a  href="#" id="link_date_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%">
		<?php	if ($fiche->date_doc) { echo (date_Us_to_Fr($fiche->date_doc)); }?>&nbsp;
		</a>
	<script type="text/javascript">
	Event.observe("link_date_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','documents_edition.php?ref_doc=<?php echo ($fiche->ref_doc)?>','true','sub_content');}, false);
	</script>
	</td>
	<td style="vertical-align:middle; text-align:center">
	<a  href="#" id="link_edit_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%; text-decoration:underline">Editer</a>
	<script type="text/javascript">
	Event.observe("link_edit_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo ($fiche->ref_doc)?>'),'true','_blank');}, false);
	</script>
	</td>
	<td style="vertical-align:middle; text-align:center">
	<a href="#" id="mail_doc_<?php echo $fiche->ref_doc?>" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-email-doc.gif"/></a> 
	<a href="documents_editing.php?ref_doc=<?php echo $fiche->ref_doc?>" target="_blank" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif"/></a> 
	<a href="documents_editing.php?ref_doc=<?php echo $fiche->ref_doc?>&print=1" target="_blank" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/icone_imprime.gif" alt="Imprimer" title="Imprimer"/></a>
	
	<script type="text/javascript">
	Event.observe("mail_doc_<?php echo $fiche->ref_doc?>", "click", function(evt){
	Event.stop(evt);
	var top=(screen.height-350)/2;
	var left=(screen.width-500)/2;
	window.open("documents_editing_email.php?ref_doc=<?php echo $fiche->ref_doc?>&mode_edition=2","","top="+top+",left="+left+",width=500,height=350,menubar=no,statusbar=no,scrollbars=yes,resizable=yes");
	});		
	</script>
	</td>
	</tr>
	
<?php
$indentation++;
		}
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

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
	<tr>
		<td rowspan="2" style="width:33px">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/arrow_ltr.png" />
		</td>
		<td style="height:4px; line-height:4px">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="4px" width="100%"/>
		</td>
		<td style="height:4px; line-height:4px">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" height="4px" width="100%"/>
		</td>
	</tr>
	<tr>
		<td style="width:325px;">
			<a href="#" id="all_coche" class="doc_link_simple">Tout cocher</a> / <a href="#" id="all_decoche" class="doc_link_simple">Tout d&eacute;cocher</a> / <a href="#" id="all_inv_coche" class="doc_link_simple">Inverser la s&eacute;lection</a> 
		</td>
		<td style="" >
			<select id="coche_action_s" name="coche_action_s" class="classinput_nsize">
				<option value="">Pour la s&eacute;lection</option>
				<option value="print">Imprimer</option>
				<option value="annuler_docs">Annuler les documents</option>
				<?php 
				switch ($form["id_type_doc"]) {
					case 1:{//DEV
						if(						$form["id_etat_doc"] == 3){?>
						<option value="DEV_enAttente_to_refuse">Refuser</option>
						<?php }elseif($form["id_etat_doc"] == 1){?>
						<option value="DEV_aRealiser_to_attenteReponseClient">En attente réponse client</option>
						<?php }
					break;}
					case 2:{//CDC
						if(						$form["id_etat_doc"] == 9){?>
						<option value="CDC_enCours_generate_BLC_enSaisie">Générer les BLC</option>
						<?php }
					break;}
					case 3:{//BLC
						if(						$form["id_etat_doc"] == 13){?>
						<option value="BLC_pretAuDepart_to_livrer">Livrer</option>
						<?php }elseif($form["id_etat_doc"] == 11){?>
						<option value="BLC_enSaisie_to_pretAuDepart">Prêt au départ</option>
						<?php }
					break;}
					case 4:{//FAC
						if(						$form["id_etat_doc"] == 16){?>
						<option value="FAC_enSaisie_to_aRegler">A régler</option>
						<?php }
					break;}
				}?>
			</select>
		</td>
	</tr>
</table><br />
<script type="text/javascript">

Event.observe("all_coche", "click", function(evt){
	Event.stop(evt); 
	coche_line_search_docs ("coche", "", <?php echo $indentation;?>);
});
Event.observe("all_decoche", "click", function(evt){
	Event.stop(evt); 
	coche_line_search_docs ("decoche", "", <?php echo $indentation;?>);
});
Event.observe("all_inv_coche", "click", function(evt){
	Event.stop(evt); 
	coche_line_search_docs ("inv_coche", "", <?php echo $indentation;?>);
});
	
Event.observe("coche_action_s", "change", function(evt){
if ($("coche_action_s").value != "") {
action_recherche($("coche_action_s").value, "" , <?php echo $indentation;?>);
}
});		
</script>

</div>
<br />
<br />
<?php 
if ($DOCUMENT_RECHERCHE_MONTANT_TOTAL) {
	?>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:25px">
		</td>
		<td style="width:10%">
		</td>
		<td style="width:18%; text-align:left">
		</td>
		<td style="width:14%; text-align:center">
		</td>
		<td style=" text-align:left">
		MONTANT TOTAL: 
		</td>
		<td style="width:9%; text-align:center">
		<?php echo number_format($montant_total_page, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]?>
		</td>
		<td style="width:10%; text-align:center">
		</td>
		<td style="width:5%"></td>
		<td style="width:95px"></td>
	</tr>
	</table>
	<?php
}
?>
<br />
<br />
<br />
<br />
<br />
</div>

<script type="text/javascript">
Event.observe("order_ref_doc", "click",  function(evt){Event.stop(evt); $('orderby').value='ref_doc'; $('orderorder').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="ref_doc") {echo "DESC";} else {echo "ASC";}?>'; page.documents_recherche_avancee();}, false);
Event.observe("order_type_doc", "click",  function(evt){Event.stop(evt); $('orderby').value='lib_type_doc'; $('orderorder').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="lib_type_doc") {echo "DESC";} else {echo "ASC";}?>'; page.documents_recherche_avancee();}, false);
Event.observe("order_etat_doc", "click",  function(evt){Event.stop(evt); $('orderby').value='lib_etat_doc'; $('orderorder').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="lib_etat_doc") {echo "DESC";} else {echo "ASC";}?>'; page.documents_recherche_avancee();}, false);
Event.observe("order_contact_doc", "click",  function(evt){Event.stop(evt); $('orderby').value='nom_contact'; $('orderorder').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="nom_contact") {echo "DESC";} else {echo "ASC";}?>'; page.documents_recherche_avancee();}, false);
Event.observe("order_montant_doc", "click",  function(evt){Event.stop(evt); $('orderby').value='montant_ttc'; $('orderorder').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="montant_ttc") {echo "DESC";} else {echo "ASC";}?>'; page.documents_recherche_avancee();}, false);
Event.observe("order_date_doc", "click",  function(evt){Event.stop(evt); $('orderby').value='date_doc'; $('orderorder').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="date_doc") {echo "DESC";} else {echo "ASC";}?>'; page.documents_recherche_avancee();}, false);


//on masque le chargement
H_loading();
</SCRIPT>