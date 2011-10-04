
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
<?php
foreach ($_ALERTES as $alerte => $value)
{
	echo $alerte." => ".$value."<br>";
}
?>
<script type="text/javascript">
<?php foreach ($liste_categories_client as $liste_categorie_client)
	{	
		if ($liste_categorie_client->id_client_categ == $_REQUEST["id_client_categ"]) 
		{?>
			preselect (<?php if (isset($liste_categorie_client->id_tarif)) { echo $liste_categorie_client->id_tarif;} else { echo "0";}?>, "id_tarif");
			preselect (<?php if (isset($liste_categorie_client->facturation_periodique)) { echo $liste_categorie_client->facturation_periodique;} else { echo "0";}?>, "facturation_periodique");
	
			if ($("ref_commercial") && $("nom_commercial"))
			{
				$("ref_commercial").value = '<?php if (isset($liste_categorie_client->ref_commercial)) { echo $liste_categorie_client->ref_commercial;} else { echo "";}?>';
				$("nom_commercial").value = '<?php if (isset($liste_categorie_client->nom_commercial)) { echo $liste_categorie_client->nom_commercial;} else { echo "";}?>';
			}
			//$("prepaiement_type").options[0].text = '<?php /*echo $liste_categorie_client->prepaiement_type*/?>//';
			$("prepaiement_ratio").value = '<?php echo $liste_categorie_client->prepaiement_ratio?>';
			$("prepaiement_ratio_defaut").value = '<?php echo $liste_categorie_client->prepaiement_ratio?>';

			<?php if(strpos($liste_categorie_client->delai_reglement,"FDM") === false)
			{	?>
				$("delai_reglement").value = '<?php if (isset($liste_categorie_client->delai_reglement)) { echo $liste_categorie_client->delai_reglement;} else { echo "0";}?>';
				// version 2.051
				$("def_delai_reglement").value = '<?php if (isset($liste_categorie_client->delai_reglement)) { echo $liste_categorie_client->delai_reglement;} else { echo "0";}?>';
				$("delai_reglement_fdm").checked = false;
				$("def_delai_reglement_fdm").checked = false;
				
			<?php }
			else
			{	?>
				$("delai_reglement").value = '<?php if (isset($liste_categorie_client->delai_reglement)) { echo substr($liste_categorie_client->delai_reglement, 0, strlen($liste_categorie_client->delai_reglement)-3);} else { echo "0";}?>';
				$("delai_reglement_fdm").checked = true;
				// version 2.051
				$("def_delai_reglement").value = '<?php if (isset($liste_categorie_client->delai_reglement)) { echo substr($liste_categorie_client->delai_reglement, 0, strlen($liste_categorie_client->delai_reglement)-3);} else { echo "0";}?>';
				$("def_delai_reglement_fdm").checked = true;
			<?php }?>
			
			// bac 15/04/2010 version 2.051
			// facturation périodique
			$("def_facturation_periodique").value = '<?php if (isset($liste_categorie_client->facturation_periodique)) { echo $liste_categorie_client->facturation_periodique; } else { echo "0";}?>';
			preselect (<?php if (isset($liste_categorie_client->facturation_periodique)) { echo $liste_categorie_client->facturation_periodique;} else { echo "0";}?>, "facturation_periodique");
			// mode édition favori
			$("def_id_edition_mode_favori").value = '<?php if ((isset($liste_categorie_client->id_edition_mode_favori)) && ($liste_categorie_client->id_edition_mode_favori)!=0) { echo $liste_categorie_client->id_edition_mode_favori; } else { echo "0";}?>';
			preselect (<?php if (isset($liste_categorie_client->id_edition_mode_favori)) { echo $liste_categorie_client->id_edition_mode_favori;} else { echo "0";}?>, "id_edition_mode_favori");
			// delai de règlement défini plus haut
			// règlement favori
			<?php $premier_mode_reglement= null; $modes_reglement = getReglements_modes(); foreach ($modes_reglement as $mode_reglement){$premier_mode_reglement = $mode_reglement->id_reglement_mode; break;}?>
			preselect (<?php if (isset($liste_categorie_client->id_reglement_mode_favori)) { echo $liste_categorie_client->id_reglement_mode_favori;} else { echo "0";}?>, "id_reglement_mode_favori");
			$("def_id_reglement_mode_favori").value = '<?php if (isset($liste_categorie_client->id_reglement_mode_favori)) { echo $liste_categorie_client->id_reglement_mode_favori; } else { echo "0";}?>';
			// Cycle de relance
			<?php $premier_cycle_relance= 0; ?>
			preselect (<?php if (isset($liste_categorie_client->id_relance_modele)) { echo $liste_categorie_client->id_relance_modele;} else { echo $premier_cycle_relance;}?>, "id_cycle_relance");
			$("def_id_cycle_relance").value = '<?php if (isset($liste_categorie_client->id_relance_modele)) { echo $liste_categorie_client->id_relance_modele; } else { echo $premier_cycle_relance;}?>';
			// encours
			$("encours").value = '<?php if (isset($liste_categorie_client->defaut_encours)) { echo $liste_categorie_client->defaut_encours;} else { echo "0";}?>';
			$("def_encours").value = '<?php if (isset($liste_categorie_client->defaut_encours)) { echo $liste_categorie_client->defaut_encours;} else { echo "0";}?>';			
			// pré-paiement
			preselect (<?php if (isset($liste_categorie_client->prepaiement_type)) { echo "'" . $liste_categorie_client->prepaiement_type . "'";} else { echo 'Acompte';}?>, "prepaiement_type");
			$("def_prepaiement_type").value  = '<?php if (isset($liste_categorie_client->prepaiement_type)) { echo $liste_categorie_client->prepaiement_type;} else { echo 'Acompte';}?>';
			$("def_prepaiement_ratio").value = '<?php echo $liste_categorie_client->prepaiement_ratio?>';
			// grille tarifaire
			$('def_id_tarif').value = <?php if (isset($liste_categorie_client->id_tarif)) { echo $liste_categorie_client->id_tarif;} else { echo "0";}?>;

			/// 2.0.54.0 liste des valeurs de schamps de la page annuaire client rechargée car on a change de categorie client.
			// les valeurs de retour sont remplies 
			$("retour_value_facturation_periodique").value 		= $("def_facturation_periodique").value;
			$('retour_value_id_edition_mode_favori').value 		= $('def_id_edition_mode_favori').value;
			$('retour_value_delai_reglement').value 			= $('def_delai_reglement').value;
			$('retour_value_delai_reglement_fdm').checked		= $('def_delai_reglement_fdm').checked;
			$("retour_value_id_reglement_mode_favori").value 	= $("def_id_reglement_mode_favori").value;
			$('retour_value_id_cycle_relance').value 	= $('def_id_cycle_relance').value;
			$('retour_value_encours').value 					= $('def_encours').value;
			$('retour_value_prepaiement_type').value 			= $('def_prepaiement_type').value;
			$('retour_value_prepaiement_ratio').value 			= $('def_prepaiement_ratio').value;
			$('retour_value_id_tarif').value 					= $('def_id_tarif').value;
			$('retour_value_app_tarifs').value 					= $('def_app_tarifs').value;
			
		<?php }
	}?>
</script>
