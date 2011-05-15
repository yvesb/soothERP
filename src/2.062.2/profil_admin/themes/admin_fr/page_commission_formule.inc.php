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
<p>Calcul de formule comm </p>
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
var erreur=false;
<?php 
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="bad_valeur_1") {
	echo "bad_valeur_1=true;";
	echo "erreur=true;\n";
	}
	
}

?>
window.parent.document.getElementById("assistant_comm_val_step1_CA").className="assistant_input";
window.parent.document.getElementById("assistant_comm_val_step1_Mg").className="assistant_input";

if (erreur) {

	if (bad_valeur_1) {
window.parent.document.getElementById("assistant_comm_val_step1_<?php if (isset($_REQUEST["assistant_comm_rep_step1"])) { echo $_REQUEST["assistant_comm_rep_step1"];}?>").className="alerte_assistant_input";
	}


}
else
{
window.parent.document.getElementById("aff_formule_comm<?php echo $cellule_cible?>").innerHTML="<?php echo $formule;?>";
window.parent.document.getElementById("formule_comm<?php echo $cellule_cible?>").value="<?php echo $formule;?>";
window.parent.reset_assistant_comm_commission("pop_up_assistant_comm_commission", "pop_up_assistant_comm_commission_iframe", "form_assistant_comm_commission", 'assistant_comm_form_step2');
<?php 
if ($cellule_cible != "" && !(isset($_REQUEST["assistant_comm_art_categ"]) && $_REQUEST["assistant_comm_art_categ"] != "" && isset($_REQUEST["assistant_comm_id_commission_regle"]) && $_REQUEST["assistant_comm_id_commission_regle"] != "") && !(isset($_REQUEST["assistant_comm_article"]) && $_REQUEST["assistant_comm_article"] != "" && isset($_REQUEST["assistant_comm_id_commission_regle"]) && $_REQUEST["assistant_comm_id_commission_regle"] != "")) {
	?>
	window.parent.document.getElementById("commission_mod<?php echo $cellule_cible?>").submit();
	
	<?php
	
}
if (isset($_REQUEST["assistant_comm_art_categ"]) && $_REQUEST["assistant_comm_art_categ"] != "" && isset($_REQUEST["assistant_comm_id_commission_regle"]) && $_REQUEST["assistant_comm_id_commission_regle"] != "") {
	?>
	window.parent.maj_commission_art_categ ('<?php echo $_REQUEST["assistant_comm_id_commission_regle"];?>', '<?php echo $_REQUEST["assistant_comm_art_categ"];?>', '<?php echo $formule;?>', '<?php echo $_REQUEST["old_formule_comm"];?>');
	<?php
}
if (isset($_REQUEST["assistant_comm_article"]) && $_REQUEST["assistant_comm_article"] != "" && isset($_REQUEST["assistant_comm_id_commission_regle"]) && $_REQUEST["assistant_comm_id_commission_regle"] != "") {
	?>
	window.parent.maj_commission_article ('<?php echo $_REQUEST["assistant_comm_id_commission_regle"];?>', '<?php echo $_REQUEST["assistant_comm_article"];?>', '<?php echo $formule;?>', '<?php echo $_REQUEST["old_formule_comm"];?>');
	<?php
}
?>
}
</script>
<?php echo $formule;?>