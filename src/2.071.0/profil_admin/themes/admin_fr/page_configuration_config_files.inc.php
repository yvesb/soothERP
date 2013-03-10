<?php

// *************************************************************************************************************
// Edition des fichiers de configuration
// *************************************************************************************************************

/* Désactivé pour des raisons de sécurité

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

<div class="emarge">

<p class="titre">Edition des fichiers de configuration</p>
<div style="height:50px">
	<div class="contactview_corps">


			<?php 
				$dir = opendir($DIR."config");
				$idx = 0;
				while($fichier = readdir($dir)){
					if(is_dir($DIR.'config/'.$fichier) || $fichier == '.' || $fichier =='..'){ continue; }
					// Masque le fichier index destiné à protéger le répertoire du listing,
					// ainsi que le fichier de config de la bdd dont les infos sensibles doivent plutôt être manipulée par l'admin système via connexion au serveur.
					if ( basename($fichier) == "index.html" OR basename($fichier) == "config_bdd.inc.php"){ continue; }
					++$idx;
					
					$config_file = file($DIR.'config/'.$fichier);
										
					$text_config_file = '';
					foreach ($config_file as $config_line) {
						$text_config_file .= $config_line;
					}
					
					?>
					<form onSubmit="return confirm('Voulez-vous vraiment modifier ce fichier de configuration?')" action="config_files_mod.php" method="post" id="" name="" target="formFrame" >
						<input type="hidden" id="nom_fichier" name="nom_fichier" value=<?php echo $fichier; ?> />
						
						<table style="width:100%;">
						<tr>
							<td class="titre_config" id="titre_<?php echo $idx;?>" colspan="4"><?php echo $fichier;?></td>
						</tr><tr id="line_txt_file_<?php echo $idx;?>" style="display:none">
							<td><textarea  id="new_text_file" name="new_text_file" class="classinput_xsize" rows="20"><?php echo $text_config_file;?></textarea></td>
						</tr><tr id="line_input_file_<?php echo $idx;?>" style="display:none">
							<td style="text-align: right; padding-right:10px;">
							<input name="valider_<?php echo $idx;?>" id="valider_<?php echo $idx;?>" src="<?php echo $DIR;?>profil_admin/themes/admin_fr/images/bt-valider.gif" type="image">
							</td>
						<tr>
						</table>
					</form>
					<?php 
				}
				closedir($dir);
			?>
		
	</div>
</div>

<script type="text/javascript">

idx_open = 1;
</SCRIPT>

<?php 
for($i=1; $i<=$idx; ++$i){
	?>
	<script type="text/javascript">

	//Script permettant l'affichage ou le masquage des fichiers
	Event.observe("titre_<?php echo $i; ?>", "click",  function(evt){
		Event.stop(evt);

		//masquage de l'ancien fichier selectionné
		$("line_txt_file_"+idx_open).hide();
		$("line_input_file_"+idx_open).hide();

		//affichage du fichier selectionné
		idx_open = <?php echo $i; ?>;
		$("line_txt_file_<?php echo $i; ?>").show();
		$("line_input_file_<?php echo $i; ?>").show();
		
	}, false);
	</SCRIPT>
	<?php 
}   ?>
<script type="text/javascript">
//Script permettant l'affichage ou le masquage des fichiers
//on masque le chargement
H_loading();
</SCRIPT>
</div>

*/