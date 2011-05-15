<?php

// *************************************************************************************************************
// RECHERCHE D'UN CONTACT
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES", "listepays");
check_page_variables ($page_variables);
$query = "SELECT pays FROM pays";
$resultat = $bdd->query($query);
$liste_pays = array();
while ($result = $resultat->fetchObject()){
	$liste_pays[] = $result->pays;
} 

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Formulaire de recherche
?>

<script type="text/javascript" language="javascript">
id_index_contentcoord=0;

array_menu_r_contact	=	new Array();
array_menu_r_contact[0] 	=	new Array('recherche_simple', 'menu_1');
array_menu_r_contact[1] 	=	new Array('recherche_avancee', 'menu_2');
array_menu_r_contact[2] 	=	new Array('recherche_perso', 'menu_3');
</script>
<div class="emarge">
<p class="titre">Recherche d'une fiche de contact</p>

<div>
	<ul id="menu_recherche" class="menu">
	<li><a href="#" id="menu_1" class="menu_select">Recherche</a></li>
	<li><a href="#" id="menu_2" class="menu_unselect">Recherche avanc&eacute;e</a></li>
	<li><a href="#" id="menu_3" class="menu_unselect">Recherche personnalis&eacute;e</a></li>
	</ul>
</div>
<div id="recherche" class="corps_moteur">
	<div id="recherche_simple" class="menu_link_affichage">
		<form action="#" id="form_recherche_simple" name="form_recherche_simple" method="GET" onsubmit="page.annuaire_recherche_simple(); return false;">
			<table style="width:97%">
				<tr class="smallheight">
					<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type=hidden name="recherche" value="1" />
					<input type="hidden" name="orderby_s" id="orderby_s" value="nom" />
					<input type="hidden" name="orderorder_s" id="orderorder_s" value="ASC" />
					<span class="labelled">Nom&nbsp;ou&nbsp;D&eacute;nomination:</span></td>
					<td><input type="text" name="nom_s" id="nom_s" value="<?php if (isset($_REQUEST["acc_ref_contact"])) { echo htmlentities($_REQUEST["acc_ref_contact"]);}
	?>"   class="classinput_xsize"/></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><span class="labelled">Profil : </span></td>
					<td><select name="id_profil_s" id="id_profil_s"  class="classinput_xsize">
						<?php if(in_array("ALL",$allowed_profils)){?>
						<option value="ALL"> -- Tous </option>
						<?php }
						for ($i=0; $i<count($profils); $i++) {
							?>
							<option value="<?php echo $profils[$i]->getId_profil()?>"><?php echo $profils[$i]->getLib_profil()?></option>
							<?php 
						}
						?>
					</select>
					</td>
					<td>&nbsp;</td>
					<td style="text-align:right"></td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
					<td><input name="submit_s" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif" style="float:left" /></td>
					<td><!--<input type="image" name="res_s" id="res_s" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>-->
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_new_contact.gif" id="create_new_contact" style="cursor:pointer" />
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
					<td></td>
					<td></td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<input type="hidden" name="page_to_show_s" id="page_to_show_s" value="1"/>
		</form>
	</div>



	<div id="recherche_avancee"  style="display:none;" class="menu_link_affichage">
		<form action="#" id="form_recherche_avancee" method="GET" onsubmit="page.annuaire_recherche_avancee(); return false;" >
			<table style="width:97%">
					<tr class="smallheight">
						<td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:3%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type=hidden name="recherche" id="recherche" value="1"/>
						<input type="hidden" name="orderby" id="orderby" value="nom"/>
						<input type="hidden" name="orderorder" id="orderorder" value="ASC"/>
						<span class="labelled">Nom&nbsp;ou&nbsp;D&eacute;nomination:</span></td>
					<td><input type="text" name="nom" id="nom" value=""   class="classinput_xsize"/></td>
					<td>&nbsp;</td>
					<td><span class="labelled">Tel :</span></td>
					<td><input type="text" name="tel" id="tel" value=""   class="classinput_xsize"/></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><span class="labelled">Cat&eacute;gorie:</span></td>
					<td>
					
						<select id="id_categorie" name="id_categorie" class="classinput_xsize">
								<option value=""></option>
							<?php 
							foreach ($ANNUAIRE_CATEGORIES as $categorie) {
								?>
								<option value="<?php echo $categorie->id_categorie?>"><?php echo htmlentities($categorie->lib_categorie)?></option>
								<?php
							}
							?>
							</select>
					</td>
					<td>&nbsp;</td>
					<td><span class="labelled">Email :</span></td>
					<td><input type="text" name="email" id="email" value=""   class="classinput_xsize"/></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><span class="labelled">Profil :</span></td>
					<td>
					<select name="id_profil" id="id_profil"  class="classinput_xsize">
							<?php if(in_array("ALL",$allowed_profils)){?>
							<option value="ALL"> -- Tous </option>
							<?php
							}
							$separateur = 1;
							for ($i=0; $i<count($profils_avancees); $i++) {
								if ($profils_avancees[$i]->getActif() == 2 && $separateur) {
								$separateur = 0;
								?>
								<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
								<?php
								}
								?>
								<option value="<?php echo $profils_avancees[$i]->getId_profil();?>"><?php echo $profils_avancees[$i]->getLib_profil();?></option>
								<?php 
							}
							?>
						</select>
					</td>
					<td>&nbsp;</td>
					<td><span class="labelled">Site :</span></td>
					<td><input type="text" name="url" id="url" value=""   class="classinput_xsize"/></td>
					<td>&nbsp;</td>
				</tr>
				<tr id="liste_categ_client" style="display:none">
					<td>&nbsp;</td>
					<td><span class="labelled">Catégorie de client : </span></td>
					<td>
					<select  id="id_client_categ"  name="id_client_categ" class="classinput_xsize">
								<option value="">Tous</option>
						<?php
						foreach ($liste_categories_client as $liste_categorie_client){
							?>
							<option value="<?php echo $liste_categorie_client->id_client_categ;?>" >
							<?php echo htmlentities($liste_categorie_client->lib_client_categ); ?></option>
							<?php 
						}
						?>
					</select>
					</td>
					<td>&nbsp;</td>
					<td></td>
					<td style="text-align:right">
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr id="liste_type_client" style="display:none">
					<td>&nbsp;</td>
					<td><span class="labelled">Type de client : </span></td>
					<td>
					<select  id="type_client"  name="type_client" class="classinput_xsize">
						<option value="">Tous</option>
						<option value="piste">Piste</option>
						<option value="prospect">Prospect</option>
						<option value="client">Client</option>
						<option value="ancien client">Ancien client</option>
						<option value="Compte bloqué">Compte bloqué</option>
					</select>
					</td>
					<td>&nbsp;</td>
					<td></td>
					<td style="text-align:right">
					</td>
					<td>&nbsp;</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td><span class="labelled">Code Postal: </span></td>
					<td><input type="text" name="code_postal" id="code_postal" value=""   class="classinput_xsize"/></td>
					<td>&nbsp;</td>
					<td><span class="labelled">Archives <input type="checkbox" name="archive" id="archive" value="1" /></span></td>
					<td style="text-align:right">
						<input name="submit" type="image" onclick="$('page_to_show').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left"/>
						<input type="image" name="res" id="res" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif" />
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><span class="labelled">Ville : </span></td>
					
					<td>
					<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
					<iframe id="iframe_choix_adresse_ville" frameborder="0" scrolling="no" src="about:_blank"  class="choix_complete_ville"></iframe>
				<div id="choix_adresse_ville"  class="choix_complete_ville"></div></div>
					<input type="text" name="ville" id="ville" value=""   class="classinput_xsize"/></td>
					<td>&nbsp;</td>
					<td></td>
					<td style="text-align:right">
					</td>
					<td>&nbsp;</td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td><span class="labelled">Pays : </span></td>
					
					
					<td>
			
			<select name="pays" id="pays" class="classinput_xsize" style="width:100%">
			<option value="">Tous</option>
				
				
				<?php
				$DEFAUT_ID_PAYS = 0; // pour que "Tous" soit sélectionné par défaut
				$separe_listepays = 0;
				foreach($listepays as $les_pays){
				if ((!$separe_listepays) && (!$les_pays->affichage)) { 
				$separe_listepays = 1; ?>
							<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
							<?php 		 
						}
					?> <option value="<?php echo $les_pays->pays;?>" name="pays" <?php if ($DEFAUT_ID_PAYS == $les_pays->id_pays) {echo 'selected="selected"';} ?> ><?php echo htmlentities($les_pays->pays);?>
					</option>
				<?php } 
				 ?>
				
				</select>
			</td>
					
					<td>&nbsp;</td>
					<td></td>
					<td style="text-align:right">
					</td>
					<td>&nbsp;</td>
				</tr>
				
				</div>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td></td>
				</tr>
			</table>
		<input type="hidden" name="page_to_show" id="page_to_show" value="1"/>
		</form>
	</div>
	<div id="recherche_perso"  style="display:none;" class="menu_link_affichage">
	
			<form action="ods_gen_req.php" id="form_recherche_perso" name="form_recherche_perso" method="POST">
			<table style="width:97%">
				<tr class="smallheight">
					<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>
				<tr>
					<td></td>
					<?php
					$liste_recherche=charge_recherche_type("1");
					if ($liste_recherche) { 
					?>
					<td><span class="labelled">Recherches :</span>
					</td>
					<td>
					<select name="id_recherche" id="id_recherche"  class="classinput_xsize">
						<?php
						foreach ($liste_recherche as $recherche) {
							?>
							<option value="<?php echo $recherche->id_recherche_perso; ?>"><?php echo $recherche->lib_recherche_perso.' - '.$recherche->desc_recherche;?></option>
							<?php 
							}
						?>
					</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
					<td><input name="submit_s" value="Exporter" type="submit" /></td>
					</td>
					<?php
					}else{
					echo 'Aucune recherche personnalisée';
					}
					?>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
					<td></td>
					<td></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</form>
	
	</div>
