<?php 
// *************************************************************************************************************
// GESTION DES FONCTIONS DES UTILISATEURS
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
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

//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
tableau_smenu[0] = Array("smenu_utilisateurs", "smenu_utilisateurs.php" ,"true" ,"sub_content", "Utilisateurs");
tableau_smenu[1] = Array('annuaire_gestion_users_fonctions','annuaire_gestion_users_fonctions.php' ,"true" ,"sub_content", "Fonctions des collaborateurs");
update_menu_arbo();
array_visu_edit_grp	=	new Array();
array_visu_edit_grp[0] 	=	new Array('user_fonction_table');
	
<?php
	$i=1;
	foreach ($liste_fonctions as $fonction) {
	?>
	array_visu_edit_grp[<?php echo $i;?>] 	=	new Array("user_fonction_table_<?php echo $fonction->id_fonction; ?>");
	<?php
	$i++;
}
?>

</script>
<div class="emarge">

<p class="titre">Fonctions des collaborateurs</p>
<div style="height:50px">



<table class="minimizetable"><tr><td style="width:300px">
<div id="list_user_fonction">
<div class="menu">	<table cellpadding="0" cellspacing="0"  id="racine" style="width:96%">
	<tr id="tr_racine" class="list_art_categs"><td width="2px"></td>
	<td>
		<a href="#" class="" id="racine" title="Inserer une nouvelle fonction" style="display:block; width:100%">Inserer une nouvelle fonction</a>
		</td><td width="15px">
		<a href="#" class="" id="ins_racine" title="Inserer une nouvelle fonction"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/insert.gif" />
		</a> 
			</td></tr></table></div>
<div id="liste_de_categorie" class="contactview_corps" style="OVERFLOW-Y: auto; OVERFLOW-X: auto; ">

			<div id="liste_de_categorie_selectable" >
