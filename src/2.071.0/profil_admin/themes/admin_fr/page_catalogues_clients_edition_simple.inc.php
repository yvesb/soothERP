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


<table style="">
	<tr>
		<td>
		<table cellpadding="0" cellspacing="0" style="">
			<tr>
				<td width="5px">
				<table cellpadding="0" cellspacing="0" width="5px">
					<tr>
					<td>
				
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/></td>
					<td>
					</td>
					</tr>
					</table>
					</td>
					<td width="350px">
					</td>
					<td width="15px">
						</td>
						<?php 
						foreach ($catalogues_clients as $catalogue_client) {
							?>
							<td width="180px">
							<div style="display:block;width:180px; text-align: center; font-weight:bolder">
								<?php echo htmlentities($catalogue_client->lib_catalogue_client);?>
								</div>
							</td>
							<script type="text/javascript">
								 maj_categ["<?php echo $catalogue_client->id_catalogue_client;?>"] = new Array();
							</script>
							<?php
						}
						?>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="smallheight">
		<td>
			<div id="liste_de_categorie_selectable" >
		<?php
$indentation_case_a_cocher = 0;
while ($art_categ = current($list_art_categ) ){
next($list_art_categ);
?>

<table cellpadding="0" cellspacing="0"  id="<?php echo ($art_categ->ref_art_categ)?>" style="width:100%">
<tr id="tr_<?php echo ($art_categ->ref_art_categ)?>" class="list_art_categs">
	<td width="5px">
	<table cellpadding="0" cellspacing="0" width="5px"><tr><td>
	<?php 
	for ($i=0; $i<=$art_categ->indentation; $i++) {
		if ($i==$art_categ->indentation) {
		 
			if (key($list_art_categ)!="") {
				if ($art_categ->indentation < current($list_art_categ)->indentation) {
					
				?><a href="#" id="link_div_art_categ_<?php echo $art_categ->ref_art_categ?>">
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/collapse.gif" width="14px" id="extend_<?php echo $art_categ->ref_art_categ?>"/>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/extend.gif" width="14px" id="collapse_<?php echo $art_categ->ref_art_categ?>" style="display:none"/></a>
				<script type="text/javascript">
				Event.observe("link_div_art_categ_<?php echo $art_categ->ref_art_categ?>", "click",  function(evt){Event.stop(evt); Element.toggle('div_<?php echo $art_categ->ref_art_categ?>') ; Element.toggle('extend_<?php echo $art_categ->ref_art_categ?>'); Element.toggle('collapse_<?php echo $art_categ->ref_art_categ?>');}, false);
				</script>
				<?php
				}
				else 
				{
				?>
				<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/>
				<?php
				}
			}
			else 
			{
			?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/>
			<?php
			}
		}
		else
		{
	?>
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/></td><td>
	<?php 
		}
	}
	?></td>
	</tr>
	</table>
	</td>
	<td >
	<div style="display:block;">
		<?php echo str_replace(" ", "&nbsp;", htmlentities($art_categ->lib_art_categ));?>
	</div>
	</td>
	<td width="15px">
		<a href="#" class="insertion" id="ins_<?php echo ($art_categ->ref_art_categ)?>" title="Inserer une cat&eacute;gorie dans <?php echo htmlentities($art_categ->lib_art_categ)?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/insert.gif" />
			</a>
		</td>
		<?php 
		foreach ($catalogues_clients as $catalogue_client) {
			//génération des cases à cocher
			?>
			<td width="180px">
			<div style="width:180px; text-align: center">
							
				<input type="checkbox" <?php 
					echo 'id="ins_'.$catalogue_client->id_catalogue_client.'_'.$indentation_case_a_cocher.'"'; 
				 	echo 'name="ins_'.$catalogue_client->id_catalogue_client.'_'.$indentation_case_a_cocher.'"';
				if (isset($catalogues_clients_dir[$catalogue_client->id_catalogue_client]) && in_array($art_categ->ref_art_categ, $catalogues_clients_dir[$catalogue_client->id_catalogue_client])) {
					echo 'checked="checked"';
				}
				?> />
				<SCRIPT type="text/javascript">
					Event.observe('ins_<?php echo $catalogue_client->id_catalogue_client;?>_<?php echo $indentation_case_a_cocher ?>', 'click',  function(evt){
					if ($('ins_<?php echo $catalogue_client->id_catalogue_client;?>_<?php echo $indentation_case_a_cocher?>').checked) {
						maj_categ["<?php echo $catalogue_client->id_catalogue_client;?>"]["<?php echo ($art_categ->ref_art_categ_parent.'@'.$art_categ->ref_art_categ)?>"] = 1;
					} else {
						maj_categ["<?php echo $catalogue_client->id_catalogue_client;?>"]["<?php echo ($art_categ->ref_art_categ_parent.'@'.$art_categ->ref_art_categ)?>"] = 0;
							 
					}
					}, false);
				</SCRIPT>
			</div>
			</td>
			<?php
		}
		?>
	</tr>
</table>
<?php 
	if (key($list_art_categ)!="") {
		if ($art_categ->indentation < current($list_art_categ)->indentation) {
			echo '<div id="div_'.$art_categ->ref_art_categ.'" style="">';
		}
		
		
		if ($art_categ->indentation > current($list_art_categ)->indentation) {
						for ($a=$art_categ->indentation; $a>current($list_art_categ)->indentation ; $a--) {
						echo '</div>';
					}
		}
	}

$indentation_case_a_cocher ++;
}
?>
			
			
			
			</td>
		</tr><tr>
		<td>
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
				<td width="5px">
				<table cellpadding="0" cellspacing="0" width="5px">
					<tr>
					<td>
				
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/inarbo.gif" width="14px"/></td>
					<td>
					</td>
					</tr>
					</table>
					</td>
					<td width="350px">
					</td>
					<td width="15px">
					</td>
					<?php 
					foreach ($catalogues_clients as $catalogue_client) {
						?>
						<td width="180px">
						<div style="display:block; width:180px; text-align: center">
							<span id="coche_all_<?php echo $catalogue_client->id_catalogue_client;?>" style="cursor:pointer">Tout cocher</span><br />
							<span id="decoche_all_<?php echo $catalogue_client->id_catalogue_client;?>" style="cursor:pointer">Tout d&eacute;cocher</span><br />
							<span style="text-align: center;">
								<input id="bt_mod_catalogue_<?php echo $catalogue_client->id_catalogue_client;?>" type="image" name="bt_mod_catalogue_<?php echo $catalogue_client->id_catalogue_client;?>" src="../profil_admin/themes/admin_fr/images/bt-valider.gif"/>
							</span>
							<script type="text/javascript">
							Event.observe('coche_all_<?php echo $catalogue_client->id_catalogue_client;?>', 'click',  function(evt){
								coche_all_art_categ_to_catalogue ("<?php echo $indentation_case_a_cocher;?>", "<?php echo $catalogue_client->id_catalogue_client;?>");
							}, false);
							Event.observe('decoche_all_<?php echo $catalogue_client->id_catalogue_client;?>', 'click',  function(evt){
								decoche_all_art_categ_to_catalogue ("<?php echo $indentation_case_a_cocher;?>", "<?php echo $catalogue_client->id_catalogue_client;?>");
							}, false);
							Event.observe('bt_mod_catalogue_<?php echo $catalogue_client->id_catalogue_client;?>', 'click',  function(evt){
								maj_catalogue_client(<?php echo $catalogue_client->id_catalogue_client;?>,maj_categ["<?php echo $catalogue_client->id_catalogue_client;?>"]);
								maj_categ["<?php echo $catalogue_client->id_catalogue_client;?>"] = new Array();	
							}, false);
							</script>
							</div>
						</td>
						<?php
					}
					?>
				</tr>
			</table>
		</td>
	</tr>
	</table>
</div>
<SCRIPT type="text/javascript">
	
<?php
	foreach ($list_art_categ  as $art_categ){
?>
	Event.observe('tr_<?php echo ($art_categ->ref_art_categ)?>', 'mouseover',  function(){changeclassname ('tr_<?php echo ($art_categ->ref_art_categ)?>', 'list_art_categs_hover');}, false);
	
	Event.observe('tr_<?php echo ($art_categ->ref_art_categ)?>', 'mouseout',  function(){changeclassname ('tr_<?php echo ($art_categ->ref_art_categ)?>', 'list_art_categs');}, false);
	
<?php 
	}
?>
//on masque le chargement
//H_loading();
</SCRIPT>
</div>
