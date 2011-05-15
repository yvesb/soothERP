
<?php

// *************************************************************************************************************
// Mise à jour du prix d'achat d'un article depuis la liste des articles avec PA non défini
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
<?php 
if ($maj_pa) {
	?>
	$("<?php echo $_REQUEST["id_line"];?>").style.color="#000000";
	<?php
} else {
	?>
	$("<?php echo $_REQUEST["id_line"];?>").style.color="#000000";
	<?php
}
?>
</script>