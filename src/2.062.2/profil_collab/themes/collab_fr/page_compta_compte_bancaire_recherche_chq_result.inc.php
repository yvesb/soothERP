<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "fiches", "form['page_to_show']", "form['fiches_par_page']", "nb_fiches");
check_page_variables ($page_variables);



?>

<div  class="mt_size_optimise">
<div style="border-bottom:1px solid #000000; font-weight:bolder">
Résultat de la recherche
</div><br />

<?php 
if (count($fiches)) { 
	?>
<table  cellspacing="0" id="tableresult">
	<tr>
		<td style="width:15%; font-weight:bolder;">
		<a href="#"  id="order_date">
		Date
		</a>
			
		</td>
		<td style="width:15%; font-weight:bolder;">
		Numéro
			
		</td>
		<td style="width:20%; font-weight:bolder;">
		Banque 
		</td>
		<td style="width:20%; font-weight:bolder;">
		Porteur 
		</td>
		<td style="width:15%; text-align:right; font-weight:bolder;">
		Montant
		</td>
		<td style="width:15%; text-align:center; font-weight:bolder;">
		Remise n°
		</td>
		<td style="text-align:right;">
		</td>
	</tr>
	<?php 
	$colorise=0;
	foreach ($fiches as $fiche) {
		$colorise++;
		$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
		?>
		<tr>
			<td  >
				<div id="link_reg_ref_<?php echo $colorise;?>" style="cursor:pointer">
				<?php echo date_Us_to_Fr($fiche->date_depot)?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->reference) { ?>
					page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->reference;?>','true','edition_reglement');
					$("edition_reglement").show();
					$("edition_reglement_iframe").show();
					<?php } ?>
				});
				</script>
			</td>
			<td >
				<div id="link_reg_ref_0_<?php echo $colorise;?>" style="cursor:pointer">
				<?php echo $fiche->numero;?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->reference) { ?>
					page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->reference;?>','true','edition_reglement');
					$("edition_reglement").show();
					$("edition_reglement_iframe").show();
					<?php } ?>
				});
				</script>
			</td>
			<td>
				<div id="link_reg_ref_1_<?php echo $colorise;?>" style="cursor:pointer">
				<?php echo $fiche->banque;?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_1_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->reference) { ?>
					page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->reference;?>','true','edition_reglement');
					$("edition_reglement").show();
					$("edition_reglement_iframe").show();
					<?php } ?>
				});
				</script>
			
			</td>
			<td>
				<div id="link_reg_ref_2_<?php echo $colorise;?>" style="cursor:pointer">
				<?php echo $fiche->porteur;?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_2_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->reference) { ?>
					page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->reference;?>','true','edition_reglement');
					$("edition_reglement").show();
					$("edition_reglement_iframe").show();
					<?php } ?>
				});
				</script>
			</td>
			<td style="text-align:right;">
				<div id="link_reg_ref_3_<?php echo $colorise;?>" style="cursor:pointer">
				<?php	 echo price_format(abs($fiche->montant_depot))." ".$MONNAIE[1]; ?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_3_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->reference) { ?>
					page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->reference;?>','true','edition_reglement');
					$("edition_reglement").show();
					$("edition_reglement_iframe").show();
					<?php } ?>
				});
				</script>
			</td>
			<td style="text-align:center;">
				<?php	 echo $fiche->num_remise; ?>
			</td>
			<td style="text-align:right;">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" style="cursor:pointer" id="print_depot_<?php echo $colorise;?>" title="Voir la remise"/>
			<script type="text/javascript">
			Event.observe("print_depot_<?php echo $colorise;?>", "click", function(evt) {
				page.verify("compta_depot_caisse_imprimer", "compta_depot_caisse_imprimer.php?id_caisse=<?php echo $fiche->id_compte_caisse_source;?>&id_compte_caisse_depot=<?php echo $fiche->id_compte_caisse_depot; ?>", "true", "_blank");
			}, false);
			</script>
			</td>
		</tr>
		<?php
	}
	?>
