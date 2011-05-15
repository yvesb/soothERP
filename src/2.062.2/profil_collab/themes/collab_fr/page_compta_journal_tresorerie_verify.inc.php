<?php
// *************************************************************************************************************
//journal des tresorerie
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

if ($nb_fiches >0) { 
echo "Etape ".$search['page_to_show']." / ".$nb_fiches;
}
?>

<SCRIPT type="text/javascript">
	$("progverify").style.width = "<?php if ($nb_fiches >0) {echo ($search['page_to_show']*100 / $nb_fiches); }?>%";
<?php
if ($search['page_to_show'] < $nb_fiches) {
	?>
	var AppelAjax = new Ajax.Updater(
						"verify_journal", 
						"compta_journal_tresorerie_verify.php", {
						method: 'post',
						asynchronous: true,
						contentType:  'application/x-www-form-urlencoded',
						encoding:     'UTF-8',
						parameters: { recherche: '1', date_fin : $("date_fin").value, date_debut : $("date_debut").value, date_exercice: $("date_exercice").value, page_to_show: '<?php echo ($search['page_to_show']+1);?>'},
						evalScripts:true, 
						onLoading:S_loading, 
						onComplete:H_loading}
						);

</SCRIPT>
	<?php 
	} else { 
	?>
	
	compta_journal_tresorerie_result_byexercice ();
	
//on masque le chargement
H_loading();
</SCRIPT>
<br />
Vérification terminée.
	<?php 
}
?>