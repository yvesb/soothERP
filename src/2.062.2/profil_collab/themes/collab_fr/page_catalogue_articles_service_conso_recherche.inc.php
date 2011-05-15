<?php

// *************************************************************************************************************
// RECHERCHE DES ABONNEMENTS
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);



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
array_menu_r_contact	=	new Array();
array_menu_r_contact[0] 	=	new Array('recherche_simple', 'menu_1');
</script>
<div class="emarge">
<p class="titre">Consommations de : <?php echo $article->getLib_article();?></p>

<div>
	<ul id="menu_recherche" class="menu">
	<li><a href="#" id="menu_1" class="menu_select">Recherche</a></li>
	</ul>
</div>
<div id="recherche" class="corps_moteur">
	<div id="recherche_simple" class="menu_link_affichage">
		<form action="#" id="form_recherche_conso_simple" name="form_recherche_conso_simple" method="GET" onsubmit="page.article_recherche_conso(); return false;">
			<table style="width:97%">
				<tr class="smallheight">
					<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><span class="labelled">Article:</span></td>
					<td>
						<select id="article" name="article" class="classinput_xsize">
							<?php 
							$ref_art_categ = "";
							foreach ($liste_consommations as $consommation) {
								if ($ref_art_categ != $consommation->ref_art_categ) {
									?>
									<optgroup disabled="disabled" label="<?php echo ($consommation->lib_art_categ); ?>"></optgroup>
									<?php
									$ref_art_categ = $consommation->ref_art_categ;
								}
								
								?>
								<option value="<?php echo $consommation->ref_article;?>" <?php if ($article->getRef_article() == $consommation->ref_article) { echo 'selected="selected"';}?>><?php echo htmlentities($consommation->lib_article);?></option>
								<?php
							}
							?>
							</select>
					</td>
					<td>&nbsp;</td>
					<td></td>
					<td></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td>
					<input type=hidden name="recherche" value="1" />
					<input type="hidden" name="orderby_s" id="orderby_s" value="nom" />
					<input type="hidden" name="orderorder_s" id="orderorder_s" value="ASC" />
					<input type="hidden" name="ref_article" id="ref_article" value="<?php echo $article->getRef_article();?>" />
					<span class="labelled">Nom&nbsp;ou&nbsp;D&eacute;nomination:</span></td>
					<td><input type="text" name="nom_s" id="nom_s" value="<?php if (isset($_REQUEST["acc_ref_contact"])) { echo htmlentities($_REQUEST["acc_ref_contact"]);}
	?>"   class="classinput_xsize"/></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><span class="labelled">Cat&eacute;gorie:</span></td>
					<td>
						<select id="id_categorie" name="id_categorie" class="classinput_xsize">
								<option value="">Toutes</option>
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
					<td><span class="labelled">Code Postal: </span></td>
					<td><input type="text" name="code_postal" id="code_postal" value=""   class="classinput_xsize"/></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td><span class="labelled">Profil : </span></td>
					<td><select name="id_profil_s" id="id_profil_s"  class="classinput_xsize">
						<option value="0"> -- Tous </option>
						
						<?php
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
				<tr >
					<td>&nbsp;</td>
					<td><span class="labelled" style="width:135px">Etat des consommations: </span></td>
					<td>
					<select  id="type_recherche"  name="type_recherche" class="classinput_xsize">
						<option value="0">Tous</option>
						<option value="1" <?php if(isset($_REQUEST["type_recherche"]) && $_REQUEST["type_recherche"] == "1" ) { ?> selected="selected"<?php } ?>>Clients en compte (valide)</option>
						<option value="2"<?php if(isset($_REQUEST["type_recherche"]) && $_REQUEST["type_recherche"] == "2" ) { ?> selected="selected"<?php } ?>>Clients en compte (expiré)</option>
						<option value="3"<?php if(isset($_REQUEST["type_recherche"]) && $_REQUEST["type_recherche"] == "3" ) { ?> selected="selected"<?php } ?>>Crédits vide</option>
					</select>
					</td>
					<td>&nbsp;</td>
					<td></td>
					<td style="text-align:right">
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
					<td><input name="submit_s" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif" style="float:left" /></td>
					<td>
					
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
</div>

<div id="resultat"></div>

</div>
<div id="edition_consommation" class="edition_consommation" style="display:none">
</div>
<SCRIPT type="text/javascript">

Event.observe("id_profil_s", "change",  function(evt){
	Event.stop(evt);
	if ($("id_profil_s").options[$("id_profil_s").selectedIndex].value == "<?php echo $CLIENT_ID_PROFIL;?>") {
		$("liste_categ_client").show();
		$("liste_type_client").show();
	} else {
		$("liste_categ_client").hide();
		$("liste_type_client").hide();
	}
}, false);

Event.observe("menu_1", "click",  function(evt){Event.stop(evt); view_menu_1('recherche_simple', 'menu_1', array_menu_r_contact );}, false);

//centrage de l'editeur
centrage_element("edition_consommation");

Event.observe(window, "resize", function(evt){
centrage_element("edition_consommation");
});

Event.observe("article", "change",  function(evt){
		page.verify("catalogue_articles_service_conso_recherche", "catalogue_articles_service_conso_recherche.php?ref_article="+$("article").value+"&type_recherche="+$("type_recherche").value, "true", "sub_content");
}, false);

<?php 
if (isset($_REQUEST["type_recherche"])) {
	?>
	//recherche automatique d'un contact depuis la page d'acceuil
	page.article_recherche_conso();
	<?php
}
?>

//on masque le chargement
H_loading();
</SCRIPT>