</table>
<?php 
} else { 
	?>
	Aucun chèque correspondant trouvé dans les remises en banques<br /><br />
	<?php 
	if (count($fiches2)) {
		?>
		
<div style="border-bottom:1px solid #000000; font-weight:bolder">
Recherche dans les contenus de caisses
</div><br />
	<table  cellspacing="0" id="tableresult">
		<tr>
			<td style="width:15%; font-weight:bolder;">
			<a href="#"  id="order_date">
			Date
			</a>
				
			</td>
			<td style="width:15%; font-weight:bolder;">
			Numéro
				
			</td>
			<td style="width:20%; font-weight:bolder;">
			Banque 
			</td>
			<td style="width:20%; font-weight:bolder;">
			Porteur 
			</td>
			<td style="width:15%; text-align:right; font-weight:bolder;">
			Montant
			</td>
			<td style="width:15%; text-align:center; font-weight:bolder;">
			Caisse
			</td>
			<td style="text-align:right;">
			</td>
		</tr>
		<?php
		$colorise=0;
		foreach ($fiches2 as $fiche) {
		$colorise++;
			?>
			<tr>
				<td  >
				<div id="link_reg_ref_<?php echo $colorise;?>" style="cursor:pointer">
					<?php echo date_Us_to_Fr($fiche->date_saisie)?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->ref_reglement) { ?>
					page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->ref_reglement;?>','true','edition_reglement');
					$("edition_reglement").show();
					$("edition_reglement_iframe").show();
					<?php } ?>
				});
				</script>
				</td>
				<td >
				<div id="link_reg_ref_0_<?php echo $colorise;?>" style="cursor:pointer">
					<?php echo $fiche->numero_cheque;?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_0_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->ref_reglement) { ?>
					page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->ref_reglement;?>','true','edition_reglement');
					$("edition_reglement").show();
					$("edition_reglement_iframe").show();
					<?php } ?>
				});
				</script>
				</td>
				<td>
				<div id="link_reg_ref_1_<?php echo $colorise;?>" style="cursor:pointer">
					<?php echo $fiche->info_banque;?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_1_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->ref_reglement) { ?>
					page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->ref_reglement;?>','true','edition_reglement');
					$("edition_reglement").show();
					$("edition_reglement_iframe").show();
					<?php } ?>
				});
				</script>
				</td>
				<td>
				<div id="link_reg_ref_2_<?php echo $colorise;?>" style="cursor:pointer">
					<?php echo $fiche->info_compte;?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_2_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->ref_reglement) { ?>
					page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->ref_reglement;?>','true','edition_reglement');
					$("edition_reglement").show();
					$("edition_reglement_iframe").show();
					<?php } ?>
				});
				</script>
				</td>
				<td style="text-align:right;">
				<div id="link_reg_ref_3_<?php echo $colorise;?>" style="cursor:pointer">
					<?php	 echo price_format(abs($fiche->montant_contenu))." ".$MONNAIE[1]; ?>
				</div>
				<script type="text/javascript">
				Event.observe("link_reg_ref_3_<?php echo $colorise;?>", "click",  function(evt){
					Event.stop(evt);
					<?php if ($fiche->ref_reglement) { ?>
					page.traitecontent('compta_reglements_edition','compta_reglements_edition.php?ref_reglement=<?php echo $fiche->ref_reglement;?>','true','edition_reglement');
					$("edition_reglement").show();
					$("edition_reglement_iframe").show();
					<?php } ?>
				});
				</script>
				</td>
				<td style="text-align:right;">
				<div id="compta_gestion2_caisse_<?php echo $colorise;?>" style="cursor:pointer">
					<?php	 echo $fiche->lib_caisse; ?>
				</div>
				<script type="text/javascript">
				Event.observe("compta_gestion2_caisse_<?php echo $colorise;?>", "click", function(evt) {
					page.verify("compta_gestion2_caisse", "index.php#compta_gestion2_caisse.php?id_caisse=<?php echo $fiche->id_compte_caisse;?>", "true", "_blank");
				}, false);
				</script>
					
				</td>
				<td style="text-align:right;">
				</td>
			</tr>
			<?php 
		}
		?>
	</table>
	<?php 
	} else {
		?>
		Aucun résultat approchant dans les contenus de caisses.
		<?php 
	}
} 
?>
<br />
<br />
<br />
<br />
<br />
<br />
<br />

</div>
<script type="text/javascript">

if ($("order_date")){
    Event.observe("order_date", "click",  function(evt){
            Event.stop(evt);
            $('orderby').value='date_depot';
            $('orderorder').value='<?php if ($form['orderorder']=="ASC" && $form['orderby']=="date_depot") {echo "DESC";} else {echo "ASC";}?>';
            page.compte_bancaire_recherche_chq();
    }, false);
}

//on masque le chargement
H_loading();
</SCRIPT>