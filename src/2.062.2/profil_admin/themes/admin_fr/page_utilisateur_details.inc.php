<?php

// *************************************************************************************************************
// RECHERCHE DES CONNEXIONS DES UTILISATEURS
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
$caiu = 1;
// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}

// Formulaire de recherche
?>

<script type="text/javascript" language="javascript">
tableau_smenu[0] = Array("smenu_utilisateurs", "smenu_utilisateurs.php" ,"true" ,"sub_content", "Utilisateurs");
tableau_smenu[1] = Array('utilisateur_details','utilisateur_details.php?ref_user=<?php echo $utilisateur->getRef_user ()?>',"true" ,"sub_content", "Détails de l'utilisateur");
update_menu_arbo();
array_menu_d_user_contact	=	new Array();
array_menu_d_user_contact[0] 	=	new Array('recherche', 'menu_1');
array_menu_d_user_contact[1] 	=	new Array('infogene', 'menu_2');
array_menu_d_user_contact[3] 	=	new Array('droits', 'menu_4');
</script>
<div class="emarge">
<p class="titre">Détails de l'utilisateur <?php echo $utilisateur->getPseudo()?> / <?php echo $contact->getNom()?></p>

<div>
	<ul id="menu_utilisateur" class="menu">
	<li><a href="#" id="menu_2" class="menu_select">Informations générales</a></li>
	<li><a href="#" id="menu_1" class="menu_unselect">Recherche des connexions</a></li>
	<li><a href="#" id="menu_4" class="menu_unselect">Droits Utilisateur</a></li>
	</ul>
</div>
<div id="infogene" class="contactview_corps" style=" OVERFLOW-Y: auto; OVERFLOW-X: auto; ">
<table class="minimizetable" width="290px">
	<tr>
		<td>
		</td>
	</tr><tr>
		<td>
		<div style="width:330px">
		<form method="post" action="utilisateur_edition_user.php" id="annu_editon_user<?php echo $caiu?>" name="annu_editon_user<?php echo $caiu?>" target="formFrame">
		<input type="hidden" name="ref_idform" value="<?php echo $caiu?>"/>
		<input type="hidden" name="ref_contact<?php echo $caiu?>" value="<?php echo $contact->getRef_contact()?>"/>
		<input id="user_ref<?php echo $caiu?>" name="user_ref<?php echo $caiu?>"  type="hidden" value="<?php echo $utilisateur->getRef_user ()?>" />
		<table class="infotable">
			<tr>
				<td class="size_strict"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
			</tr>
			<tr>
				<td class="size_strict">
				<span class="labelled">Pseudo:</span></td><td>
				<input id="user_pseudo<?php echo $caiu?>" name="user_pseudo<?php echo $caiu?>" type="text" class="classinput_xsize" value="<?php echo htmlentities($utilisateur->getPseudo())?>" />
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Mot de passe:</span></td>
				<td>
				<input id="user_code<?php echo $caiu?>" name="user_code<?php echo $caiu?>" class="classinput_xsize" value=""   type="password"/>
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Confimer Mdp:</span></td>
				<td>
				<input id="user_2code<?php echo $caiu?>" name="user_2code<?php echo $caiu?>" class="classinput_xsize" value=""  type="password"/>
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Coordonn&eacute;es:</span></td>
				<td>
				<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
				<iframe id="iframe_liste_choix_coordonnee<?php echo $caiu?>" frameborder="0" scrolling="no" src="about:_blank"  class="choix_liste_choix_coordonnee" style="display:none"></iframe>
				<div id="choix_liste_choix_coordonnee<?php echo $caiu?>"  class="choix_liste_choix_coordonnee" style="display:none"></div></div>
				<div id="coordonnee_choisie<?php echo $caiu?>" class="simule_champs" style="width:99%;cursor: default;">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif"/ style="float:right" id="bt_coordonnee_choisie<?php echo $caiu?>">
					<span id="lib_coordonnee_choisie<?php echo $caiu?>"><?php echo getLib_coordonnee($utilisateur->getRef_coord_user())?></span>
				</div>
				<input id="user_coord<?php echo $caiu?>" name="user_coord<?php echo $caiu?>" class="classinput_xsize" value="<?php echo htmlentities($utilisateur->getRef_coord_user());?>" type="hidden"/>
				</td>
			</tr>
			<tr>
				<td>
					<span class="labelled">Langage:</span>
				</td><td>
				<select id="user_id_langage<?php echo $caiu?>"  name="user_id_langage<?php echo $caiu?>" class="classinput_xsize" >
					<?php
					foreach ($langages as $langage){
						?>
						<option value="<?php echo $langage['id_langage']?>" <?php if ($utilisateur->getId_langage () == $langage['id_langage']) {echo 'selected="selected"';}?>>
						<?php echo htmlentities($langage['lib_langage'])?></option>
						<?php 
					}
					?>
				</select>
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled">Actif:</span></td><td>
				<input id="user_actif<?php echo $caiu?>" name="user_actif<?php echo $caiu?>" <?php if ($utilisateur->getActif()) {echo 'checked="checked"';}?> value="1"   type="checkbox"  />
				</td>
			</tr>
			<tr>
				<td>
				<span class="labelled" id="v_utili_master" style="display:<?php if ($utilisateur->getMaster()) {?>block<?php 
				} else { ?>none<?php } ?>">Utilisateur principal</span>
				
				</td><td>
				
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td style="text-align:right;">
				<input type="image" name="modifier<?php echo $caiu?>" id="modifier<?php echo $caiu?>" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif"/>
				</td>
			</tr>
		</table>
		</form> 
		</div>
		</td>
	</tr>
