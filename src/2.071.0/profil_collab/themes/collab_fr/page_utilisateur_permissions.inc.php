<?php
// *************************************************************************************************************
// FONCTIONS DES UTILISATEURS
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);

function type_input($values){
	$result = "";
	
	$result = substr($values,0,strpos($values,'('));
	
	return $result;
}

function input_values($values){
	global $bdd;
	$result = array();

	$tmp_contenu = substr($values,strpos($values,'(')+1,strrpos($values,')')-strpos($values,'(')-1);
	$tmp_contenu = explode(';',$tmp_contenu);
	
	foreach($tmp_contenu as $value){
		switch (substr($value,0,1)){
			case '[' :
				$result[] = explode(',',substr($value,strpos($value,'[')+1,strrpos($value,']')-strpos($value,'[')-1));
				break;
			case '{' :
							$query = substr($value,strpos($value,'{')+1,strrpos($value,'}')-strpos($value,'{')-1);
							$resultat = $bdd->query ($query);
							while ($tmp = $resultat->fetch()) {
								$result[] = $tmp;
							}
				break;
		}
	}
	return $result;
}



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<div style="padding:10px;" >
<table class="minimizetable" width="320px">
	<tr>
		<td>
		</td>
	</tr>
	<tr>
		<td>
		<span >Utilisateur principal:
		<input id="set_user_master" name="set_user_master" <?php if ($utilisateur->getMaster()) {echo 'checked="checked" ';}?> value="0"  type="checkbox" />
		</span>
		</td>
	</tr>