</div>

<div id="resultat"></div>

</div>
<SCRIPT type="text/javascript">

Event.observe("code_postal", "click",  function(evt){
	Event.stop(evt);
	pre_start_commune("code_postal", "ville", "choix_adresse_ville", "iframe_choix_adresse_ville", "liste_ville.php?cp=", "id_pays");
}, false);
Position.includeScrollOffsets = true;


//creation d'un nouveau contact (transfère la ref_doc si on est dans un document
Event.observe("create_new_contact", "click",  function(evt){
	Event.stop(evt);
	page.verify('annuaire_nouvelle_fiche','annuaire_nouvelle_fiche.php','true','sub_content');
}, false);


Event.observe("id_profil", "change",  function(evt){
	Event.stop(evt);
	if ($("id_profil").options[$("id_profil").selectedIndex].value == "<?php echo $CLIENT_ID_PROFIL;?>") {
		$("liste_categ_client").show();
		$("liste_type_client").show();
	} else {
		$("liste_categ_client").hide();
		$("liste_type_client").hide();
	}
}, false);


Event.observe("menu_1", "click",  function(evt){Event.stop(evt); view_menu_1('recherche_simple', 'menu_1', array_menu_r_contact );}, false);
Event.observe("menu_2", "click",  function(evt){Event.stop(evt); view_menu_1('recherche_avancee', 'menu_2', array_menu_r_contact );}, false);
Event.observe("menu_3", "click",  function(evt){Event.stop(evt); view_menu_1('recherche_perso', 'menu_3', array_menu_r_contact );}, false);
$("nom_s").focus();
//Event.observe($('res_s'), "click", function(evt){	Event.stop(evt); $("form_recherche_simple").reset();});
Event.observe($('res'), "click", function(evt){	Event.stop(evt); $("form_recherche_avancee").reset();});

