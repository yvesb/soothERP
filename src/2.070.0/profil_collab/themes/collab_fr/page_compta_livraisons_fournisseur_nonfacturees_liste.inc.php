<?php

// *************************************************************************************************************
// AFFICHAGE DES LIVRAISONS fournisseurS NON FACTUREES
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

?>

<div style="width:100%;"><br />
	<ul>
		<li class="colorise0" style="height:24px; line-height:24px; width:100%">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:24px;">
			<tr valign="middle">
				<td style="width:25px; height:24px" valign="middle">
					<div style="width:25px;">
					</div>
				</td>
				<td style=" text-align:left; width:70px; font-weight:bolder;" valign="middle">
					<div style="width:70px; height:24px; line-height:24px; cursor:pointer;" id="order_date_doc_<?php echo $stocks->getId_stock ();?>">
						 Date
					</div>
					<script type="text/javascript">
Event.observe("order_date_doc_<?php echo $stocks->getId_stock ();?>", "click",  function(evt){
Event.stop(evt); 
page.verify ('compta_livraisons_fournisseur_nonfacturees_liste','compta_livraisons_fournisseur_nonfacturees_liste.php?orderby=date_creation&orderorder=<?php if (isset($_REQUEST['orderorder']) && $_REQUEST['orderorder']=="ASC" && $_REQUEST['orderby']=="date_creation") {echo "DESC";} else {echo "ASC";}?>&id_stock=<?php echo $stocks->getId_stock();?>','true','lcnf');
}, false);
					</script>
				</td>
				<td style="width:108px; font-weight:bolder" valign="middle">
					<div style="width:108px; height:24px; line-height:24px; cursor:pointer;" id="order_ref_doc_<?php echo $stocks->getId_stock ();?>">
						R&eacute;f&eacute;rence
					</div>
					<script type="text/javascript">
Event.observe("order_ref_doc_<?php echo $stocks->getId_stock ();?>", "click",  function(evt){
Event.stop(evt); 
page.verify ('compta_livraisons_fournisseur_nonfacturees_liste','compta_livraisons_fournisseur_nonfacturees_liste.php?orderby=ref_doc&orderorder=<?php if (isset($_REQUEST['orderorder']) && $_REQUEST['orderorder']=="ASC" && $_REQUEST['orderby']=="ref_doc") {echo "DESC";} else {echo "ASC";}?>&id_stock=<?php echo $stocks->getId_stock();?>','true','lcnf');
}, false);
					</script>
				</td>
				<td style="font-weight:bolder;text-align:left; font-weight:bolder;" valign="middle">
					<div style=" height:24px; line-height:24px; cursor:pointer;" id="order_nom_contact_<?php echo $stocks->getId_stock ();?>">fournisseur
					</div>
					<script type="text/javascript">
