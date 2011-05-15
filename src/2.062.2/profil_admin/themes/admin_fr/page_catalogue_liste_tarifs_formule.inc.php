
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
<p>Calcul de formule </p>
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
var bad_valeur_1=false;
var bad_valeur_2=false;
var bad_valeur_3=false;
var erreur=false;
<?php 
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_valeur_1") {
	echo "bad_valeur_1=true;";
	echo "erreur=true;\n";
	}
	if ($alerte=="bad_valeur_2") {
	echo "bad_valeur_2=true;";
	echo "erreur=true;\n";
	}
	if ($alerte=="bad_valeur_3") {
	echo "bad_valeur_3=true;";
	echo "erreur=true;\n";
	}
	
}

?>
<?php if ($USE_FORMULES) {?>
window.parent.document.getElementById("assistant_val_step2_marge").className="assistant_input";
window.parent.document.getElementById("assistant_val_step2_multi").className="assistant_input";
window.parent.document.getElementById("assistant_val_step2_addition").className="assistant_input";
window.parent.document.getElementById("assistant_rep_step3_pas").className="assistant_input";
<?php }?>
window.parent.document.getElementById("assistant_val_step1_arb").className="assistant_input";
if (erreur) {

<?php if ($USE_FORMULES) {?>
	if (bad_valeur_3) {
window.parent.document.getElementById("assistant_rep_step3_pas").className="alerte_assistant_input";
	} else {
window.parent.document.getElementById("assistant_rep_step3_pas").className="assistant_input";
	}
	if (bad_valeur_2) {
window.parent.document.getElementById("<?php echo $champ_retour;?>").className="alerte_assistant_input";
	} else {
window.parent.document.getElementById("<?php echo $champ_retour;?>").className="assistant_input";
	}
<?php }?>
	if (bad_valeur_1) {
window.parent.document.getElementById("assistant_val_step1_arb").className="alerte_assistant_input";
	} else {
window.parent.document.getElementById("assistant_val_step1_arb").className="assistant_input";
	}


}
else
{
window.parent.document.getElementById("aff_formule_tarif<?php echo $cellule_cible?>").innerHTML="<?php echo $formule;?>";
window.parent.document.getElementById("marge_moyenne<?php echo $cellule_cible?>").value="<?php echo $formule;?>";
window.parent.reset_assistant_tarif("pop_up_assistant_tarif", "pop_up_assistant_tarif_iframe", "form_assistant_tarif", 'assistant_form_step2', 'assistant_form_step3', 'assistant_form_step4');
<?php 
if ($cellule_cible != "") {
	?>
	window.parent.document.getElementById("catalogue_liste_tarifs_mod<?php echo $cellule_cible?>").submit();
	
	<?php
	
}
?>
}
</script>
<?php echo $formule;?>