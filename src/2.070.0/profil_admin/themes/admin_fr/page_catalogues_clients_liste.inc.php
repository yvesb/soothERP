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
</script>
<div class="emarge">


<div>
Ajouter un nouveau catalogue
<table style="width:550px;">
		<tr class="smallheight">
			<td>
				<form action="catalogues_clients_add.php" method="post" id="catalogues_clients_add" name="catalogues_clients_add" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="">Libellé du catalogue: </td>
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						</td>
						<td>
						<input name="lib_catalogue_client" id="lib_catalogue_client" type="text" value=""  class="classinput_xsize"/>
						</td>
						<td>
							<div style="text-align:right">
							<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
							</div>
						</td>

					</tr>
				</table>
				</form>
			</td>
			<td>
				<div style="text-align:left; width:35px">
				</div>
			</td>
		</tr>
	</table>
</div>
<div>
Liste des catalogues
<table style="width:550px;">
	<?php 
	foreach ($catalogues_clients as $catalogue_client) {
		?>
		<tr class="smallheight">
			<td>
				<form action="catalogues_clients_mod.php" method="post" id="catalogues_clients_mod_<?php echo $catalogue_client->id_catalogue_client;?>" name="catalogues_clients_mod_<?php echo $catalogue_client->id_catalogue_client;?>" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style=""><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						
						</td>
						<td>
						<input name="lib_catalogue_client" id="lib_catalogue_client" type="text" value="<?php echo htmlentities($catalogue_client->lib_catalogue_client);?>"  class="classinput_xsize"/>
						<input name="id_catalogue_client" id="id_catalogue_client" type="hidden" value="<?php echo htmlentities($catalogue_client->id_catalogue_client);?>"/>
						</td>
						<td>
							<div style="text-align:right">
							<input name="modifier_<?php echo $catalogue_client->id_catalogue_client;?>" id="modifier_<?php echo $catalogue_client->id_catalogue_client;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
							</div>
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td>
				<div style="text-align:left; width:35px">
				<form action="catalogues_clients_sup.php" method="post" id="catalogues_clients_sup_<?php echo $catalogue_client->id_catalogue_client;?>" name="catalogues_clients_sup_<?php echo $catalogue_client->id_catalogue_client;?>" target="formFrame" >
						<input name="id_catalogue_client" id="id_catalogue_client" type="hidden" value="<?php echo htmlentities($catalogue_client->id_catalogue_client);?>"/>
							<input name="supprimer_<?php echo $catalogue_client->id_catalogue_client;?>" id="supprimer_<?php echo $catalogue_client->id_catalogue_client;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" />
				</form>
				<SCRIPT type="text/javascript">
				Event.observe("supprimer_<?php echo $catalogue_client->id_catalogue_client;?>", "click",  function(evt){
					Event.stop(evt); 
					alerte.confirm_supprimer("catalogue_client_supprime", "catalogues_clients_sup_<?php echo $catalogue_client->id_catalogue_client;?>")
				}, false);
				</SCRIPT>
				</div>
			</td>
		</tr>
		<?php
	}
	?>
	</table>
</div>
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>
</div>