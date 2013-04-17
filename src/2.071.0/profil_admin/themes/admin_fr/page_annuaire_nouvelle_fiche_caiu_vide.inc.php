<div id="coordcontent">
<table class="minimizetable">
  <tr>
		<td colspan="2">
		<table>
			<tr>
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr><tr>
				<td class="size_strict">
					<span class="labelled">Titre:</span>
				</td><td>
		<div style="text-align:right; float:right"> <a href="#" id="link_sup_coordcontent_li_%//%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a></div>
					<input id="coordonnee_lib%//%" name="coordonnee_lib%//%" type="text" class="classinput_lsize" value="" />
				</td>
			</tr>
<!-- Ajout du select  type -->
			<?php if(!empty($GEST_TYPE_COORD)){
                            ?><tr>
				<td>
					<span class="labelled">Type :</span>
				</td><td>
					<select id="type_coord%//%" name="type_coord%//%" class="classinput_xsize" >
					<?php 
					global $bdd;
					$query = "SELECT id_coord_type, coord_type, defaut  FROM coordonnees_types";
					$retour = $bdd->query($query);
					while($res= $retour->fetchObject()){
						if($res->defaut ==1){
							echo "<option value='".$res->id_coord_type."' selected='selected'>".$res->coord_type."</option>";
						}else{
							echo "<option value='".$res->id_coord_type."' >".$res->coord_type."</option>";
						}
					}					
					?>
					</select>
				</td>
			</tr><?php } ?> <tr>
				<td>
					<span class="labelled">T&eacute;l&eacute;phone 1:</span>
				</td><td>
					<input id="coordonnee_tel1%//%" name="coordonnee_tel1%//%" class="classinput_xsize"/>
				</td>
			</tr><tr>
				<td>
					<span class="labelled">T&eacute;l&eacute;phone 2:</span>
				</td><td>
					<input id="coordonnee_tel2%//%" name="coordonnee_tel2%//%" class="classinput_xsize"/>
				</td>
			</tr><tr>
				<td>
					<span class="labelled">Email:</span>
				</td><td>
					<input id="coordonnee_email%//%" name="coordonnee_email%//%" class="classinput_lsize"/>
					<span class="infobulle" id="email_user_creation_info%//%">
					<span>
					<p class="infotext">Proposez &agrave; ce contact de devenir utilisateur</p>
					</span>
					</span>
					<input id="email_user_creation%//%" name="email_user_creation%//%" type="checkbox" value="1" />
	
				</td>
			</tr><tr>
				<td>
					<span class="labelled">Fax:</span>
				</td><td>
				
					<input id="coordonnee_fax%//%" name="coordonnee_fax%//%" class="classinput_xsize"/>
				</td>
			</tr><tr>
				<td>
					<span class="labelled">Note:</span>
				</td><td>
					<textarea id="coordonnee_note%//%" name="coordonnee_note%//%" rows="2"  class="classinput_xsize"/></textarea>
				</td>
			</tr>
		</table>
		<br />
		</td>
	</tr>
</table>
</div>

<div id="adressecontent">
<table class="minimizetable">
  <tr>
		<td colspan="2">
		<table>
			<tr class="smallheight">
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
				<td class="size_strict">
				<span class="labelled">Titre:</span>
				</td><td>
		<div style="text-align:right; float:right"> <a href="#" id="link_sup_adressecontent_li_%//%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a></div>
				<input id="adresse_lib%//%" name="adresse_lib%//%" type="text" class="classinput_lsize" value="" />
				</td>
			</tr><?php if(!empty($GEST_TYPE_COORD)){
                            ?><tr>
				<td>
					<span class="labelled">Type :</span>
				</td><td>
					<select id="type_adresse%//%" name="type_adresse%//%" class="classinput_xsize" >
					<?php 
					global $bdd;
					$query = "SELECT id_adresse_type, adresse_type, defaut  FROM adresses_types";
					$retour = $bdd->query($query);
					while($res= $retour->fetchObject()){
						if($res->defaut ==1){
							echo "<option value='".$res->id_adresse_type."' selected='selected'>".$res->adresse_type."</option>";
						}else{
							echo "<option value='".$res->id_adresse_type."' >".$res->adresse_type."</option>";
						}
					}					
					?>
					</select>
				</td>
			</tr><?php } ?><tr>
				<td>
				<span class="labelled">Adresse:</span>
				</td><td>
				<textarea id="adresse_adresse%//%" name="adresse_adresse%//%" rows="2" class="classinput_xsize"/></textarea>
				</td>
			</tr><tr>
				<td>
				<span class="labelled">Code Postal:</span>
				</td><td>
				<input id="adresse_code%//%" name="adresse_code%//%" class="classinput_xsize"/>
				</td>
			</tr><tr>
				<td>
				<span class="labelled">Ville:</span>
				</td><td>
				<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
				<iframe id="iframe_choix_adresse_ville%//%" frameborder="0" scrolling="no" src="about:_blank"  class="choix_complete_ville"></iframe>
				<div id="choix_adresse_ville%//%"  class="choix_complete_ville"></div></div>
				<input name="adresse_ville%//%" id="adresse_ville%//%" class="classinput_xsize"/>
				</td>
			</tr><tr>
				<td>
				<span class="labelled">Pays:</span>
				</td><td>
				<select id="adresse_id_pays%//%"  name="adresse_id_pays%//%" class="classinput_xsize">
					<?php
					$separe_listepays = 0;
					foreach ($listepays as $payslist){
						if ((!$separe_listepays) && (!$payslist->affichage)) { 
							$separe_listepays = 1; ?>
							<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
							<?php 		 
						}
						?>
						<option value="<?php echo $payslist->id_pays?>" <?php if ($DEFAUT_ID_PAYS == $payslist->id_pays) {echo 'selected="selected"';}?>>
						<?php echo htmlentities($payslist->pays)?></option>
						<?php 
					}
					?>
				</select>
				</td>
			</tr><tr>
				<td>
				<span class="labelled">Note:</span>
				</td>
				<td>
				<textarea id="adresse_note%//%" name="adresse_note%//%" rows="2"  class="classinput_xsize"/></textarea>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

