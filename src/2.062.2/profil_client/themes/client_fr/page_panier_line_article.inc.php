<?php

// *************************************************************************************************************
// LIGNE D'ARTICLE
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#0099CC">
	<tr class="colorise1">
		<td style="width: 5%;"></td>
		<td style="width:10%">
			<?php if ($contenu->article->getRef_interne() != "") { echo $contenu->article->getRef_interne();} else { echo $contenu->article->getRef_article();} ?>
			<input value="<?php echo $contenu->article->getRef_article();?>" id="ref_article_<?php echo $indentation_contenu?>" name="ref_article_<?php echo $indentation_contenu?>" type="hidden" />
		</td>
		<td style="width:25%; padding-left:3px">
			<div class="r_art_lib">
				<?php if (substr_count($contenu->article->getLib_article(), "<br />") || substr_count($contenu->article->getLib_article(), "\n"))
				{			echo str_replace("&curren;", "&euro;",(str_replace("<br />","\n",$contenu->article->getLib_article())));}
				else{	echo str_replace("&curren;", "&euro;",($contenu->article->getLib_article()));} ?>
			</div>
			<div class="r_art_desc_courte">
				<?php if (isset($line_insert))
				{			echo (str_replace("<br />","\n",$contenu->article->getDesc_courte()));}
				else{	echo str_replace("&curren;", "&euro;",(str_replace("<br />","\n",$contenu->article->getDesc_courte())));} ?>				
			</div> 
		</td>
		<td style="width:10%;" align="center">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td rowspan="2" width="8px"></td>
					<td rowspan="2" style="vertical-align:middle">
						<input value="<?php echo $contenu->qte;?>" id="qte_<?php echo $indentation_contenu?>" name="qte_<?php echo $indentation_contenu?>" type="text" size="2" class="input_add_panier" style="text-align:center;" />
					</td>
					<td style="text-align:center; width:15px;">
						<a href="#" id="qte_add_one_<?php echo $indentation_contenu;?>">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" />
						</a>
					</td>
				</tr>
				<tr>
					<td style="text-align:center; width:15px;">
						<a href="#" id="qte_sub_one_<?php echo $indentation_contenu;?>">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/moins.gif" />
						</a>
					</td>
				</tr>
			</table>
		</td>
		<td style="width:10%; text-align: center" >
			<a href="#" id="aff_resume_stock_<?php echo ($contenu->article->getRef_article());?>">
				<?php $stock = $contenu->article->getStocks();
				if (isset($stock[$_SESSION['magasins'][$ID_MAGASIN]->getId_stock()]) && $stock[$_SESSION['magasins'][$ID_MAGASIN]->getId_stock()]->qte) { ?>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/stock_dispo.gif" />
				<?php }else{ ?>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/stock_vide.gif" />
				<?php } ?>
			</a>
		</td>
		<td style="width:15%; text-align:right;">
			<?php if((!$_SESSION['user']->getLogin() && $AFF_CAT_PRIX_VISITEUR) || ($_SESSION['user']->getLogin() && $AFF_CAT_PRIX_CLIENT)){
				if ($_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["app_tarifs"] == "HT")
				{			echo number_format( interface_article_pv ($contenu->article, $contenu->qte), $TARIFS_NB_DECIMALES, ".", ""	)."&nbsp;".$MONNAIE[1];}
				else{	echo number_format(( interface_article_pv ($contenu->article, $contenu->qte)*(1+$contenu->article->getTva()/100)), $TARIFS_NB_DECIMALES, ".", ""	)."&nbsp;".$MONNAIE[1];}
			} ?>
		</td>	
		<td style="width:15%; text-align:right;">
			<?php if((!$_SESSION['user']->getLogin() && $AFF_CAT_PRIX_VISITEUR) || ($_SESSION['user']->getLogin() && $AFF_CAT_PRIX_CLIENT)) {
				if($_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["app_tarifs"] == "HT")
				{			echo number_format( interface_article_pv ($contenu->article, $contenu->qte)*$contenu->qte, $TARIFS_NB_DECIMALES, ".", ""	)."&nbsp;".$MONNAIE[1];} 
				else{	echo number_format(( interface_article_pv ($contenu->article, $contenu->qte)*(1+$contenu->article->getTva()/100))*$contenu->qte, $TARIFS_NB_DECIMALES, ".", ""	)."&nbsp;".$MONNAIE[1];}
			} ?>
		</td>	
		<td style="text-align:right; width:5%">
			<a href="#" id="sup_<?php echo $indentation_contenu?>">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">		
			</a>
		</td>
		<td style="text-align:right; width:5%">&nbsp;</td>
	</tr>
</table>
<script type="text/javascript">
		Event.observe("qte_add_one_<?php echo ($indentation_contenu);?>", "click", function(evt){
			Event.stop(evt);
			$("qte_<?php echo $indentation_contenu?>").value = parseFloat($("qte_<?php echo $indentation_contenu?>").value)+1;
			maj_line_qte($("qte_<?php echo $indentation_contenu?>").value,  "<?php echo $contenu->article->getRef_article();?>");
		}, false);
		
		Event.observe("qte_sub_one_<?php echo ($indentation_contenu);?>", "click", function(evt){
			Event.stop(evt);
			$("qte_<?php echo $indentation_contenu?>").value = parseFloat($("qte_<?php echo $indentation_contenu?>").value)-1;
			maj_line_qte($("qte_<?php echo $indentation_contenu?>").value, "<?php echo $contenu->article->getRef_article();?>");
		}, false);
		
		Event.observe("qte_<?php echo ($indentation_contenu);?>", "blur", function(evt){
			nummask(evt, <?php echo $contenu->qte;?>, "X.X");
			maj_line_qte($("qte_<?php echo $indentation_contenu?>").value, "<?php echo $contenu->article->getRef_article();?>");
		}, false);
		
		Event.observe("sup_<?php echo $indentation_contenu?>" , "click", function(evt){
			Event.stop(evt);
			doc_sup_line("<?php echo $contenu->article->getRef_article();?>");
			remove_tag("<?php echo $indentation_contenu?>");
		}, false);	
</script>