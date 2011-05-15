
<?php

// *************************************************************************************************************
// SUSPENDRE LES UTILISATEURS DU CONTACT
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
<p>suspendre les utilisateurs </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
var texte_erreur = "";
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
	window.parent.changed = false;
<?php
if (count($users)>0) {
	foreach ($users as $user) {
		?>
			window.parent.refreshtagmobil('userlist2','li','usercontent', 'annuaire_edition_valid_view_user_nouvelle', '<?php echo $user->getRef_user ()?>', '');	
		<?php
	}
}
?>

}
</script>