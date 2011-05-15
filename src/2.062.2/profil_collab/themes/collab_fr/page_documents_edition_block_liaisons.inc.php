<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************

$doc_liaisons_source = array();
$doc_liaisons_dest = array();
$diff_array = array();

//suppression des doublons dans les résultats de liaison
if ($doc_liaisons_possibles) {
	for ($i = 0; $i <= count($doc_liaisons_possibles); $i++) {
		if (!isset($doc_liaisons_possibles[$i])) {continue;}
		if(isset($diff_array[$doc_liaisons_possibles[$i]->ref_doc])) { unset($doc_liaisons_possibles[$i]); continue;}
		$diff_array[$doc_liaisons_possibles[$i]->ref_doc] = $doc_liaisons_possibles[$i];
	}
}

if (isset ($doc_liaisons['source'])) {
	$doc_liaisons_source = $doc_liaisons['source'];
	if ($doc_liaisons_possibles) {
		foreach ($doc_liaisons_source as $doc_source) {
			for ($i = 0; $i <= count($doc_liaisons_possibles); $i++) {
				if (isset($doc_liaisons_possibles[$i]) && $doc_liaisons_possibles[$i]->ref_doc == $doc_source->ref_doc_source) {
					unset($doc_liaisons_possibles[$i]); continue;
				}
			}
		}
	}
}
if (isset ($doc_liaisons['dest'])) {
	$doc_liaisons_dest = $doc_liaisons['dest'];
	if ($doc_liaisons_possibles) {
		foreach ($doc_liaisons_dest as $doc_dest) {
			for ($i = 0; $i <= count($doc_liaisons_possibles); $i++) {
				if (isset($doc_liaisons_possibles[$i]) && $doc_liaisons_possibles[$i]->ref_doc == $doc_dest->ref_doc_destination) {
					unset($doc_liaisons_possibles[$i]); continue;
				}
			}
		}
	}
}

