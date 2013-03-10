<?php

// *************************************************************************************************************
// RECHERCHE D'UN CONTACT
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
<script type="text/javascript">
</script>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_compta_plan_recherche_mini.inc.php" ?>

<div class="emarge">
<div style=" float:right; text-align:right">
<span id="retour_compta_auto" style="cursor:pointer; text-decoration:underline">Retour à la comptabilité automatique</span>
<script type="text/javascript">
Event.observe('retour_compta_auto', 'click',  function(evt){
Event.stop(evt); 
page.verify('compta_automatique','compta_automatique.php','true','sub_content');
}, false);
</script>
</div>
<p class="titre">Numéros de compte associés aux contacts de clients</p>

<div id="recherche" class="corps_moteur">
	<div id="recherche_avancee"   class="menu_link_affichage">
		<form action="#" id="form_recherche_avancee" method="GET" onsubmit="page.compta_client_comptes_plan(); return false;" >
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
					<td></td>
					<td></td>
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
					<td>
					<input name="id_profil" id="id_profil"  value="<?php echo $CLIENT_ID_PROFIL;?>" type="hidden"></td>
					<td></td>
					<td>&nbsp;</td>
				</tr>
				<tr id="liste_categ_client" >
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
				<tr id="liste_type_client" >
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
					<td></td>
					<td><input name="submit" type="image" onclick="$('page_to_show').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left"/>
					</td>
					<td>&nbsp;</td>
					<td></td>
					<td style="text-align:right">
						
					</td>
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
</div>

<div id="resultat"></div>

</div>
<SCRIPT type="text/javascript">


$("nom").focus();


//on masque le chargement
H_loading();
</SCRIPT>