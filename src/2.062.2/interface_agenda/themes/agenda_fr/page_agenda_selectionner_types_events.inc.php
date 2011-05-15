<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************
   

// Variables nécessaires à l'affichage
$page_variables = array ("agendasTypesAvecDroit");
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
$page_source = "page_source.php";
$page_cible = "page_cible.php";

?>

<!-- Bouton pour fermer la page sans sauvegarder -->
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-fermer.gif" id="close_selectionner_types_events" class="bt_fermer_popup" alt="Fermer" title="Fermer" />
<SCRIPT type="text/javascript">
	Event.observe("close_selectionner_types_events", "click", function(evt){
		$("pop_up_selection_types_events").innerHTML="";
		$("pop_up_selection_types_events").hide();
		}, false);
</script>

<div class="div_titre_popup">
	<table width="100%">
			<tr>
				<td style="width:3%"></td>
				<td style="width:94%;" class="label_titre_popup" >Sélectionner des types d'événements affichés</td>
				<td style="width:3%"></td>
			</tr>
	</table>
</div>

<br />

<div>
	<table width="100%">
		<tr>
			<td style="width:3%"></td>
			<td class="labelled_text" style="width:310px;vertical-align:middle">Sélectionner un types d'agenda</td>
			<td align="center">
				<select id="id_liste_types_agendas_selected" style="width:200px">
				<option value="0" selected="selected">
						--Tous les types
				</option>
				<?php 
				reset($agendasTypesAvecDroit);
				for($i=0; $i<count($agendasTypesAvecDroit); $i++){
					$index = key($agendasTypesAvecDroit); ?>
					<option value="<?php echo $index ?>">
						<?php echo $agendasTypesAvecDroit[$index]; ?>
					</option>
				<?php next($agendasTypesAvecDroit); } ?>
				</select>
				<script type="text/javascript">
					Event.observe("id_liste_types_agendas_selected", "change",  function(evt){
						Event.stop(evt);
						$("choix_type_agenda").innerHTML = "";
						page.traitecontent('choix_type_agenda','agenda_selectionner_types_events_result.php?'+
								'page_source=<?php echo $page_source;?>'+
								'&page_cible=<?php echo $page_cible;?>'+
								'&id_type_agenda='+$("id_liste_types_agendas_selected").options[$("id_liste_types_agendas_selected").selectedIndex].value,'true','choix_type_agenda');
					});
				</script>
			</td>
			<td style="vertical-align:middle"><span>Tout cocher</span></td>
			<td style="width:3%"></td>
		</tr>
	</table>
	
	<br/>
	
	<div class="div_titre_popup" >
	<table width="100%">
			<tr>
				<td style="width:3%"></td>
				<td style="width:94%;" class="label_titre_popup" >Types d'événements</td>
				<td style="width:3%"></td>
			</tr>
		</table>
	</div>

	<br />

	<!-- C'est dans cette div que nous affichons la page pour choisir un model de pdf en fonction du type qu'on a choisi plus haut -->
	<!-- par défaut on affiche le 1er type que l'on trouve -->
	<div id="choix_type_agenda" style="margin-left:1%; margin-right:1%; height:270px; overflow: auto" >
	<?php 
		$NoRequireFor_agenda_selectionner_types_events_result = true;
		$id_type_agenda = 0;
		include ("agenda_selectionner_types_events_result.php");
	?>
	</div>
				
</div>
<script type="text/javascript">
	//on masque le chargement
	H_loading();
</script>