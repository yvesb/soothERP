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
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
	<tr>
		<td style=" width:50%">
			<span class="r_art_lib">


			<?php 
			if (substr_count($contenu->article->getLib_article(), "<br />") || substr_count($contenu->article->getLib_article(), "\n")) {
				echo str_replace("&curren;", "&euro;",(str_replace("<br />","\n", $contenu->article->getLib_article())));
			} else { 
				echo str_replace("&curren;", "&euro;",($contenu->article->getLib_article()));
			}
			?>
			</span>
			</td>
		<td style="width:3px" class="document_border_right">
		</td>
		<td style="width:25px; text-align:center;" class="document_border_right">
			<span style="width:25px;">
			<?php echo $contenu->qte;?>
			</span>
		</td>	
		<td style="width:3px">
		</td>
		<td style="width:71px; text-align:right;" class="document_border_right">
			<span style="width:71px; text-align:right">
			<?php if ((!$_SESSION['user']->getLogin() && $AFF_CAT_PRIX_VISITEUR) || ($_SESSION['user']->getLogin() && $AFF_CAT_PRIX_CLIENT)) {?>
			<?php
			if ($_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["app_tarifs"] == "HT") {
				echo number_format( interface_article_pv ($contenu->article, $contenu->qte)*$contenu->qte, $TARIFS_NB_DECIMALES, ".", ""	)."&nbsp;".$MONNAIE[1];
			} else {
				echo number_format(( interface_article_pv ($contenu->article, $contenu->qte)*(1+$contenu->article->getTva()/100))*$contenu->qte, $TARIFS_NB_DECIMALES, ".", ""	)."&nbsp;".$MONNAIE[1];
			}
			?>
			<?php } ?>
			</span>
		</td>	
	</tr>
</table>
<script type="text/javascript">
</script>