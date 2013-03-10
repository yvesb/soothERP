<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("grille_tarrifaire");
check_page_variables ($page_variables);
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

if(!is_null($grille_tarrifaire->lib_tarif))
{		 $lib_grille_tarrifaire = $grille_tarrifaire->lib_tarif;}
else{$lib_grille_tarrifaire = "Automatique";}


var_dump($grille_tarrifaire->lib_tarif);
?>

<script type="text/javascript">
//Mise à jour du panel client

	$("client_ligne1").innerHTML = "<?php echo addslashes(preg_replace('(\r\n|\n|\r)','',$ligne1));?>";
	$("client_ligne2").innerHTML = "<?php echo addslashes(preg_replace('(\r\n|\n|\r)','',$ligne2));?>";
	$("client_ligne3").innerHTML = "<?php echo addslashes(preg_replace('(\r\n|\n|\r)','',$ligne3));?>";
	
	$("client_grille_tarifaire").innerHTML = "<?php echo $lib_grille_tarrifaire;?>";
	
	$("ref_contact").value = "<?php echo $client->getRef_contact();?>";
</script>
