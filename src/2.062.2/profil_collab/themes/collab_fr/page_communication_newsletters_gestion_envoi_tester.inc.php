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
<p>envoi test newsletter </p>
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

if (isset($erreur)){ echo "erreur = true;";}
?>
if (erreur) {
window.parent.alerte.alerte_erreur ('Test de la newsletter', "<?php if (isset($erreur)){ echo $erreur;}?>",'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
}
else
{
window.parent.alerte.alerte_erreur ('Test de la newsletter', 'Un email de test vient de vous être envoyé','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');

window.parent.changed = false;
}
</script>