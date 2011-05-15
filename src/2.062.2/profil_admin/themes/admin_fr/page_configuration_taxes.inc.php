<?php
require_once ($DIR."_adresse.class.php");
// *************************************************************************************************************
// CONFIG DES DONNEES taxes
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
tableau_smenu[0] = Array("smenu_catalogue", "smenu_catalogue.php" ,"true" ,"sub_content", "Catalogue");
tableau_smenu[1] = Array('configuration_taxes','configuration_taxes.php' ,"true" ,"sub_content", "Paramètres de taxes");
update_menu_arbo();
</script>
<div class="emarge"><p class="titre">Paramètres de taxes</p>

<div class="contactview_corps" style="text-align:center;"><br />

<table style="width:87%;">
	<tbody>
		<tr>
			<td style="width:25%">Libellé taxe</td>
			<td style="width:25%">Pays</td>
			<td style="width:25%">Code Taxe</td>
			<td style="width:25%">Info Calcul</td>
		</tr>
	</tbody>
</table>
<?php 
foreach ($taxes_liste as $taxe_liste) {
	?>
	<form action="configuration_taxes_maj.php" enctype="multipart/form-data" method="POST"  id="configuration_taxes_maj_<?php echo $taxe_liste['id_taxe'];?>" name="configuration_taxes_maj_<?php echo $taxe_liste['id_taxe'];?>" target="formFrame">
  <input name="id_taxe"  type="hidden" value="<?php echo $taxe_liste['id_taxe'];?>" />
  <table style="width: 100%;">
		<tbody>
			<tr>
  			<td>
					<input name="lib_taxe_<?php echo $taxe_liste['id_taxe'];?>" id="lib_taxe_<?php echo $taxe_liste['id_taxe'];?>" type="text" value="<?php echo $taxe_liste['lib_taxe'];?>" class="classinput_xsize" />
				</td>
				<td>
					<input name="id_pays_<?php echo $taxe_liste['id_taxe'];?>" id="id_pays_<?php echo $taxe_liste['id_taxe'];?>" type="text" value="<?php echo $taxe_liste['pays'];?>" disabled="disabled" class="classinput_xsize" />
				</td>
				<td>
					<input name="code_taxe_<?php echo $taxe_liste['id_taxe'];?>" id="code_taxe_<?php echo $taxe_liste['id_taxe'];?>" type="text" value="<?php echo $taxe_liste['code_taxe'];?>" disabled="disabled" class="classinput_xsize"/>
				</td>
     		<td>
					<input name="code_taxe_<?php echo $taxe_liste['id_taxe'];?>" id="code_taxe_<?php echo $taxe_liste['id_taxe'];?>" type="text" value="<?php echo $taxe_liste['info_calcul'];?>" disabled="disabled" class="classinput_xsize"/>
				</td>
				<td>
					<img id="eye_<?php echo $taxe_liste['id_taxe'];?>" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme().'images/'.((intval($taxe_liste['visible']) == 1)? "":"un");?>visible.gif" style="cursor: pointer;" />
				</td>
				<td>
					<input name="valider" id="valider" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/bt-valider.gif" />
					<input name="visible_<?php echo $taxe_liste['id_taxe'];?>" id="visible_<?php echo $taxe_liste['id_taxe'];?>" type="hidden" value="<?php echo ((intval($taxe_liste['visible']) == 1)? "1":"0");?>" />
				</td>
			</tr>
		</tbody>
	</table>
  </form>
	<br />
<SCRIPT type="text/javascript">
	Event.observe('eye_<?php echo $taxe_liste['id_taxe'];?>', 'click', function(evt){
			if ($('visible_<?php echo $taxe_liste['id_taxe'];?>').value == 1) {
				$("eye_<?php echo $taxe_liste['id_taxe'];?>").src = '<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/unvisible.gif';
				$('visible_<?php echo $taxe_liste['id_taxe'];?>').value = '0';
			} else {
				$("eye_<?php echo $taxe_liste['id_taxe'];?>").src = '<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/visible.gif';
				$('visible_<?php echo $taxe_liste['id_taxe'];?>').value = '1';
			}
	});
			
</script>
			
	<?php
}	
?>
</div>
</div>
<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>