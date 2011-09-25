<?php

// *************************************************************************************************************
// insertion d'image dans un descriptif
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="close_edit_img" style="cursor:pointer; float:right" onclick="parent.document.getElementById('image_choix_editor').style.display='none';"/>
<div style="font:11px Arial, Helvetica, sans-serif; background-color:#FFFFFF">
<br />

<form action="image_editor_insert.php" enctype="multipart/form-data" method="POST" id="image_editor_insert" name="image_editor_insert" target="formFrame" class="classinput_nsize" >

<table class="contactview_corps" style="width:100%">
	<tr>
		<td>
		<span style=" font-size:10px ;text-align: left; float:left">Indiquez l'emplacement de votre image:</span> 
		<input type="file" size="35" name="fichier_img" style=" font-size:10px" />	
		</td>
	<tr>
	</tr>
		<td>
		<input type="hidden" name="folder_stock" value="<?php echo $_REQUEST["folder_stock"];?>"/>
		<input type="hidden" name="proto" value="<?php echo $_REQUEST["proto"];?>"/>
		<input type="hidden" name="ifr" value="<?php echo $_REQUEST["ifr"];?>"/>
		<input type="submit" name="Submit" value="Valider" style=" font-size:10px"  />
		</td>
	</tr>
</table>
</form>
<SCRIPT type="text/javascript">


//on masque le chargement
parent.H_loading();
</SCRIPT>
</div>