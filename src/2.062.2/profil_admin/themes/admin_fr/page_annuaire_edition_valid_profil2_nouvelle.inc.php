
<?php

// *************************************************************************************************************
// NOUVEAU PROFIL ADMIN
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
<p>nouveau profil admin</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var type_admin=false;
var erreur=false;
<?php 
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_type_admin") {
		echo "type_admin=true;\n";
		echo "erreur=true;\n";
	}
	
}


?>
if (erreur) {
	if (type_admin) {
		window.parent.document.getElementById("type_admin").className="alerteform_xsize";
		window.parent.document.getElementById("type_admin").focus();
	}else {
		window.parent.document.getElementById("type_admin").className="classinput_xsize";
	}

}
else
{
window.parent.switchprofil_new_edit("<?php echo $id_profil?>", "typeprofil<?php echo $id_profil?>", "annuaire_edition_valid_view_profil_nouvelle");
window.parent.switchprofil_new_edit("<?php echo $id_profil?>", "type_fiche", "annuaire_edition_check_profil");
}
</script>