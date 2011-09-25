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
tableau_smenu[0] = Array("smenu_utilisateurs", "smenu_utilisateurs.php" ,"true" ,"sub_content", "Utilisateurs");
tableau_smenu[1] = Array('annuaire_gestion_collabs_liste','annuaire_gestion_collabs_liste.php' ,"true" ,"sub_content", "Liste des collaborateurs");
update_menu_arbo();
</script>
<div class="emarge">
<p class="titre">Liste des collaborateurs</p>

<div id="recherche" class="corps_moteur">
	<div id="recherche_simple" class="menu_link_affichage">
		<form action="#" id="form_recherche_simple" name="form_recherche_simple" method="GET" onsubmit="page.annuaire_recherche_collabs(); return false;">
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
					<input type="hidden" name="id_profil_s" id="id_profil_s" value="<?php echo $COLLAB_ID_PROFIL;?>" />
					<span class="labelled">Nom&nbsp;ou&nbsp;D&eacute;nomination:</span></td>
					<td><input type="text" name="nom_s" id="nom_s" value="<?php if (isset($_REQUEST["acc_ref_contact"])) { echo htmlentities($_REQUEST["acc_ref_contact"]);}
	?>"   class="classinput_xsize"/></td>
					<td></td>
					<td></td>
				</tr>
				
				<tr>
					<td></td>
					<td>
					Fonction:
					</td>
					<td>
					<select name="id_fonction_s" id="id_fonction_s"  class="classinput_xsize">
						<option value="">Toutes</option>
					<?php
					foreach ($liste_fonctions as $fonction) {
						?>
						<option value="<?php echo $fonction->id_fonction;?>"><?php echo $fonction->lib_fonction;?></option>
						<?php
					}
					?>
					</select></td>
					<td><!--<input type="image" name="res_s" id="res_s" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-annuler.gif"/>-->	</td>
					<td>&nbsp;</td>
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

</div>

<div id="resultat"></div>

</div>
<SCRIPT type="text/javascript">

	//recherche automatique d'un contact depuis la page d'acceuil
	page.annuaire_recherche_collabs();
//on masque le chargement
H_loading();
</SCRIPT>