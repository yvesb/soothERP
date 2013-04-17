
<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<p>&nbsp;</p>
<p>contact ajout </p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var nom_vide=false;
var bad_categorie=false;
var nbre_enfants=false;
var type_admin=false;
var email=false;
var erreur=false;
var texte_erreur = "";
<?php 
if (count($_ALERTES)>0) {
}
foreach ($_ALERTES as $alerte => $value) {
	if ($alerte=="Création_contact") {

	}
	
	if ($alerte=="id_civilite_vide") {

	}
	
	if ($alerte=="nom_vide") {
		echo "nom_vide=true;\n";
		echo "erreur=true;\n";
	}
	if ($alerte=="bad_categorie") {
		echo "bad_categorie=true;\n";
		echo "erreur=true;\n";
	}
	
	if ($alerte=="bad_nbre_enfants") {
		echo "nbre_enfants=true;\n";
		echo "erreur=true;\n";
	}
	
	if ($alerte=="bad_type_admin") {
		echo "type_admin=true;\n";
		echo "erreur=true;\n";
	}
	
	if ($alerte=="email_used") {
		echo "email=true;";
		echo "erreur=true;\n";
	}
	
	
	
}

?>
if (erreur) {


//
//verif info CAIU

<?php
for ($i = 0; $i <= $_REQUEST['compte_info']; $i++) {
	if (isset($_REQUEST['adresse_lib'.$i])) {
		?>

		<?php
	}

	if (isset($_REQUEST['coordonnee_lib'.$i])) {
		?>
		if (email) {
			window.parent.document.getElementById("coordonnee_email<?php echo $i?>").className="alerteform_lsize";
			window.parent.document.getElementById("coordonnee_email<?php echo $i?>").focus();
		texte_erreur += "Cette adresse email est déjà utilisée par <br/> <a href=\"index.php#annuaire_view_fiche.php?ref_contact=<?php if (isset( $_ALERTES["email_used"])) { echo $_ALERTES["email_used"][0];}?>\" target=\"_blank\"><?php if (isset( $_ALERTES["email_used"])) {  echo str_replace("\n", " ",$_ALERTES["email_used"][1]);}?></a>";
		} else {
			window.parent.document.getElementById("coordonnee_email<?php echo $i?>").className="classinput_lsize";
		}
		<?php 
	}
	
	if (isset($_REQUEST['site_lib'.$i])) {
		?>
		<?php
		}
	}
?>


if (nbre_enfants) {
	if (window.parent.document.getElementById("collab_nbre_enfants")) {
		window.parent.document.getElementById("collab_nbre_enfants").className="alerteform_xsize";
		window.parent.document.getElementById("collab_nbre_enfants").focus();
		texte_erreur += "La valeur saisie pour le nombre d'enfant du profil collaborateur est invalide.<br/>";
	}
}else {
	if (window.parent.document.getElementById("collab_nbre_enfants")) {
		window.parent.document.getElementById("collab_nbre_enfants").className="classinput_xsize";
	}
}

//
//profil admin
//
if (type_admin) {
	if (window.parent.document.getElementById("type_admin")) {
		window.parent.document.getElementById("type_admin").className="alerteform_xsize";
		window.parent.document.getElementById("type_admin").focus();
		texte_erreur += "Le type d'administrateur choisi semble incorrecte.<br/>";
	}
}else {
	if (window.parent.document.getElementById("type_admin")) {
		window.parent.document.getElementById("type_admin").className="classinput_xsize";
	}
}


if (bad_categorie) {
	window.parent.document.getElementById("id_categorie").className="alerteform_xsize";
	window.parent.document.getElementById("id_categorie").focus();
	texte_erreur += "Le type de contact semble incorrecte.<br/>";
} else {
	window.parent.document.getElementById("id_categorie").className="classinput_xsize";
}

if (nom_vide) {
	window.parent.document.getElementById("nom").className="alerteform_xsize";
	window.parent.document.getElementById("nom").focus();
	texte_erreur += "Indiquez un nom pour votre contact.<br/>";
} else {
	window.parent.document.getElementById("nom").className="classinput_xsize";
}



window.parent.alerte.alerte_erreur ('Erreur de saisie', texte_erreur,'<input type="submit" id="bouton0" name="bouton0" value="Ok" />');


}
else
{
<?php 
if (isset ($_INFOS['Création_contact']) ) {
	?>
	window.parent.changed = false;
	window.parent.page.verify('annuaire_affiche_fiche','annuaire_view_fiche.php?ref_contact=<?php echo $_INFOS['Création_contact']?>','true','sub_content');
	<?php 
}
?>
}
</script>