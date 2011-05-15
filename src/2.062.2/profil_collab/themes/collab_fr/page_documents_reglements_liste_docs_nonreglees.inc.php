<?php

// *************************************************************************************************************
// LISTE FACTURES NON PAYEES
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

if (!isset($GLOBALS['_ALERTES']['infos_non_utiles'])) { 
?>
<table style="width:100%">
	<tr>
		<td style="width:47%;"></td>
		<td style="width:4%"></td>
		<td style="width:47%"></td>
	</tr>
	<tr>
		<td style="width:47%"><!--Affichage des factures ajoutables au total si FAC et montant positif-->
				<?php 
if( ($id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC && $montant_positif == 1) || ($id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC && $id_etat_doc == 9)) {
	?>
				<div>
					<div style="display:block; text-align:left; font-weight:bolder"> Factures non r&eacute;gl&eacute;es. </div>
					<table width="100%" border="0"  cellspacing="0" style="width:100%; background-color:#FFFFFF; border:1px solid #d6d6d6;">
						<tr>
							<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>
						<?php
		$montant_total = 0;
		foreach ($liste_factures as $facture) {
			if (isset($facture->montant_ttc)) { 
			//if ($facture->montant_ttc == "") { continue;}
			?>
						<tr>
							<td style="font-size:10px; cursor:pointer" id="facture_<?php echo $facture->ref_doc;?>"><?php echo date_Us_to_Fr($facture->date_creation);?><br />
									<span <?php if (round(strtotime($facture->date_echeance)-strtotime(date("c")))<0) {?>style=" color:#FF0000;"<?php }?>> <?php echo htmlentities(date_Us_to_Fr($facture->date_echeance));?> </span> </td>
							<td style="font-size:10px; cursor:pointer" id="facture2_<?php echo $facture->ref_doc;?>"><?php echo $facture->ref_doc;?><br />
									<span <?php if ($facture->id_etat_doc == 16) {?>style="color:#FF0000"<?php } ?>> <?php echo htmlentities(($facture->lib_etat_doc));?> </span> </td>
							<td style="text-align:right; font-size:10px; padding-right:2px;  cursor:pointer" id="facture3_<?php echo $facture->ref_doc;?>"><?php
				$montant_reglements = 0;
				if ($facture->montant_reglements) { $montant_reglements = $facture->montant_reglements;}
				if ($facture->montant_ttc) { echo number_format($facture->montant_ttc- $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	)." "; $montant_total += number_format($facture->montant_ttc - $montant_reglements , $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="text-align:left; font-size:10px; cursor:pointer" id="facture4_<?php echo $facture->ref_doc;?>"> /
									<?php
				if ($facture->montant_ttc) { echo number_format($facture->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="padding-left:10px"><input type="checkbox" name="add_doc_<?php echo $facture->ref_doc; ?>" id="add_doc_<?php echo $facture->ref_doc; ?>" value="<?php echo $facture->ref_doc; ?>" />
							</td>
						</tr>
						<tr>
							<td colspan="5"><div style="height:8px; line-height:8px; border-bottom:1px solid #d6d6d6;"></div>
									<script type="text/javascript">
				Event.observe('facture_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('facture2_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('facture3_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('facture4_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				
				
				Event.observe('add_doc_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					if ($("add_doc_<?php echo $facture->ref_doc; ?>").checked) {
						add_doc_to_toto  ("<?php echo $facture->ref_doc; ?>", "<?php echo number_format($facture->montant_ttc - $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	);?>");
					} else {
						del_doc_to_toto ("<?php echo $facture->ref_doc; ?>", "<?php echo number_format($facture->montant_ttc - $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	);?>");
					
					}
				});
				</script>
							</td>
						</tr>
						<?php
			}
		}
		?>
					<tr>
						<td style="width:25%">&nbsp;</td>
						<td style="font-weight:bolder; width:40%; text-align:right; padding-right:10px"> Total: </td>
						<td style="font-weight:bolder; text-align:right "><?php echo $montant_total." ".$MONNAIE[1];;?> </td>
						<td style=""></td>
					</tr>
				</table>
				</div>
<?php } ?>
			<!--Affichage des factures ajoutables au total si FAF et montant positif-->
				<?php 
if( $id_type_doc == $FACTURE_FOURNISSEUR_ID_TYPE_DOC && $montant_positif == 1) { 
	?>
				<div>
					<div style="display:block; text-align:left; font-weight:bolder"> Factures non r&eacute;gl&eacute;es. </div>
					<table width="100%" border="0"  cellspacing="0" style="width:100%; background-color:#FFFFFF; border:1px solid #d6d6d6;">
						<tr>
							<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>
						<?php
		$montant_total = 0;
		foreach ($liste_factures as $facture) {
			if (isset($facture->montant_ttc)) { 
			//if ($facture->montant_ttc == "") { continue;}
			?>
						<tr>
							<td style="font-size:10px; cursor:pointer" id="facture_<?php echo $facture->ref_doc;?>"><?php echo date_Us_to_Fr($facture->date_creation);?><br />
									<span <?php if (round(strtotime($facture->date_echeance)-strtotime(date("c")))<0) {?>style=" color:#FF0000;"<?php }?>> <?php echo htmlentities(date_Us_to_Fr($facture->date_echeance));?> </span> </td>
							<td style="font-size:10px; cursor:pointer" id="facture2_<?php echo $facture->ref_doc;?>"><?php echo $facture->ref_doc;?><br />
									<span <?php if ($facture->id_etat_doc == 32) {?>style="color:#FF0000"<?php } ?>> <?php echo htmlentities(($facture->lib_etat_doc));?> </span> </td>
							<td style="text-align:right; font-size:10px; padding-right:2px;  cursor:pointer" id="facture3_<?php echo $facture->ref_doc;?>"><?php
				$montant_reglements = 0;
				if ($facture->montant_reglements) { $montant_reglements = $facture->montant_reglements;}
				if ($facture->montant_ttc) { echo number_format($facture->montant_ttc- $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; $montant_total += number_format($facture->montant_ttc - $montant_reglements , $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="text-align:left; font-size:10px; cursor:pointer" id="facture4_<?php echo $facture->ref_doc;?>"> /
									<?php
				if ($facture->montant_ttc) { echo number_format($facture->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="padding-left:10px"><input type="checkbox" name="add_doc_<?php echo $facture->ref_doc; ?>" id="add_doc_<?php echo $facture->ref_doc; ?>" value="<?php echo $facture->ref_doc; ?>" />
							</td>
						</tr>
						<tr>
							<td colspan="5"><div style="height:8px; line-height:8px; border-bottom:1px solid #d6d6d6;"></div>
									<script type="text/javascript">
				Event.observe('facture_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_faf','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('facture2_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_faf','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('facture3_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_faf','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('facture4_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_faf','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				
				
				Event.observe('add_doc_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					if ($("add_doc_<?php echo $facture->ref_doc; ?>").checked) {
						add_doc_to_toto  ("<?php echo $facture->ref_doc; ?>", "<?php echo number_format($facture->montant_ttc - $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	);?>");
					} else {
						del_doc_to_toto ("<?php echo $facture->ref_doc; ?>", "<?php echo number_format($facture->montant_ttc - $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	);?>");
					
					}
				});
				</script>
							</td>
						</tr>
						<?php
			}
		}
		?>
						<tr>
							<td style="width:25%">&nbsp;</td>
							<td style="font-weight:bolder; width:40%; text-align:right; padding-right:10px"> Total: </td>
							<td style="font-weight:bolder; text-align:right "><?php echo $montant_total." ".$MONNAIE[1];;?> </td>
							<td style=""></td>
						</tr>
					</table>
				</div>
			<?php } ?>
				<!--Affichage des factures ajoutables au total si FAC et montant negatif-->
				<?php 
if( $id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC && $montant_positif == -1) { 
	?>
				<div>
					<div style="display:block; text-align:left; font-weight:bolder"> Factures d'avoir non soldés. </div>
					<table width="100%" border="0"  cellspacing="0" style="width:100%; background-color:#FFFFFF; border:1px solid #d6d6d6;">
						<tr>
							<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>
						<?php
		$montant_total = 0;
		foreach ($liste_avoir_to_use as $facture) {
			if (isset($facture->montant_ttc)) { 
			//if ($facture->montant_ttc == "") { continue;}
			?>
						<tr>
							<td style="font-size:10px; cursor:pointer" id="facture_<?php echo $facture->ref_doc;?>"><?php echo date_Us_to_Fr($facture->date_creation);?><br />
							</td>
							<td style="font-size:10px; cursor:pointer" id="facture2_<?php echo $facture->ref_doc;?>"><?php echo $facture->ref_doc;?><br />
							</td>
							<td style="text-align:right; font-size:10px; padding-right:2px;  cursor:pointer" id="facture3_<?php echo $facture->ref_doc;?>"><?php
				$montant_reglements = 0;
				if ($facture->montant_reglements) { $montant_reglements = $facture->montant_reglements;}
				if ($facture->montant_ttc) { echo number_format($facture->montant_ttc- $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; $montant_total += number_format($facture->montant_ttc - $montant_reglements , $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="text-align:left; font-size:10px; cursor:pointer" id="facture4_<?php echo $facture->ref_doc;?>"> /
									<?php
				if ($facture->montant_ttc) { echo number_format($facture->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="padding-left:10px"><input type="checkbox" name="add_doc_<?php echo $facture->ref_doc; ?>2" id="add_doc_<?php echo $facture->ref_doc; ?>" value="<?php echo $facture->ref_doc; ?>" />
							</td>
						</tr>
						<tr>
							<td colspan="5"><div style="height:8px; line-height:8px; border-bottom:1px solid #d6d6d6;"></div>
									<script type="text/javascript">
				Event.observe('facture_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('facture2_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('facture3_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('facture4_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				
				
				Event.observe('add_doc_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					if ($("add_doc_<?php echo $facture->ref_doc; ?>").checked) {
						add_doc_to_toto  ("<?php echo $facture->ref_doc; ?>", "<?php echo number_format($facture->montant_ttc - $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	);?>");
					} else {
						del_doc_to_toto ("<?php echo $facture->ref_doc; ?>", "<?php echo number_format($facture->montant_ttc - $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	);?>");
					
					}
				});
				</script>
							</td>
						</tr>
						<?php
			}
		}
		?>
						<tr>
							<td style="width:25%">&nbsp;</td>
							<td style="font-weight:bolder; width:40%; text-align:right; padding-right:10px"> Total: </td>
							<td style="font-weight:bolder; text-align:right "><?php echo $montant_total." ".$MONNAIE[1];;?> </td>
							<td style=""></td>
						</tr>
					</table>
				</div>
			<?php } ?>
			
		
				<!--Affichage des factures ajoutables au total si FAF et montant negatif-->
				<?php 
if( $id_type_doc == $FACTURE_FOURNISSEUR_ID_TYPE_DOC && $montant_positif == -1) { 
	?>
				<div>
					<div style="display:block; text-align:left; font-weight:bolder"> Factures d'avoir non soldés. </div>
					<table width="100%" border="0"  cellspacing="0" style="width:100%; background-color:#FFFFFF; border:1px solid #d6d6d6;">
						<tr>
							<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>
						<?php
		$montant_total = 0;
		foreach ($liste_avoir_to_use as $facture) {
			if (isset($facture->montant_ttc)) { 
			//if ($facture->montant_ttc == "") { continue;}
			?>
						<tr>
							<td style="font-size:10px; cursor:pointer" id="facture_<?php echo $facture->ref_doc;?>"><?php echo date_Us_to_Fr($facture->date_creation);?><br />
							</td>
							<td style="font-size:10px; cursor:pointer" id="facture2_<?php echo $facture->ref_doc;?>"><?php echo $facture->ref_doc;?><br />
							</td>
							<td style="text-align:right; font-size:10px; padding-right:2px;  cursor:pointer" id="facture3_<?php echo $facture->ref_doc;?>"><?php
				$montant_reglements = 0;
				if ($facture->montant_reglements) { $montant_reglements = $facture->montant_reglements;}
				if ($facture->montant_ttc) { echo number_format($facture->montant_ttc- $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; $montant_total += number_format($facture->montant_ttc - $montant_reglements , $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="text-align:left; font-size:10px; cursor:pointer" id="facture4_<?php echo $facture->ref_doc;?>"> /
									<?php
				if ($facture->montant_ttc) { echo number_format($facture->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="padding-left:10px"><input type="checkbox" name="add_doc_<?php echo $facture->ref_doc; ?>2" id="add_doc_<?php echo $facture->ref_doc; ?>" value="<?php echo $facture->ref_doc; ?>" />
							</td>
						</tr>
						<tr>
							<td colspan="5"><div style="height:8px; line-height:8px; border-bottom:1px solid #d6d6d6;"></div>
									<script type="text/javascript">
				Event.observe('facture_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_faf','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('facture2_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_faf','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('facture3_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_faf','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('facture4_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_faf','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $facture->ref_doc; ?>'),'true','_blank');
				});
				
				
				Event.observe('add_doc_<?php echo $facture->ref_doc; ?>', "click", function(evt){
					if ($("add_doc_<?php echo $facture->ref_doc; ?>").checked) {
						add_doc_to_toto  ("<?php echo $facture->ref_doc; ?>", "<?php echo number_format($facture->montant_ttc - $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	);?>");
					} else {
						del_doc_to_toto ("<?php echo $facture->ref_doc; ?>", "<?php echo number_format($facture->montant_ttc - $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	);?>");
					
					}
				});
				</script>
							</td>
						</tr>
						<?php
			}
		}
		?>
						<tr>
							<td style="width:25%">&nbsp;</td>
							<td style="font-weight:bolder; width:40%; text-align:right; padding-right:10px"> Total: </td>
							<td style="font-weight:bolder; text-align:right "><?php echo $montant_total." ".$MONNAIE[1];;?> </td>
							<td style=""></td>
						</tr>
					</table>
				</div>
			<?php } ?>
		</td>
		<td style="width:4%"></td>
		<td style="width:47%">
		<!--Affichage des factures ajoutables au total si FAC et montant positif-->
				<?php 
if( ($id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC && $montant_positif == 1) || ($id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC && $id_etat_doc == 9)) {
?>
				<div>
					<div style="display:block; text-align:left; font-weight:bolder"> Avoirs . </div>
					<table width="100%" border="0"  cellspacing="0" style="width:100%; background-color:#FFFFFF; border:1px solid #d6d6d6;">
						<tr>
							<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>
						<?php
		$montant_total = 0;
		foreach ($liste_avoir_to_use as $avoir) {
                    if (isset($avoir->montant_ttc)) {
			//if ($facture->montant_ttc == "") { continue;}
			?>
						<tr>
							<td style="font-size:10px; cursor:pointer" id="avoir_<?php echo $avoir->ref_doc;?>"><?php echo date_Us_to_Fr($avoir->date_creation);?><br />
							</td>
							<td style="font-size:10px; cursor:pointer" id="avoir2_<?php echo $avoir->ref_doc;?>"><?php echo $avoir->ref_doc;?><br />
							</td>
							<td style="text-align:right; font-size:10px; padding-right:2px;  cursor:pointer" id="avoir3_<?php echo $avoir->ref_doc;?>"><?php
				$montant_reglements = 0;
				if ($avoir->montant_reglements) { $montant_reglements = $avoir->montant_reglements;}
				if ($avoir->montant_ttc) { echo number_format($avoir->montant_ttc+ $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	)." "; $montant_total += number_format($avoir->montant_ttc + $montant_reglements , $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="text-align:left; font-size:10px; cursor:pointer" id="avoir4_<?php echo $avoir->ref_doc;?>"> /
									<?php
				if ($avoir->montant_ttc) { echo number_format($avoir->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="padding-left:5px; font-size:10px;"><div  id="add_avoir_<?php echo $avoir->ref_doc; ?>" style="cursor:pointer">Ajouter</div></td>
						</tr>
						<tr>
							<td colspan="5"><div style="height:8px; line-height:8px; border-bottom:1px solid #d6d6d6;"></div>
									<script type="text/javascript">
				Event.observe('avoir_<?php echo $avoir->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $avoir->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('avoir2_<?php echo $avoir->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $avoir->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('avoir3_<?php echo $avoir->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $avoir->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('avoir4_<?php echo $avoir->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_fac','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $avoir->ref_doc; ?>'),'true','_blank');
				});
				
				
				Event.observe('add_avoir_<?php echo $avoir->ref_doc; ?>', "click", function(evt){
					add_avoir  ("<?php echo $avoir->ref_doc; ?>", "<?php echo $document->getRef_doc ();?>");
				});
				</script>
							</td>
						</tr>
						<?php
			}
		}
		?>
						<tr>
							<td style="width:25%">&nbsp;</td>
							<td style="font-weight:bolder; width:40%; text-align:right; padding-right:10px"> Total: </td>
							<td style="font-weight:bolder; text-align:right "><?php echo $montant_total." ".$MONNAIE[1];;?> </td>
							<td style=""></td>
						</tr>
					</table>
				</div>
			<?php } ?>
			
			
		<!--Affichage des factures ajoutables au total si FAF et montant positif-->
				<?php 
if( $id_type_doc == $FACTURE_FOURNISSEUR_ID_TYPE_DOC && $montant_positif == 1) { 
	?>
				<div>
					<div style="display:block; text-align:left; font-weight:bolder"> Avoirs . </div>
					<table width="100%" border="0"  cellspacing="0" style="width:100%; background-color:#FFFFFF; border:1px solid #d6d6d6;">
						<tr>
							<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>
						<?php
		$montant_total = 0;
		foreach ($liste_avoir_to_use as $avoir) {
			if (isset($avoir->montant_ttc)) { 
			//if ($facture->montant_ttc == "") { continue;}
			?>
						<tr>
							<td style="font-size:10px; cursor:pointer" id="avoir_<?php echo $avoir->ref_doc;?>"><?php echo date_Us_to_Fr($avoir->date_creation);?><br />
							</td>
							<td style="font-size:10px; cursor:pointer" id="avoir2_<?php echo $avoir->ref_doc;?>"><?php echo $avoir->ref_doc;?><br />
							</td>
							<td style="text-align:right; font-size:10px; padding-right:2px;  cursor:pointer" id="avoir3_<?php echo $avoir->ref_doc;?>"><?php
				$montant_reglements = 0;
				if ($avoir->montant_reglements) { $montant_reglements = $avoir->montant_reglements;}
				if ($avoir->montant_ttc) { echo number_format($avoir->montant_ttc- $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	)." "; $montant_total += number_format($avoir->montant_ttc - $montant_reglements , $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="text-align:left; font-size:10px; cursor:pointer" id="avoir4_<?php echo $avoir->ref_doc;?>"> /
									<?php
				if ($avoir->montant_ttc) { echo number_format($avoir->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="padding-left:5px; font-size:10px;"><div  id="add_avoir_<?php echo $avoir->ref_doc; ?>" style="cursor:pointer">Ajouter</div></td>
						</tr>
						<tr>
							<td colspan="5"><div style="height:8px; line-height:8px; border-bottom:1px solid #d6d6d6;"></div>
									<script type="text/javascript">
				Event.observe('avoir_<?php echo $avoir->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_faf','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $avoir->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('avoir2_<?php echo $avoir->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_faf','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $avoir->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('avoir3_<?php echo $avoir->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_faf','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $avoir->ref_doc; ?>'),'true','_blank');
				});
				Event.observe('avoir4_<?php echo $avoir->ref_doc; ?>', "click", function(evt){
					page.verify ('document_edition_faf','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $avoir->ref_doc; ?>'),'true','_blank');
				});
				
				
				Event.observe('add_avoir_<?php echo $avoir->ref_doc; ?>', "click", function(evt){
					add_avoir  ("<?php echo $avoir->ref_doc; ?>", "<?php echo $document->getRef_doc ();?>");
				});
				</script>
							</td>
						</tr>
						<?php
			}
		}
		?>
						<tr>
							<td style="width:25%">&nbsp;</td>
							<td style="font-weight:bolder; width:40%; text-align:right; padding-right:10px"> Total: </td>
							<td style="font-weight:bolder; text-align:right "><?php echo $montant_total." ".$MONNAIE[1];;?> </td>
							<td style=""></td>
						</tr>
					</table>
				</div>
			<?php } ?>
				<br />
				<!--Affichage des reglements ajoutables au total si FAC-->
				<?php
if( ($id_type_doc == $FACTURE_CLIENT_ID_TYPE_DOC && $montant_positif != 0) || ($id_type_doc == $COMMANDE_CLIENT_ID_TYPE_DOC && $id_etat_doc == 9))  {
	?>
				<div>
					<div style="display:block; text-align:left; font-weight:bolder"> Règlements non attribués . </div>
					<table width="100%" border="0"  cellspacing="0" style="width:100%; background-color:#FFFFFF; border:1px solid #d6d6d6;">
						<tr>
							<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>
						<?php
		$montant_total = 0;
		foreach ($liste_regmnt_to_use as $regmnt) {
				$montant_reglements = 0;
				$montant_used = 0;
				if (isset($regmnt->montant_used)) { $montant_used = number_format($regmnt->montant_used, $TARIFS_NB_DECIMALES, ".", "");}
			if (isset($regmnt->montant_reglement)) {
			?>
						<tr>
							<td style="font-size:10px; " id="regmnt_<?php echo $regmnt->ref_reglement;?>"><?php echo date_Us_to_Fr($regmnt->date_reglement);?><br />
							</td>
							<td style="font-size:10px; " id="regmnt2_<?php echo $regmnt->ref_reglement;?>"><?php echo htmlentities($regmnt->lib_reglement_mode);?><br />
							</td>
							<td style="text-align:right; font-size:10px; padding-right:2px;  " id="regmnt3_<?php echo $regmnt->ref_reglement;?>"><?php
				if ($regmnt->montant_reglement) { echo number_format($regmnt->montant_reglement- $montant_used, $TARIFS_NB_DECIMALES, ".", ""	)." "; $montant_total += number_format($regmnt->montant_reglement - $montant_used , $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="text-align:left; font-size:10px; " id="regmnt4_<?php echo $regmnt->ref_reglement;?>"> /
									<?php
				if ($regmnt->montant_reglement) { echo number_format($regmnt->montant_reglement, $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="padding-left:5px; font-size:10px;"><div  id="add_regmnt_<?php echo $regmnt->ref_reglement; ?>" style="cursor:pointer">Ajouter</div></td>
						</tr>
						<tr>
							<td colspan="5"><div style="height:8px; line-height:8px; border-bottom:1px solid #d6d6d6;"></div>
									<script type="text/javascript">
				Event.observe('add_regmnt_<?php echo $regmnt->ref_reglement; ?>', "click", function(evt){
					add_regmnt  ("<?php echo $regmnt->ref_reglement; ?>", "<?php echo $document->getRef_doc ();?>");
				});
				</script>
							</td>
						</tr>
						<?php
			}
		}
		?>
						<tr>
							<td style="width:25%">&nbsp;</td>
							<td style="font-weight:bolder; width:40%; text-align:right; padding-right:10px"> Total: </td>
							<td style="font-weight:bolder; text-align:right "><?php echo $montant_total." ".$MONNAIE[1];;?> </td>
							<td style=""></td>
						</tr>
					</table>
				</div>
			<?php } ?>
				<!--Affichage des reglements ajoutables au total si FAF et montant positif-->
				<?php 
if( $id_type_doc == $FACTURE_FOURNISSEUR_ID_TYPE_DOC && $montant_positif == 1) { 
	?>
				<div>
					<div style="display:block; text-align:left; font-weight:bolder"> Règlements non attribués . </div>
					<table width="100%" border="0"  cellspacing="0" style="width:100%; background-color:#FFFFFF; border:1px solid #d6d6d6;">
						<tr>
							<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:40%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
							<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						</tr>
						<?php
		$montant_total = 0;
		foreach ($liste_regmnt_to_use as $regmnt) {
				$montant_reglements = 0;
				$montant_used = 0;
				if (isset($regmnt->montant_used)) { $montant_used = number_format($regmnt->montant_used, $TARIFS_NB_DECIMALES, ".", "");}
			if (isset($regmnt->montant_reglement)) {
			?>
						<tr>
							<td style="font-size:10px; " id="regmnt_<?php echo $regmnt->ref_reglement;?>"><?php echo date_Us_to_Fr($regmnt->date_reglement);?><br />
							</td>
							<td style="font-size:10px; " id="regmnt2_<?php echo $regmnt->ref_reglement;?>"><?php echo htmlentities($regmnt->lib_reglement_mode);?><br />
							</td>
							<td style="text-align:right; font-size:10px; padding-right:2px;  " id="regmnt3_<?php echo $regmnt->ref_reglement;?>"><?php
				if ($regmnt->montant_reglement) { echo number_format($regmnt->montant_reglement- $montant_used, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]; $montant_total += number_format($regmnt->montant_reglement - $montant_used , $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="text-align:left; font-size:10px; " id="regmnt4_<?php echo $regmnt->ref_reglement;?>"> /
									<?php
				if ($regmnt->montant_reglement) { echo number_format($regmnt->montant_reglement, $TARIFS_NB_DECIMALES, ".", ""	); }?>
							</td>
							<td style="padding-left:5px; font-size:10px;"><div  id="add_regmnt_<?php echo $regmnt->ref_reglement; ?>" style="cursor:pointer">Ajouter</div></td>
						</tr>
						<tr>
							<td colspan="5"><div style="height:8px; line-height:8px; border-bottom:1px solid #d6d6d6;"></div>
									<script type="text/javascript">
				Event.observe('add_regmnt_<?php echo $regmnt->ref_reglement; ?>', "click", function(evt){
					add_regmnt  ("<?php echo $regmnt->ref_reglement; ?>", "<?php echo $document->getRef_doc ();?>");
				});
				</script>
							</td>
						</tr>
						<?php
			}
		}
		?>
						<tr>
							<td style="width:25%">&nbsp;</td>
							<td style="font-weight:bolder; width:40%; text-align:right; padding-right:10px"> Total: </td>
							<td style="font-weight:bolder; text-align:right "><?php echo $montant_total." ".$MONNAIE[1];;?> </td>
							<td style=""></td>
						</tr>
					</table>
				</div>
			<?php } ?>
		</td>
	</tr>
</table>
<?php }?>	
<script type="text/javascript">
$("docs_liste").innerHTML = "";

//on masque le chargement
H_loading();

</script>