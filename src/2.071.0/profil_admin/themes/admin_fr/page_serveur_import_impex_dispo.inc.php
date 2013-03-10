<?php

// *************************************************************************************************************
//  LISTE DES TYPES D'IMPORT MIS A DISPOSITION
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
	<table style="width:450px;">
	<?php 
	if (count($liste_import_dispo) && $liste_import_dispo[0] != "" ) {
		?>
		<tr>
			<td colspan="3">
				Types d'imports disponibles:
			</td>
		</tr>
		<?php
		foreach ($liste_export_types as $export_type) {
			if (!in_array($export_type->id_impex_type , $liste_import_dispo)) { continue; }
			?>
			<tr>
				<td>
					<?php echo $export_type->lib_impex_type;?> :
				</td>
				<td style="text-align:center">
					<input name="id_impex_type_<?php echo $export_type->id_impex_type ;?>" id="id_impex_type_<?php echo $export_type->id_impex_type ;?>" type="checkbox" value="<?php echo $export_type->id_impex_type ;?>"/>
				</td>
				<td style="text-align:right">
					
				</td>
				
			</tr>
			<?php
		}
		?>
		<tr>
			<td>
				
			</td>
			<td style="text-align:center">
			</td>
			<td style="text-align:right">
							<div style="text-align:right">
							<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
							</div>
			</td>
		</tr>
		<?php
	} else {
	?>
	
	<tr>
		<td colspan="3">
			Le serveur indiqué semble ne proposer aucun type de données en partage.
		</td>
	</tr>
	<?php
	}
	?>
	</table>
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>