<?php
reset($liste_fonctions);
	while ($liste_fonction = current($liste_fonctions) ){
	
next($liste_fonctions);
	?>
	
	<table cellpadding="0" cellspacing="0"  id="<?php echo ($liste_fonction->id_fonction)?>" style="width:96%">
	<tr id="tr_<?php echo ($liste_fonction->id_fonction)?>" class="list_art_categs"><td width="5px">
		<table cellpadding="0" cellspacing="0" width="5px"><tr><td>
		<?php 
		for ($i=0; $i<=$liste_fonction->indentation; $i++) {
			if ($i==$liste_fonction->indentation) {
			 
				if (key($liste_fonctions)!="") {
					if ($liste_fonction->indentation < current($liste_fonctions)->indentation) {
						
					?><a href="#" id="link_div_art_categ_<?php echo $liste_fonction->id_fonction?>">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/collapse.gif" width="14px" id="extend_<?php echo $liste_fonction->id_fonction?>"/>
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/extend.gif" width="14px" id="collapse_<?php echo $liste_fonction->id_fonction?>" style="display:none"/></a>
					<script type="text/javascript">
					Event.observe("link_div_art_categ_<?php echo $liste_fonction->id_fonction?>", "click",  function(evt){Event.stop(evt); Element.toggle('div_<?php echo $liste_fonction->id_fonction?>') ; Element.toggle('extend_<?php echo $liste_fonction->id_fonction?>'); Element.toggle('collapse_<?php echo $liste_fonction->id_fonction?>');}, false);
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
		</tr></table>
		</td><td>
		<a href="#" id="mod_<?php echo ($liste_fonction->id_fonction)?>" style="display:block; width:100%">
				
			<?php echo htmlentities($liste_fonction->lib_fonction)?>
		</a>
		</td><td width="15px">
			<a href="#" class="insertion" id="ins_<?php echo ($liste_fonction->id_fonction)?>" title="Inserer une fonction dans <?php echo htmlentities($liste_fonction->lib_fonction)?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/insert.gif" />
				</a>
			</td></tr></table>
<?php 
if (key($liste_fonctions)!="") {
	if ($liste_fonction->indentation < current($liste_fonctions)->indentation) {
		echo '<div id="div_'.$liste_fonction->id_fonction.'" style="">';
	}
	
	
	if ($liste_fonction->indentation > current($liste_fonctions)->indentation) {
					for ($a=$liste_fonction->indentation; $a> current($liste_fonctions)->indentation ; $a--) {
					echo '</div>';
				}
	}
}

}
?>
		<div>
		<br>
		<a href="#" id="init_fonctions"  class="common_link">Réinitialisation des Fonctions</a>
		<script type="text/javascript">
		Event.observe('init_fonctions', 'click',  function(evt){
			Event.stop(evt);
			$("titre_alert").innerHTML = "Réinitialisation des Fonctions";
			$("texte_alert").innerHTML = "Confirmer la Réinitialisation des Fonctions<br />Toutes les modifications apportées a celles-ci seront perdues";
			$("bouton_alert").innerHTML = '<input type="submit" name="bouton1" id="bouton1" value="Confirmer" /><input type="submit" id="bouton0" name="bouton0" value="Annuler" />';
		
			$("alert_pop_up_tab").style.display = "block";
			$("framealert").style.display = "block";
			$("alert_pop_up").style.display = "block";
			
			$("bouton0").onclick= function () {
			$("framealert").style.display = "none";
			$("alert_pop_up").style.display = "none";
			$("alert_pop_up_tab").style.display = "none";
			}
			$("bouton1").onclick= function () {
			$("framealert").style.display = "none";
			$("alert_pop_up").style.display = "none";
			$("alert_pop_up_tab").style.display = "none";
			initialize_fonctions();
			}
			
			}, false);
		</script>
		</div>
	</div>
</div>
<script type="text/javascript">

	Event.observe('tr_racine', 'mouseover',  function(){changeclassname ('tr_racine', 'list_art_categs_hover');changeclassname ('ins_racine', 'insertion_hover');}, false);
	Event.observe('tr_racine', 'mouseout',  function(){changeclassname ('tr_racine', 'list_art_categs');changeclassname ('ins_racine', 'insertion');}, false);
	
	
		Event.observe('ins_racine', 'click',  function(evt){Event.stop(evt); 
			view_one_content_of_x("user_fonction_table", array_visu_edit_grp);
			preselect ("", "id_fonction_parent");
			}, false);
	
	Event.observe('racine', 'click',  function(evt){Event.stop(evt); 
view_one_content_of_x("user_fonction_table", array_visu_edit_grp);}, false);

	
<?php
	foreach ($liste_fonctions as $liste_fonction) {
?>
	Event.observe('tr_<?php echo ($liste_fonction->id_fonction)?>', 'mouseover',  function(){changeclassname ('tr_<?php echo ($liste_fonction->id_fonction)?>', 'list_art_categs_hover');changeclassname ('ins_<?php echo ($liste_fonction->id_fonction)?>', 'insertion_hover');}, false);
	
	Event.observe('tr_<?php echo ($liste_fonction->id_fonction)?>', 'mouseout',  function(){changeclassname ('tr_<?php echo ($liste_fonction->id_fonction)?>', 'list_art_categs');changeclassname ('ins_<?php echo ($liste_fonction->id_fonction)?>', 'insertion');}, false);
	
	Event.observe('ins_<?php echo ($liste_fonction->id_fonction)?>', 'click',  function(evt){Event.stop(evt);
		view_one_content_of_x("user_fonction_table", array_visu_edit_grp);
		preselect ("<?php echo $liste_fonction->id_fonction; ?>", "id_fonction_parent");}, false);
	
	Event.observe('mod_<?php echo ($liste_fonction->id_fonction)?>', 'click',  function(evt){Event.stop(evt); 
view_one_content_of_x("user_fonction_table_<?php echo $liste_fonction->id_fonction; ?>", array_visu_edit_grp);}, false);


<?php 
	}
?>

function setheight_catalogue_categorie_inc_list_cat(){
set_tomax_height("liste_de_categorie" , -55);
set_tomax_height("liste_de_categorie_selectable" , -55);

}

Event.observe(window, "resize", setheight_catalogue_categorie_inc_list_cat, false);

setheight_catalogue_categorie_inc_list_cat();

//on masque le chargement
H_loading();
</script>
</div>
</td><td>
<div id="content_user_fonction" class="contactview_corps">

<table class="minimizetable">
<tr>
<td>
<div id="cat_client" style="padding-left:10px; padding-right:10px">

	
	
	<table>
		<tr>
			<td style="width:95%">
				<table>
					<tr class="smallheight">
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td ><span class="labelled">Libell&eacute;:</span>
						</td>
						<td ><span class="labelled">Description:</span>
						</td>
						<td ><span class="labelled">Fonction parent:</span>
						</td>
						<td>&nbsp;
						</td>
					</tr>
				</table>
			</td>
			<td>
			</td>
		</tr>
	</table>
	<div class="caract_table" id="user_fonction_table" style="display:<?php if (!isset($_REQUEST["id_fonction"])){echo "block";}else{echo "none";} ?>">

	<table>
		<tr>
			<td style="width:95%">
				<form action="annuaire_gestion_users_fonctions_add.php" method="post" id="annuaire_gestion_users_fonctions_add" name="annuaire_gestion_users_fonctions_add" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input id="id_profil" name="id_profil" type="hidden" value="<?php echo $COLLAB_ID_PROFIL;?>"/>
						<input id="lib_fonction" name="lib_fonction" type="text" value=""  class="classinput_lsize"/>
						</td>
						<td>
						<textarea id="desc_fonction" name="desc_fonction" class="classinput_xsize"></textarea>
						</td>
						<td>
							<select id="id_fonction_parent" name="id_fonction_parent" class="classinput_lsize">
								<option value="">Fonction principale</option>
							<?php 
							foreach ($liste_fonctions as $liste_fonction_parent) {
								?>
								<option value="<?php echo $liste_fonction_parent->id_fonction; ?>"><?php echo htmlentities($liste_fonction_parent->lib_fonction); ?>
								</option>
								<?php 
							}
							?>
							</select>
						</td>
						<td>
							<p style="text-align:center">
							<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" />
							</p>
						</td>
					</tr>
					</table>
				</form>
			</td>
			<td>
			</td>
		</tr>
	</table>
	</div>
	<?php 
	if ($liste_fonctions) {
	?>

	<?php 
	}
	foreach ($liste_fonctions as $liste_fonction) {
	?>
	<div class="caract_table" id="user_fonction_table_<?php echo $liste_fonction->id_fonction; ?>" style="display:<?php if (isset($_REQUEST["id_fonction"]) && $_REQUEST["id_fonction"] == $liste_fonction->id_fonction){echo "block";}else{echo "none";} ?>">

		<table>
		<tr>
			<td style="width:95%">
				<form action="annuaire_gestion_users_fonctions_mod.php" method="post" id="annuaire_gestion_users_fonctions_mod_<?php echo $liste_fonction->id_fonction; ?>" name="annuaire_gestion_users_fonctions_mod_<?php echo $liste_fonction->id_fonction; ?>" target="formFrame" >
				<table>
					<tr class="smallheight">
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>	
					<tr>
						<td>
						<input id="id_profil_<?php echo $liste_fonction->id_fonction; ?>" name="id_profil_<?php echo $liste_fonction->id_fonction; ?>" type="hidden" value="<?php echo $liste_fonction->id_profil;?>"/>
						<input id="lib_fonction_<?php echo $liste_fonction->id_fonction; ?>" name="lib_fonction_<?php echo $liste_fonction->id_fonction; ?>" type="text" value="<?php echo htmlentities($liste_fonction->lib_fonction); ?>"  class="classinput_lsize"/>
			<input name="id_fonction" id="id_fonction" type="hidden" value="<?php echo $liste_fonction->id_fonction; ?>" />
						</td>
						<td>
						<textarea id="desc_fonction_<?php echo $liste_fonction->id_fonction; ?>" name="desc_fonction_<?php echo $liste_fonction->id_fonction; ?>" class="classinput_xsize"><?php echo htmlentities($liste_fonction->desc_fonction); ?></textarea>
						</td>
						<td>
							<select id="id_fonction_parent_<?php echo $liste_fonction->id_fonction; ?>" name="id_fonction_parent_<?php echo $liste_fonction->id_fonction; ?>" class="classinput_lsize">
								<option value="">Fonction principale</option>
							<?php 
							foreach ($liste_fonctions as $liste_fonction_parent) {
								if ($liste_fonction->id_fonction != $liste_fonction_parent->id_fonction) {
								?>
								<option value="<?php echo $liste_fonction_parent->id_fonction; ?>" <?php if ($liste_fonction_parent->id_fonction==$liste_fonction->id_fonction_parent){echo 'selected="selected"';}?>><?php echo htmlentities($liste_fonction_parent->lib_fonction); ?>
								</option>
								<?php 
								}
							}
							?>
							</select>
						</td>
						<td>
							<input type="hidden" name="maj_user_perms_<?php echo $liste_fonction->id_fonction;?>" id="maj_user_perms_<?php echo $liste_fonction->id_fonction;?>" value="0" /> 
							<p style="text-align:center">
								<input name="modifier_<?php echo $liste_fonction->id_fonction;?>" id="modifier_<?php echo $liste_fonction->id_fonction;?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
							</p>
							<script type="text/javascript">
							
								Event.observe("modifier_<?php echo $liste_fonction->id_fonction;?>", "click",  function(evt){
									Event.stop(evt);
								
										$("maj_user_perms_<?php echo $liste_fonction->id_fonction;?>").value = "0";
										$("annuaire_gestion_users_fonctions_mod_<?php echo $liste_fonction->id_fonction; ?>").submit();
								}, false);
							</script>
						</td>
					</tr>
					<tr>
						<td colspan="4">
						<hr>
						Liste des droits d'accès<br />
<br />
						<?php 

						$y = 0;
						foreach ($liste_permissions as $perms) {
		?>
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="<?php echo 15*$perms->indentation;?>px" HEIGHT="15px"/>
		<?php 
		switch (type_input($perms->values)) {
			/****************************************
			 * Conteneur
			 ****************************************/
			case 'CONT':
				echo "<B>".($perms->lib_permission)."</B><br />";
				break;
			/****************************************
			 * Case a cocher
			 ****************************************/
			case 'CAC':
					?>
						<input type="checkbox" name="permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>" id="permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>" value="<?php echo $perms->id_permission;?>"  <?php 
							foreach ($liste_fonction->permissions as $perm_user) {
								if ($perm_user->id_permission == $perms->id_permission) { echo 'checked="checked"'; break;} 
							}
							?> />
					<?php echo ($perms->lib_permission);?><br />
		<script type="text/javascript">
		
		Event.observe($("permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>"), "click", function(evt){
			if ($("permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").checked) {
				<?php 
						$permissions_dependantes = charger_permissions_dependantes_inactives_fonctions ($perms->id_permission, $liste_fonction->id_fonction,true);
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
							$("permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").checked=true;
							}
						$("bouton1").onclick= function () {
							hide_pop_alerte ();
							set_maj_or_del_permission_fonction("<?php echo $liste_fonction->id_fonction;?>", "<?php echo $perms->id_permission;?>", "<?php echo $COLLAB_ID_PROFIL;?>", "1");
							$("choix_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").hide();
							}
						<?php }else{?>
						set_maj_or_del_permission_fonction("<?php echo $liste_fonction->id_fonction;?>", "<?php echo $perms->id_permission;?>", "<?php echo $COLLAB_ID_PROFIL;?>", "1");
						<?php }?>
				} else {
				<?php 
						$permissions_dependantes = charger_permissions_dependantes_actives_fonctions ($perms->id_permission, $liste_fonction->id_fonction,true);
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
							$("permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").checked=true;
							}
						$("bouton1").onclick= function () {
							hide_pop_alerte ();
							set_maj_or_del_permission_fonction("<?php echo $liste_fonction->id_fonction;?>", "<?php echo $perms->id_permission;?>", "<?php echo $COLLAB_ID_PROFIL;?>", "0");
							$("choix_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").hide();
							}
						<?php }else{?>
							set_maj_or_del_permission_fonction("<?php echo $liste_fonction->id_fonction;?>", "<?php echo $perms->id_permission;?>", "<?php echo $COLLAB_ID_PROFIL;?>", "0");
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
					$tmp = input_values($perms->values);
					?>
					<input type="checkbox" name="permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>" id="permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>" value="<?php echo $perms->id_permission;?>"  
					<?php 
							$tmp_checked = False;	
							foreach ($liste_fonction->permissions as $perm_user) {
								if ($perm_user->id_permission == $perms->id_permission) { echo 'checked="checked"'; $tmp_checked = True; $permissions_values = explode(",",$perm_user->value); break;} 
							}
					?>>
					<?php 
					echo ($perms->lib_permission);
					?>
					(<span id="num_choix_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>"><?php echo count($permissions_values)?></span>/<?php echo count($tmp) ?>)
					<span id="affiche_choix_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>_box"><a href="#" id="affiche_choix_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>_link" style="text-decoration: none; font-size: larger ;" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/extend.gif" width="15px"/></a></span>
					<br>
					<div id="choix_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>" style="display:none;">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="<?php echo 15*$perms->indentation;?>px"/>
							<SELECT name="select_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>" id="select_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>" SIZE="5" WIDTH="300" STYLE="width: 300px" MULTIPLE>
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
						<a id="select_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>_valide" href="#">Valider</a>
					</div>
					<script type="text/javascript">
					Event.observe($("affiche_choix_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>_link"), "click", function(evt){
						Event.stop(evt);
						if(!$("choix_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").visible()){
							$("choix_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").show();
							$("affiche_choix_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>_link").innerHTML="<img src='<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/collapse.gif' width='15px'/>";
						}else{
							$("choix_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").hide();
							$("affiche_choix_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>_link").innerHTML="<img src='<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/extend.gif' width='15px'/>";
						}
					});
					Event.observe($("select_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>"), "change", function(evt){
						Event.stop(evt);
						$("num_choix_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").innerHTML = $F("select_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").length;
					});
					Event.observe($("permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>"), "click", function(evt){
						if ($("permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").checked) {
							$("choix_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").show();
						} else {
							<?php 
							$permissions_dependantes = charger_permissions_dependantes_actives_fonctions ($perms->id_permission,$liste_fonction->id_fonction,true);
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
								$("permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").checked=true;
								}
							$("bouton1").onclick= function () {
								hide_pop_alerte ();
								set_maj_or_del_permission_fonction("<?php echo $liste_fonction->id_fonction;?>", "<?php echo $perms->id_permission;?>", "<?php echo $COLLAB_ID_PROFIL;?>", "0");
								$("choix_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").hide();
								}
							<?php }else{?>
								set_maj_or_del_permission_fonction("<?php echo $liste_fonction->id_fonction;?>", "<?php echo $perms->id_permission;?>", "<?php echo $COLLAB_ID_PROFIL;?>", "0");
							<?php }?>
						}
					});
					
					Event.observe($("select_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>_valide"), "click", function(evt){
					Event.stop(evt);
					<?php 
					$permissions_dependantes_cac = charger_permissions_dependantes_inactives_fonctions ($perms->id_permission, $liste_fonction->id_fonction,true);
					$permissions_dependantes = charger_permissions_dependantes_meme_type($perms->id_permission,true);
					$permissions_parentes = charger_permissions_parentes_meme_type($perms->id_permission,true);
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
								$("permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").checked=true;
								}
							$("bouton1").onclick= function () {
								hide_pop_alerte ();
								maj_permissions_multiple_fonction("<?php echo $liste_fonction->id_fonction;?>", "<?php echo $perms->id_permission;?>",$F("select_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>"), "<?php echo $COLLAB_ID_PROFIL;?>");
								$("choix_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").hide();
								}
							<?php }else{?>
							maj_permissions_multiple_fonction("<?php echo $liste_fonction->id_fonction;?>", "<?php echo $perms->id_permission;?>",$F("select_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>"), "<?php echo $COLLAB_ID_PROFIL;?>");
							$("choix_permission_<?php echo $liste_fonction->id_fonction;?>_<?php echo $perms->id_permission;?>").hide();
							<?php }?>
					});
					</script>
					<?php 
					break;
		}
	}
						?>
						</td>
					</tr>
					<tr>
					<td colspan="4"><hr></td>
					</tr>
					<tr>
						<?php 
						$myfonction = new fonctions($liste_fonction->id_fonction);
						$mes_membres = $myfonction->get_liste_membres();
						if (is_array($mes_membres) && count($mes_membres)>0 ){
							?>
							<td ><B>Utilisateurs concernés:</B></td>
							<td colspan="3"><A id="maj_droits_all_membres_<?php echo $liste_fonction->id_fonction ?>" HREF="#" class="common_link">Réinitialiser tous les droits</A>
							<script type="text/javascript">
							Event.observe($("maj_droits_all_membres_<?php echo $liste_fonction->id_fonction ?>"), "click", function(evt){
								Event.stop(evt);
								maj_droits_all_membres_fonction(<?php echo $liste_fonction->id_fonction ?>);
							});
							</script>
							</td></tr>
							<?php 
							foreach($mes_membres as $membre){
									?>
									<tr><td colspan="3"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="15px" HEIGHT="15px"/>
									<a href="#utilisateur_details.php?ref_user=<?php echo $membre["datas"]->ref_user; ?>"><?php echo $membre["string"]; ?></a></td><td>
									<A id="maj_droits_membre_<?php echo $liste_fonction->id_fonction ?>_<?php echo $membre["datas"]->ref_user ?>" HREF="#" class="common_link">Réinitialiser les droits</A>
									<script type="text/javascript">
									Event.observe($("maj_droits_membre_<?php echo $liste_fonction->id_fonction ?>_<?php echo $membre["datas"]->ref_user ?>"), "click", function(evt){
										Event.stop(evt);
										maj_droits_membre_fonction(<?php echo $liste_fonction->id_fonction ?>,'<?php echo $membre["datas"]->ref_contact ?>','<?php echo $membre["datas"]->ref_user ?>');
									});
									</script>
									</td></tr>
									<?php 
								}
						}
						?>
				</table>
				</form>
			</td>
			<td>
			<form method="post" action="annuaire_gestion_users_fonctions_sup.php" id="annuaire_gestion_users_fonctions_sup_<?php echo $liste_fonction->id_fonction; ?>" name="annuaire_gestion_users_fonctions_sup_<?php echo $liste_fonction->id_fonction; ?>" target="formFrame">
			<input name="id_fonction" id="id_fonction" type="hidden" value="<?php echo $liste_fonction->id_fonction; ?>" />
		</form>
		<a href="#" id="link_annuaire_gestion_users_fonctions_sup_<?php echo $liste_fonction->id_fonction; ?>"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a>
		<script type="text/javascript">
		Event.observe("link_annuaire_gestion_users_fonctions_sup_<?php echo $liste_fonction->id_fonction; ?>", "click",  function(evt){Event.stop(evt); alerte.confirm_supprimer('user_fonction_supprime', 'annuaire_gestion_users_fonctions_sup_<?php echo $liste_fonction->id_fonction; ?>');}, false);
		</script>
			</td>
		</tr>
	</table>
	</div>
	<?php
	}
	?>
</div>
</td>
</tr>
</table>

<SCRIPT type="text/javascript">
new Form.EventObserver('annuaire_gestion_users_fonctions_add', function(element, value){formChanged();});

<?php 
foreach ($liste_fonctions as $liste_fonction) {
	?>
	new Form.EventObserver('annuaire_gestion_users_fonctions_mod_<?php echo $liste_fonction->id_fonction; ?>', function(){formChanged();});
	<?php
}
?>



function setheight_user_fonction(){
set_tomax_height("list_user_fonction" , -55);
//set_tomax_height("content_user_fonction" , -55);
}
Event.observe(window, "resize", setheight_user_fonction, false);
setheight_user_fonction();
//on masque le chargement
H_loading();
</SCRIPT>


</div>
</td></tr></table>
</div>
</div>