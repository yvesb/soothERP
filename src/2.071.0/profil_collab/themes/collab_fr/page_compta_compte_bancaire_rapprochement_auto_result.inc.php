<?php

// *************************************************************************************************************
// Rapprochement automatique affichage de la progression
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

if ($_REQUEST["a_rapprocher"] >0) { 
echo ($nb_ope)." rapprochements effectués automatiquement  / ".$_REQUEST["a_rapprocher"]." à rapprocher ";
}
?>
<SCRIPT type="text/javascript">
	$("progverify").style.width = "<?php if ($_REQUEST["a_rapprocher"] > 0) {echo ( $nb_move*100 / $_REQUEST["a_rapprocher"]); }?>%";
<?php
if ($nb_move < $_REQUEST["a_rapprocher"]  && $next_date_fin_moves != $ENTREPRISE_DATE_CREATION) {
	?>

	var AppelAjax = new Ajax.Updater(
						"verify_journal", 
						"compta_compte_bancaire_rapprochement_auto_result.php", {
						method: 'post',
						asynchronous: true,
						contentType:  'application/x-www-form-urlencoded',
						encoding:     'UTF-8',
						parameters: { recherche: '1', date_fin : '<?php echo $next_date_fin_moves;?>', id_compte_bancaire: '<?php echo $_REQUEST["id_compte_bancaire"];?>', a_rapprocher: '<?php echo $_REQUEST["a_rapprocher"];?>', nb_ope: '<?php echo $nb_ope;?>', nb_move: '<?php echo $nb_move;?>'},
						evalScripts:true, 
						onLoading:S_loading, 
						onComplete:H_loading}
						);

</SCRIPT>
	<?php } else { ?>

	//on masque le chargement
	H_loading();
</SCRIPT>
<br />
Rapprochements automatiques terminés.
<?php }?>