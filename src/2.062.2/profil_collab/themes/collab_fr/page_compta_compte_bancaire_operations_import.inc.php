<?php

// *************************************************************************************************************
// IMPORT D'OPERATIONS
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="close_edit_ope" style="cursor:pointer; float:right"/>
<script type="text/javascript">
Event.observe('close_edit_ope', 'click',  function(evt){
Event.stop(evt); 
$("edition_operation").hide();
}, false);
</script>

<p  style="font-weight:bolder">IMPORT d'opérations</p>
<div class="emarge">
	<table class="minimizetable">
		<tr>
			<td>
			Importer des opérations bancaires depuis un fichier au format .ofx<br />

			<form action="compta_compte_bancaire_operations_import_valid.php" method="post" id="operations_import_valid" name="operations_import_valid" target="formFrame" enctype="multipart/form-data" >
			
				<table border="0" cellspacing="0" cellpadding="0" style="width:100%">
					<tr>
						<td style="width:20%">
						Indiquez l'emplacement du fichier à importer:<br />
						<input type="file" size="35" name="ope_ofx" />
						</td>
						<td> </td>
						<td style="text-align:right; width:25%"> 
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td style="text-align:right">
				<input type="hidden" name="id_compte_bancaire_ope" id="id_compte_bancaire_ope" value="<?php echo $compte_bancaire->getId_compte_bancaire();?>"/>
						<?php if (isset($_REQUEST["from_tb"])) { ?>
						<input type="hidden" name="from_tb" id="from_tb" value="1"/>
						<?php }?>
						<input name="import_operations_import_valid" id="import_operations_import_valid" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-importer.gif" />
						</td>
					</tr>
				</table>
			
			
			</form>
			
			</td>
		</tr>
	</table>
</div>
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>