<?php

// *************************************************************************************************************
// AFFICHAGE D'ALERTE QTE STOCK
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
<script type="text/javascript">
var duree_mois = <?php echo $duree_mois_abo ?>;
var duree_jour = <?php echo $duree_jours_abo ?>;

var duree_tot = (duree_mois * 30 + duree_jour)*24*3600;

var duree_abonnement_ini = <?php 
							$query = "SELECT `duree` FROM `articles_modele_service_abo` WHERE `ref_article` = '".$ref_article."' ";
							$resultat = $bdd->query ($query);
							if (!$duree = $resultat->fetchObject()) { return false; }
							
							echo $duree->duree;
							?>*<?php 
							$query = "SELECT `engagement` FROM `articles_modele_service_abo` WHERE `ref_article` = '".$ref_article."' ";
							$resultat = $bdd->query ($query);
							if (!$engagement = $resultat->fetchObject()) { return false; }
							
							echo $engagement->engagement;
							?>;
var prix_ht_unitaire = <?php 
					$query = "SELECT DISTINCT `pu_ht` FROM `articles_tarifs` WHERE `ref_article` = '".$ref_article."' ";
					$resultat = $bdd->query ($query);
					if (!$pu_ht = $resultat->fetchObject()) { return false; }
					
					echo $pu_ht->pu_ht;
					?>;
var prix_ht_unitaire_duree = prix_ht_unitaire*duree_tot/duree_abonnement_ini;
//alert(prix_ht_total);
$("pu_ht_old_<?php echo $indentation;?>").value = prix_ht_unitaire_duree;
$("pu_ht_<?php echo $indentation;?>").value = prix_ht_unitaire_duree;
document_calcul_tarif();
</script>