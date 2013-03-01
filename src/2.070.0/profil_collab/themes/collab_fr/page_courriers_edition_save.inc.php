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
<p>enregistrement du courrier + <?php echo $cmd; ?></p>
<p>&nbsp; </p>
<?php 
foreach ($_ALERTES as $alerte => $value) {
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
	var erreur=false;
	var texte_erreur = "";
	<?php 
	if (count($_ALERTES)>0) {}
	?>
	if (erreur) {}
	else{
		<?php 
		switch ($cmd) {
			case "apercu":{ ?>
								window.parent.page.verify("visualiser_courrier","courriers_editing.php?id_courrier=<?php echo $courrier->getId_courrier(); ?>","true","_blank");
								<?php /*
								window.parent.alerte.alerte_erreur ('Enregistrement du courrier', 'Le courrier a été bien été enregistré','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
								window.parent.page.traitecontent('communication_courrier','annuaire_view_courriers.php?ref_contact=<?php echo $ref_destinataire; ?>','true','contactview_courrier');
								*/
								break;}
			case "save":{/*
								window.parent.alerte.alerte_erreur ('Enregistrement du courrier', 'Le courrier a été bien été enregistré','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
								window.parent.page.traitecontent('communication_courrier','annuaire_view_courriers.php?ref_contact=<?php echo $ref_destinataire; ?>','true','contactview_courrier');
								*/
								break;}
			case "print":{ ?>
								window.parent.page.verify("visualiser_courrier","courriers_editing.php?id_courrier=<?php echo $courrier->getId_courrier(); ?>&print=1","true","_blank");
								<?php /*
								window.parent.alerte.alerte_erreur ('Enregistrement du courrier', 'Le courrier a été bien été enregistré','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
								window.parent.page.traitecontent('communication_courrier','annuaire_view_courriers.php?ref_contact=<?php echo $ref_destinataire; ?>','true','contactview_courrier');
								*/
								break;}
			case "fax":{ //@TODO COURRIER : Gestion du FAX : Traitement du bouton FAX
								window.parent.alerte.alerte_erreur ('FAX', 'Fonction non gérée','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
								break;}
			case "email":{/*
								window.parent.alerte.alerte_erreur ('Enregistrement du courrier', 'Le courrier a été bien été enregistré','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
								window.parent.page.traitecontent('communication_courrier','annuaire_view_courriers.php?ref_contact=<?php echo $ref_destinataire; ?>','true','contactview_courrier');
								*/
								break;}
			case "valider":{ //@TODO COURRIER : Gestion de la VALIDATION : Traitement de la VALIDATION ?>
								window.parent.alerte.alerte_erreur ('VALIDER', 'Courrier validé','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
								window.parent.document.getElementById("lib_etat_courrier").innerHTML = 	"<?php echo $courrier->getLib_etat_courrier(); ?>";
								<?php break;}
			default:{ //par défaut, on fait la sauvegarde du courrier
								/*
								window.parent.alerte.alerte_erreur ('Enregistrement du courrier', 'Le courrier a été bien été enregistré','<input type="submit" id="bouton0" name="bouton0" value="Ok" />');
								window.parent.page.traitecontent('communication_courrier','annuaire_view_courriers.php?ref_contact=<?php echo $ref_destinataire; ?>','true','contactview_courrier');
								*/
								break;}
		}
		?>
	}
</script>