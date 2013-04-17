<?php

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<form method="post" action="ods_gen.php">
    <input type="hidden" name="code_ods_modele" value="export_selected_docs" />
    <input type="hidden" name="liste_doc" id="liste_doc" value="<?php echo $_REQUEST['docs']; ?>" />
    
    <?php $liste_modeles_ods_valides=charge_modele_export_docs(); ?>
	<form method="post" action="ods_gen.php" id="change_code_ods_modele" target="_top" >
	<select name="code_ods_modele" >
	<?php foreach ($liste_modeles_ods_valides as $modele_ods): ?>
            <option value="<?php echo $modele_ods->code_export_modele;?>"><?php echo $modele_ods->lib_modele;?></option>
	<?php endforeach; ?>
	</select>
    <br /><br /> 
    <input type="submit" name="bouton2" id="bouton2" value="Confirmer" onclick="hide_popup();" />
    <input type="button" id="bouton0" name="bouton0" value="Annuler" onclick="hide_popup();" />
</form>