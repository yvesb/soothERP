<?php

// *************************************************************************************************************
// AFFICHAGE D'UN DOCUMENT
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

?><?php 
$indentation_contenu = 0;
$liste_contenu = $document->getContenu ();
foreach ($liste_contenu as $contenu) {
	if ($contenu->type_of_line == "article") {
		?>
		<div id="panier_line_<?php echo $indentation_contenu;?>" class="panier_line">
		<span id="panier_prix_<?php echo $indentation_contenu;?>" class="panier_prix"><?php if ($document->getApp_tarifs() == "HT" || $document->getApp_tarifs() == "") { echo number_format((($contenu->pu_ht*$contenu->qte)*(1-($contenu->remise/100))), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];} else { echo number_format(((($contenu->pu_ht*$contenu->qte)*(1-($contenu->remise/100)))*(1+($contenu->tva/100))), $TARIFS_NB_DECIMALES, ".", ""	)." ".$MONNAIE[1];}?></span>
		<span id="panier_qte_<?php echo $indentation_contenu;?>" class="panier_qte"><?php echo $contenu->qte;?></span>
		<span id="panier_lib_<?php echo $indentation_contenu;?>" class="panier_lib"><?php echo str_replace("€", "&euro;",substr($contenu->lib_article, 0 , 21))?><br /></span>
		</div>
		<?php 
	$indentation_contenu++;
	} 
}
?>
<script type="text/javascript">
H_loading(); 
</script>