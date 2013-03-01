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



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<?php
$indentation_commande  = 0;
$indentation_article = 0;
foreach ($commandes as $commande) {
	
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="document_box_head">
		<tr>
			<td style="width:188px">
			<a href="#" id ="<?php echo htmlentities($stock_vu."_".$commande->ref_doc);?>" style="text-decoration:none; color:#000000">
			<?php echo htmlentities($commande->ref_doc);?>
			</a>
			<script type="text/javascript">
				Event.observe('<?php echo htmlentities($stock_vu."_".$commande->ref_doc);?>', 'click',  function(evt){ Event.stop(evt); window.open( "<?php echo $_ENV['CHEMIN_ABSOLU'].$_SESSION['profils'][$_SESSION['user']->getId_profil ()]->getDir_profil();?>#"+escape('documents_edition.php?ref_doc=<?php echo htmlentities($commande->ref_doc)?>'),'_blank');}, false);
			</script>
			</td>
			<td style="font-weight:bolder">&nbsp;
			<a href="#" id ="<?php echo htmlentities($stock_vu."_".$commande->ref_doc);?>ctc" style="text-decoration:none; color:#000000"><?php echo ($commande->nom_contact);?>
			</a>
			<script type="text/javascript">
				Event.observe('<?php echo htmlentities($stock_vu."_".$commande->ref_doc);?>ctc', 'click',  function(evt){ Event.stop(evt); window.open( "<?php echo $_ENV['CHEMIN_ABSOLU'].$_SESSION['profils'][$_SESSION['user']->getId_profil ()]->getDir_profil();?>#"+escape('annuaire_view_fiche.php?ref_contact=<?php echo htmlentities($commande->ref_contact)?>'),'_blank');}, false);
			</script>
			
			</td>
			<td style="width:145px;  text-align:right">
			<?php 
			if (isset($_REQUEST["id_stock"]) && !$_REQUEST["id_stock"]) {echo htmlentities($commande->lib_stock);}
			?>
			</td>
			<td style="width:85px;  text-align:right"><?php echo htmlentities(date_Us_to_Fr($commande->date_doc));?></td>
			
			<td style="width:145px;  text-align:right">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bts_cdc_livraison.gif" id="commande_genere_livraison_<?php echo htmlentities($stock_vu."_".$commande->ref_doc);?>" alt="Livraison de la commande" style="cursor:pointer; display:" />
			<script type="text/javascript">
				//generer_document_doc ("generer_bl_client", ref_doc)
				Event.observe("commande_genere_livraison_<?php echo htmlentities($stock_vu."_".$commande->ref_doc);?>", "click", function(evt){
				Event.stop(evt); 
				generer_document_doc ("generer_bl_client", "<?php echo $commande->ref_doc;?>");
				$("commande_genere_livraison_<?php echo htmlentities($stock_vu."_".$commande->ref_doc);?>").hide();
				}, false);
			</script>
			</td>
			<td class="document_border_right" style="width:45px; text-align:right">
				<a href="documents_editing.php?ref_doc=<?php echo $commande->ref_doc?>" target="edition" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-pdf.gif" alt="Imprimer" title="Imprimer"/></a>
			</td>
		</tr>
	</table>
	<table cellpadding="0" cellspacing="0" border="0" style="border-bottom:1px solid #9dabb3; border-left:1px solid #9dabb3; border-right:1px solid #9dabb3; width:100%">
	<tr><td>
	<?php 
	$liste_contenu = $commande->lines ;
	$colorise=0;
	foreach ($liste_contenu as $contenu) {
	$colorise++;
	$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
		if (!isset($contenu->qte_livree) || $contenu->qte_livree == "") { $contenu->qte_livree = 0;}
		if (!isset($contenu->qte_stock) || $contenu->qte_stock == "") { $contenu->qte_stock = 0;}
		
		if (($contenu->qte - $contenu->qte_livree) >0 || $contenu->ref_article == "INFORMATION") {
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="<?php  echo  $class_colorise?>">
				<tr>
					<td style="width:28px;">
						
					</td>
					<td style="width:110px" class="document_border_right">
						<div style="width:107px;">
						<a href="#" id="<?php echo htmlentities($stock_vu."_".$commande->ref_doc);?><?php echo htmlentities($contenu->ref_article)?>" style="text-decoration:none; color:#000000">
						<?php if ($contenu->ref_interne != "") { echo $contenu->ref_interne;} else { echo $contenu->ref_article;} ?></a><br />
						<?php echo $contenu->ref_oem;?>
						</div>
						<script type="text/javascript">
							Event.observe('<?php echo htmlentities($stock_vu."_".$commande->ref_doc);?><?php echo htmlentities($contenu->ref_article)?>', 'click',  function(evt){ Event.stop(evt); window.open( "<?php echo $_ENV['CHEMIN_ABSOLU'].$_SESSION['profils'][$_SESSION['user']->getId_profil ()]->getDir_profil();?>#"+escape('catalogue_articles_view.php?ref_article=<?php echo htmlentities($contenu->ref_article)?>'),'_blank');}, false);
						</script>
					</td>
					<td style=" padding-left:3px">
						<div style="">&nbsp;
							<?php
								echo (str_replace("<br />","\n",$contenu->lib_article));
							?>
						</div>
						<div style="height:3px; line-height:3px;"></div>
						<div style=" font-style:italic">
						<?php
								echo (str_replace("<br />","\n",$contenu->desc_article));
							?>
						</div>
					</td>
					<td style="width:70px; text-align:center;" >
						<?php 
						if ($contenu->ref_article != "INFORMATION") { ?>
						<div style="width:70px; cursor:pointer" id="aff_resume_stock_<?php echo $stock_vu."_".$indentation_commande."_".$indentation_article;?>">
						<?php echo ($contenu->qte - $contenu->qte_livree);?>
						</div>
						<script type="text/javascript">
						Event.observe("aff_resume_stock_<?php echo $stock_vu."_".$indentation_commande."_".$indentation_article;?>", "click", function(evt){show_resume_stock("<?php echo $contenu->ref_article;?>", evt); Event.stop(evt);}, false);
						</script>
								<?php
						}
						?>
					</td>
					<td style="width:10px; text-align:center;" >
						<div style="width:10px">
						<?php 
						if ($contenu->ref_article != "INFORMATION") {
							if (!isset($contenu->id_stock)) {
							$contenu->id_stock = $_SESSION['magasin']->getId_stock ();
							}
							if (isset($contenu->id_stock)) {
							if (($contenu->qte - $contenu->qte_livree) <= ($contenu->qte_stock)) {
								?>
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/point_vert.gif" alt="stock suffisant dans ce magasin" title="stock suffisant dans ce magasin" />
								<?php
							}
							}
							if (isset($contenu->modele) && $contenu->modele != "materiel") {
								?>
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/point_vert.gif" alt="Article de service" title="Article de service" />
								<?php
							}
						}
						?>
						</div>
						
					</td>
				</tr>
			</table>
			<?php 
		}
	$indentation_article ++;
	}
	?>
</td>
</tr>
</table><br />

	<?php 
$indentation_commande++;
}
?>