//$doc_liaisons_possibles = array_diff ($doc_liaisons_possibles , $diff_array);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
lets_open = "";
lets_open = "<?php if (!isset($_REQUEST["lets_open"])) {?>&lets_open=1<?php } ?>";
</script>
<?php 
	if ($doc_liaisons_dest || $doc_liaisons_possibles || $doc_liaisons_source){
	?>
	<table cellpadding="0" cellspacing="0" border="0" style="width:100%" class="document_box">
		<tr style=" line-height:26px; height:26px;" class="document_box_color">
			<td style=" line-height:26px; height:26px;padding-left:3px; border-bottom:1px solid #FFFFFF " class="doc_bold"  >
				Documents associ&eacute;s
			</td>
			<td style="line-height:26px; height:26px; padding-right:3px; border-bottom:1px solid #FFFFFF ; cursor:pointer; text-align:right" class="doc_bold"  id="show_liaisons_possibles">
			<?php 
			// affichage des liaisons possibles
			if ($doc_liaisons_possibles) {
				?>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ding.gif" /><span style="text-decoration:underline; color:#000000">Attention des documents peuvent &ecirc;tre associ&eacute;s &agrave; ce document.</span>		
				<?php 
			}
			?>
			</td>
		</tr>
		<tr>
		<td colspan="2" class="document_box_bottom_liaison">
		<?php 
		// affichage des liaisons possibles
		if ($doc_liaisons_possibles) {
			?>
			<div id="liste_liaisons_possibles" style=" <?php if (!isset($_REQUEST["lets_open"])) {?>display:none;<?php } ?> width:100%">
				<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
				<?php 
				$increment_liaisons_pos = 0;
					?>
					<?php 
					foreach ($doc_liaisons_possibles as $doc_liaison_possible) {
						?>
						<tr style="cursor:pointer" id="liaison_pos_<?php echo $increment_liaisons_pos; ?>">
							<td style=" padding-left:3px; width:20%;" id="liaison_pos_1_<?php echo $increment_liaisons_pos; ?>"><?php echo htmlentities($doc_liaison_possible->ref_doc);?></td>
							<td style=" padding-left:3px; width:30%;" id="liaison_pos_2_<?php echo $increment_liaisons_pos; ?>"><?php echo htmlentities($doc_liaison_possible->lib_type_doc);?></td>
							<td style=" padding-left:3px; width:20%;" id="liaison_pos_3_<?php echo $increment_liaisons_pos; ?>"><?php echo htmlentities($doc_liaison_possible->lib_etat_doc);?></td>
							<td style=" padding-left:3px; width:20%;" id="liaison_pos_4_<?php echo $increment_liaisons_pos; ?>"><?php echo date_Us_to_Fr ($doc_liaison_possible->date_creation);?> <?php echo getTime_from_date($doc_liaison_possible->date_creation);?></td>
							<td style="text-align:right">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-link.gif" id="lier_liaison_pos_<?php echo $increment_liaisons_pos; ?>" alt="associer les documents" title="associer les documents" />				
							</td>
						</tr>
						<?php
						$increment_liaisons_pos++;
					}
					?>
				</table>
			<div style="border-bottom:1px solid #000000"></div>
			</div>
		<script type="text/javascript">
		Event.observe("show_liaisons_possibles", "click", function(evt){ 
			if ($("liste_liaisons_possibles").style.display == "none") {
				$("liste_liaisons_possibles").show();
				lets_open = "&lets_open=1";
			} else {
				$("liste_liaisons_possibles").hide();
				lets_open = "";
			}
		});
		<?php
		$increment_liaisons_pos = 0;
		foreach ($doc_liaisons_possibles as $doc_liaison_possible) {
			?>
			Event.observe('liaison_pos_1_<?php echo $increment_liaisons_pos; ?>', "click", function(evt){
		page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($doc_liaison_possible->ref_doc)?>'),'true','_blank');
			});
			Event.observe('liaison_pos_2_<?php echo $increment_liaisons_pos; ?>', "click", function(evt){
		page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($doc_liaison_possible->ref_doc)?>'),'true','_blank');
			});
			Event.observe('liaison_pos_3_<?php echo $increment_liaisons_pos; ?>', "click", function(evt){
		page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($doc_liaison_possible->ref_doc)?>'),'true','_blank');
			});
			Event.observe('liaison_pos_4_<?php echo $increment_liaisons_pos; ?>', "click", function(evt){
		page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($doc_liaison_possible->ref_doc)?>'),'true','_blank');
			});
				
			Event.observe('lier_liaison_pos_<?php echo $increment_liaisons_pos; ?>', "click", function(evt){	link_document_from ("<?php echo $document->getRef_doc ()?>", "<?php echo $doc_liaison_possible->ref_doc ?>"); });
			<?php
			$increment_liaisons_pos++;
		}
		?>
		</script>
		<?php
		}
		?>
	
		<?php 
		//documents étant la cible de ce document
		$increment_liaisons = 0;
		if ($doc_liaisons_dest) {
			?>
			<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
			<?php 
			foreach ($doc_liaisons_dest as $doc_liaison_dest) {
				?>
				<tr style="cursor:pointer; <?php if (!$doc_liaison_dest->active) { ?> color:#999999;<?php } ?>" id="liaison_<?php echo $increment_liaisons; ?>">
					<td style=" padding-left:3px; width:20%;" id="liaison_1_<?php echo $increment_liaisons; ?>"><?php echo htmlentities($doc_liaison_dest->ref_doc_destination);?></td>
					<td style=" padding-left:3px; width:30%;" id="liaison_2_<?php echo $increment_liaisons; ?>"><?php echo htmlentities($doc_liaison_dest->lib_type_doc);?></td>
					<td style=" padding-left:3px; width:20%;" id="liaison_3_<?php echo $increment_liaisons; ?>"><?php echo htmlentities($doc_liaison_dest->lib_etat_doc);?></td>
					<td style=" padding-left:3px; width:20%;" id="liaison_4_<?php echo $increment_liaisons; ?>"><?php echo date_Us_to_Fr ($doc_liaison_dest->date_creation);?> <?php echo getTime_from_date($doc_liaison_dest->date_creation);?></td>
					<td style="text-align:right">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="delier_liaison_<?php echo $increment_liaisons; ?>"  alt="Rompre la liaison" title="Rompre la liaison" />				
					</td>
				</tr>
				<?php
				$increment_liaisons++;
			}
			?>
			</table>
			<?php
		}
		?>
		<?php 
		//documents ayant pour cible ce document
		if ($doc_liaisons_source) {
			?>
			<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
			<?php 
			foreach ($doc_liaisons_source as $doc_liaison_source) {
				?>
				<tr style="cursor:pointer; <?php if (!$doc_liaison_source->active) { ?> color:#999999;<?php } ?>" id="liaison_<?php echo $increment_liaisons; ?>">
					<td style=" padding-left:3px; width:20%;" id="liaison_1_<?php echo $increment_liaisons; ?>"><?php echo htmlentities($doc_liaison_source->ref_doc_source);?></td>
					<td style=" padding-left:3px; width:30%;" id="liaison_2_<?php echo $increment_liaisons; ?>"><?php echo htmlentities($doc_liaison_source->lib_type_doc);?></td>
					<td style=" padding-left:3px; width:20%;" id="liaison_3_<?php echo $increment_liaisons; ?>"><?php echo htmlentities($doc_liaison_source->lib_etat_doc);?></td>
					<td style=" padding-left:3px; width:20%;" id="liaison_4_<?php echo $increment_liaisons; ?>"><?php echo date_Us_to_Fr ($doc_liaison_source->date_creation);?> <?php echo getTime_from_date($doc_liaison_source->date_creation);?></td>
					<td style="text-align:right">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="delier_liaison_<?php echo $increment_liaisons; ?>" alt="Rompre la liaison" title="Rompre la liaison" />				
					</td>
				</tr>
				<?php
				$increment_liaisons++;
			}
			?>
			</table>
			<?php
		}
		?>
		</td>
		</tr>
	</table>
	
	<script type="text/javascript">
	<?php
	$increment_liaisons = 0;
	foreach ($doc_liaisons_dest as $doc_liaison_dest) {
		?>
		Event.observe('liaison_1_<?php echo $increment_liaisons; ?>', "click", function(evt){ 
		page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($doc_liaison_dest->ref_doc_destination)?>'),'true','_blank');
		});
		Event.observe('liaison_2_<?php echo $increment_liaisons; ?>', "click", function(evt){ 
		page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($doc_liaison_dest->ref_doc_destination)?>'),'true','_blank');
		});
		Event.observe('liaison_3_<?php echo $increment_liaisons; ?>', "click", function(evt){ 
		page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($doc_liaison_dest->ref_doc_destination)?>'),'true','_blank');
		});
		Event.observe('liaison_4_<?php echo $increment_liaisons; ?>', "click", function(evt){ 
		page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($doc_liaison_dest->ref_doc_destination)?>'),'true','_blank');
		});
		
		Event.observe('delier_liaison_<?php echo $increment_liaisons; ?>', "click", function(evt){
		alerte.confirm_supprimer_and_callpage ("liaison_sup_confirm", "documents_edition_block_liaisons_unlink.php?ref_doc=<?php echo $document->getRef_doc ()?>&ref_doc_liaison=<?php echo $doc_liaison_dest->ref_doc_destination ?>"+lets_open);
			});
		<?php
		$increment_liaisons++;
	}
	?>
	<?php
	foreach ($doc_liaisons_source as $doc_liaison_source) {
		?>
		Event.observe('liaison_1_<?php echo $increment_liaisons; ?>', "click", function(evt){ 
		page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($doc_liaison_source->ref_doc_source)?>'),'true','_blank');
		});
		Event.observe('liaison_2_<?php echo $increment_liaisons; ?>', "click", function(evt){
		page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($doc_liaison_source->ref_doc_source)?>'),'true','_blank');
		});
		Event.observe('liaison_3_<?php echo $increment_liaisons; ?>', "click", function(evt){
		page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($doc_liaison_source->ref_doc_source)?>'),'true','_blank');
		});
		Event.observe('liaison_4_<?php echo $increment_liaisons; ?>', "click", function(evt){
		page.verify('documents_edition','index.php#'+escape('documents_edition.php?ref_doc=<?php echo htmlentities($doc_liaison_source->ref_doc_source)?>'),'true','_blank');
		});
		
		Event.observe('delier_liaison_<?php echo $increment_liaisons; ?>', "click", function(evt){Event.stop(evt);
		alerte.confirm_supprimer_and_callpage ("liaison_sup_confirm", "documents_edition_block_liaisons_unlink.php?ref_doc=<?php echo $document->getRef_doc ()?>&ref_doc_liaison=<?php echo $doc_liaison_source->ref_doc_source ?>"+lets_open);
		 });
		<?php
		$increment_liaisons++;
	}
	?>
	//on masque le chargement
	H_loading();
	
	</script>
	<?php
}
?>