</table>
		
		<script type="text/javascript" language="javascript">
		//fonction de choix de coordonnees
		
		//effet de survol sur le faux select
		Event.observe('coordonnee_choisie<?php echo $caiu?>', 'mouseover',  function(){$("bt_coordonnee_choisie<?php echo $caiu?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_hover.gif";}, false);
		Event.observe('coordonnee_choisie<?php echo $caiu?>', 'mousedown',  function(){$("bt_coordonnee_choisie<?php echo $caiu?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select_down.gif";}, false);
		Event.observe('coordonnee_choisie<?php echo $caiu?>', 'mouseup',  function(){$("bt_coordonnee_choisie<?php echo $caiu?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
		Event.observe('coordonnee_choisie<?php echo $caiu?>', 'mouseout',  function(){$("bt_coordonnee_choisie<?php echo $caiu?>").src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-arrow_select.gif";}, false);
							
		//affichage des choix
		Event.observe('coordonnee_choisie<?php echo $caiu?>', 'click',  function(evt){Event.stop(evt); start_coordonnee ("<?php echo $contact->getRef_contact()?>", "lib_coordonnee_choisie<?php echo $caiu?>", "user_coord<?php echo $caiu?>", "choix_liste_choix_coordonnee<?php echo $caiu?>", "iframe_liste_choix_coordonnee<?php echo $caiu?>", "annuaire_liste_choix_coordonnee.php");}, false);
							
		
		</script>
</div>
<div id="recherche" style="display:none">
	<div id="recherche_simple" class="corps_moteur">
		<form action="#" id="form_recherche_simple" name="form_recherche_simple" method="GET" onsubmit="page.utilisateur_recherche_histo(); return false;">
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
					<input type="hidden" name="orderby_s" id="orderby_s" value="date" />
					<input type="hidden" name="orderorder_s" id="orderorder_s" value="DESC" />
					</td>
					<td><input type="hidden" name="nom_s" id="nom_s" value="<?php echo $utilisateur->getRef_user()?>"   class="classinput_xsize"/><input name="id_profil_s" id="id_profil_s" type="hidden" value=""></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><span class="labelled">Adresse I.P.: </span></td>
					<td><input type="text" id="ip" name="ip" value="" class="classinput_xsize" /> </td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><span class="labelled">Période&nbsp;du&nbsp; </span></td>
					<td><input type="text" id="date_debut" name="date_debut" value="" class="classinput_nsize" size="10" /> au&nbsp;<input type="text" id="date_fin" name="date_fin" value="" class="classinput_nsize" size="10" /></td>
					<td></td>
					<td></td>
					<td></td>
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


<div id="resultat"></div>
</div>
<div id="droits" class="contactview_corps" style=" OVERFLOW-Y: auto; OVERFLOW-X: auto; display:none">

</div>

</div>
<SCRIPT type="text/javascript">
function setheight_utilisateur_detail(){
set_tomax_height("infogene" , -32);
set_tomax_height("fonctions" , -32);
set_tomax_height("droits" , -32);
}
Event.observe(window, "resize", setheight_utilisateur_detail, false);
setheight_utilisateur_detail();

Event.observe("menu_1", "click",  function(evt){
	Event.stop(evt); view_menu_1('recherche', 'menu_1', array_menu_d_user_contact );
}, false);
Event.observe("menu_2", "click",  function(evt){
	Event.stop(evt); view_menu_1('infogene', 'menu_2', array_menu_d_user_contact );
	setheight_utilisateur_detail();
}, false);

Event.observe("menu_4", "click",  function(evt){
Event.stop(evt); view_menu_1('droits', 'menu_4', array_menu_d_user_contact );
page.traitecontent("utilisateur_permissions", "utilisateur_permissions.php?ref_user=<?php echo $utilisateur->getRef_user ()?>", "true", "droits");
setheight_utilisateur_detail();
}, false);

	Event.observe("date_debut", "blur", function(evt){
		datemask (evt);
	}, false);
	Event.observe("date_fin", "blur", function(evt){
		datemask (evt);
	}, false);
//on masque le chargement
H_loading();
</SCRIPT>