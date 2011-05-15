
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
<p>mail_template (ajouter) </p>
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
?>
if (erreur) {


}
else
{

window.parent.changed = false;

window.parent.page.traitecontent('communication_mail_templates','communication_mail_templates.php','true','sub_content');

}
</script>