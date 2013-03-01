<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
echo "1";
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************
echo "2";



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<p>&nbsp;</p>
<p>Résultat des commerciaux type MOD</p>
<p>&nbsp;</p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">

window.parent.changed = false;

window.parent.page.verify('communication_mod_resultats_commerciaux','communication_mod_resultats_commerciaux.php','true','sub_content');

</script>