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

<script type="text/javascript" language="javascript">
tableau_smenu[0] = Array("smenu_annuaire", "smenu_annuaire.php" ,"true" ,"sub_content", "Annuaire");
tableau_smenu[1] = Array('annuaire_recherche','annuaire_recherche.php',"true" ,"sub_content", "Recherche d'une fiche de contact");
update_menu_arbo();
array_menu_r_contact	=	new Array();
array_menu_r_contact[0] 	=	new Array('recherche_simple', 'menu_1');
array_menu_r_contact[1] 	=	new Array('recherche_avancee', 'menu_2');
</script>
<div class="emarge">
<p class="titre">Recherche d'une fiche de contact</p>

<div>
	<ul id="menu_recherche" class="menu">
	<li><a href="#" id="menu_1" class="menu_select">Recherche</a></li>
	<li><a href="#" id="menu_2" class="menu_unselect">Recherche avanc&eacute;e</a></li>
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
				<tr>
					<td></td>
					<td>&nbsp;</td>
					<td><input name="submit_s" type="image" onclick="$('page_to_show_s').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif" style="float:left" /></td>
					<td><!--<input type="image" name="res_s" id="res_s" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>-->	</td>
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
							<option value="0"> -- Tous </option>
							<?php
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
				<tr>
					<td>&nbsp;</td>
					<td><span class="labelled">Code Postal: </span></td>
					<td><input type="text" name="code_postal" id="code_postal" value=""   class="classinput_xsize"/></td>
					<td>&nbsp;</td>
					<td></td>
					<td style="text-align:right">
						<input name="submit" type="image" onclick="$('page_to_show').value=1;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-rechercher.gif"  style="float:left"/>
						<input type="image" name="res" id="res" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif" />
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><span class="labelled">Ville : </span></td>
					<td><input type="text" name="ville" id="ville" value=""   class="classinput_xsize"/></td>
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
Event.observe("menu_1", "click",  function(evt){Event.stop(evt); view_menu_1('recherche_simple', 'menu_1', array_menu_r_contact );}, false);
Event.observe("menu_2", "click",  function(evt){Event.stop(evt); view_menu_1('recherche_avancee', 'menu_2', array_menu_r_contact );}, false);
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
//on masque le chargement
H_loading();
</SCRIPT>