<?php 
if (isset($_REQUEST["acc_ref_contact"])) {
	?>
	//recherche automatique d'un contact depuis la page d'acceuil
	page.annuaire_recherche_simple();
	<?php
}
?>



//remplissage si on fait un retour dans l'historique
if (historique_request[0][0] == historique[0] && (default_show_id == "from_histo" || default_show_id == "to_histo")) {
	if (historique_request[0][1] == "simple") {
	$('nom_s').value = historique_request[0]["nom_s"];
	preselect (parseInt(historique_request[0]["id_profil_s"]), 'id_profil_s') ;
	$('page_to_show_s').value = historique_request[0]["page_to_show_s"];
	$('orderby_s').value = historique_request[0]["orderby_s"];
	$('orderorder_s').value = historique_request[0]["orderorder_s"];
	view_menu_1('recherche_simple', 'menu_1', array_menu_r_contact );
	page.annuaire_recherche_simple();
	}
	if (historique_request[0][1] == "avancee") {
		$('nom').value 					= historique_request[0]["nom"];
		preselect (parseInt(historique_request[0]["id_categorie"]), 'id_categorie') ;
		preselect (parseInt(historique_request[0]["id_profil"]), 'id_profil') ;
		
		preselect (parseInt(historique_request[0]["id_client_categ"]), 'id_client_categ') ;
		preselect (parseInt(historique_request[0]["type_client"]), 'type_client') ;
		if (historique_request[0]["id_profil"] == "<?php echo $CLIENT_ID_PROFIL;?>") {
			$("liste_categ_client").show();
			$("liste_type_client").show();
		}
		$('page_to_show').value = historique_request[0]["page_to_show"];
		$('tel').value 					= historique_request[0]["tel"];
		$('email').value 				= historique_request[0]["email"];
		$('url').value 					= historique_request[0]["url"];
		$('code_postal').value 	= historique_request[0]["code_postal"];
		$('ville').value 				= historique_request[0]["ville"];
		$('pays').value 				= historique_request[0]["pays"];
		$('orderby').value 			= historique_request[0]["orderby"];
		$('orderorder').value 	= historique_request[0]["orderorder"]; 
		if (historique_request[1]["archive"] == "1") 	{	$('archive').checked = true;	}
		view_menu_1('recherche_avancee', 'menu_2', array_menu_r_contact );
		page.annuaire_recherche_avancee();
	}
}

//on masque le chargement
H_loading();
</SCRIPT>