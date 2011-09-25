<?php

// *************************************************************************************************************
// ONGLET DES MARGES DU DOCUMENT
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************
$o = 0;
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<div style="width:100%; ">
	<div style="padding:20px">
		<span class="bolder">Marges du document</span>
		<?php if (count($liste_articles)) {?>
		<br />
		<br />
		<div class="roundedtable">
		<span class="marge_lib">&nbsp;
		</span>
		<span class="marge_val">Marge HT:
		</span>
		<span class="marge_pc">Taux de marge:
		</span>
		<br />
		</div>
		
		<br />
		<div class="roundedtable">
		<span class="marge_lib"><span class="bolder">Total du document:</span>
		</span>
		<span class="marge_val"><?php echo price_format($calcul_total["ptt_ht"] - $calcul_total["pa_ht"])." ".$MONNAIE[1]; ?>
		</span>
		<span class="marge_pc"><?php if ($calcul_total["ptt_ht"]) {echo price_format(((($calcul_total["pa_ht"]*100) / $calcul_total["ptt_ht"])-100) * -1)." %";} ?>
		</span>
			<?php  if ($calcul_total["ptt_ht"]) { ?>
			<span class="marge_graph">
			<div>
			<div style="width:<?php echo round( ((($calcul_total["pa_ht"]*100) / $calcul_total["ptt_ht"])-100) * -1 , 0)."%"; ?>; background-color:<?php if (isset($degrader[$o])) { echo $degrader[$o]; $o++;}?>;" title="<?php echo round( ((($calcul_total["pa_ht"]*100) / $calcul_total["ptt_ht"])-100) * -1 , 0)."%"; ?>">
			</div>
			</div>
			</span>
			<?php } ?>
		<br />
		</div>
		<br />
		
		<div class="roundedtable">
		<span class="bolder">Familles d'articles</span><br />

		<?php 
		foreach ($liste_modele as $modele) {
			?>
			<div  style="border-top:1px solid #FFFFFF">
			<span class="marge_lib"><?php echo $BDD_MODELES[$modele["modele"]]; ?>:
			</span>
			<span class="marge_val"><?php echo price_format($modele["pt_ht"] - $modele["pa_ht"])." ".$MONNAIE[1]; ?>
			</span>
			<span class="marge_pc"><?php if ($modele["pt_ht"]) {echo price_format(((($modele["pa_ht"]*100) / $modele["pt_ht"])-100) * -1)." %";}?>
			</span>
			<?php  if ($modele["pt_ht"]) { ?>
			<span class="marge_graph">
			<div>
			<div style="width:<?php echo round( ((($modele["pa_ht"]*100) / $modele["pt_ht"])-100) * -1 , 0)."%"; ?>; background-color:<?php if (isset($degrader[$o])) { echo $degrader[$o]; $o++;}?>;" title="<?php echo round( ((($modele["pa_ht"]*100) / $modele["pt_ht"])-100) * -1 , 0)."%"; ?>">
			</div>
			</div>
			</span>
			<?php } ?>
			<br />
			</div>
			<?php
		}
		?>
		</div>
		<br />
		
		<div class="roundedtable">
		<span class="bolder">Catégorie d'articles</span><br />

		<?php 
		foreach ($liste_categories as $categorie) {
			?>
			<div  style="border-top:1px solid #FFFFFF">
			<span class="marge_lib">	<?php echo $categorie["lib_categ"]; ?>:
			</span>
			<span class="marge_val"><?php echo price_format($categorie["pt_ht"] - $categorie["pa_ht"])." ".$MONNAIE[1]; ?>
			</span>
			<span class="marge_pc"><?php if ($categorie["pt_ht"]) {echo price_format(((($categorie["pa_ht"]*100) / $categorie["pt_ht"])-100) * -1)." %";} ?>
			</span>
			<?php  if ($categorie["pt_ht"]) { ?>
			<span class="marge_graph">
			<div>
			<div style="width:<?php echo round( ((($categorie["pa_ht"]*100) / $categorie["pt_ht"])-100) * -1 , 0)."%"; ?>; background-color:<?php if (isset($degrader[$o])) { echo $degrader[$o]; $o++;}?>;" title="<?php echo round( ((($categorie["pa_ht"]*100) / $categorie["pt_ht"])-100) * -1 , 0)."%"; ?>">
			</div>
			</div>
			</span>
			<?php } ?>
			<br />
			</div>
			<?php
		}
		?>
		</div>
		<br />
		
		<div class="roundedtable">
		<span class="bolder">Articles</span><br />

		<?php 
		foreach ($liste_articles as $article) {
			?>
			<div  style="border-top:1px solid #FFFFFF">
			<span class="marge_lib">	<?php echo $article["lib_article"]; ?>:
			</span>
			<span class="marge_val"><?php echo price_format($article["pt_ht"] - $article["pa_ht"])." ".$MONNAIE[1]; ?>
			</span>
			<span class="marge_pc"><?php if ($article["pt_ht"]) {echo price_format(((($article["pa_ht"]*100) / $article["pt_ht"])-100) * -1)." %";} ?>
			</span>
			<?php if ($article["pt_ht"]) {?>
			<span class="marge_graph">
			<div>
			<div style="width:<?php echo round( ((($article["pa_ht"]*100) / $article["pt_ht"])-100) * -1 , 0)."%"; ?>; background-color:<?php if (isset($degrader[$o])) { echo $degrader[$o]; $o++;}?>;" title="<?php echo round( ((($article["pa_ht"]*100) / $article["pt_ht"])-100) * -1 , 0)."%"; ?>">
			</div>
			</div>
			</span>
			<?php } ?>
			<br />
			</div>
			<?php
		}
		?>
		</div>
		
		<?php 
		}
		?>
	</div>
	
	<script type="text/javascript">
	//maj commerciaux
	if (document.getElementById('commercial_content'))
	{
		page.traitecontent('commercial_content','documents_commercial.php?ref_doc=<?php echo $document->getRef_doc(); ?>','true','commercial_content');
	}
	//on masque le chargement
	H_loading();
	</script>
</div>
