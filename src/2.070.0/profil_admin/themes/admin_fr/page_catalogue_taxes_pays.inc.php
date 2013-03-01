
				<select  id="taxe_id_pays"  name="taxe_id_pays" class="classinput_nsize" style="width:250px">
					<?php
		foreach ($listepays as $payslist){
		?>
		<option value="<?php echo $payslist->id_pays?>" <?php if ($payslist->id_pays==$DEFAUT_ID_PAYS){echo 'selected="selected"';}?>>
		<?php echo htmlentities($payslist->pays)?></option>
		<?php 
		}?>
				</select>
	
<script type="text/javascript">
Event.observe('taxe_id_pays', 'change',  function(){page.traitecontent('categ_taxes_list_content','catalogue_taxes_client.php?id_pays='+$('taxe_id_pays').value,true,'taxes_client'); 	currentpays = $('taxe_id_pays').value;}, false);

currentpays = <?php echo $DEFAUT_ID_PAYS?>;
page.traitecontent('categ_taxes_list_content','catalogue_taxes_client.php?id_pays=<?php echo $DEFAUT_ID_PAYS?>',true,'taxes_client');

//on masque le chargement
H_loading();

</script>
