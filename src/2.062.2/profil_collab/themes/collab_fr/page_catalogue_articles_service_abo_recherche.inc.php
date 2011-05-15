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


<?php
	include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" 
?>


<p class="titre">Suivi des abonnements:</p>
<div>
	<ul id="menu_recherche" class="menu">
	<li><a href="#" id="menu_1" class="menu_select">Recherche</a></li>
	</ul>
</div>
<div id="moteur_recherche" class="corps_moteur">
	<div id="recherche_simple" class="menu_link_affichage">
		<form action="#" id="form_recherche_abo_simple" name="form_recherche_abo_simple" method="GET" onsubmit="page.article_recherche_abo(); return false;">
			<table style="width:100%" border="0">
				<tr class="smallheight">
					<td style="width: 2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width: 3%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width: 2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				</tr>
				
				<tr>
					<td></td>
					<td>
						<span class="labelled">Article:</span>
					</td>
					<td>
						<select id="ref_article" name="ref_article" class="classinput_xsize" style="width:250px" />
							<?php 
							$ref_art_categ = "";
							foreach ($liste_abonnements as $abonnement) {
								if ($ref_art_categ != $abonnement->ref_art_categ) {
									?>
									<optgroup disabled="disabled" label="<?php echo ($abonnement->lib_art_categ); ?>"></optgroup>
									<?php
									$ref_art_categ = $abonnement->ref_art_categ;
								}
								
								?>
								<option value="<?php echo $abonnement->ref_article;?>" <?php if ($article->getRef_article() == $abonnement->ref_article) { echo 'selected="selected"';}?>><?php echo htmlentities($abonnement->lib_article);?></option>
								<?php
							}
							?>
						</select>
					</td>
					<td></td>
					<td>
						<span class="labelled">Client:</span>
					</td>
					<td>
						<input type="text" readonly="readonly" name="nom_client" id="nom_client" class="classinput_xsize" style="width:220px" />
						<input type="hidden" name="ref_client" id="ref_client" />
						<script type="text/javascript">
							Event.observe('nom_client', 'click',  function(evt){
								// recherche_client_set_contact -> fonction java script qui sera appellée par show_mini_moteur_contacts
								// les résultats seront insérés dans les inputs ref_contact et nom_contact
								Event.stop(evt); show_mini_moteur_contacts ("recherche_client_set_contact", "\'ref_client\', \'nom_client\' ");
								preselect ('<?php echo $CLIENT_ID_PROFIL; ?>', 'id_profil_m');
								page.annuaire_recherche_mini();
							}, false);
							
							centrage_element("pop_up_mini_moteur");
							centrage_element("pop_up_mini_moteur_iframe");
							Event.observe(window, "resize", function(evt){
								centrage_element("pop_up_mini_moteur_iframe");
								centrage_element("pop_up_mini_moteur");
							});
						</script>
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif"/ style="cursor:pointer" id="ref_client_suppr_img">
						<script type="text/javascript">
							Event.observe('ref_client_suppr_img', 'click',  function(evt){
								Event.stop(evt); 
								$("ref_client").value = "";
								$("nom_client").value = "";
							}, false);
						</script>
					</td>
					<td></td>
				</tr>
				
				<tr>
					<td></td>
					<td>
						<span class="labelled">Etat&nbsp;de&nbsp;l&acute;abonnement:</span>
					</td>
					<td>
						<select  id="etat_abo"  name="etat_abo" class="classinput_xsize" style="width:250px">
							<option value="0" selected="selected">Tous</option>
							<option value="1"<?php if(isset($_REQUEST["type_recherche"]) && $_REQUEST["type_recherche"] == "1" ) { ?> selected="selected"<?php } ?>>Abonnement en cours</option>
							<option value="2"<?php if(isset($_REQUEST["type_recherche"]) && $_REQUEST["type_recherche"] == "2" ) { ?> selected="selected"<?php } ?>>Abonnement à renouveler</option>
							<option value="3"<?php if(isset($_REQUEST["type_recherche"]) && $_REQUEST["type_recherche"] == "3" ) { ?> selected="selected"<?php } ?>>Abonnement expiré</option>
						</select>
					</td>
					<td></td>
					<td>
						<span class="labelled">Cartégorie&nbsp;de&nbsp;clients:</span>
					</td>
					<td>
						<select id="id_client_categ" name="id_client_categ" class="classinput_xsize" style="width:220px">
							<option value="0">Toutes</option>
							<?php 
							foreach ($ANNUAIRE_CATEGORIES as $categorie) {?>
							<option value="<?php echo $categorie->id_categorie?>"><?php echo htmlentities($categorie->lib_categorie)?></option>
							<?php } ?>
						</select>
					</td>
					<td></td>
				</tr>
				
				<tr>
					<td></td>
					<td>
						<div id="afficher_plus_de_criteres" style="display:block; cursor:pointer">
							<span class="labelled">+ de critères</span>
						</div>
						<div id="afficher_moins_de_criteres" style="display:none; cursor:pointer">
							<span class="labelled">- de critères</span>
						</div>
						<script type="text/javascript">
							Event.observe("afficher_plus_de_criteres", "click",  function(evt){
									Event.stop(evt);
									$("afficher_plus_de_criteres").hide();
									$("afficher_moins_de_criteres").show();
									$("plus_de_criteres").show();
									}, false);
			
							Event.observe("afficher_moins_de_criteres", "click",  function(evt){
								Event.stop(evt);
								$("afficher_moins_de_criteres").hide();
								$("afficher_plus_de_criteres").show();
								$("plus_de_criteres").hide();
								}, false);
						</script>
					</td>
					<td></td>
					<td></td>
					<td>
						<input name="submit_s" type="image" onclick="$('page_to_show_s').value=1;" 
							src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif" style="float:left" />
					</td>
					<td></td>
					<td></td>
				</tr>
				
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
			
			<div id="plus_de_criteres" style="display:none;">	
				<table style="width:100%" border="0">
					<tr>
						<td></td>
						<td>
							<span class="labelled">Date de souscription</span>
						</td>
						<td>
							<input type="text" name="date_souscription_min" id="date_souscription_min" class="classinput_xsize" style="width:100px" >
							au
							<input type="text" name="date_souscription_max" id="date_souscription_max"  class="classinput_xsize" style="width:100px">
						</td>
						<td></td>
						<td>
							<span class="labelled">Code&nbsp;postal&nbsp;du&nbsp;client:</span>
						</td>
						<td>
							<input id="adresse_code" name="adresse_code"  class="classinput_xsize" style="width:220px" />
						</td>
						<td></td>
					</tr>

					<tr >
						<td></td>
						<td>
							<span class="labelled">Date d'échéance:</span>
						</td>
						<td>
							<input type="text" name="date_echeance_min" id="date_echeance_min" class="classinput_xsize" style="width:100px">
							au
							<input type="text" name="date_echeance_max" id="date_echeance_max" class="classinput_xsize" style="width:100px">
						</td>
						<td></td>
						<td>
							<span class="labelled">Ville:</span>
						</td>
						<td>
							<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
								<iframe id="iframe_choix_adresse_ville" frameborder="0" scrolling="no" src="about:_blank"  class="choix_complete_ville" width="220px"></iframe>
								<div id="choix_adresse_ville"  class="choix_complete_ville" style="width:220px"></div>
							</div>
							<input name="adresse_ville" id="adresse_ville"  class="classinput_xsize" style="width:220px" />
							
							<script type="text/javascript">
								Event.observe('adresse_ville', 'focus',  function(evt){start_commune("adresse_code", "adresse_ville", "choix_adresse_ville", "iframe_choix_adresse_ville", "liste_ville.php?cp=");}, false);
							</script>
						</td>
						<td></td>
					</tr>
							
					<tr>
						<td></td>
						<td>
							<span class="labelled">Date de fin:</span>
						</td>
						<td>
							<input type="text" name="date_fin_min" id="date_fin_min" class="classinput_xsize" style="width:100px">
							au
							<input type="text" name="date_fin_max" id="date_fin_max"  class="classinput_xsize" style="width:100px">
							
						</td>
						<td></td>
						<td>
							<span class="labelled">Pays:</span>
						</td>
						<td>
							<input name="adresse_pays" id="adresse_pays"  class="classinput_xsize" style="width:220px" />
						</td>
						<td></td>
					</tr>
									
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>
							<input name="submit_s" type="image" onclick="$('page_to_show_s').value=1;" 
								src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif" style="float:left" />
						</td>
						<td></td>
						<td></td>
					</tr>
					
					<tr class="smallheight">
						<td style="width: 2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width: 3%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:16%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width:27%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
						<td style="width: 2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>
					
				</table>
			</div>
			<input type="hidden" name="page_to_show_s"	id="page_to_show_s"	value="1"/>
			<input type="hidden" name="orderby_s" 			id="orderby_s" 			value="nom" />
			<input type="hidden" name="orderorder_s" 		id="orderorder_s"		value="ASC" />
			<input type="hidden" name="recherche" 			id="recherche"			value="1" />
		</form>
	</div>
</div>

<div id="resultat"></div>

</div>
<div id="edition_abonnement" class="edition_abonnement" style="display:none">
</div>
<SCRIPT type="text/javascript">

//centrage de l'editeur
centrage_element("edition_abonnement");
Event.observe(window, "resize", function(evt){
	centrage_element("edition_abonnement");
});

Event.observe("ref_article", "change",  function(evt){
		page.verify("catalogue_articles_service_abo_recherche", "catalogue_articles_service_abo_recherche.php?ref_article="+$("ref_article").options[$("ref_article").selectedIndex].value+"&type_recherche="+$("type_recherche").value, "true", "sub_content");
}, false);

<?php 
if (isset($_REQUEST["type_recherche"])) {
	?>
	//recherche automatique d'un contact depuis la page d'acceuil
	page.article_recherche_abo();
	<?php
}
?>

//on masque le chargement
H_loading();
</SCRIPT>