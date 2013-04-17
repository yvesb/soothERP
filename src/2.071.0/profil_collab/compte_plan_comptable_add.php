<?php
// *************************************************************************************************************
// AJOUT D'UN COMPTE COMPTABLE
// *************************************************************************************************************

//Require
require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

//Vars

$form['numero_compte'] = $search['numero_compte'] = "";
if (isset($_REQUEST['numero_compte'])) {
	$form['numero_compte'] = $_REQUEST['numero_compte'];
	$search['numero_compte'] = $_REQUEST['numero_compte'];
}
$form['lib_compte'] = $search['lib_compte'] = "";
if (isset($_REQUEST['lib_compte'])) {
	$form['lib_compte'] = $_REQUEST['lib_compte'];
	$search['lib_compte'] = $_REQUEST['lib_compte'];
}
$form['favori'] = $search['favori'] = "";
if (isset($_REQUEST['favori'])) {
	$form['favori'] = $_REQUEST['favori'];
	$search['favori'] = $_REQUEST['favori'];
}

$check_erreurs = array();
if( isset ( $_REQUEST['check']) && $_REQUEST['check'] == 'true'){
	//Verifs BDD
	if($search['numero_compte'] != "") {
		if (!preg_match("`^[[:alnum:]\-\_]+$`", $search['numero_compte'])) {
			$check_erreurs['num'][] = "Le numéro n'est pas valide";
		} else {
			$query = "SELECT numero_compte, lib_compte
							FROM plan_comptable
							WHERE numero_compte = '".$search['numero_compte']."';";
			$resultat = $bdd->query($query);
			$result = $resultat->fetchAll();
			if(count($result) !=0){
				$check_erreurs['num'][] = "Le numéro existe déja";
			}
			unset ($result, $resultat, $query);
		}
	} else {
		$check_erreurs['num'][] = "Le numéro est vide ...";
	}
	if ($search['lib_compte'] != ""){
		$query = "SELECT numero_compte, lib_compte
						FROM plan_comptable
						WHERE lib_compte = '".$search['lib_compte']."';";
		$resultat = $bdd->query($query);
		$result = $resultat->fetchAll();
		
		if(count($result)!=0){
			$check_erreurs['lib'][] = "La description existe déja";
		}
		unset ($result, $resultat, $query);
	} else {
		$check_erreurs['lib'][] = "La description est vide ...";
	}
	if (empty($check_erreurs)){
            $_REQUEST['valid'] = 'true';
        }
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

if ( isset($_REQUEST['valid']) && $_REQUEST['valid'] == 'true' ){
	//start
	// Ajout du compte
	$new_compte = new compta_plan_general ();
	if($new_compte->create_compte_plan_comptable ($search)){
		// Validation du compte pour la selection
		
		// Fermeture des popups
		?>
		<script type="text/javascript">
		<!--
		close_compta_plan_add_mini_moteur();
		
		$("retour_value").value = "<?php echo $form['numero_compte'];?>";
		$("retour_lib").value = "<?php echo $form['lib_compte'];?>";
		$("<?php echo $_REQUEST['cible_id_num'];?>").innerHTML = $("retour_value").value;
		$("<?php echo $_REQUEST['cible_id_lib'];?>").innerHTML = $("retour_lib").value;
		$("retour_value").form.submit();
		close_compta_plan_mini_moteur();
		//-->
		</script>
		<?php 
		//end
	}
} else {
	include ($DIR.$_SESSION['theme']->getDir_theme()."page_compte_plan_comptable_add.inc.php");
}