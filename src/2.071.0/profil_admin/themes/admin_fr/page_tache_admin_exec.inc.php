<?php

// *************************************************************************************************************
//  Considére un tache d'admin comme executée
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

?>
<p>&nbsp;</p>
<p>tache executée </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	
}

?>
if (erreur) {


}
else
{
<?php 
if (isset($_REQUEST["id_tache_admin"])) {
	?>
	window.parent.document.getElementById("etat_tache_<?php echo $_REQUEST["id_tache_admin"];?>_2").style.display = "none";
	window.parent.document.getElementById("go_tache_<?php echo $_REQUEST["id_tache_admin"];?>_2").style.color = "#CCCCCC";
	window.parent.document.getElementById("go_tache_<?php echo $_REQUEST["id_tache_admin"];?>_3").style.color = "#CCCCCC";
	window.parent.document.getElementById("go_tache_<?php echo $_REQUEST["id_tache_admin"];?>_4").style.color = "#CCCCCC";
	<?php 
}
?>
}
</script>