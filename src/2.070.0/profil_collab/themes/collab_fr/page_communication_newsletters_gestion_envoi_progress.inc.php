<?php

// *************************************************************************************************************
// AFFICHAGE DE LA PROGRESSION DE L'ENVOI DES EMAILS
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<SCRIPT type="text/javascript">

<?php 
if (count($fiches)) { 
	?>
	$("info_progress").innerHTML = "Emails envoyés: <?php echo ($search['page_to_show']-1)*$search['fiches_par_page']+count($fiches);  ?> /  <?php echo $nb_fiches;?>";

	$("files_progress").style.width = "<?php echo ((($search['page_to_show']-1)*$search['fiches_par_page']+count($fiches)) * 100) /$nb_fiches;?>%";
	var AppelAjax = new Ajax.Updater(
											"progress_script",
											"communication_newsletters_gestion_envoi_progress.php", 
											{
											evalScripts:true, 
											parameters: {id_envoi: <?php echo $id_envoi;?>, page_to_show: "<?php echo $page_to_show;?>", nb_fiches: <?php echo $nb_fiches;?>   },
											insertion: Insertion.Bottom,
											}
											);
	<?php 
} else { 
	?>
	$("info_progress_more").innerHTML = "Envoi terminé.";
	H_loading();
	<?php 
} 
?>
</SCRIPT>