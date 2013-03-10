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
																			 'page.documents_recherche_cmde_fr()');





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
				<td style="width:20%"> <hr style="height: 2px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>  </td>
				<td style="width:20%"> <hr style="height: 2px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>   </td>
				<td style="width:5%"> <hr style="height: 2px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>   </td>
				<td style="width:10%"> <hr style="height: 2px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>  </td>
				<td style="width:10%"> <hr style="height: 2px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>  </td>
				<td style="width:15%"> <hr style="height: 2px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>  </td>
			</tr>
			
			<tr style="background-color: #c2cfd7">

				<td style="width:25%">
					<a  href="#" id="link_ref_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%">
					<?php	if ($fiche->ref_doc) { echo ($fiche->ref_doc)." du ".str_replace("-","/",(date_Us_to_Fr($fiche->date_doc))) ;}?>		
					</a>
					<script type="text/javascript">
					Event.observe("link_ref_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','documents_edition.php?ref_doc=<?php echo ($fiche->ref_doc)?>','true','sub_content');}, false);
					</script>
				</td>
				
				<td style="width:20% ; font-weight:bold" >
					<a  href="#" id="link_type_doc_<?php echo ($fiche->ref_doc)?>" style="display:block; width:100%">
					<?php	if ($fiche->nom_contact) { echo (substr(str_replace("€", "&euro;", $fiche->nom_contact), 0, 38)); }?>&nbsp;
					</a>
					<script type="text/javascript">
					Event.observe("link_type_doc_<?php echo ($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','documents_edition.php?ref_doc=<?php echo ($fiche->ref_doc)?>','true','sub_content');}, false);
					</script>
				</td>
				
				<td style="width:15% ; text-align:center ; color:#868486">
					<?php if ($fiche->lib_etat_doc == "En cours") { ?>
					<a  href="#" id="link_etat_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="display:block; width:100%">[
					<?php	echo htmlentities($fiche->lib_etat_doc); } ?>
				
					<?php if ($fiche->lib_etat_doc == "En saisie") { ?>
					<a  href="#" id="link_etat_doc_<?php echo htmlentities($fiche->ref_doc)?>" style="color:red;display:block; width:100%">[
					<?php	echo htmlentities($fiche->lib_etat_doc); } ?>
					]
					</a>
					<script type="text/javascript">
					Event.observe("link_etat_doc_<?php echo htmlentities($fiche->ref_doc)?>", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','documents_edition.php?ref_doc=<?php echo htmlentities($fiche->ref_doc)?>','true','sub_content');}, false);
					</script>
				</td>
				
				<td style="width:15%; text-align:center">
				</td>
			
				<td style="width:10%; text-align:center">
				</td>
	
				<td style="width:15%; text-align:center">
				</td>
			</tr>
 
</table>


<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
 
	<?php if (!empty($detail_art)) { 
		foreach ($detail_art as $article) {
			if (($article->ref_doc == $fiche->ref_doc ) AND ($article->ref_article != 'INFORMATION') AND ($article->ref_article != 'SSTOTAL') ) {
	?>
		<?php $colorise++; 
			$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
			
		?>
		

			<tr class="colorise1">
	
				<td style="width:20%">	
					<a  href="#" id="link_art_ref_<?php echo ($article->ref_article);echo ($fiche->ref_doc);?>" style="display:block; width:100%">
						<?php echo $article->ref_article;
						?> 
					</a>
					<script type="text/javascript">
					Event.observe("link_art_ref_<?php echo ($article->ref_article);echo ($fiche->ref_doc);?>", "click",  function(evt){Event.stop(evt); page.verify('catalogue_articles_view','index.php#'+escape('catalogue_articles_view.php?ref_article=<?php echo ($article->ref_article)?>'),'true','_blank');}, false);
					</script>
				</td>
	
	
				<td style="width:20%">
					<?php	 echo ($article->lib_article)."&nbsp;";?>		
				</td>
			
				<td style="width:10%; text-align:center;">
					<span style="text-decoration:underline"><?php echo ($article->qte)."x";?> </span> 
				</td>
				
				<td style="width:10%; text-align:center">
					<?php	?>	
				</td>
				
				<td style="width:10%; text-align:right">
				<div id="aff_prix_ht_<?php echo $colorise;?>" style="display:<?php if ($_COOKIE["tarig"] != "HT") { echo "none";} ?>">
					<?php { echo price_format((($article->pu_ht)*($article->qte)), $TARIFS_NB_DECIMALES, ",", ""	)." ".$MONNAIE[1]." HT"; }?>
				</div>
				<div id="aff_prix_ttc_<?php echo $colorise;?>" style="display:<?php if ($_COOKIE["tarig"] != "TTC") { echo "none";} ?>">
					<?php { echo price_format((($article->pu_ttc)*($article->qte)), $TARIFS_NB_DECIMALES, ",", ""	)." ".$MONNAIE[1]." TTC"; }?>	
				</div>
				</td>
				
				<td style="width:15%; text-align:center"> 
				</td>
				
			</tr>
			
		<?php if (isset($article->desc_article) AND ($article->desc_article !="")) { ?>
		
			<tr class="colorise1">
	
				<td style="width:20%">			
				</td>
	
				<td style="width:20% ; font-style:italic">
					<?php	 echo ($article->desc_article)."&nbsp;";?>		
				</td>
				
				<td style="width:10%; text-align:center"></td>
				<td style="width:10%; text-align:center"></td>
				<td style="width:10%; text-align:center"></td>
				<td style="width:15%; text-align:center"></td>
			</tr>	

		<?php } ?>	
<tr class="colorise1">
	
				<td style="width:20%"> <hr style="height: 1px;margin:0;padding:0;color:#e6e6e6;background-color:#e6e6e6;border:0"/>  </td>
				<td style="width:20%"> <hr style="height: 1px;margin:0;padding:0;color:#e6e6e6;background-color:#e6e6e6;border:0"/>   </td>
				<td style="width:10%"> <hr style="height: 1px;margin:0;padding:0;color:#e6e6e6;background-color:#e6e6e6;border:0"/>   </td>
				<td style="width:10%"> <hr style="height: 1px;margin:0;padding:0;color:#e6e6e6;background-color:#e6e6e6;border:0"/>  </td>
				<td style="width:10%"> <hr style="height: 1px;margin:0;padding:0;color:#e6e6e6;background-color:#e6e6e6;border:0"/>  </td>
				<td style="width:15%"> <hr style="height: 1px;margin:0;padding:0;color:#e6e6e6;background-color:#e6e6e6;border:0"/>  </td>
			</tr>
		<?php } 

	} 
} ?>

			<tr class="colorise1">
	
				<td style="width:20%"> <hr style="height: 1px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>  </td>
				<td style="width:20%"> <hr style="height: 1px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>   </td>
				<td style="width:10%"> <hr style="height: 1px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>   </td>
				<td style="width:10%"> <hr style="height: 1px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>  </td>
				<td style="width:10%"> <hr style="height: 1px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>  </td>
				<td style="width:15%"> <hr style="height: 1px;margin:0;padding:0;color:#000000;background-color:#000000;border:0"/>  </td>
			</tr>
			
			
			
			<tr class="colorise1">
	
				<td style="width:20% ; vertical-align:middle; text-align:left">
					<a href="documents_editing.php?ref_doc=<?php echo $fiche->ref_doc?>" target="_blank" >Afficher |&nbsp;</a> 
					<a href="documents_editing.php?ref_doc=<?php echo $fiche->ref_doc?>&print=1" target="_blank" >Imprimer |&nbsp;</a>
					<a href="#" id="mail_doc_<?php echo $fiche->ref_doc?>" >Surveiller</a>
					<script type="text/javascript">
					Event.observe("mail_doc_<?php echo $fiche->ref_doc?>", "click", function(evt){
					Event.stop(evt);
					var top=(screen.height-350)/2;
					var left=(screen.width-500)/2;
					window.open("documents_editing_email.php?ref_doc=<?php echo $fiche->ref_doc?>&mode_edition=2","","top="+top+",left="+left+",width=500,height=350,menubar=no,statusbar=no,scrollbars=yes,resizable=yes");
					});		
					</script>
				</td>			
	
				<td style="width:20% ; font-style:italic"></td>
				<td style="width:10%; text-align:center"></td>
				<td style="width:10%; text-align:center; font-weight:bold">Montant total</td>
				<td style="width:10%; text-align:right; font-weight:bold">
				<div id="aff_montant_ht_<?php echo $montant;?>" style="display:<?php if ($_COOKIE["tarig"] != "HT") { echo "none";}?>">
				<?php	 { $montant_total_page_ht +=$fiche->montant_ht; echo price_format($fiche->montant_ht, $TARIFS_NB_DECIMALES, ",", ""	)." ".$MONNAIE[1]." HT";  }?>
				</div>
				<div id="aff_montant_ttc_<?php echo $montant;?>" style="display:<?php if ($_COOKIE["tarig"] != "TTC") { echo "none";}?>">
				<?php	 { $montant_total_page_ttc +=$fiche->montant_ttc; echo price_format($fiche->montant_ttc, $TARIFS_NB_DECIMALES, ",", ""	)." ".$MONNAIE[1]." TTC";  }?>
				</div>
				</td>
				
				<td style="width:15px;  text-align:center">
				<span id="commande_genere_reception_<?php echo htmlentities($fiche->id_stock."_".$fiche->ref_doc);?>" style="color:green; cursor:pointer; display:">[ RECEPTION >>]<span/>
				<script type="text/javascript">
				//generer_document_doc ("generer_bl_client", ref_doc)
				Event.observe("commande_genere_reception_<?php echo htmlentities($fiche->id_stock."_".$fiche->ref_doc);?>", "click", function(evt){
				Event.stop(evt); 
				generer_document_doc ("generer_br_fournisseur", "<?php echo $fiche->ref_doc;?>");
				$("commande_genere_reception_<?php echo htmlentities($fiche->id_stock."_".$fiche->ref_doc);?>").hide();
				}, false);
				</script>
				</td>
				
			</tr>

			<tr class="colorise1">
	
				<td style="width:20%"> <hr style="height: 13px;margin:0;padding:0;color:#FFFFFF;background-color:#FFFFFF;border:0"/>  </td>
				<td style="width:20%"> <hr style="height: 13px;margin:0;padding:0;color:#FFFFFF;background-color:#FFFFFF;border:0"/>   </td>
				<td style="width:10%"> <hr style="height: 13px;margin:0;padding:0;color:#FFFFFF;background-color:#FFFFFF;border:0"/>   </td>
				<td style="width:10%"> <hr style="height: 13px;margin:0;padding:0;color:#FFFFFF;background-color:#FFFFFF;border:0"/>  </td>
				<td style="width:10%"> <hr style="height: 13px;margin:0;padding:0;color:#FFFFFF;background-color:#FFFFFF;border:0"/>  </td>
				<td style="width:15%"> <hr style="height: 13px;margin:0;padding:0;color:#FFFFFF;background-color:#FFFFFF;border:0"/>  </td>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td>&nbsp;</td>
		<td>
			Afficher les tarifs 
			<input  name="taxation" id="taxation_ht" type="radio"  value="HT" <?php if ($_COOKIE["tarig"] == "HT") {?> checked="checked"<?php }?>>HT
			<input  name="taxation" id="taxation_ttc" type="radio" value="TTC" <?php if ($_COOKIE["tarig"] == "TTC") {?> checked="checked"<?php }?>>TTC
		</td>
		<td>&nbsp;</td>
		
		
		
	</tr>
</table>



<br />
<?php 
if ($DOCUMENT_RECHERCHE_MONTANT_TOTAL) {
	?>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
	<tr class="colorise0">
		<td style="width:10%">
		</td>
		<td style="width:10%">
		</td>
		<td style="width:18%; text-align:left">
		</td>
		<td style="width:15%; text-align:center">
		</td>
		<td style="width: 20%; text-align:center">
		MONTANT TOTAL: 
		</td>
		<td style="width:13%; text-align:center">
		<div id="aff_total_ht" style="display:<?php if ($_COOKIE["tarig"] != "HT") { echo "none";}?>">
		<?php echo price_format($montant_total_page_ht, $TARIFS_NB_DECIMALES, ",", ""	)." ".$MONNAIE[1]." HT"?>
		</div>
		<div id="aff_total_ttc" style="display:<?php if ($_COOKIE["tarig"] != "TTC") { echo "none";}?>">
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


<script type="text/javascript">
Event.observe('taxation_ttc', "click", function(evt){
 

document.cookie = 'tarig=TTC';
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

document.cookie = 'tarig=HT';
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