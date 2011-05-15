<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "fiches");
check_page_variables ($page_variables);

$total_qte_commande = 0;
$total_qte_livre = 0;
$total_qte_A_livre = 0;
?>

<script type="text/javascript" language="javascript">
	array_menu_r_article	=	new Array();
	array_menu_r_article[0] 	=	new Array('recherche_cmde', 'menu_1');
</script>

<div class="emarge">

	<p class="titre">Commandes Client « en cours » pour : <?php echo $article->getLib_article(); ?></p>

	
	<div class="mt_size_optimise">
		<br />
		<div id="affresult">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="text-align:left;">R&eacute;sultat de la recherche :</td>
					<td ></td>
					<td style="text-align:right;">R&eacute;ponses : <?php echo count($fiches)?></td>
				</tr>
			</table>
		</div>
	
	<?php if(count($fiches)>0) { ?>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="tableresult">
			<tr class="colorise0">
				<td width="1%">&nbsp;</td>
				<td width="9%">
					Date
				</td>
				<td width="15%">
					Référence document
				</td>
				<td>
					Client
				</td>
				
				<!-- bac 17/05/2010 ajout date de livraison -->
				<td width="7%">
					A livrer le
				</td>
				<!-- bac .-->
				
				<td width="12%" style="text-align: right;">
					Qté commandée
				</td>
				<td width="9%" style="text-align: right;">
					Qté livrée
				</td>
				<td width="9%" style="text-align: right;">
					Qté à livrer
				</td>
				<td width="1%">&nbsp;</td>
			</tr>
		<?php 
		$colorise=0;
		foreach ($fiches as $fiche) {
		$colorise++;
		$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2'; ?>
			<tr class="<?php  echo  $class_colorise; ?>" id="line_<?php echo $colorise; ?>">
				<td>&nbsp;</td>
				<td class="reference">
					<?php	echo date_Us_to_Fr($fiche->date_creation_doc); ?>
				</td>
				<td>
					<?php	if ($fiche->ref_doc) {?>
					<a href="#" id="link_ref_doc_<?php echo $colorise; ?>" style="display:block; width:100%">
						<?php	echo $fiche->ref_doc; ?>&nbsp;
					</a>
					<script type="text/javascript">
						Event.observe("link_ref_doc_<?php echo $colorise; ?>", "click",  function(evt){
							Event.stop(evt);
							page.verify('affaires_affiche_fiche','index.php#'+escape('documents_edition.php?ref_doc=<?php echo ($fiche->ref_doc)?>'),'true','_blank');
						}, false);
					</script>
					<?php } ?>
				</td>
				<td>
					<?php	if ($fiche->nom_contact) {?>
					<a href="#" id="link_to_contact_name_<?php echo $colorise; ?>" style="display:block; width:100%">
						<?php	echo (substr(str_replace("€", "&euro;", $fiche->nom_contact), 0, 38)); ?>&nbsp;
					</a>
					<script type="text/javascript">
					Event.observe("link_to_contact_name_<?php echo $colorise; ?>", "click",  function(evt){
						Event.stop(evt);
						page.verify('affaires_affiche_fiche','index.php#'+escape('annuaire_view_fiche.php?ref_contact=<?php echo ($fiche->ref_contact)?>'),'true','_blank');
					}, false);
					</script>
					<?php } ?>
				</td>
				
				<!-- bac 2.054.0 ajout date de livraison -->
				<td>
					<?php if( $fiche->date_livraison) echo date_Us_to_Fr($fiche->date_livraison); ?>
				</td>
				<!-- bac. -->
				
				<td style="text-align:right;">
					<?php
					$total_qte_commande += $fiche->qte;
					echo $fiche->qte; ?>
				</td>
				<td style="text-align:right;">
					<?php 
					$total_qte_livre += $fiche->qte_livree;
					echo $fiche->qte_livree; ?>
				</td>
	
				<td style="text-align:right;">
					<?php 
					$total_qte_A_livre += $fiche->qte - $fiche->qte_livree;
					echo $fiche->qte - $fiche->qte_livree; ?>
				</td>
				<td>&nbsp;</td>
			</tr>
		<?php } 
		$colorise++;
		$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
		?>
		<tr class="<?php  echo  $class_colorise; ?>" id="line_<?php echo $colorise; ?>">
			<td colspan="5">&nbsp;</td>
			<td colspan="5"><hr/></td>
		</tr>
		<?php
		$colorise++;
		$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
		?>
		<tr class="<?php  echo  $class_colorise; ?>" id="line_<?php echo $colorise; ?>">
				<td>&nbsp;</td>
				<td></td>
				<td width="10%">
				
				</td>
				<td>
					TOTAL
				</td>
				
				<td></td>
				
				<td style="text-align: right;">
					<?php echo $total_qte_commande; ?> 
				</td>
				<td style="text-align: right;">
					<?php echo $total_qte_livre; ?> 
				</td>
				<td style="text-align: right;">
					<?php echo $total_qte_A_livre; ?> 
				</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		<br/>

		<br/>
		<div>
			<table  border="0" cellpadding="0" cellspacing="0" width="100%" >
				<tr>
					<td width="1%"></td>
					<td style="height:50px; vertical-align:middle; text-align:right;">
						<div id="export_liste_format_CSV" class="link_to_doc_fromart" style="float:right; font-size:10pt;">&gt;&gt; Exporter la liste au format CSV</div>
					</td>
					<td width="1%"></td>
				</tr>
			</table>
		</div>
		<script type="text/javascript">
			Event.observe("export_liste_format_CSV", "click",  function(evt){
				Event.stop(evt);
				page.catalogue_articles_export_CSV_cdc_en_cours("<?php echo $article->getRef_article(); ?>");
				//page.traitecontent("resultat","catalogue_articles_export_CSV_cdc_en_cours.php?ref_article=<?php echo $article->getRef_article(); ?>", true ,"resultat");
			}, false);
		</script>
		<div id="resultat"></div>
		<br/>
	</div>
	
	<?php } ?>
	<br />
</div>

<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>