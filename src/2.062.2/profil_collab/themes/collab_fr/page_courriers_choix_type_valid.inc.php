<?php

// *************************************************************************************************************
// PAGE POUR VALIDER LE CHOIX DU TYPE ET DU MODELE PDF D'UN COURRIER
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
<p>change le type  et le modele du courrier</p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
var erreur=false;
<?php 
if (count($_ALERTES)>0) {}
foreach ($_ALERTES as $alerte => $value) {}
?>
if (erreur) {}
else
{
	<?php 
	//On créé un courrier. On valide le choix du type, puis on arrive sur le courrier en question
	if($page_source == "annuaire_view_courriers" && $page_cible == "courriers_edition.php" && $cible == "contactview_courrier"){ ?>
		window.parent.document.getElementById("courrier_choix_type").innerHTML="";
		window.parent.document.getElementById("courrier_choix_type").hide();
		window.parent.page.traitecontent('aa','courriers_edition.php?ref_destinataire=<?php echo $ref_destinataire."&id_courrier=".$courrier->getId_courrier(); ?>','true','contactview_courrier');
	<?php
	}
	
	//On édite un courrier On valide le choix du type / modele PDF et un message de confirmation apparait.	
	if($page_source == "courriers_edition" && $page_cible == "none" && $cible == "none"){ ?>
		window.parent.document.getElementById("courrier_options").innerHTML="";
		window.parent.document.getElementById("courrier_options").hide();
	
		window.parent.document.getElementById("titre_alert").innerHTML = 'Mise à jour du courrier';
		window.parent.document.getElementById("texte_alert").innerHTML = 'Un nouveau type de courrier et un nouveau modele de PDF viennent d\'être définis';
		window.parent.document.getElementById("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="OK" />';
		
		window.parent.document.getElementById("alert_pop_up_tab").style.display = "block";
		window.parent.document.getElementById("framealert").style.display = "block";
		window.parent.document.getElementById("alert_pop_up").style.display = "block";
		
		window.parent.document.getElementById("bouton0").onclick= function () {
			window.parent.document.getElementById("framealert").style.display = "none";
			window.parent.document.getElementById("alert_pop_up").style.display = "none";
			window.parent.document.getElementById("alert_pop_up_tab").style.display = "none";
		}
	<?php 
	}
	
	//On est dans FICHE CONTACT > COMMUNICATION et on fait OPTION sur un courrier. On valide le choix du type / model PDF et un message de confirmation apparait.	
	if($page_source == "annuaire_view_courriers" && $page_cible == "none" && $cible == "none"){ ?>
		window.parent.document.getElementById("courrier_options").innerHTML="";
		window.parent.document.getElementById("courrier_options").hide();
	
		window.parent.document.getElementById("titre_alert").innerHTML = 'Mise à jour du courrier';
		window.parent.document.getElementById("texte_alert").innerHTML = 'Un nouveau type de courrier et un nouveau modele de PDF viennent d\'être définis';
		window.parent.document.getElementById("bouton_alert").innerHTML = '<input type="submit" id="bouton0" name="bouton0" value="OK" />';
		
		window.parent.document.getElementById("alert_pop_up_tab").style.display = "block";
		window.parent.document.getElementById("framealert").style.display = "block";
		window.parent.document.getElementById("alert_pop_up").style.display = "block";
		
		window.parent.document.getElementById("bouton0").onclick= function () {
			window.parent.document.getElementById("framealert").style.display = "none";
			window.parent.document.getElementById("alert_pop_up").style.display = "none";
			window.parent.document.getElementById("alert_pop_up_tab").style.display = "none";
		}
		<?php 
	} ?>
}
</script>