</div>

<div id="sitecontent">
<table class="minimizetable">
  <tr>
		<td colspan="2">
		<table>
			<tr>
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
				<td class="size_strict">
				<span class="labelled">Titre:</span></td>
				<td>
		<div style="text-align:right; float:right"> <a href="#" id="link_sup_sitecontent_li_%//%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a></div>
				<input id="site_lib%//%" name="site_lib%//%" type="text" class="classinput_lsize" value="" />
				</td>
			</tr>
			<?php if(!empty($GEST_TYPE_COORD)){
                            ?><tr>
				<td>
					<span class="labelled">Type :</span>
				</td><td>
					<select id="type_site%//%" name="type_site%//%" class="classinput_xsize" >
					<?php 
					global $bdd;
					$query = "SELECT id_web_type, web_type, defaut  FROM sites_web_types";
					$retour = $bdd->query($query);
					while($res= $retour->fetchObject()){
						if($res->defaut ==1){
							echo "<option value='".$res->id_web_type."' selected='selected'>".$res->web_type."</option>";
						}else{
							echo "<option value='".$res->id_web_type."' >".$res->web_type."</option>";
						}
					}					
					?>
					</select>
				</td>
			</tr><?php } ?>
			<tr>
				<td>
				<span class="labelled">Adresse URL:</span>
				</td>
				<td>
				<input id="site_url%//%" name="site_url%//%" class="classinput_xsize"/>
				</td>
			</tr><tr>
				<td>
				<span class="labelled">Login:</span>
				</td><td>
				<input name="site_login%//%" id="site_login%//%" class="classinput_xsize"/>
				</td>
			</tr><tr>
				<td>
				<span class="labelled">Mot de passe:</span>
				</td><td>
				<input id="site_pass%//%" name="site_pass%//%" type="text" class="classinput_xsize"/>
				</td>
			</tr><tr>
				<td>
				<span class="labelled">Note:</span>
				</td><td>
				<textarea id="site_note%//%" name="site_note%//%" rows="2"  class="classinput_xsize"/></textarea>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

</div>


<div id="usercontent">
<table class="minimizetable">
  <tr>
		<td>
		<div><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" border="0"></div>
		</td><td>
		<div style="text-align:right;"> <a href="#" id="link_sup_usercontent_li_%//%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0"></a></div>
		</td>
	</tr><tr>
		<td colspan="2">
		<table>
			<tr>
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr><tr>
				<td class="size_strict">
					<span class="labelled">Pseudo:</span>
				</td><td>
					<input id="user_pseudo%//%" name="user_pseudo%//%" type="text" class="classinput_xsize" value="" />
				</td>
			</tr><tr>
				<td>
					<span class="labelled">Mot de passe:</span>
				</td><td>
					<input id="user_code%//%" name="user_code%//%" class="classinput_xsize" type="password"/>
				</td>
			</tr><tr>
				<td>
					<span class="labelled">Confirmer Mdp:</span>
				</td><td>
					<input id="user_2code%//%" name="user_2code%//%" class="classinput_xsize" type="password"/>
				</td>
			</tr><tr>
				<td>
					<span class="labelled">Coordonn&eacute;es:</span>
				</td><td>
				<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
				<iframe id="iframe_liste_choix_coordonnee%//%" frameborder="0" scrolling="no" src="about:_blank"  class="choix_liste_choix_coordonnee" style="display:none;"></iframe>
				<div id="choix_liste_choix_coordonnee%//%"  class="choix_liste_choix_coordonnee" style="display:none;"></div></div>
				<div id="coordonnee_choisie%//%" class="simule_champs" style="width:99%;cursor: default;">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif"/ style="float:right" id="bt_coordonnee_choisie%//%">
					<span id="lib_coordonnee_choisie%//%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				</div>
				<input id="user_coord%//%" name="user_coord%//%" class="classinput_xsize" value="" type="hidden"/>
				</td>
			</tr><tr>
				<td>
				<span class="labelled">Langage:</span>
				</td>
				<td>
				<select id="user_id_langage%//%"  name="user_id_langage%//%" class="classinput_xsize" >
				<?php
				foreach ($langages as $langage){
					?>
					<option value="<?php echo $langage['id_langage']?>" <?php if ($DEFAUT_ID_LANG == $langage['id_langage']) {echo 'selected="selected"';}?>>
					<?php echo htmlentities($langage['lib_langage'])?></option>
					<?php 
				}?>
				</select>
				</td>
			</tr><tr>
				<td>
					<span class="labelled">Actif:</span>
				</td><td>
					<input type="checkbox" id="user_actif%//%" name="user_actif%//%" value="1" checked="checked"/>
				</td>
			</tr>
		</table>
		<br />
		</td>
	</tr>
</table>
</div>