<?php

// *************************************************************************************************************
// ONGLET DE COMPTABILITE FAC
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
<div style="width:100%; ">
<div style="padding:20px">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td style="border-bottom:1px solid #000000; font-weight:bolder">
			Ventilation facture Fournisseur
			</td>
		</tr>
		<tr>
			<td >&nbsp;
			
			</td>
		</tr>
		<tr>
			<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="width:50%;">
					
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="width:40%; font-weight:bolder">Réf Doc</td>
					<td style=" width:60%;font-weight:bolder; color:#999999">
					<span style="cursor:pointer" id="link_edit_doc"><?php echo $document->getRef_doc();?></span>
					
					<script type="text/javascript">
					Event.observe("link_edit_doc", "click",  function(evt){Event.stop(evt); page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo $document->getRef_doc()?>'),'true','_blank');}, false);
					</script>
					</td>
				</tr>
				<tr>
					<td style="font-weight:bolder">Tiers</td>
					<td style="font-weight:bolder; color:#999999"><?php echo $document->getNom_contact ();?></td>
				</tr>
				<tr>
					<td style="font-weight:bolder">Date</td>
					<td style="font-weight:bolder; color:#999999"><?php echo date_Us_to_Fr($document->getDate_creation ());?></td>
				</tr>
				<tr>
					<td style="font-weight:bolder"></td>
					<td style="font-weight:bolder; color:#999999"></td>
					
				</tr>
			</table>
					</td>
					<td style="width:50%;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="width:40%; font-weight:bolder">Récapitulatif</td>
					<td style=" width:60%;font-weight:bolder; color:#999999"></td>
				</tr>
				<tr>
					<td style="width:20%; font-weight:bolder; text-align:right">Montant TTC: </td>
					<td style="font-weight:bolder; color:#999999; text-align:right"><?php echo (number_format($document->getMontant_ttc (), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]);?></td>
				</tr>
				<tr>
					<td style="width:20%; font-weight:bolder; text-align:right">Montant HT: </td>
					<td style="font-weight:bolder; color:#999999; text-align:right"><?php echo (number_format($document->getMontant_ht (), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]);?></td>
				</tr>
				<tr>
					<td colspan="2">
					<?php 
					$lib_tva = "TVA:";
					$liste_tva_doc = $document->getTVAs();
					foreach ($liste_tva_doc as $key=>$val) {
					?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td style="width:40%; font-weight:bolder; text-align:right"><span style="text-align:right"><?php echo $lib_tva;?> <?php echo $key;?>%</span>
							</td>
							<td style="font-weight:bolder; color:#999999; text-align:right"><?php echo (number_format($val, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1]);?>
							</td>
						</tr>
					</table>
					<?php 
						$lib_tva = "";
					}
					?>
					</td>
				</tr>
			</table>
					</td>
				</tr>
			</table>
<br />

			</td>
		</tr>
		<tr>
			<td >&nbsp;
			
			</td>
		</tr>
		<tr>
			<td >
			<form action="documents_compta_8_mod.php" id="documents_compta_8_mod" name="documents_compta_8_mod" target="formFrame">
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td  style="width:25%; font-weight:bolder; border-top:1px solid #DDDDDD">&nbsp;
				
				</td>
				<td colspan="4" style="border-top:1px solid #DDDDDD">
				</td>
			</tr>
			<tr>
				<td style="width:25%">&nbsp;</td>
				<td style="font-weight:bolder; width:26%; text-align:center; padding-right:15px">Montant</td>
				<td style="font-weight:bolder; width:18%; text-align:center">N° Compte</td>
				<td style="font-weight:bolder; width:22%">Libellé</td>
				<td style="width:4%">&nbsp;</td>
			</tr>
			</table>
			
			
			
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td  style="width:33%; font-weight:bolder; border-top:1px solid #DDDDDD">
					Montant HT
					</td>
					<td  style=" border-top:1px solid #DDDDDD">
			
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="font-weight:bolder; width:38%; text-align:right; padding-right:15px">&nbsp;</td>
						<td style="font-weight:bolder; width:24%; text-align:center">&nbsp;</td>
						<td style="font-weight:bolder; width:33%">&nbsp;</td>
						<td style="width:5%">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="4">
						<div id="liste_comptes_6">
						<?php
						$i = 0;
						$montant = 0;
						$liste_ventil_ht = $ventillation_facture["6"];
						foreach ($liste_ventil_ht as $line_ventil) {
							$montant += $line_ventil->montant;
							include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_compta_line.inc.php";
							$i++;
						}
						?>
						</div>
						</td>
					</tr>
					<tr>
						<td colspan="3" style="border-bottom:1px solid #FFFFFF"><br />
		&nbsp;
						</td>
						<td>
						<span style="color:#66CC33; font-weight:bolder; font-size:18px; cursor:pointer" id="doc_compta_add_line_6">+</span>
						</td>
					</tr>
					<tr>
						<td colspan="4">&nbsp;
						</td>
					</tr>
					<tr>
						<td style="text-align: right">
						<div style="padding-right:35px">
						<span id="doc_compta_tot_montant_ht_ok" style="color:#66CC33; font-weight:bolder; display:">
						<?php echo number_format($document->getMontant_ht(), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>
						</span>
						</div>
						</td>
						<td colspan="2" style="text-align:left">
						<span id="doc_compta_tot_montant_ht_nok" style="color:#FF0000; font-weight:bolder; display:none"> Le total HT des lignes comptables doit correspondre au montant HT du document: 
						<?php echo number_format($document->getMontant_ht(), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>
						</span>
						</td>
						<td>
						</td>
					</tr>
				<tr>
					<td colspan="5">&nbsp;
					</td>
				</tr>
			</table>
				</td>
				</tr>
			</table>
					
					
					
					
			
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td  style="width:33%; font-weight:bolder; border-top:1px solid #DDDDDD">
					Montant TVA
					</td>
					<td  style=" border-top:1px solid #DDDDDD">
			
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td style="font-weight:bolder; width:38%; text-align:right; padding-right:15px">&nbsp;</td>
							<td style="font-weight:bolder; width:24%; text-align:center">&nbsp;</td>
							<td style="font-weight:bolder; width:33%">&nbsp;</td>
							<td style="width:5%">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="4">
							<div id="liste_comptes_7">
							<?php
							$montant = 0;
							$liste_ventil_tva = $ventillation_facture["7"];
							foreach ($liste_ventil_tva as $line_ventil) {
								$montant += $line_ventil->montant;
								include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_compta_line.inc.php";
								$i++;
							}
							?>
							</div>
							</td>
						</tr>
						<tr>
							<td colspan="3" style="border-bottom:1px solid #FFFFFF"><br />
			&nbsp;
							</td>
							<td>
							<span style="color:#66CC33; font-weight:bolder; font-size:18px; cursor:pointer" id="doc_compta_add_line_7">+</span>
							</td>
						</tr>
						<tr>
							<td colspan="4">&nbsp;
							</td>
						</tr>
						<tr>
							<td style="text-align: right">
							<div style="padding-right:35px">
							<span id="doc_compta_tot_montant_tva_ok" style="color:#66CC33; font-weight:bolder; display:">
							<?php echo number_format($document->getMontant_tva(), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>
							</span>
							</div>
							</td>
							<td colspan="2" style="text-align:left">
							<span id="doc_compta_tot_montant_tva_nok" style="color:#FF0000; font-weight:bolder; display:none"> Le total TVA des lignes comptables doit correspondre au montant TVA du document: 
							<?php echo number_format($document->getMontant_tva(), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>
							</span>
							</td>
							<td>
							</td>
						</tr>
					<tr>
						<td colspan="5">&nbsp;
						</td>
					</tr>
				</table>
				</td>
				</tr>
			</table>
					
					
					
					
					
					
					
			
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td  style="width:33%; font-weight:bolder; border-top:1px solid #DDDDDD">
					Montant TTC
					</td>
					<td  style=" border-top:1px solid #DDDDDD">
			
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td style="font-weight:bolder; width:38%; text-align:right; padding-right:15px">&nbsp;</td>
							<td style="font-weight:bolder; width:24%; text-align:center">&nbsp;</td>
							<td style="font-weight:bolder; width:33%">&nbsp;</td>
							<td style="width:5%">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="4">
							<div id="liste_comptes_8">
							<?php
							$montant = 0;
							$liste_ventil_ttc = $ventillation_facture["8"];
							foreach ($liste_ventil_ttc as $line_ventil) {
								$montant += $line_ventil->montant;
								include $DIR.$_SESSION['theme']->getDir_theme()."page_documents_compta_line.inc.php";
								$i++;
							}
							?>
							</div>
							</td>
						</tr>
						<tr>
							<td colspan="3" style="border-bottom:1px solid #FFFFFF"><br />
			&nbsp;
							</td>
							<td>
							</td>
						</tr>
						<tr>
							<td colspan="4">&nbsp;
							</td>
						</tr>
						<tr>
							<td style="text-align: right">
							<div style="padding-right:35px">
							<span id="doc_compta_tot_montant_ttc_ok" style="color:#66CC33; font-weight:bolder; display:">
							<?php echo number_format($document->getMontant_ttc(), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>
							</span>
							</div>
							</td>
							<td colspan="2" style="text-align:left">
							<span id="doc_compta_tot_montant_ttc_nok" style="color:#FF0000; font-weight:bolder; display:none"> Le total doit correspondre au montant TTC du document: 
							<?php echo number_format($document->getMontant_ttc(), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?>
							</span>
							</td>
							<td>
							</td>
						</tr>
					<tr>
						<td colspan="5">&nbsp;
						</td>
					</tr>
				</table>
					
					
					
					
					
					
					
				</td>
				</tr>
			</table>
			<input type="hidden" id="indentation_compta_lignes" name="indentation_compta_lignes" value="<?php echo $i;?>" />
			<input type="hidden" id="ref_doc_compta" name="ref_doc_compta" value="<?php echo $document->getRef_doc();?>" />
			<input type="hidden" id="doc_compta_montant_ht" name="doc_compta_montant_ht" value="<?php echo  number_format($document->getMontant_ht(), $TARIFS_NB_DECIMALES, ".", ""	);?>" />
			<input type="hidden" id="doc_compta_montant_tva" name="doc_compta_montant_tva" value="<?php echo  number_format($document->getMontant_tva(), $TARIFS_NB_DECIMALES, ".", ""	);?>" />
			<input type="hidden" id="doc_compta_montant_ttc" name="doc_compta_montant_ttc" value="<?php echo  number_format($document->getMontant_ttc(), $TARIFS_NB_DECIMALES, ".", ""	);?>" />
			<?php if (isset($_REQUEST["from_grand_livre"])) { ?>
			<input type="hidden" id="reload_search_grand_livre" name="reload_search_grand_livre" value="<?php echo $_REQUEST["from_grand_livre"];?>" />
			
			<?php } ?><br />

				<input name="valider_compta" id="valider_compta" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" style="float:right" />
			</form>
			</td>
		</tr>
	</table>
	
	
	<script type="text/javascript">
					Event.observe('doc_compta_add_line_6', 'click',  function(evt){
						Event.stop(evt);
						insert_compta_line("6");
					},false); 
					Event.observe('doc_compta_add_line_7', 'click',  function(evt){
						Event.stop(evt);
						insert_compta_line("7");
					},false); 
	
					Event.observe('documents_compta_8_mod', 'submit',  function(evt){
						Event.stop(evt);
						if (check_document_compta_lignes ()) {
							$("documents_compta_8_mod").submit();
						}
					},false); 
	//on masque le chargement
	H_loading();
	</script>
</div>
<div>
