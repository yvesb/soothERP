<?php
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<form action="codes_promo_add.php" method="post" id="codes_promo_add" name="codes_promo_add" target="formFrame" >
	<table style="padding:4px 0px 2px 0px;">
		<tr>
		
			<td style="text-align:right">Libell&eacute;: </td>
			<td><input name="lib_code_promo" id="lib_code_promo" type="text" value=""  class="classinput_xsize"  /></td>
			
			<td style="text-align:right">Code: </td>
			<td><input name="code" id="code" type="text" value=""  class="classinput_xsize"  />	</td>
			
			<td style="text-align:right">pourcentage: </td>
			<td><input name="pourcentage" id="pourcentage"  type="text" value=""  class="classinput_xsize"  /></td>
					
			<td style="text-align:center">
				<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
			</td>
		</tr>
	</table>
</form>
