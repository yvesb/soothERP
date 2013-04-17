<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************


?>
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_annuaire", "smenu_annuaire.php" ,"true" ,"sub_content", "Annuaire");
tableau_smenu[1] = Array('<?php echo $import_annuaire_csv['menu_admin'][1][0];?>','<?php echo $import_annuaire_csv['menu_admin'][1][1];?>','<?php echo $import_annuaire_csv['menu_admin'][1][2];?>','<?php echo $import_annuaire_csv['menu_admin'][1][3];?>', "<?php echo $import_annuaire_csv['menu_admin'][1][4];?>");
update_menu_arbo();
</script>
<div class="emarge">


<p class="titre">Import terminé</p>
<div>

<table class="contactview_corps" style=" width:100%">
	<tr>
		<td >
		 	l'ensemble des informations présentes dans votre fichier csv ont été transformées en contact.
		</td>
	</tr>
</table>
<br />

</div>
<div id="resultat_imports">
</div>

<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>
</div>