<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


?>
<div>
	<a href="#" id="link_close_pop_up_commerciaux_det" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
	<script type="text/javascript">
	Event.observe("link_close_pop_up_commerciaux_det", "click",  function(evt){Event.stop(evt); $("pop_up_commerciaux_det").hide();}, false);
	</script><br />

<table width="100%" border="0" cellspacing="4" cellpadding="2">
	<tr>
		<td style="font-weight:bolder; text-align:left" colspan="2"></td>
		<td style="width:5%; font-weight:bolder; text-align:center"></td>
		<td style="width:45%; font-weight:bolder; text-align:center" colspan="2"></td>
	</tr>
	<?php 
	foreach ($liste_commerciaux as $commercial) {
	if ($commercial->ref_contact != $_REQUEST["ref_contact"]) {unset($commercial); continue;}
		?>
		<tr> 
			<td style="font-weight:bolder; text-align:left" colspan="2">Détail des résultats commerciaux - 
				<a href="index.php#annuaire_view_fiche.php?ref_contact=<?php echo $commercial->ref_contact;?>" target="_blank" class="common_link" ><?php echo htmlentities($commercial->nom); ?></a>
				
			</td>
			<td style="font-weight:bolder; text-align:right; color:#999999; ">
			</td>
			<td style="font-weight:bolder; text-align:left; padding-left:20px; color:#999999;" colspan="2">
			<span style="float:right"><?php echo number_format($commercial->ca, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></span>	Chiffre d'affaire généré:	
			</td>
		</tr>
		<tr> 
			<td style="font-weight:bolder; text-align:left" colspan="2">Période analysée du <?php echo ($form['date_debut']);?> au <?php echo ($form['date_fin']);?>
			</td>
			<td style="font-weight:bolder; text-align:left; padding-left:20px; color:#999999;">
			</td>
			<td style="font-weight:bolder; text-align:left; padding-left:20px; color:#999999; " colspan="2">
				<span style="float:right"><?php echo number_format($commercial->mg, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></span>
			 Marge générée:
			</td>
			</tr>
		<tr> 
			<td style="font-weight:bolder; text-align:left" colspan="2">
			</td>
			<td style="font-weight:bolder; text-align:right; color:#999999; ">
			</td>
			<td style="font-weight:bolder; text-align:left; padding-left:20px; color:#999999;" colspan="2">
			<span style="float:right"><?php echo number_format($commercial->comm, $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];?></span>
				TOTAL COMMISSIONS:
				
			</td>
		</tr>
		<tr>
			<td colspan="5">
			<span style="font-weight:bolder">
			<?php
			switch ($doc_fom_comm) {
				case "CDC": 
					?>Commissionnement sur les Commandes Clients<?php
				break;
				case "FAC": 
					?>Commissionnement sur les Factures Clients<?php
				break;
				case "RGM": 
					?>Commissionnement sur les  Factures Clients Acquitées<?php
				break;
			}
			?>
			</span>
			<div style="height:320px; overflow:auto;">
			<?php 
			if (count($commercial->docs)) {?>
			<table width="100%" border="0" cellspacing="4" cellpadding="2">
				<tr>
					<td style="width:15%; font-weight:bolder; text-align:left">Date </td>
					<td style="font-weight:bolder; text-align:left; ">Document&nbsp;Commercial</td>
					<td style="width:15%; font-weight:bolder; text-align:center">CA</td>
					<td style="width:15%; font-weight:bolder; text-align:center">Marge</td>
					<td style="width:15%; font-weight:bolder; text-align:center">Commission</td>
					<td style="font-weight:bolder; text-align:center; width:5%">Action</td>
				</tr>
					<?php 
						foreach ($commercial->docs as $docu) {
							?>
							<tr>
								<td style="width:15%; text-align:left"><?php echo date_Us_to_Fr($docu->date_creation_doc);?> </td>
								<td style="width:20%; text-align:left; ">
									<a href="index.php#documents_edition.php?ref_doc=<?php echo $docu->ref_doc?>" target="_blank" class="common_link"><?php echo $docu->ref_doc;?></a> <?php if (isset($docu->part) && $docu->part !=100) { echo "<span style='color:#999999'>(".$docu->part."%)</span>";}?>
								</td>
								<td style="width:15%; text-align:right; padding-right:15px;"><?php echo price_format($docu->ca)." ".$MONNAIE[1];?></td>
								<td style="width:15%; text-align:right; padding-right:15px;"><?php echo price_format($docu->mg)." ".$MONNAIE[1];?></td>
								<td style="width:15%; text-align:right; padding-right:15px;"><?php echo price_format($docu->comm)." ".$MONNAIE[1];?></td>
								<td style="text-align:center">
								<table>
									<tr>
										<td style="text-align:center"><span class="green_underlined" id="tb_<?php echo $commercial->ref_contact; ?>_<?php echo $docu->ref_doc; ?>" >Détails</span></td>
										<td style="width:5%; text-align:center; color:#97bf0d">-</td>
										<td style=" text-align:center"><span class="green_underlined" id="rc_<?php echo $commercial->ref_contact; ?>_<?php echo $docu->ref_doc; ?>">
			<a href="documents_editing.php?ref_doc=<?php echo $docu->ref_doc?>" target="_blank" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif"/></a> </span>
										</td>
									</tr>
								</table>
								<script type="text/javascript">
									Event.observe('tb_<?php echo $commercial->ref_contact; ?>_<?php echo $docu->ref_doc; ?>', "click", function(evt){
										page.traitecontent('marge_content','index.php#documents_edition.php?ref_doc=<?php echo $docu->ref_doc; ?>&marges=1','true','_blank');
										Event.stop(evt);
									});
									</script>
								</td>
							</tr>
							<?php
						}	
						?>
						</td>
					</tr>
				</table>
				<?php
			}
			?>

			</div>
			</td>
		</tr>
		<?php
	}
	?>
</table>
</div>


<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>