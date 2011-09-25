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
</script>
<div class="emarge">
<p class="titre">Historique des connexions des utilisateurs de  <?php echo $contact->getNom()?></p>


<div id="recherche" >
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
					<td><input type="hidden" name="nom_s" id="nom_s" value="<?php echo $contact->getRef_contact()?>"   class="classinput_xsize"/><input name="id_profil_s" id="id_profil_s" type="hidden" value=""></td>
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


</div>
<SCRIPT type="text/javascript">
function setheight_utilisateur_detail(){
set_tomax_height("infogene" , -32);
}
Event.observe(window, "resize", setheight_utilisateur_detail, false);
setheight_utilisateur_detail();


Event.observe("date_debut", "blur", function(evt){
	datemask (evt);
}, false);
Event.observe("date_fin", "blur", function(evt){
	datemask (evt);
}, false);
	
page.utilisateur_recherche_histo();
//on masque le chargement
H_loading();
</SCRIPT>