</table>
<br />
<?php
if (isset($liste_permissions_collab)) {
	?>
	<span class="sous_titre1" >Droits de collaborateur</span><br/>
	<?php 
	$user_fonctions = $utilisateur->get_user_fonctions();
	if (is_array($user_fonctions)){
		?>
		<hr>
		<B>Fonctions de l'utilisateur : </B><BR>
		<?php 
		foreach($user_fonctions as $fonction){
			?>
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="15px" HEIGHT="15px"/>
			<I><?php echo $fonction->lib_fonction?></I> 
			<?php 
		}
	?>
	<BR>
	<A id="maj_droits_membre_<?php echo $user_fonctions[0]->id_fonction ?>_<?php echo $utilisateur->getRef_user() ?>" HREF="#" class="common_link">Réinitialiser les droits</A>
	<script type="text/javascript">
	Event.observe($("maj_droits_membre_<?php echo $user_fonctions[0]->id_fonction ?>_<?php echo $utilisateur->getRef_user() ?>"), "click", function(evt){
		Event.stop(evt);
		maj_droits_membre_fonction(<?php echo $user_fonctions[0]->id_fonction ?>,'<?php echo $utilisateur->getRef_contact() ?>','<?php echo $utilisateur->getRef_user() ?>');
		page.traitecontent("utilisateur_permissions", "utilisateur_permissions.php?ref_user=<?php echo $_REQUEST["ref_user"]?>", "true", "droits");
		});
	</script>
	<hr>
	<?php 
	}
	?>
	<br />
	<form action="utilisateur_droits_maj.php" method="post" id="utilisateur_droits_maj" name="utilisateur_droits_maj" target="formFrame" >
	<input type="hidden" name="ref_user" value="<?php echo $utilisateur->getRef_user();?>" /> 
	<?php
	foreach ($liste_permissions_collab as $perm_collab) {
		?>
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="<?php echo 15*$perm_collab->indentation;?>px" HEIGHT="15px"/>
		<?php 
		switch (type_input($perm_collab->values)) {
			/****************************************
			 * Conteneur
			 ****************************************/
			case 'CONT':
				echo "<B>".($perm_collab->lib_permission)."</B><br />";
				break;
			/****************************************
			 * Case a cocher
			 ****************************************/
			case 'CAC':
					?>
						<input type="checkbox" name="permission_<?php echo $perm_collab->id_permission;?>" id="permission_<?php echo $perm_collab->id_permission;?>" value="<?php echo $perm_collab->id_permission;?>"  <?php 
							foreach ($utilisateur_permissions as $perm_user) {
								if ($perm_user->id_permission == $perm_collab->id_permission) { echo 'checked="checked"'; break;} 
							}
							?> />
					<?php echo ($perm_collab->lib_permission);?><br />
		<script type="text/javascript">
		
		Event.observe($("permission_<?php echo $perm_collab->id_permission;?>"), "click", function(evt){
			if ($("permission_<?php echo $perm_collab->id_permission;?>").checked) {
				<?php 
						$permissions_dependantes = charger_permissions_dependantes_inactives ($perm_collab->id_permission, $utilisateur->getRef_user(),true);
						if (count($permissions_dependantes) > 0){
						?>
						$("titre_alert").innerHTML = "Avertissement dépendances :";
						$("texte_alert").innerHTML = "Vous allez aussi activer les permissions suivantes: <br /><br />";
						<?php
						foreach($permissions_dependantes as $permission_dependante){?>
						$("texte_alert").innerHTML += "<?php echo "<I>".$permission_dependante."</I>";?><br /> ";
						<?php }	?>
						$("bouton_alert").innerHTML = "<input type=\"submit\" id=\"bouton1\" name=\"bouton1\" value=\"Confirmer\" /><input type=\"submit\" id=\"bouton0\" name=\"bouton0\" value=\"Annuler\" />";
						show_pop_alerte();
						
						$("bouton0").onclick= function () {
							hide_pop_alerte ();
							$("permission_<?php echo $perm_collab->id_permission;?>").checked=true;
							}
						$("bouton1").onclick= function () {
							hide_pop_alerte ();
							set_maj_or_del_permission("<?php echo $utilisateur->getRef_user();?>", "<?php echo $perm_collab->id_permission;?>", "<?php echo $COLLAB_ID_PROFIL;?>", "1");
							$("choix_permission_<?php echo $perm_collab->id_permission;?>").hide();
							}
						<?php }else{?>
						set_maj_or_del_permission("<?php echo $utilisateur->getRef_user();?>", "<?php echo $perm_collab->id_permission;?>", "<?php echo $COLLAB_ID_PROFIL;?>", "1");
						<?php }?>
				} else {
				<?php 
						$permissions_dependantes = charger_permissions_dependantes_actives ($perm_collab->id_permission, $utilisateur->getRef_user(),true);
						if (count($permissions_dependantes) > 0){
						?>
						$("titre_alert").innerHTML = "Avertissement dépendances :";
						$("texte_alert").innerHTML = "Vous allez aussi désactiver les permissions suivantes : <br /><br />";
						<?php
						foreach($permissions_dependantes as $permission_dependante){?>
							$("texte_alert").innerHTML += "<?php echo "<I>".$permission_dependante."</I>";?> <br />";
						<?php }	?>
						$("bouton_alert").innerHTML = "<input type=\"submit\" id=\"bouton1\" name=\"bouton1\" value=\"Confirmer\" /><input type=\"submit\" id=\"bouton0\" name=\"bouton0\" value=\"Annuler\" />";
						show_pop_alerte();
						
						$("bouton0").onclick= function () {
							hide_pop_alerte ();
							$("permission_<?php echo $perm_collab->id_permission;?>").checked=true;
							}
						$("bouton1").onclick= function () {
							hide_pop_alerte ();
							set_maj_or_del_permission("<?php echo $utilisateur->getRef_user();?>", "<?php echo $perm_collab->id_permission;?>", "<?php echo $COLLAB_ID_PROFIL;?>", "0");
							$("choix_permission_<?php echo $perm_collab->id_permission;?>").hide();
							}
						<?php }else{?>
							set_maj_or_del_permission("<?php echo $utilisateur->getRef_user();?>", "<?php echo $perm_collab->id_permission;?>", "<?php echo $COLLAB_ID_PROFIL;?>", "0");
						<?php }?>
			}
		});
		</script>
		<?php
					break;

			/****************************************
			 * Select choix multiple
			 ****************************************/
			case 'SELECT_MULTIPLE':
					$permissions_values = array();
					$tmp = input_values($perm_collab->values);
					?>
					<input type="checkbox" name="permission_<?php echo $perm_collab->id_permission;?>" id="permission_<?php echo $perm_collab->id_permission;?>" value="<?php echo $perm_collab->id_permission;?>"  
					<?php 
							$tmp_checked = False;	
							foreach ($utilisateur_permissions as $perm_user) {
								if ($perm_user->id_permission == $perm_collab->id_permission) { echo 'checked="checked"'; $tmp_checked = True; $permissions_values = explode(",",$perm_user->value); break;} 
							}
					?>>
					<?php 
					echo ($perm_collab->lib_permission);
					?>
					(<span id="num_choix_<?php echo $perm_collab->id_permission;?>"><?php echo count($permissions_values)?></span>/<?php echo count($tmp) ?>)
					<span id="affiche_choix_<?php echo $perm_collab->id_permission;?>_box"><a href="#" id="affiche_choix_<?php echo $perm_collab->id_permission;?>_link" style="text-decoration: none; font-size: larger ;"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/extend.gif" width="15px"/></a></span>
					<br>
					<div id="choix_permission_<?php echo $perm_collab->id_permission;?>" style="display:none;">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="<?php echo 15*$perm_collab->indentation;?>px"/>
							<SELECT name="select_permission_<?php echo $perm_collab->id_permission;?>" id="select_permission_<?php echo $perm_collab->id_permission;?>" SIZE="5" WIDTH="300" STYLE="width: 300px" MULTIPLE>
							<?php 
							foreach ($tmp as $value){?>
								<OPTION VALUE="<?php echo $value[0]?>" 
								<?php 
								if (in_array($value[0], $permissions_values)){echo " SELECTED";}
								?>><?php echo $value[1]?></OPTION>
								<?php 
							}
							?>
						</select> 
						<a id="select_permission_<?php echo $perm_collab->id_permission;?>_valide" href="#">Valider</a>
					</div>
					<script type="text/javascript">
					Event.observe($("affiche_choix_<?php echo $perm_collab->id_permission;?>_link"), "click", function(evt){
						Event.stop(evt);
						if(!$("choix_permission_<?php echo $perm_collab->id_permission;?>").visible()){
							$("choix_permission_<?php echo $perm_collab->id_permission;?>").show();
							$("affiche_choix_<?php echo $perm_collab->id_permission;?>_link").innerHTML="<img src='<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/collapse.gif' width='15px'/>";
						}else{
							$("choix_permission_<?php echo $perm_collab->id_permission;?>").hide();
							$("affiche_choix_<?php echo $perm_collab->id_permission;?>_link").innerHTML="<img src='<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/extend.gif' width='15px'/>";
						}
					});
					Event.observe($("select_permission_<?php echo $perm_collab->id_permission;?>"), "change", function(evt){
						Event.stop(evt);
						$("num_choix_<?php echo $perm_collab->id_permission;?>").innerHTML = $F("select_permission_<?php echo $perm_collab->id_permission;?>").length;
					});
					Event.observe($("permission_<?php echo $perm_collab->id_permission;?>"), "click", function(evt){
						if ($("permission_<?php echo $perm_collab->id_permission;?>").checked) {
							$("choix_permission_<?php echo $perm_collab->id_permission;?>").show();
						} else {
							<?php 
							$permissions_dependantes = charger_permissions_dependantes_actives ($perm_collab->id_permission,$utilisateur->getRef_user(),true);
							if (count($permissions_dependantes) > 0){
							?>
							$("titre_alert").innerHTML = "Avertissement dépendances :";
							$("texte_alert").innerHTML = "Vous allez aussi désactiver les permissions suivantes : <br /><br />";
							<?php
							foreach($permissions_dependantes as $permission_dependante){?>
								$("texte_alert").innerHTML += "<?php echo "<I>".$permission_dependante."</I>";?> <br />";
							<?php }	?>
							$("bouton_alert").innerHTML = "<input type=\"submit\" id=\"bouton1\" name=\"bouton1\" value=\"Confirmer\" /><input type=\"submit\" id=\"bouton0\" name=\"bouton0\" value=\"Annuler\" />";
							show_pop_alerte();
							
							$("bouton0").onclick= function () {
								hide_pop_alerte ();
								$("permission_<?php echo $perm_collab->id_permission;?>").checked=true;
								}
							$("bouton1").onclick= function () {
								hide_pop_alerte ();
								set_maj_or_del_permission("<?php echo $utilisateur->getRef_user();?>", "<?php echo $perm_collab->id_permission;?>", "<?php echo $COLLAB_ID_PROFIL;?>", "0");
								$("choix_permission_<?php echo $perm_collab->id_permission;?>").hide();
								}
							<?php }else{?>
								set_maj_or_del_permission("<?php echo $utilisateur->getRef_user();?>", "<?php echo $perm_collab->id_permission;?>", "<?php echo $COLLAB_ID_PROFIL;?>", "0");
							<?php }?>
						}
					});
					
					Event.observe($("select_permission_<?php echo $perm_collab->id_permission;?>_valide"), "click", function(evt){
					Event.stop(evt);
					<?php 
					$permissions_dependantes_cac = charger_permissions_dependantes_inactives ($perm_collab->id_permission, $utilisateur->getRef_user(),true);
					$permissions_dependantes = charger_permissions_dependantes_meme_type($perm_collab->id_permission,true);
					$permissions_parentes = charger_permissions_parentes_meme_type($perm_collab->id_permission,true);
					$alert_perms = array_unique(array_merge($permissions_dependantes_cac,$permissions_parentes,$permissions_dependantes));
						if (count($alert_perms) > 0){
							?>
							$("titre_alert").innerHTML = "Avertissement dépendances :";
							$("texte_alert").innerHTML = "Vous allez aussi modifier les permissions suivantes : <br /><br />";
							<?php
								foreach($alert_perms as $alert_perm){?>
							$("texte_alert").innerHTML += "<?php echo "<I>".$alert_perm."</I>";?> <br />";
							<?php }	?>
							$("bouton_alert").innerHTML = "<input type=\"submit\" id=\"bouton1\" name=\"bouton1\" value=\"Confirmer\" /><input type=\"submit\" id=\"bouton0\" name=\"bouton0\" value=\"Annuler\" />";
							show_pop_alerte();
							
							$("bouton0").onclick= function () {
								hide_pop_alerte ();
								$("permission_<?php echo $perm_collab->id_permission;?>").checked=true;
								}
							$("bouton1").onclick= function () {
								hide_pop_alerte ();
								maj_permissions_multiple("<?php echo $utilisateur->getRef_user();?>", "<?php echo $perm_collab->id_permission;?>",$F("select_permission_<?php echo $perm_collab->id_permission;?>"), "<?php echo $COLLAB_ID_PROFIL;?>");
								$("choix_permission_<?php echo $perm_collab->id_permission;?>").hide();
								}
							<?php }else{?>
							maj_permissions_multiple("<?php echo $utilisateur->getRef_user();?>", "<?php echo $perm_collab->id_permission;?>",$F("select_permission_<?php echo $perm_collab->id_permission;?>"), "<?php echo $COLLAB_ID_PROFIL;?>");
							$("choix_permission_<?php echo $perm_collab->id_permission;?>").hide();
							<?php }?>
					});
					</script>
					<?php 
					break;
		}
	}
	?>
	<br />
	<br />
	</form>
	<?php
}
?>
</div>
<SCRIPT type="text/javascript">

		Event.observe($("set_user_master"), "click", function(evt){
			if ($("set_user_master").checked) {
				set_master("<?php echo $utilisateur->getRef_user();?>");
				$("v_utili_master").show();
			} else {
			
			<?php if (count($users) > 1) { ?>
				$("titre_alert").innerHTML = 'Sélectionnez le nouvel utilisateur principal:';
				$("texte_alert").innerHTML = '<?php 
				foreach ($users as $user) {
					if ($user->ref_user == $utilisateur->getRef_user()) {continue;}
					echo "<span style=\"cursor:pointer\" onclick=\"set_master(\'".$user->ref_user."\'); hide_pop_alerte (); $(\'v_utili_master\').hide();\">".substr($user->pseudo, 0, 25)." / ".$user->email."</span><br />"; 
				}
				?>';
				$("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="Annuler" />';
			
				show_pop_alerte ();
				
				$("bouton0").onclick= function () {
				hide_pop_alerte ();
				$("set_user_master").checked = "checked";
				$("v_utili_master").show();
				}
			<?php } else {?>
				$("set_user_master").checked = "checked";
				$("v_utili_master").show();
			<?php } ?>
			}
		});
//on masque le chargement
H_loading();
</SCRIPT>