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
<span class="sous_titre2">Choix du catalogue</span><br />

	<select id="choix_catalogue_client" name="choix_catalogue_client" class="classinput_xsize" style="width:300px">
		<option value=""></option>
	<?php 
	foreach ($catalogues_clients as $catalogue_client) {
		?>
		<option value="<?php echo htmlentities($catalogue_client->id_catalogue_client);?>">
		<?php echo htmlentities($catalogue_client->lib_catalogue_client);?>
		</option>
		<?php
	}
	?>
	</select>
</div>
<div id="edition_catalogue_client_avance_content" >
</div>
<SCRIPT type="text/javascript">

Event.observe("choix_catalogue_client", "change",  function(evt){
	if ($("choix_catalogue_client").value != "") {
		page.verify('catalogues_clients_edition_avance_content','catalogues_clients_edition_avance_content.php?id_catalogue_client='+$("choix_catalogue_client").value,'true','edition_catalogue_client_avance_content');
	}
}, false);
//on masque le chargement
H_loading();
</SCRIPT>
</div>