<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<script type="text/javascript">
var table_length = $("reglements_effectues").rows.length + 0;
var motant = "0.00";
if(table_length == 1){ motant = "<?php echo price_format($motant); ?>"; }

ajouterReglement(table_length, "&euro;", "<?php echo $mdp_lib;?>", "<?php echo $mdp;?>", motant)

H_loading();
</script>
