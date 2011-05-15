<?php
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<form action="recherche_add.php" method="post" id="recherche_add" name="recherche_add" target="formFrame" >
	<input name="parent"  id="parent" type="hidden" value="<?php echo $parent; ?>" />
	<input name="idtype"  id="idtype" type="hidden" value="<?php echo $idtype; ?>" />
	<table style="padding:4px 0px 2px 0px;">
		<tr>
		
			<td style="text-align:right" >Libell&eacute;: </td>
			<td style="width:15%;" ><input name="lib_recherche" id="lib_recherche" type="text" value=""  class="classinput_xsize"  /></td>
			
			<td style="text-align:right">Description: </td>
			<td style="width:20%;" ><input name="desc_recherche" id="desc_recherche" type="text" value=""  class="classinput_xsize"  />	</td>
			
			<td style="text-align:right">Requ&ecirc;te: </td>
			<td style="width:45%;" ><textarea name="requete" id="requete" rows=3 COLS=50></textarea></td>
					
			<td style="text-align:center">
				<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
			</td>
		</tr>
	</table>
</form>