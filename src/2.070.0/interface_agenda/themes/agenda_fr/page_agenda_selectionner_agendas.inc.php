<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************
   

// Variables nécessaires à l'affichage
$page_variables = array ("groupesAgendasAvecDroits");
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
$page_source = "page_source.php";
$page_cible = "page_cible.php";

?>

<!-- Bouton pour fermer la page sans sauvegarder -->
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-fermer.gif" id="close_selectionner_agendas" class="bt_fermer_popup" alt="Fermer" title="Fermer" />
<SCRIPT type="text/javascript">
	Event.observe("close_selectionner_agendas", "click", function(evt){
		$("pop_up_selection_agendas").innerHTML="";
		$("pop_up_selection_agendas").hide();
		}, false);
</script>

<div class="div_titre_popup">
	<table width="100%">
			<tr>
				<td style="width:3%"></td>
				<td style="width:94%;" class="label_titre_popup" >Sélection des agendas affichés</td>
				<td style="width:3%"></td>
			</tr>
	</table>
</div>

<br />

<div>
	<table width="100%">
		<tr>
			<td style="width:3%"></td>
			<td class="labelled_text" style="width:310px;vertical-align:middle">Sélectionner une liste d'agendas à afficher</td>
			<td align="center">
				<select id="id_liste_agenda_selected" style="width:200px">
					<option value="0" selected="selected">
						--Toutes les listes
					</option>
				<?php 
				reset($groupesAgendasAvecDroits);
				for($i=0; $i<count($groupesAgendasAvecDroits); $i++){
					$index = key($groupesAgendasAvecDroits); ?>
					<option value="<?php echo $index ?>">
						<?php echo $groupesAgendasAvecDroits[$index]; ?>
					</option>
				<?php next($groupesAgendasAvecDroits); } ?>
				</select>
				<script type="text/javascript">
					Event.observe("id_liste_agenda_selected", "change",  function(evt){
						Event.stop(evt);
						$("choix_liste_agenda").innerHTML = "";
						page.traitecontent('choix_liste_agenda','agenda_selectionner_agendas_result.php?'+
								'page_source=<?php echo $page_source;?>'+
								'&page_cible=<?php echo $page_cible;?>'+
								'&id_liste_agenda='+$("id_liste_agenda_selected").options[$("id_liste_agenda_selected").selectedIndex].value,'true','choix_liste_agenda');
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
				<td style="width:94%;" class="label_titre_popup" >Agendas disponibles</td>
				<td style="width:3%"></td>
			</tr>
		</table>
	</div>

	<br />

	<!-- C'est dans cette div que nous affichons la page pour choisir un model de pdf en fonction du type qu'on a choisi plus haut -->
	<!-- par défaut on affiche le 1er type que l'on trouve -->
	<div id="choix_liste_agenda" style="margin-left:1%; margin-right:1%; height:270px; overflow: auto" >
	<?php 
		$NoRequireFor_agenda_selectionner_agendas_result = true;
		$id_liste_agenda = 0;
		include ("agenda_selectionner_agendas_result.php");
	?>
	</div>
				
</div>
<script type="text/javascript">
	//on masque le chargement
	H_loading();
</script>