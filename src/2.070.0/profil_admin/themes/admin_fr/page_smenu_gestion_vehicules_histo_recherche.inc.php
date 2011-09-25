<?php

// *************************************************************************************************************
// Ajout de type de pièces jointes
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

window.parent.page.traitecontent('smenu_gestion_vehicules_histo','smenu_gestion_vehicules_histo.php?id_vehicule=<?php echo $id_vehicule; ?>&lib_evenement=<?php echo $lib_evenement;?>&date_debut=<?php echo $date_debut;?>&date_fin=<?php echo $date_fin;?>&cout=<?php echo $cout;?>&ecart=<?php echo $ecart;?>','true','sub_content');

</script>
