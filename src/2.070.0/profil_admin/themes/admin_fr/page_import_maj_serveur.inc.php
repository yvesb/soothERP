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
tableau_smenu[0] = Array("import_maj_serveur", "import_maj_serveur.php" ,"true" ,"sub_content", "Mises à jour");
tableau_smenu[1] = Array("", "" ,"" ,"", "");
update_menu_arbo();
</script>
<div class="emarge">
<div>

<table cellpadding="0" cellspacing="0" border="0" style="width:100%; ">
<tr>
<td style="width:50%"></td>
<td align="center" style="text-align:center"><table cellpadding="0" cellspacing="0" border="0" width="550px">
	<tr>
	
	<td valign="top" style="text-align:center">
		<p align="center">&nbsp;</p>
		<p align="center"></p>
		<p style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; "><span><span>LUNDI<span style="color: #98C10F" >MATIN</span> BUSINESS</span></span></p>
		<p>
		<?php
		echo "version ".affiche_version ($_SERVER['VERSION']);
		$last_version = "0";
		$new_version = "0";
		
		if (isset($version_file[0]) && isset($version_file[1])) {
			$last_version = str_replace("\n", "", $version_file[0]);
			$new_version = str_replace("\n", "",$version_file[1]);
		}
		?>
		</p>
		<p>
		<?php
		if ($last_version == "0" || $last_version == "" ) { 
			echo "Aucune mise à jour nécessaire";
			
		} else {
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id="head_choix_maj">
				<tr>
					<td style="text-align:center">
					<div style="text-align:center">
						<input type="submit" id="manu" name="manu" class="bt" style="display: ;" value="MAJ manuelle" /><br />

					</div>
					</td>
					<td>&nbsp;</td>
					<td style="text-align:center">
					<div style="text-align:center">
						<input type="submit" id="auto" name="auto"  <?php if ($erreur) {?>disabled="disabled"<?php } ?> class="bt" style="display: ;" value="MAJ automatique" /><br />

					</div>
					</td>
				</tr>
				<tr>
					<td style="text-align:center; font-style:italic; ">
					<div id="manu_comment" >
					Mettez &agrave; jour LMB en t&eacute;l&eacute;chargeant les fichiers de mise &agrave; jour manuellement sur votre serveur depuis un fichier zip.
					</div>
					</td>
					<td>&nbsp;</td>
					<td style="text-align:center; font-style:italic;" >
					<div id="auto_comment">
					Mettez &agrave; jour LMB en utilisant notre syst&egrave;me de mise &agrave; jour automatique depuis notre serveur FTP. 
					</div>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>

			<SCRIPT type="text/javascript">
				Event.observe('manu', 'click',  function(evt){
				Event.stop(evt);
				$("head_choix_maj").hide();
				$("lauch_maj").hide();
				$("head_manu").show();
				$("total_box").show();
				});
				Event.observe('auto', 'click',  function(evt){
				Event.stop(evt);
				$("head_choix_maj").hide();
				$("lauch_maj_manu").hide();
				$("head_auto").show();
				$("lauch_maj").show();
				$("install_box").show();
				$("total_box").show();
				});
			</SCRIPT>
				
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<div id="total_box" style="display:none">
			<div class="white_rounded_top">
					<div class="head_download" style="display:none" id="head_auto">
						<span class="bold_text">Mise à jour de Lundi Matin Business</span><br />
						Ceci peut prendre plusieurs minutes. Vous pouvez utiliser votre ordinateur<br />
						pour d&rsquo;autres t&acirc;ches durant l&rsquo;installation			<br />

					</div>
					<div class="head_download" style="display:none; height:100px" id="head_manu">
						<span class="bold_text">Mise à jour Manuelle de Lundi Matin Business</span><br />
						Télécharger le fichier à l'adresse suivante:<br />
<a href="<?php echo $MAJ_SERVEUR['url']."check_maj_zip_version.php?ma_version=".$_SERVER['VERSION'];?>" target="_blank"><?php echo $MAJ_SERVEUR['url']."check_maj_zip_version.php?ma_version=".$_SERVER['VERSION'];?></a><br />
						Décompresser le fichier<br />
						Copier le dossier "maj_lmb_<?php echo $new_version;?>/" dans le dossier "echange_lmb/" sur votre serveur<br />
						Une fois l'ensemble des fichiers uploadés sur votre serveur, <span id="maj_manu_suite" style="cursor:pointer; text-decoration:underline">cliquez ici</span>.<br />

					</div>
			</div>
			
			
			<SCRIPT type="text/javascript">
				Event.observe('maj_manu_suite', 'click',  function(evt){
				Event.stop(evt);
				$("lauch_maj").hide();
				$("lauch_maj_manu").show();
				$("install_box").show();
				});
				</SCRIPT>
			<div class="grey_rounded_bottom">
			
				<div style="text-align:center; margin:5px 0px;">
					
					<div id="install_box" style="width:400px;	margin:0px auto; display:none">
					
						Nouvelle version disponible <?php echo affiche_version ($last_version);?><br />
						<div style="text-align:left; font-size:11px">
							<?php
							$url_infos = $MAJ_SERVEUR['url']."maj-v".$last_version."/maj_info.txt";
							if (remote_file_exists ($url_infos)) {
								$fvi = file($url_infos);
								foreach ($fvi as $line) {
									echo $line."<br />";
								}
							}
							?>
						</div>
						<br />
						<input type="submit" id="lauch_maj" name="go_etape_5a" style="display:none" class="bt" value="Mettre à niveau le Logiciel" />
						<input type="submit" id="lauch_maj_manu" name="go_etape_5a_manu" style="display:none" class="bt" value="Mettre à niveau le Logiciel" />
						<div id="maj_etat" style="display:none">Mise à jour vers version <?php echo $new_version;?> en cours</div><br />
						<br />
						<div style="text-align:left" class="bold_text" id="info_progress">&nbsp;</div>
						
						<div id="progress_barre" class="progress_barre">
							<div id="files_progress" class="files_progress">&nbsp;</div>
						</div>
						
						<div style="text-align:left;" class="sbold_ita_text" id="info_progress_more"></div>
						<br /><br />
						
					</div>
					
					
					
				</div><br />


			</div>
			</div>
			<SCRIPT type="text/javascript">
				Event.observe('lauch_maj', 'click',  function(evt){
				Event.stop(evt);
				$("lauch_maj").hide();
				$("maj_etat").show();
				setTimeout ("view_progress('<?php echo $new_version;?>')", 2000);
				var AppelAjax = new Ajax.Updater(
												"maj_viewer", 
												"maj_serveur.php", 
												{
												method: 'post',
												asynchronous: true,
												contentType:  'application/x-www-form-urlencoded',
												encoding:     'UTF-8',
												evalScripts:true, 
												onLoading:S_loading, 
												onComplete: function(requester) {
																			H_loading ();
																			if (requester.responseText!="") {
																			//	requester.responseText.evalScripts();
																			}
																		} 
												}
												);
				}, false);
				
				
				Event.observe('lauch_maj_manu', 'click',  function(evt){
				Event.stop(evt);
				$("lauch_maj_manu").hide();
				$("maj_etat").show();
				setTimeout ("view_progress('<?php echo $new_version;?>')", 2000);
				var AppelAjax = new Ajax.Updater(
												"maj_viewer", 
												"<?php echo $DIR;?>echange_lmb/maj_lmb_<?php echo $new_version;?>/miseajour_lmb.php", 
												{
												method: 'post',
												asynchronous: true,
												contentType:  'application/x-www-form-urlencoded',
												encoding:     'UTF-8',
												evalScripts:true, 
												onLoading:S_loading, 
												onComplete: function(requester) {
																			H_loading ();
																			if (requester.responseText!="") {
																			//	requester.responseText.evalScripts();
																			}
																		} 
												}
												);
				}, false);
				
			</SCRIPT>
		<?php
	}
	?>
		</p>

		<div id="maj_viewer" <?php if (!$AFFICHE_DEBUG) {?> style="display:none"<?php } ?>>&nbsp;</div>
		<p>&nbsp;</p></td>
	</tr>
	</table>

</td>
<td style="width:50%"></td>
</tr>
</table>
</div>

<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>
</div>