
<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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
<p>magasins MOD </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var lib_magasin_vide=false;
var stock_not_actif=false;
var tarif_not_existing=false;
var last_active_magasin=false;
var active_magasin_caisses=false;

<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {

	if ($alerte=="lib_magasin_vide") {
		echo "lib_magasin_vide=true;\n";
		echo "erreur=true;\n";
	}
	
	if ($alerte=="stock_not_actif") {
		echo "stock_not_actif=true;\n";
		echo "erreur=true;\n";
	}
	
	if ($alerte=="tarif_not_existing") {
		echo "tarif_not_existing=true;\n";
		echo "erreur=true;\n";
	}
	
	if ($alerte=="last_active_magasin") {
		echo "last_active_magasin=true;\n";
		echo "erreur=true;\n";
	}
	
	if ($alerte=="active_magasin_caisses") {
		echo "active_magasin_caisses=true;\n";
		echo "erreur=true;\n";
	}
	
}

?>
if (erreur) {

if (lib_magasin_vide) {
	window.parent.document.getElementById("lib_magasin_<?php echo $_REQUEST['id_magasin']?>").className="alerteform_lsize";
	window.parent.document.getElementById("lib_magasin_<?php echo $_REQUEST['id_magasin']?>").focus();
	} else {
	window.parent.document.getElementById("lib_magasin_<?php echo $_REQUEST['id_magasin']?>").className="classinput_lsize";
		}


if (stock_not_actif) {
window.parent.alerte.confirm_supprimer('catalogue_magasins_stock_not_actif', '');
		}

if (tarif_not_existing) {
window.parent.alerte.confirm_supprimer('catalogue_magasins_tarif_not_existing', '');
		}

if (last_active_magasin) {
window.parent.document.getElementById("actif_<?php echo $_REQUEST['id_magasin']?>").checked="checked";
window.parent.alerte.confirm_supprimer('catalogue_magasins_last_active_magasin', '');
		}

if (active_magasin_caisses) {
window.parent.document.getElementById("actif_<?php echo $_REQUEST['id_magasin']?>").checked="checked";
window.parent.alerte.confirm_supprimer('catalogue_magasins_actives_caisses', '');
		}


}
else
{

window.parent.changed = false;

window.parent.page.verify('catalogue_magasin','catalogue_magasins.php','true','sub_content');

}
</script>