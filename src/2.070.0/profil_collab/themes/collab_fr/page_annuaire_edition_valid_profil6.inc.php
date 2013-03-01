
<?php

// *************************************************************************************************************
// MODIFICATION DU PROFIL CONSTRUCTEUR
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
<p>modifier profil constructeur </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var identifiant_revendeur=false;
var erreur=false;
<?php 
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="identifiant_revendeur") {
		echo "identifiant_revendeur=true;\n";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {
	if (identifiant_revendeur) {
		window.parent.document.getElementById("identifiant_revendeur").className="alerteform_xsize";
		window.parent.document.getElementById("identifiant_revendeur").focus();
		}else {
		window.parent.document.getElementById("identifiant_revendeur").className="classinput_xsize";
	}

}
else
{
window.parent.changed = false;
window.parent.refreshprofil_edit("<?php echo $id_profil?>", "typeprofil<?php echo $id_profil?>", "annuaire_edition_valid_view_profil_nouvelle");
}
</script>