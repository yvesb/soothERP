<?php
// *********************************************
// CONFIG DES INTERFACES - THEMES
// *********************************************
global $CHOIX_THEME;
?>
<script type="text/javascript">
	tableau_smenu[0] = Array("smenu_site_internet", "smenu_site_internet.php", "true", "sub_content", "Interfaces");
	tableau_smenu[1] = Array('site_internet_choix_theme', 'site_internet_choix_theme.php', 'true', 'sub_content', "Choix du th&#232;me");
	update_menu_arbo();
</script>
<div class="emarge">
	<p class="titre">Choix du th&#232;me de vos interfaces</p>

	<div class="contactview_corps">
		<table width="100%">
			<tr class="smallheight">
				<td style="width:35%"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_gtheme() ?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:20%"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_gtheme() ?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td style="width:35%"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_gtheme() ?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>

				<td class="titre_config" colspan="3">S&eacute;lection de vos th&#232;mes disponibles:</td>
			</tr>
			<tr>
				<td colspan="3"></td>
			</tr>
			<tr>
				<td> <p class="li">Vous utilisez actuellement le th&#232;me : <strong><?php echo $CHOIX_THEME ?></strong></p>
					<?php
					echo '<form><table class="caract_table caract_table_use"><tbody><tr><td class="tdimg">';
					echo '<img class="imgtd"';
					if (file_exists($DIR . 'themes/' . $CHOIX_THEME . '/imgthm.jpg')) {
						echo 'class="imgfs" src="' . $DIR . 'themes/' . $CHOIX_THEME . '/imgthm.jpg"></img></td>';
					} else {
						echo 'src="' . $DIR . $_SESSION['theme']->getDir_gtheme() . '/images/no_pict.gif"></img></td>';
					}
					if (file_exists($DIR . 'themes/' . $CHOIX_THEME . '/desc.php')) {
						echo '<td class="tddesc"><div>';
						include $DIR . $_SESSION['theme']->getDir_gtheme() . '/desc.php';													
						echo '</div></td></tr>';
					} else {
						echo '<td class="tddesc"><p>Nom : ' . $CHOIX_THEME . '</p><p>Pas de description disponible dans le themes ' . $CHOIX_THEME . '</p></td></tr>';
					}

					echo '<tr><td colspan="2" class="tdbt"><input class="nop" type="image" name="modifier" id="choix_theme_modifier-' . $CHOIX_THEME . '" src="' . $DIR . $_SESSION['theme']->getDir_gtheme() . 'images/bt-modifier.gif" /></td></tr>';
					echo '</tbody></table></form>';
					?>
				</td></tr>
			<td style="width:100%">
				<?php
				$nb_fichier	 = 0;
				$repthm		 = '../../themes/';
				if ($dossier = opendir($repthm)) {
					while (false !== ($fichier = readdir($dossier))) {
						if ($fichier != '.' && $fichier != '..' && $fichier != $CHOIX_THEME && is_dir($repthm . $fichier)) {
							$nb_fichier++;
						}
					} // On termine la boucle if et while
					if ($nb_fichier > 1) {
						echo '<p class="li">Vous avez <strong>' . $nb_fichier . '</strong> autres th&#232;mes disponibles :</p>';
					} else {
						echo '<p class="li">Vous avez <strong>' . $nb_fichier . '</strong> autre th&#232;me disponible :</p>';
					}
					closedir($dossier);
				} else {
					echo '<br />';
					echo '<p class="li">Le dossier des th&#232;mes n\' a pas pu &ecirc;tre ouvert</p>';
				}

				$nb_fichier	 = 0;
				//$repthm		 = '../themes/';
				if ($dossier = opendir($repthm)) {
					while (false !== ($fichier = readdir($dossier))) {
						if ($fichier != '.' && $fichier != '..' && $fichier != $CHOIX_THEME && is_dir($repthm . $fichier)) {
							$nb_fichier++;
							?>
							<form action="site_internet_choix_theme_maj.php" method="POST"  id="choix_theme_maj-<?php echo $fichier; ?>" name="choix_theme_maj-<?php echo $fichier; ?>" target="formFrame">
								<table class="caract_table"><tbody><tr><td class="tdimg">
												<?php
												echo '<img class="imgtd"';
												if (file_exists($repthm . $fichier . '/imgthm.jpg')) {
													echo 'class="imgfs" src="' . $repthm . $fichier . '/imgthm.jpg"></img></td>';
												} else {
													echo 'src="' . $DIR . $_SESSION['theme']->getDir_gtheme() . '/images/no_pict.gif"></img></td>';
												}
												if (file_exists($repthm . $fichier . '/desc.php')) {
													echo '<td class="tddesc"><div>';
													include $repthm . $fichier . '/desc.php';
													echo '</div></td></tr>';
												} else {
													echo '<td class="tddesc"><p>Nom : ' . $fichier . '</p><p>Pas de description disponible !</p></td></tr>';
												}
												echo '<tr><td colspan="2" class="tdbt">';
												echo '<input type="hidden" name="choix_theme_val" value="' . $fichier . '">';
												echo '<input type="image" name="valider" id="choix_theme_val-' . $fichier . '" src="' . $DIR . $_SESSION['theme']->getDir_gtheme() . 'images/bt-valider.gif" />';
												//echo '<button class="btimg" id="choix_theme_maj-' . $fichier . '" type="submit" name="choix_theme_maj" value="' . $fichier . '"><img src="' . $DIR . 'themes/' . $CHOIX_THEME . '/images/bt-valider.gif"></img></button>';
												echo '<input class="nop" type="image" name="modifier" id="choix_theme_modifier-' . $fichier . '" src="' . $DIR . $_SESSION['theme']->getDir_gtheme() . 'images/bt-modifier.gif" />';
												echo '<input class="nop" type="image" name="supp" id="choix_theme_supp-' . $fichier . '" src="' . $DIR . $_SESSION['theme']->getDir_gtheme() . 'images/bt-supprimer.gif" />';
												echo '</tbody></table></form>';
											} // On ferme le if (qui permet de ne pas afficher les fichiers ou dossiers inutiles.)
										} // On termine la boucle while
										$nb_fichier++;
										echo '<p class="li">Au total, vous disposez de <strong>' . $nb_fichier . '</strong> th&#232;me(s)</p>';
										closedir($dossier);
										echo '<br />';
									} else {
										echo '<br />';
										echo '<p class="li">Le dossier des th&#232;mes n\' a pas pu &ecirc;tre ouvert</p>';
									}
									?>
								</td></tr><tr> <td colspan="3"> </td></tr></table></form>
				</div>
				</div>

				<SCRIPT type="text/javascript">
$$('.nop').invoke('observe', 'click', respond);
function respond(event) {
alert('Avertissement : Fonctionalité non disponible');
}
					//on masque le chargement
					H_loading();
				</SCRIPT>