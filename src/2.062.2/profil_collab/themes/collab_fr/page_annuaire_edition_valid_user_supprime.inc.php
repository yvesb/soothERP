
<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "users");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<p>&nbsp;</p>
<p>user: suppression dans un contact existant </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
if (count($_ALERTES)>0) {
echo "erreur";
}
?>
<script type="text/javascript">
var erreur=false;
var compte_maitre=false
<?php 
foreach ($_ALERTES as $alerte => $value) {
	
	if ($alerte=="compte_maitre") {
		echo "compte_maitre=true;";
		echo "erreur=true;\n";
	}
}

?>
if (erreur) {
	if (compte_maitre) {
		window.parent.alerte.confirm_supprimer('user_compte_maitre', '');
	}

}
else
{
<?php
foreach ($users as $user) {
	?>
		window.parent.refreshtagmobil('userlist2','li','usercontent', 'annuaire_edition_valid_view_user_nouvelle', '<?php echo $user->ref_user?>', '');	
	<?php
}
?>
<?php if (!count($users)) {?>
window.parent.document.getElementById("block_suspendre_user").style.display = "none";
<?php }?>

window.parent.remove_tag ('usercontent_li_<?php echo $_REQUEST['ref_idform']?>');
}
</script>