Event.observe("order_nom_contact_<?php echo $stocks->getId_stock ();?>", "click",  function(evt){
Event.stop(evt); 
page.verify ('compta_livraisons_fournisseur_nonfacturees_liste','compta_livraisons_fournisseur_nonfacturees_liste.php?orderby=nom_contact&orderorder=<?php if (isset($_REQUEST['orderorder']) && $_REQUEST['orderorder']=="ASC" && $_REQUEST['orderby']=="nom_contact") {echo "DESC";} else {echo "ASC";}?>&id_stock=<?php echo $stocks->getId_stock();?>','true','lcnf');
}, false);
					</script>
				</td>
				<td style="text-align:left; width:100px; font-weight:bolder;" valign="middle">
					<div style="width:100px; height:24px; line-height:24px;">
						Etat
					</div>
				</td>
				<td style="width:100px;text-align:right; font-weight:bolder;" valign="middle">
					<div style="width:100px; height:24px; line-height:24px; padding-right:20px">
						Montant
					</div>
				</td>
				<td style="width:80px; text-align:center; font-weight:bolder;" valign="middle">
					<div style="width:80px; height:24px; line-height:24px;">
						Facturer
					</div>
				</td>
				<td style="width:80px;text-align:center; font-weight:bolder;" valign="middle">
					<div style="width:80px; height:24px; line-height:24px;">
						Editer
					</div>
				</td>
				<td style="width:25px; text-align:right" valign="middle">
					<div style="width:25px">
					</div>
				</td>
			</tr>
		</table>
		</li>
	</ul>
	<div>
	<ul id ="commandes" style="width:100%">
	<?php
	$indentation = 0;
	$colorise=0;
	foreach ($livraisons as $livraison) {
		$colorise++;
		$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
		?>
		<li id="licommande_<?php echo $indentation;?>" class="<?php echo $class_colorise;?>" style="height:24px; line-height:24px; width:100%">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:24px;">
			<tr valign="middle">
				<td style="width:25px; height:24px; line-height:24px;" valign="middle">
					<div style="width:25px;">
						<input id="check<?php echo $stocks->getId_stock ();?>_<?php echo $indentation;?>" name="check_<?php echo $stocks->getId_stock ();?>_<?php echo $indentation;?>" type="checkbox" value="check_line"/>
						<input id="refdoc_<?php echo $stocks->getId_stock ();?>_<?php echo $indentation;?>" name="refdoc_<?php echo $stocks->getId_stock ();?>_<?php echo $indentation;?>" type="hidden" value="<?php echo htmlentities($livraison->ref_doc);?>"/>
					</div>
				</td>
				<td style=" text-align:left; width:70px; font-size:10px" valign="middle">
					<div style="width:70px; height:24px; line-height:24px;">
						<?php echo htmlentities(date_Us_to_Fr($livraison->date_creation));?>
					</div>
				</td>
				<td style="width:108px; font-size:10px; font-weight:bolder" valign="middle">
					<div style="width:108px; height:24px; line-height:24px;">
						<a href="#" id ="<?php echo htmlentities($livraison->ref_doc);?>" style="text-decoration:none; color:#000000">
						<?php echo htmlentities($livraison->ref_doc);?>
						</a>
						<script type="text/javascript">
							Event.observe('<?php echo htmlentities($livraison->ref_doc);?>', 'click',  function(evt){ Event.stop(evt); window.open( "<?php echo $_ENV['CHEMIN_ABSOLU'].$_SESSION['profils'][$_SESSION['user']->getId_profil ()]->getDir_profil();?>#"+escape('documents_edition.php?ref_doc=<?php echo htmlentities($livraison->ref_doc)?>'),'_blank');}, false);
						</script>
					</div>
				</td>
				<td style="font-weight:bolder;text-align:left;" valign="middle">
					<div style="; height:24px; line-height:24px;">&nbsp;
					<a href="#" id ="<?php echo htmlentities($livraison->ref_doc);?>ctc" style="text-decoration:none; color:#000000"><?php  echo htmlentities(substr($livraison->nom_contact, 0 , 38));?>
					</a>
					<script type="text/javascript">
						Event.observe('<?php echo htmlentities($livraison->ref_doc);?>ctc', 'click',  function(evt){ Event.stop(evt); window.open( "<?php echo $_ENV['CHEMIN_ABSOLU'].$_SESSION['profils'][$_SESSION['user']->getId_profil ()]->getDir_profil();?>#"+escape('annuaire_view_fiche.php?ref_contact=<?php echo htmlentities($livraison->ref_contact)?>'),'_blank');}, false);
					</script>
					</div>
				</td>
				<td style="text-align:left; width:150px;" valign="middle">
					<div style="width:130px; height:24px; line-height:24px;">
					<span <?php if ($livraison->id_etat_doc == 11) {?>style="color:#FF0000"<?php } ?>>
					<?php echo htmlentities(($livraison->lib_etat_doc));?>
					</span>
					</div>
				</td>
				<td style="width:100px;text-align:right" valign="middle">
					<div style="width:100px; height:24px; line-height:24px; padding-right:20px">
						<?php echo (number_format($livraison->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]);?>
					</div>
				</td>
				<td style="width:80px; text-align:center" valign="middle">
					<div style="width:80px; height:24px; line-height:24px;">
						<a href="#" id ="<?php echo htmlentities($livraison->ref_doc);?>fac" style="text-decoration:underline; color:#000000">
						Facturer
						</a>
						<script type="text/javascript">
						Event.observe('<?php echo htmlentities($livraison->ref_doc);?>fac', 'click',  function(evt){ 
							Event.stop(evt); 
							generer_document_doc ("generer_fa_fournisseur", "<?php echo htmlentities($livraison->ref_doc);?>");
							remove_tag ("licommande_<?php echo $indentation;?>");
						}, false);
						</script>
					</div>
				</td>
				<td style="width:80px;text-align:center" valign="middle">
					<div style="width:80px; height:24px; line-height:24px;">
						<a href="#" id ="<?php echo htmlentities($livraison->ref_doc);?>edt" style="text-decoration:underline; color:#000000">
						Editer
						</a>
						<script type="text/javascript">
							Event.observe('<?php echo htmlentities($livraison->ref_doc);?>edt', 'click',  function(evt){ Event.stop(evt); window.open( "<?php echo $_ENV['CHEMIN_ABSOLU'].$_SESSION['profils'][$_SESSION['user']->getId_profil ()]->getDir_profil();?>#"+escape('documents_edition.php?ref_doc=<?php echo htmlentities($livraison->ref_doc)?>'),'_blank');}, false);
						</script>
					</div>
				</td>
				<td style="width:25px; text-align:right" valign="middle">
					<div style="width:25px; height:24px; line-height:24px;">
						<a href="documents_editing.php?ref_doc=<?php echo $livraison->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="Imprimer" title="Imprimer"/></a>
					</div>
				</td>
			</tr>
		</table>
		</li>
		<?php 
	$indentation++;
	}
	?>
	</ul>
</div>

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
			<select id="coche_action" name="coche_action" class="classinput_nsize">
				<option value="">Pour la s&eacute;lection</option>
				<option value="generer_fa_fournisseur">Facturer</option>
				
				
			</select>
		</td>
	</tr>
</table><br />


<script type="text/javascript">

Event.observe("all_coche", "click", function(evt){
	Event.stop(evt); 
	coche_line ("coche", "<?php echo $stocks->getId_stock ();?>" , "commandes")
});
Event.observe("all_decoche", "click", function(evt){
	Event.stop(evt); 
	coche_line ("decoche", "<?php echo $stocks->getId_stock ();?>" , "commandes");
});
Event.observe("all_inv_coche", "click", function(evt){
	Event.stop(evt); 
	coche_line ("inv_coche", "<?php echo $stocks->getId_stock ();?>" , "commandes");
});

Event.observe("coche_action", "change", function(evt){action_BLC($("coche_action").value, "<?php echo $stocks->getId_stock ();?>" , "commandes");});
//on masque le chargement
H_loading();

</script>