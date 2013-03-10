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
                                       'page_to_show_c',
																			 'page.documents_recherche_cmde()');





// Affichage des résultats
$montant_total_page_ht = 0;
$montant_total_page_ttc = 0;
?><br />

<div   class="mt_size_optimise">
<br />

	<?php 
	$colorise = 0;
	$montant = 0;
	?>
	<?php 
		foreach ($fiches as $fiche) {
	$montant++;
	?> 
	
<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
			
			<tr >
				<td style="width:24%"> <hr style="height: 2px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>  </td>
				<td style="width:19%"> <hr style="height: 2px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>   </td>
				<td style="width:12%"> <hr style="height: 2px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>   </td>
				<td style="width:35%"> <hr style="height: 2px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>  </td>
				<td style="width:8%"> <hr style="height: 2px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>  </td>
			</tr>
			
			<tr style="background-color: #c2cfd7">

				<td style="width:24%">
					<a  href="#" id="link_ref_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%">
					<?php	if ($fiche->ref_doc) { echo ($fiche->ref_doc)." du ".str_replace("-","/",(date_Us_to_Fr($fiche->date_doc))) ;}?>		
					</a>
					<script type="text/javascript">
					Event.observe("link_ref_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo ($fiche->ref_doc)?>'),'true','_blank');}, false);
					</script>
				</td>
				
				<td style="width:19% ; font-weight:bold" >
					<a  href="#" id="link_type_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%">
					<?php	if ($fiche->nom_contact) { echo (substr(str_replace("€", "&euro;", $fiche->nom_contact), 0, 38)); }?>&nbsp;
					</a>
					<script type="text/javascript">
					Event.observe("link_type_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo ($fiche->ref_doc)?>'),'true','_blank');}, false);
					</script>
				</td>
				
				<td style="width:12% ; text-align:center ; color:#868486">
					<?php if ($fiche->id_etat_doc == 9) { ?>
					<a  href="#" id="link_etat_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="display:block; width:100%">[
					<?php	echo htmlentities($fiche->lib_etat_doc); } ?>
				
					<?php if ($fiche->id_etat_doc == 6) { ?>
					<a  href="#" id="link_etat_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="color:red;display:block; width:100%">[
					<?php	echo htmlentities($fiche->lib_etat_doc); } ?>

                                         <?php if ($fiche->id_etat_doc == 11) { ?>
					<a  href="#" id="link_etat_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="color:red;display:block; width:100%">[
					<?php	echo htmlentities($fiche->lib_etat_doc); } ?>
                                            
                                        <?php if ($fiche->id_etat_doc == 13) { ?>
					<a  href="#" id="link_etat_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="display:block; width:100%">[
					<?php	echo htmlentities($fiche->lib_etat_doc); } ?>

					<?php if ($fiche->id_etat_doc == 8) { ?>
					<a  href="#" id="link_etat_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="display:block; width:100%">[
					<?php	echo htmlentities($fiche->lib_etat_doc); } ?>
					]
					</a>
					<script type="text/javascript">
					Event.observe("link_etat_doc_<?php echo htmlentities($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($fiche->ref_doc)?>'),'true','_blank');}, false);
					</script>
				</td>
				<?php
                                $cmd_doc = open_doc($fiche->ref_doc);
                                
                                 if(empty($search['cmdeaprep'])){?>
                                    <td style="width:35%; text-align:center">
                                            <span id="commande_genere_livraison_<?php echo htmlentities($fiche->id_stock."_".$fiche->ref_doc);?>" style="color:green; cursor:pointer; display:"> <?php if ($cmd_doc->getDate_livraison ()!= 0000-00-00) {echo  ( date_Us_to_Fr ($cmd_doc->getDate_livraison()))."   ";}?>[ LIVRAISON >>]<span/>
                                            <script type="text/javascript">
                                            //generer_document_doc ("generer_bl_client", ref_doc)
                                            Event.observe("commande_genere_livraison_<?php echo htmlentities($fiche->id_stock."_".$fiche->ref_doc);?>", "click", function(evt){
                                            Event.stop(evt); 
                                            //generer_document_doc ("generer_bl_client", "<?php echo $fiche->ref_doc;?>");
                                            page.verify('documents_edition_generer_blank', 'index.php#'+escape('documents_edition_generer_blank.php?fonction_generer=generer_bl_client&ref_doc=<?php echo $fiche->ref_doc;?>'),'true','_blank');
                                            $("commande_genere_livraison_<?php echo htmlentities($fiche->id_stock."_".$fiche->ref_doc);?>").hide();
                                            }, false);
                                            </script>
                                    </td>
                                <?php unset($cmd_doc);}else{echo "<span>        </span>";}
                                ?>
                                
				
                                <td style="width:8%; text-align:right">
					<a href="documents_editing.php?ref_doc=<?php echo $fiche->ref_doc?>" target="_blank" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif"/></a> 
					<a href="documents_editing.php?ref_doc=<?php echo $fiche->ref_doc?>&print=1" target="_blank" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/icone_imprime.gif" alt="Imprimer" title="Imprimer"/></a>
				</td>
			</tr>
 
</table>


<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
 
<?php if (!empty($detail_art)) { 
	 foreach ($detail_art as $article) {
			if ( ($article->ref_doc == $fiche->ref_doc ) AND ($article->ref_article != 'INFORMATION') AND ($article->ref_article != 'SSTOTAL') AND ( ($article->qte - $article->qte_livree)>0 ) ) {
	?>
		<?php $colorise++; 
			$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
		?>
			<tr class="colorise1">
				<td style="width:2%; text-align:center;">
					<?php
						if (!isset($article->qte_stock) || $article->qte_stock == "") { $article->qte_stock = 0;};
						if ( $article->qte_stock > 0 AND ($article->qte_stock - $article->qte) >= 0 AND $article->modele == "materiel" ) { ?>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/point_vert.gif"/>
						<?php } else { ?>
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/point_rouge.gif"/>
						<?php } ?>
				</td>
				<td style="width:18%; text-align:left;">
					<a  href="#" id="link_art_ref_<?php echo ($article->ref_doc_line);?>" style="display:block; width:100%">
						<?php echo $article->ref_article;?> 
					</a>
					<script type="text/javascript">
					Event.observe("link_art_ref_<?php echo ($article->ref_doc_line);?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo ($article->ref_article)?>'),'true','_blank');}, false);
					</script>
				</td>
	
	
				<td style="width:47%; text-align:left;">
					<?php	 echo ($article->lib_article)."&nbsp;";?>		
				</td>
			
				<td style="width:15%; text-align:center;">
					<span style="text-decoration:underline">
					<a href="#" id="aff_resume_stock_<?php echo ($article->ref_doc_line);?>"><?php echo ($article->qte - $article->qte_livree)."x";?></a>
					</span>
					<script type="text/javascript">
					Event.observe("aff_resume_stock_<?php echo ($article->ref_doc_line);?>", "click", function(evt){show_resume_stock("<?php echo $article->ref_article;?>", evt); Event.stop(evt);}, false);
					</script>
				</td>
				 
				<td style="width:18%; text-align:right">
					<div id="aff_prix_ht_<?php echo $colorise;?>" style="display:<?php if ($_REQUEST["app_tarifs_c"] != "HT") { echo "none";} ?>">
						<?php { echo price_format((($article->pu_ht)*($article->qte)), $TARIFS_NB_DECIMALES, ",", ""	)." ".$MONNAIE[1]." HT"; }?>
					</div>
					<div id="aff_prix_ttc_<?php echo $colorise;?>" style="display:<?php if ($_REQUEST["app_tarifs_c"] != "TTC") { echo "none";} ?>">
						<?php { echo price_format((($article->pu_ttc)*($article->qte)), $TARIFS_NB_DECIMALES, ",", ""	)." ".$MONNAIE[1]." TTC"; }?>	
					</div>
				</td>

			</tr>
			
		<?php if (isset($article->desc_article) AND ($article->desc_article !="")) { ?>
		
			<tr class="colorise1">
	
				<td style="width:2%"></td>
	
				<td style="width:18% ">
				</td>
				
				<td style="width:47%; text-align:center; font-style:italic; text-align:left">
					<?php	 echo ($article->desc_article)."&nbsp;";?>		</td>
				<td style="width:10%; text-align:left"></td>
				<td style="width:5%; text-align:center"></td>
				
				<td style="width:18%; text-align:center"></td>
			</tr>	

		<?php } ?>	
			<tr class="colorise1">
	
				<td style="width:2%"> <hr style="height: 1px;margin:0;padding:0;color:#e6e6e6;background-color:#e6e6e6;border:0"/>  </td>
				<td style="width:18%"> <hr style="height: 1px;margin:0;padding:0;color:#e6e6e6;background-color:#e6e6e6;border:0"/>   </td>
				<td style="width:47%"> <hr style="height: 1px;margin:0;padding:0;color:#e6e6e6;background-color:#e6e6e6;border:0"/>   </td>
				<td style="width:10%"> <hr style="height: 1px;margin:0;padding:0;color:#e6e6e6;background-color:#e6e6e6;border:0"/>  </td>
				<td style="width:5%"> <hr style="height: 1px;margin:0;padding:0;color:#e6e6e6;background-color:#e6e6e6;border:0"/>  </td>
				<td style="width:18%"> <hr style="height: 1px;margin:0;padding:0;color:#e6e6e6;background-color:#e6e6e6;border:0"/>  </td>
			</tr>
		
		
		<?php } 

	} 
}?>
</table>


<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
			<tr class="colorise1">
				<td style="width:2%"> <hr style="height: 1px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>   </td>
				<td style="width:18%"> <hr style="height: 1px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>   </td>
				<td style="width:47%"> <hr style="height: 1px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>   </td>
				<td style="width:15%"> <hr style="height: 1px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>  </td>
				<td style="width:18%"> <hr style="height: 1px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>  </td>
			</tr>
			
			<tr class="colorise1">
	
				<td style="width:2% ; font-style:italic"></td>
				<td style="width:18% ; vertical-align:middle; text-align:left">
					<a href="documents_editing.php?ref_doc=<?php echo $fiche->ref_doc?>" target="_blank" >Afficher |&nbsp;</a>
					<a href="documents_editing.php?ref_doc=<?php echo $fiche->ref_doc?>&print=1" target="_blank" >Imprimer &nbsp;</a>
				
				</td>			
	
				<td style="width:47% ; font-style:italic"></td>
				<td style="width:15%;text-align:center; font-weight:bold">Montant total</td>
				<td style="width:18%;text-align:right; font-weight:bold">
				<div id="aff_montant_ht_<?php echo $montant;?>" style="display:<?php if ($_REQUEST["app_tarifs_c"] != "HT") { echo "none";}?>">
				<?php	 { $montant_total_page_ht +=$fiche->montant_ht; echo price_format($fiche->montant_ht, $TARIFS_NB_DECIMALES, ",", ""	)." ".$MONNAIE[1]." HT";  }?>
				</div>
				<div id="aff_montant_ttc_<?php echo $montant;?>" style="display:<?php if ($_REQUEST["app_tarifs_c"] != "TTC") { echo "none";}?>">
				<?php	 { $montant_total_page_ttc +=$fiche->montant_ttc; echo price_format($fiche->montant_ttc, $TARIFS_NB_DECIMALES, ",", ""	)." ".$MONNAIE[1]." TTC";  }?>
				</div>
				</td>
			</tr>

			<tr class="colorise1">
	
				<td style="width:2%"> <hr style="height: 13px;margin:0;padding:0;color:#FFFFFF;background-color:#FFFFFF;border:0"/>  </td>
				<td style="width:18%"> <hr style="height: 13px;margin:0;padding:0;color:#FFFFFF;background-color:#FFFFFF;border:0"/>   </td>
				<td style="width:47%"> <hr style="height: 13px;margin:0;padding:0;color:#FFFFFF;background-color:#FFFFFF;border:0"/>   </td>
				<td style="width:15%"> <hr style="height: 13px;margin:0;padding:0;color:#FFFFFF;background-color:#FFFFFF;border:0"/>  </td>	
				<td style="width:18%"> <hr style="height: 13px;margin:0;padding:0;color:#FFFFFF;background-color:#FFFFFF;border:0"/>  </td>
			</tr>
			
	<?php } ?>

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
<?php 
if ($DOCUMENT_RECHERCHE_MONTANT_TOTAL) {
	?>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:5%">
			
		</td>
		<td style="width:23%; font-weight:normal">
		Afficher les tarifs
			<input  name="taxation" id="taxation_ht" type="radio"  value="HT" <?php if ($_REQUEST["app_tarifs_c"] == "HT") {?> checked="checked"<?php }?>>HT
			<input  name="taxation" id="taxation_ttc" type="radio" value="TTC" <?php if ($_REQUEST["app_tarifs_c"] == "TTC") {?> checked="checked"<?php }?>>TTC
		
		</td>
		<td style="width:10%; text-align:left">
		</td>
		<td style="width:15%; text-align:center">
		</td>
		<td style="width: 19%; text-align:center">
		MONTANT TOTAL: 
		</td>
		<td style="width:13%; text-align:center">
		<div id="aff_total_ht" style="display:<?php if ($_REQUEST["app_tarifs_c"] != "HT") { echo "none";}?>">
		<?php echo price_format($montant_total_page_ht, $TARIFS_NB_DECIMALES, ",", ""	)." ".$MONNAIE[1]." HT"?>
		</div>
		<div id="aff_total_ttc" style="display:<?php if ($_REQUEST["app_tarifs_c"] != "TTC") { echo "none";}?>">
		<?php echo price_format($montant_total_page_ttc, $TARIFS_NB_DECIMALES, ",", ""	)." ".$MONNAIE[1]." TTC"?>
		</div>
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

<iframe frameborder="0" scrolling="no" src="about:_blank" id="resume_stock_iframe" class="resume_stock_iframe"></iframe>
<div id="resume_stock" class="resume_stock">
</div>

<SCRIPT type="text/javascript">
Event.observe('taxation_ttc', "click", function(evt){
 $("app_tarifs_c").value = "TTC";

document.cookie = 'tarif=TTC';
  for (i=1; i <= <?php echo $colorise;?>; i++) {
 $("aff_prix_ttc_"+i).show();
 $("aff_prix_ht_"+i).hide();
}
	 for (i=1; i <= <?php echo $montant;?>; i++) {
 $("aff_montant_ttc_"+i).show();
 $("aff_montant_ht_"+i).hide(); } 
  $("aff_total_ttc").show();
 $("aff_total_ht").hide();
}
);
Event.observe('taxation_ht', "click", function(evt){
 $("app_tarifs_c").value = "HT";
document.cookie = 'tarif=HT';
   for (i=1; i <= <?php echo $colorise;?>; i++) {
 $("aff_prix_ttc_"+i).hide();
 $("aff_prix_ht_"+i).show();
 }
for (i=1; i <= <?php echo $montant;?>; i++) {
 $("aff_montant_ttc_"+i).hide();
 $("aff_montant_ht_"+i).show(); }
 $("aff_total_ttc").hide();
 $("aff_total_ht").show();


});
//on masque le chargement
H_loading();
</SCRIPT>