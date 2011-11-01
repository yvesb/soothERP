<?php

// *************************************************************************************************************
// ACCUEIL DU PROFIL COLLAB
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

//******************************************************************
// Variables communes d'affichage
//******************************************************************


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

$Udate_now = time();
?>

<div id="pop_up_selection_agendas" class="pop_up_selection_agendas" style="display:none">
</div>

<div id="pop_up_selection_types_events" class="pop_up_selection_types_events" style="display:none">
</div>

<script type="text/javascript">
//DECLARATION DES VARIABLES GLOBALES
	scale_used = "semaine";
	autoUpdate = false;
	Udate_used = (new Date()).getTime();
	event_DUREE_DEFAUT = <?php echo $event_DUREE_DEFAUT?>;

	centrage_element("pop_up_selection_agendas");
	centrage_element("pop_up_selection_types_events");
	
	Event.observe(window, "resize", function(evt){
		centrage_element("pop_up_selection_agendas");
		centrage_element("pop_up_selection_types_events");
	});
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%" class="fond_acceuil">
	<tr height="80px" id="entete">
		<td colspan="3">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr height="27px">
					<td width="350px" rowspan="2">
					<a href="http://www.lundimatin.fr" target="_blank" rel="noreferrer"><img src="../fichiers/images/powered_by_lundimatin.png" width="120"/></a>
					</td>
					<td align="center">
						<table cellpadding="0" cellspacing="0" border="0" style="margin-top:10px;">
							<tr>
								<td class="barre_navigation_bt_precedent" id ="precedent">
									&nbsp;
								</td>
								
								<td class="barre_navigation_bt_short" id ="afficherJournee">
									Jour
								</td>
								
								<td class="barre_navigation_bt_long_selected" id ="afficherSemaine">
									Semaine
								</td>
								
								<td class="barre_navigation_bt_short" id ="afficherMois">
									Mois
								</td>
								
								<td class="barre_navigation_bt_suivant" id ="suivant">
									&nbsp;
								</td>
							</tr>
						</table>
						<script type="text/javascript">
							Event.observe("precedent", "click", function(ev) {
								Event.stop(ev);
								panneau_eition_reset_formulaire();
								switch (scale_used) {
								case "jour":{
									var d = new Date(Udate_deb_jour);
									d = new Date(d.getFullYear(), d.getMonth(), d.getDate()-1, 0, 0, 0, 0);
									page.traitecontent("agenda_jour","agenda_view_jour.php?Udate_used="+d.getTime()+"&HEURE_DE_DEPART="+$("grille_jour").scrollTop, true ,"grille_agenda");
									break;}
								case "semaine":{
									var d = new Date(Udate_deb_semaine);
									d = new Date(d.getFullYear(), d.getMonth(), d.getDate()-7, 0, 0, 0, 0);
									page.traitecontent("agenda_semaine","agenda_view_semaine.php?Udate_used="+d.getTime()+"&HEURE_DE_DEPART="+$("grille_semaine").scrollTop, true ,"grille_agenda");
									break;}
								case "mois":{
									var d = new Date(Udate_deb_mois);
									d = new Date(d.getFullYear(), d.getMonth()-1, 1, 0, 0, 0, 0);
									page.traitecontent("agenda_mois","agenda_view_mois.php?Udate_used="+d.getTime(), true ,"grille_agenda");
									break;}
								}
							}, false);
							
							Event.observe("afficherJournee", "click", function(ev) {
								Event.stop(ev);
								scale_used = "jour";
								page.traitecontent("agenda_jour","agenda_view_jour.php?Udate_used="+Udate_used, true ,"grille_agenda");
								$("afficherJournee").className = 	"barre_navigation_bt_short_selected";
								$("afficherSemaine").className = 	"barre_navigation_bt_long";
								$("afficherMois").className = 		"barre_navigation_bt_short";
								panneau_eition_reset_formulaire()
							}, false);
	
							Event.observe("afficherSemaine", "click", function(ev) {
								Event.stop(ev);
								scale_used = "semaine";
								var params = ""; 
								if($("grille_semaine")!=null){
									params +=	"&HEURE_DE_DEPART="+$("grille_semaine").scrollTop;
								}
								page.traitecontent("agenda_semaine","agenda_view_semaine.php?Udate_used="+Udate_used+params, true ,"grille_agenda");
								$("afficherJournee").className = 	"barre_navigation_bt_short";
								$("afficherSemaine").className = 	"barre_navigation_bt_long_selected";
								$("afficherMois").className = 		"barre_navigation_bt_short";
								panneau_eition_reset_formulaire()
							}, false);
	
							Event.observe("afficherMois", "click", function(ev) {
								Event.stop(ev);
								scale_used = "mois";
								page.traitecontent("agenda_mois","agenda_view_mois.php?Udate_used="+Udate_used, true ,"grille_agenda");
								$("afficherJournee").className = 	"barre_navigation_bt_short";
								$("afficherSemaine").className = 	"barre_navigation_bt_long";
								$("afficherMois").className = 		"barre_navigation_bt_short_selected";
								panneau_eition_reset_formulaire()
							}, false);
							
							Event.observe("suivant", "click", function(ev) {
								Event.stop(ev);
								panneau_eition_reset_formulaire();
								switch (scale_used) {
								case "jour":{
									var d = new Date(Udate_deb_jour);
									d = new Date(d.getFullYear(), d.getMonth(), d.getDate()+1, 0, 0, 0, 0);
									page.traitecontent("agenda_jour","agenda_view_jour.php?Udate_used="+d.getTime()+"&HEURE_DE_DEPART="+$("grille_jour").scrollTop, true ,"grille_agenda");
									break;}
								case "semaine":{
									var d = new Date(Udate_deb_semaine);
									d = new Date(d.getFullYear(), d.getMonth(), d.getDate()+7, 0, 0, 0, 0);
									page.traitecontent("agenda_semaine","agenda_view_semaine.php?Udate_used="+d.getTime()+"&HEURE_DE_DEPART="+$("grille_semaine").scrollTop, true ,"grille_agenda");
									break;}
								case "mois":{
									var d = new Date(Udate_deb_mois);
									d = new Date(d.getFullYear(), d.getMonth()+1, 1, 0, 0, 0, 0);
									page.traitecontent("agenda_mois","agenda_view_mois.php?Udate_used="+d.getTime(), true ,"grille_agenda");
									break;}
								}
								//alert(tmpUdate);
							}, false);
						</script>
					</td>
					<td width="350px" rowspan="2">
						<table border="0" cellpadding="0px" cellspacing="4px" style="margin-top:8px; margin-right:8px; vertical-align:middle;" align="right">
							<tr height="24px">
								<td></td>
								<td width="182px" style="background-image : url('<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/input_rech.gif');
									background-repeat:no-repeat;vertical-align:middle;" align="center">
									<input id="rechercher_agenda" type="text" style="border:0; width:176px; text-align:right;" />	
								</td>
								<td>
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/search.gif" alt="Rechercher" title="Rechercher" id="bt_rechercher" />
								</td>
								<td>
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/bt_actualiser.gif" 	alt="Actualiser" title="Actualiser" id="refresh_content" />
								</td>
								<td>
									<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/bt-fermer_grand.gif" 	alt="Fermer" title="Fermer" id="bt_fermer" />
								</td>
							</tr>
						</table>
						<script type="text/javascript">
							//bouton refresh
							Event.observe('refresh_content', 'click',  function(evt){
									Event.stop(evt);
									refresh_sub_content();
									return_to_page = "";
								}, false);
							Event.observe('refresh_content_alert_onException', 'click',  function(evt){
									Event.stop(evt);
									refresh_sub_content();
									$("alert_pop_up").style.display = "none";
									$("framealert").style.display = "none";
									$("alert_onException").style.display = "none";
									return_to_page = "";
								}, false);
							Event.observe('norefresh_content_alert_onException', 'click',  function(evt){
									Event.stop(evt);
									$("alert_pop_up").style.display = "none";
									$("framealert").style.display = "none";
									$("alert_onException").style.display = "none";
								}, false);
							
							Event.observe("bt_fermer", "click", function(ev) {
								Event.stop(ev);
								window.close();
							}, false);
							
							Event.observe("bt_rechercher", "click", function(ev) {
								/*Event.stop(ev);
								alert("recherche : "+$("rechercher_agenda").value);
								$("rechercher_agenda").value = "";*/
								$("titre_alert").innerHTML = "Avertissement :";
								$("texte_alert").innerHTML = "Fonctionalité non disponible <br />";

								$("bouton_alert").innerHTML = "<input type=\"submit\" id=\"bouton0\" name=\"bouton0\" value=\"OK\" />";
								show_pop_alerte();			
								$("bouton0").focus();
								
								$("bouton0").onclick= function () {
									hide_pop_alerte ();
								}
													
							}, false);
						</script>
						<div style="margin-top:8px; margin-right:12px; vertical-align:middle; color:#565565; font-weight:bolder; font-size: 9pt" align="right">
						Utilisateur connecté : <?php echo $_SESSION['user']->getContactName (); ?>
						</div>
					</td>
				</tr>
				<tr height="43px" valign="middle">
					<td align="center" style="vertical-align:middle;">
						<div id="RetourAujourdhui" class="horloge" >
							
						</div>
						<script type="text/javascript">
									Event.observe("RetourAujourdhui", "click", function(ev) {
										Event.stop(ev);
										Udate_used = (new Date()).getTime();
										switch (scale_used) {
											case "jour":{
												page.traitecontent("agenda_jour","agenda_view_jour.php?Udate_used="+Udate_used, true ,"grille_agenda");
												break;}
											case "semaine":{
												page.traitecontent("agenda_semaine","agenda_view_semaine.php?Udate_used="+Udate_used+"&HEURE_DE_DEPART="+$("grille_semaine").scrollTop, true ,"grille_agenda");
												break;}
											case "mois":{
												page.traitecontent("agenda_mois","agenda_view_mois.php?Udate_used="+Udate_used, true ,"grille_agenda");
												break;}
										}
									}, false);
								</script>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr height="4px">
		<td colspan="3" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/trait_entete.gif'); background-repeat:repeat-x;"></td>
	</tr>
	<tr>
		<td width="186px" style="background-color:#d0cfdd;" id="conteneur_panneau_gauche">
			<div id="panneau_gauche" style="max-height:200px; width:100%; overflow:auto;">
				<!-- ############### -->
				<!-- PANNEAU AGENDAS -->
				<!-- ############### -->
				<table cellpadding="0" cellspacing="0" border="0" width="100%" height="20px">
					<tr>
						<td width="7px"></td>
						<td id="panneau_agendas_entete_agenda" class="panneau_agendas_titre">
							<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/gray_down.gif" style="" alt="Agendas" title="Agendas" id="develop_agendas" />
							&nbsp;Agendas
						</td>
						<?php if(Lib_interface_agenda::afficher_bt_SelectionDesAgendasAffiches()){?>
						<td width="20px" align="left" id="show_pop_up_selection_agendas">
							+
							<script type="text/javascript">
								etatPanneauAgendas = true; //affiché
								Event.observe("show_pop_up_selection_agendas", "click",  function(evt){
									Event.stop(evt);
									page.traitecontent('pop_up_selection_agendas','agenda_selectionner_agendas.php', 'true','pop_up_selection_agendas');
									$("pop_up_selection_agendas").show();
								}, false);
							</script>
						</td>
						<?php }else{ ?>
						<td width="20px"></td>
						<?php } ?>
					</tr>
				</table>
				<script type="text/javascript">
					etatPanneauAgendas = true; //affiché
					Event.observe("panneau_agendas_entete_agenda", "click", function(ev) {
						Event.stop(ev);
						if(etatPanneauAgendas){
							$("develop_agendas").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/gray_right.gif";
							$("panneau_agendas_agendas").hide();
							etatPanneauAgendas = false;
						}else{
							$("develop_agendas").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/gray_down.gif";
							$("panneau_agendas_agendas").show();
							etatPanneauAgendas = true;
						}
			 		}, false);
				</script>
				<table id="panneau_agendas_agendas" cellpadding="0" cellspacing="4px" width="100%" border="0">
					<?php
					//$agendasAvecDroits[REF_AGENDA] = array();
					//$agendasAvecDroits[REF_AGENDA]["libAgenda"] = string;
					//$agendasAvecDroits[REF_AGENDA]["affiche"] = bool;
					//$agendasAvecDroits[REF_AGENDA]["droits"] = int[];
					//$agendasAvecDroits[REF_AGENDA]["couleur1"] = string;
					//$agendasAvecDroits[REF_AGENDA]["couleur2"] = string;
					//$agendasAvecDroits[REF_AGENDA]["couleur3"] = string;
					//$agendasAvecDroits[REF_AGENDA]["id_type_agenda"] = int;
					//$agendasAvecDroits[REF_AGENDA]["lib_type_agenda"] = string;
					reset($agendasAvecDroits);
					for($i=0;$i < count($agendasAvecDroits); $i++){
						$index = key($agendasAvecDroits); 
						
						if(is_null($agendasAvecDroits[$index]["affiche"]))
						{			$display = "display:none;";}
						else{	$display = "";}
						?>
					<tr style="height:20px; vertical-align:middle; <?php echo $display; ?>" id="panneau_agendas_agenda_ligne_<?php echo $index;?>">
						<td style="width:2px"></td>
						<td id="panneau_agendas_agenda_cell_mini_<?php echo $index;?>" 	class="panneau_agendas_cell_mini" 	style="width:7px; background-color:<?php echo $agendasAvecDroits[$index]["couleur1"]; ?>;">&nbsp;</td>
						<td id="panneau_agendas_agenda_cell_<?php echo $index;?>" 			class="panneau_agendas_cell">
							<?php if(!is_null($agendasAvecDroits[$index]["affiche"]) && $agendasAvecDroits[$index]["affiche"] == 0){ ?>
							<span id="panneau_agendas_agenda_cell_text_<?php echo $index;?>" class="panneau_agendas_disable_text"><?php echo $agendasAvecDroits[$index]["libAgenda"]; ?></span>
							<?php }else{?>
							<span id="panneau_agendas_agenda_cell_text_<?php echo $index;?>" class="panneau_agendas_enable_text" ><?php echo $agendasAvecDroits[$index]["libAgenda"]; ?></span>
							<?php }?>
						</td>
						<td style="width:2px">
							<script type="text/javascript">
								Event.observe("panneau_agendas_agenda_cell_mini_<?php echo $index;?>", "click",  function(evt){
									Event.stop(evt);
									if($("panneau_agendas_agenda_cell_text_<?php echo $index;?>").className == "panneau_agendas_enable_text"){
										majAgendasUsersAgendasAffichage("<?php echo $_SESSION['user']->getRef_user();?>", "<?php echo $index;?>", 0, "page_accueil_fct_retour_afficher_agenda('panneau_agendas_agenda_cell_text_<?php echo $index;?>',false && maj,'<?php echo $index;?>');");
									}else{
										majAgendasUsersAgendasAffichage("<?php echo $_SESSION['user']->getRef_user();?>", "<?php echo $index;?>", 1, "page_accueil_fct_retour_afficher_agenda('panneau_agendas_agenda_cell_text_<?php echo $index;?>',true && maj,'<?php echo $index;?>');");
									}
								});
								
								Event.observe("panneau_agendas_agenda_cell_<?php echo $index;?>", "click",  function(evt){
									Event.stop(evt);
									if($("panneau_agendas_agenda_cell_text_<?php echo $index;?>").className == "panneau_agendas_enable_text"){
										majAgendasUsersAgendasAffichage("<?php echo $_SESSION['user']->getRef_user();?>", "<?php echo $index;?>", 0, "page_accueil_fct_retour_afficher_agenda('panneau_agendas_agenda_cell_text_<?php echo $index;?>',false && maj,'<?php echo $index;?>');");
									}else{
										majAgendasUsersAgendasAffichage("<?php echo $_SESSION['user']->getRef_user();?>", "<?php echo $index;?>", 1, "page_accueil_fct_retour_afficher_agenda('panneau_agendas_agenda_cell_text_<?php echo $index;?>',true && maj,'<?php echo $index;?>');");
									}
								});
							</script>
						</td>
					</tr>
					<?php next($agendasAvecDroits);}?>
				</table>
				<!-- ################## -->
				<!-- PANNEAU EVENEMENTS -->
				<!-- ################## -->
				<?php if(Lib_interface_agenda::afficher_bt_SelectionDesAgendasAffiches()){?>
					<table cellpadding="0" cellspacing="0" border="0" width="100%" height="20px">
						<tr>
							<td width="7px"></td>
							<td id="panneau_agendas_entete_events" class="panneau_agendas_titre">
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/gray_down.gif" style="" alt="Evénements" title="Evénements" id="develop_evenements" />
								&nbsp;Evénements
							</td>
							<td width="20px" align="left" id="show_pop_up_selection_types_events">
								+
								<script type="text/javascript">
									Event.observe("show_pop_up_selection_types_events", "click",  function(evt){
										Event.stop(evt);
										page.traitecontent('show_pop_up_selection_types_events','agenda_selectionner_types_events.php', 'true','pop_up_selection_types_events');
										$("pop_up_selection_types_events").show();
									}, false);
								</script>
							</td>
						</tr>
					</table>
					<script type="text/javascript">
						etatPanneauAgendasEvenements = true; //affiché
						Event.observe("panneau_agendas_entete_events", "click", function(ev) {
							Event.stop(ev);
							if(etatPanneauAgendasEvenements){
								$("develop_evenements").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/gray_right.gif";
								$("panneau_agendas_types_events").hide();
								etatPanneauAgendasEvenements = false;
							}else{
								$("develop_evenements").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/gray_down.gif";
								$("panneau_agendas_types_events").show();
								etatPanneauAgendasEvenements = true;
							}
				 		}, false);
					</script>
		
					<table id="panneau_agendas_types_events" cellpadding="0" cellspacing="4px" width="100%" border="0">
						<?php
						//$eventsTypesAvecDroit[ID_TYPE_EVENT] = array();
						//$eventsTypesAvecDroit[ID_TYPE_EVENT]["libEvent"] = string;
						//$eventsTypesAvecDroit[ID_TYPE_EVENT]["affiche"] = bool;
						//$eventsTypesAvecDroit[ID_TYPE_EVENT]["droits"] = int[];
						reset($eventsTypesAvecDroit);
						for($i=0;$i < count($eventsTypesAvecDroit); $i++){
							$index = key($eventsTypesAvecDroit);
							
							if(is_null($eventsTypesAvecDroit[$index]["affiche"]))
							{			$display = "display:none;";}
							else{	$display = "";}
							?>
						<tr style="height:20px; vertical-align:middle; <?php echo $display; ?>" id="panneau_agendas_types_events_ligne_<?php echo $index;?>">
							<td style="width:2px"></td>
							<td id="panneau_agendas_event_cell_<?php echo $index;?>" class="panneau_agendas_cell">
								<?php if(!is_null($eventsTypesAvecDroit[$index]["affiche"]) && $eventsTypesAvecDroit[$index]["affiche"] == 0){ ?>	
								<span id="panneau_agendas_event_type_cell_text_<?php echo $index;?>" class="panneau_agendas_disable_text"><?php echo $eventsTypesAvecDroit[$index]["libEvent"]; ?></span>
								<?php }else{?>
								<span id="panneau_agendas_event_type_cell_text_<?php echo $index;?>" class="panneau_agendas_enable_text" ><?php echo $eventsTypesAvecDroit[$index]["libEvent"]; ?></span>
								<?php }?>
							</td>
							<td style="width:2px">
								<script type="text/javascript">
									Event.observe("panneau_agendas_event_cell_<?php echo $index;?>", "click",  function(evt){
										Event.stop(evt);
										if($("panneau_agendas_event_type_cell_text_<?php echo $index;?>").className == "panneau_agendas_enable_text"){
											majAgendasUsersEventsTypesAffichage("<?php echo $_SESSION['user']->getRef_user();?>", "<?php echo $index;?>", 0, "page_accueil_fct_retour_afficher_events_types('panneau_agendas_event_type_cell_text_<?php echo $index;?>',false && maj,<?php echo $index;?>);");
										}else{
											majAgendasUsersEventsTypesAffichage("<?php echo $_SESSION['user']->getRef_user();?>", "<?php echo $index;?>", 1, "page_accueil_fct_retour_afficher_events_types('panneau_agendas_event_type_cell_text_<?php echo $index;?>',true && maj,<?php echo $index;?>);");
										}
									}, false);
								</script>
							</td>
						</tr>
						<?php next($eventsTypesAvecDroit);}?>
					</table>
				<?php } ?>
			</div>
  	</td>
		
		
		<!-- GRILLE de l'agenda-->
		<!-- JOUR ou SEMAINE ou MOIS -->
		<td rowspan="2">
			<div id="grille_agenda" style="width:100%; -moz-user-select:none; overflow:hidden" ></div>
			<script type="text/javascript">
				$("grille_agenda").style.maxHeight = (getWindowHeight()-185)+"px";
				switch (scale_used) {
					case "jour":{
						page.traitecontent("agenda_jour","agenda_view_jour.php?Udate_used="+Udate_used, true ,"grille_agenda");
					break;}
					case "mois":{
						page.traitecontent("agenda_mois","agenda_view_mois.php?Udate_used="+Udate_used, true ,"grille_agenda");
					break;}
					default:{ // donc semaine
						page.traitecontent("agenda_semaine","agenda_view_semaine.php?Udate_used="+Udate_used, true ,"grille_agenda");
					break;}
				}
			</script>
		</td>
		<td rowspan="2" width="207px" style="background-color: white;" >

			<div style="width:100%; height:20px; background-color:#9695a5"></div>
			
			<div align="center" style="padding-top:7px; padding-left:15px; padding-right: 15px; padding-left:15px; display:none; max-height:50%; overflow:auto;" id="panneau_event_edition">
			<?php $selectOptionsAgenda =  Lib_interface_agenda::buildSelectOptionsAgenda($agendasAvecDroits,$droitsUserAgendas);?>
				<!-- ---------------------------------------- -->
				<div id="panneau_event_edit_part_evenement" style="display:none;">
					<div	class="panneau_edition_event_titre" style="display:none;">Evénement</div>
					<div class="" style="height:10px"></div>
					<!--div 	class="panneau_edition_event_separateur" style="height:10px"></div>
					<textarea id="evt_edition_lib" name="evt_edition_lib" cols="15" rows="1" style="width: 97%;" ></textarea -->
					<input type="hidden" id="evt_edition_lib" />
					<!--div 	class="" style="height:20px"></div-->
				</div>
				<!-- ---------------------------------------- -->
				<div id="panneau_event_edit_part_agenda" style="">	
					<div 	class="panneau_edition_event_titre2">Agenda</div>
					<input type="hidden" id="evt_edition_agenda_old" value="" />
					<select id="evt_edition_agenda_selected" class="edition_event" name="evt_edition_agenda_selected" style="width:100%">
					<?php echo $selectOptionsAgenda;?>
					</select>
					<div class="" style="height:10px"></div>
					<div class="panneau_edition_event_separateur" style="height:7px"></div>
					<?php //<input type="text" id="evt_edition_lib" class="edition_event" style="width:97%;" value = ""/> ?>
					<div id="panneau_event_formulaire_type" name="panneau_event_formulaire_type"></div>
					<div 	class="" style="height:7px"></div>
					<div class="panneau_edition_event_separateur" style="height:7px"></div>
				</div>
				<script type="text/javascript">
					onload = majSelect_type_formulaire($("evt_edition_agenda_selected").options[$("evt_edition_agenda_selected").selectedIndex].value, $("panneau_event_formulaire_type"));
					Event.observe("evt_edition_agenda_selected", "change",  function(evt){
						Event.stop(evt);
						text_to_save = $("evt_edition_lib2").value;
						//majSelect_Options_events_types($("evt_edition_agenda_selected").options[$("evt_edition_agenda_selected").selectedIndex].value, $("evt_edition_type_event_selected"));
						majSelect_Options_events_types($("evt_edition_agenda_selected").selectedIndex, $("evt_edition_agenda_selected").options[$("evt_edition_agenda_selected").selectedIndex].value, $("evt_edition_type_event_selected"));
						majSelect_type_formulaire($("evt_edition_agenda_selected").options[$("evt_edition_agenda_selected").selectedIndex].value, $("panneau_event_formulaire_type"));
						$("evt_edition_lib2").value = text_to_save;
					}, false);
				</script>
				<!-- ---------------------------------------- -->
				<div style="display:none;">
					<div id="panneau_event_edit_part_type_event" style="display:none;">	
						<div 	class="panneau_edition_event_titre2">Type d'événement</div>
						<input type="hidden" id="evt_edition_type_event_old" value="" />
						<select id="evt_edition_type_event_selected" name="evt_edition_type_event_selected" class="edition_event" style="width:100%"></select>
						<div class="" style="height:20px"></div>
					</div>
				</div>
				<!-- ---------------------------------------- -->
				<!-- ---------------------------------------- -->
				<?php /*
				<div id="panneau_event_edit_part_agenda_new_event">	
					<div 	class="panneau_edition_event_titre2">Agenda</div>
					<select id="evt_edition_agenda_selected_new_event" name="evt_edition_agenda_selected_new_event" class="edition_event"  style="width:100%">
					<?php echo $selectOptionsAgenda;?>
					</select>
					<div class="" style="height:20px"></div>
				</div>
				<script type="text/javascript">
					Event.observe("evt_edition_agenda_selected_new_event", "change",  function(evt){
						Event.stop(evt);
						var droitsCibles = [700, 9999];
						//majSelect_Options_events_types($("evt_edition_agenda_selected_new_event").options[$("evt_edition_agenda_selected_new_event").selectedIndex].value, $("evt_edition_type_event_selected_new_event"), droitsCibles);
						majSelect_Options_events_types($("evt_edition_agenda_selected").selectedIndex, $("evt_edition_agenda_selected_new_event").options[$("evt_edition_agenda_selected_new_event").selectedIndex].value, $("evt_edition_type_event_selected_new_event"), droitsCibles);
					}, false);
				</script>
				<!-- ---------------------------------------- -->
				<div id="panneau_event_edit_part_type_event_new_event">	
					<div class="panneau_edition_event_titre2">Type d'événement</div>
					<select id="evt_edition_type_event_selected_new_event" name="evt_edition_type_event_selected_new_event" class="edition_event" style="width:100%">
						<?php reset($agendasAvecDroits);
						for ($i = 0; $i< count($agendasAvecDroits); $i++){
							$index = key($agendasAvecDroits);
							$eventsTypesAvecDroits = $_SESSION["agenda"]["GestionnaireEvenements"]->getEventsTypesAvecDroits($agendasAvecDroits[$index]["id_type_agenda"]);
							if(count($eventsTypesAvecDroits) > 0){
								echo Lib_interface_agenda::buildSelectOptionsEventType($eventsTypesAvecDroits);
								unset($eventsTypesAvecDroits);
								break;
							}
							next($agendasAvecDroits);
						}?>
					</select>
					<div class="" style="height:20px"></div>
				</div>
			</div>
			*/ ?>
			<!-- ---------------------------------------- -->
			<div id="panneau_event_edit_part_dates_titre" class="panneau_edition_event_titre2">Planification</div>
			<div id="panneau_event_edit_part_dates">	
				<div class="panneau_edition_event_ligne" style="display:none;">
					<input type="checkbox" id="evt_edition_toute_la_journee" name="evt_edition_toute_la_journee" />&nbsp;Toute la journée
				</div>
				<table cellpadding="4px" cellspacing="0">
					<tr>
						<td width="15 px;" style="text-align:left; vertical-align:middle;">le</td>
						<td colspan="3">
							<input type="text" id="evt_edition_date_deb"  name="evt_edition_date_deb"  class="edition_event" style="width:68px; padding-left:16px; padding-right:16px;" maxlength="10" value="" /><?php strftime("%d/%m/%Y", time()); ?>
						</td>
					</tr>
					<tr>
						<td style="text-align:left; vertical-align:middle;">de</td>
						<td align="left">
							<input type="text" id="evt_edition_heure_deb" name="evt_edition_heure_deb" class="edition_event" style="width:32px; padding-left:2px; padding-right:2px;" maxlength="5"  value="" /><?php strftime("%H:%M", time()); ?>
						</td>
						<td style="text-align:center; vertical-align:middle;">à</td>
						<td align="right">
							<input type="text" id="evt_edition_heure_fin" name="evt_edition_heure_fin" class="edition_event" style="width:32px; padding-left:2px; padding-right:2px;" maxlength="5"  value="" /><?php strftime("%H:%M", time()+$event_duree_moyenne); ?>
						</td>
					</tr>
				</table>
				<script type="text/javascript">
				evt_edition_heure_deb = Number.NaN;// en milliseconds
				evt_edition_heure_fin = Number.NaN;// en milliseconds
				
				Event.observe("evt_edition_date_deb", "blur", function(ev) {
					$("evt_edition_date_fin").value = $F("evt_edition_date_deb");
				}, false);

				
				

				Event.observe("evt_edition_heure_deb", "focus", function(ev) {
					evt_edition_heure_deb = getHeure($F("evt_edition_heure_deb"));
				}, false);
				
				Event.observe("evt_edition_heure_deb", "blur", function(ev) {
					var str_heure = $F("evt_edition_heure_deb");
					var new_evt_edition_heure_deb = getHeure(str_heure);
							evt_edition_heure_fin = getHeure($F("evt_edition_heure_fin"));
					if(!isNaN(evt_edition_heure_deb) && !isNaN(new_evt_edition_heure_deb) && !isNaN(evt_edition_heure_fin) && evt_edition_heure_fin > evt_edition_heure_deb){
						evt_edition_heure_fin = (evt_edition_heure_fin - evt_edition_heure_deb) + new_evt_edition_heure_deb;
						var regex_heure_separateur = new RegExp("[\-hH\:]","g");
						var separateur = regex_heure_separateur.exec(str_heure);

						var heure_fin = new Date(evt_edition_heure_fin);
						$("evt_edition_heure_fin").value = buildStrTime(heure_fin.getHours(), separateur, heure_fin.getMinutes());
					}
				}, false);

				</script>
				
				<?php 
//					<div class="panneau_edition_event_ligne_date"></div>
//					<div 	class="" style="height:10px"></div>
//					<div class="panneau_edition_event_ligne_date"></div>
					?>
				<input type="text" id="evt_edition_date_fin" name="evt_edition_date_fin"  class="edition_event" style="width:66px; padding-left:2px; padding-right:2px; display:none;" maxlength="10" value="" /><?php strftime("%d/%m/%Y", time()+$event_duree_moyenne); ?>
				<div class="" style="height:5px"></div>
			</div>
			<!-- ---------------------------------------- -->
			<div class="panneau_edition_event_separateur" style="height:7px"></div>
			<div id="panneau_event_edit_part_notes">	
				<div class="panneau_edition_event_titre2" >Notes</div>
				<textarea id="evt_edition_note" rows="2" style="overflow:auto; width:97%"></textarea>
				<div class="" style="height:20px"></div>
			</div>
			<!-- ---------------------------------------- -->
			
			<input type="button" id="AnnulerEvent" 		name="AnnulerEvent" 	value="Annuler" 			style="display:none; max-width:50%;" />
			<input type="button" id="ValiderEvent" 		name="ValiderEvent" 	value="Valider" 			style="display:none; max-width:50%;" />
			<input type="button" id="SupprimerEvent" 	name="SupprimerEvent" value="Supprimer" 		style="display:none; max-width:50%;" />
			<input type="button" id="MajEvent" 				name="MajEvent" 			value="Modifier"			style="display:none; max-width:50%;" />
			<input type="button" id="SaveNewEvent" 		name="SaveNewEvent" 	value="Sauvegarder" 	style="display:none; max-width:50%;" />
			
			
			<div 	class="" style="height:10px"></div>
			
			<!-- <input type="button" id="NouveauEvent" 		name="NouveauEvent" 	value=" + " 					style="display:none;" /> -->
			<?php 
			// les boutons AnnulerEvent ValiderEvent SupprimerEvent MajEvent et NouveauEvent sont masqués/démasqués dans
			// _agenda.js > panneau_eition_reset_formulaire();
			// page_agenda_view_panneau_edition.inc.php
			
			?>
			
			<script type="text/javascript">

				panneau_eition_reset_formulaire();
				
				panneau_deition_modes = { none:"0" , creation:"1", edition:"2"};
				$("panneau_deition_curent_mode").value = panneau_deition_modes.none;

				panneauGaucheAddListener($("evt_edition_lib", "evt_edition_agenda_selected", "evt_edition_type_event_selected", "evt_edition_type_event_selected", "evt_edition_toute_la_journee"));
				panneauGaucheAddListener($$("input.edition_event"));
				
				Event.observe("AnnulerEvent", "click", function(ev) {
					Event.stop(ev);
					AnnulerEvent(scale_used);
				}, false);
				
				Event.observe("ValiderEvent", "click", function(ev) {
					Event.stop(ev);
					if($("evt_edition_qte"))
					{				
						$("evt_edition_lib2").value = "Location  x"+ $("evt_edition_qte").value;
						ValiderEventLocation(scale_used);
					}
					else
						ValiderEvent(scale_used);
				}, false);

				Event.observe("SaveNewEvent", "click", function(ev) {
					Event.stop(ev);
					SaveNewEvent(scale_used);
				}, false);
				
				Event.observe("MajEvent", "click", function(ev) {
					Event.stop(ev);
					if($("evt_edition_qte"))
					{				
						$("evt_edition_lib2").value = "Location  x"+ $("evt_edition_qte").value;
						MajEventLocation(scale_used);
					}
					else
						MajEvent(scale_used);
			 }, false);
			</script>
				
			<script type="text/javascript">
				Event.observe("SupprimerEvent", "click", function(ev) {
					Event.stop(ev);
					DelEvent(scale_used);
				}, false);
			</script>
			<input type="hidden" id="panneau_deition_curent_mode" value="0" />
			<input type="hidden" id="ref_event" value="" />
			<input type="hidden" id="id_graphic_event" value="" />
			</div>
		</td>
	</tr>
	<tr height="100px" style="max-height: 190px; ">
		<td height="190px" style="max-height: 190px;">
			<div align="center" id="conteneur_mini_calendar">
							<div style="display:none;">
								Transformer un Timestamp en date<br/>
								<input type="text" id="WhatDateIsIt" name="WhatDateIsIt" value="" />
								<script type="text/javascript">
									Event.observe("WhatDateIsIt", "blur", function(ev) {
										Event.stop(ev);
										if($("WhatDateIsIt").value != ""){
											var d = new Date();
											d.setTime(parseInt($("WhatDateIsIt").value)*1000);
											alert(d);
										}
									}, false);
								</script>
								<br/>
								Udate_used<br/>
								<input type="text" id="Udate_used" name="Udate_used" value="<?php echo time(); ?>"/>
							</div>
				<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" >
					<tr><td>&nbsp;</td></tr>
					<tr height="150px">
						<td align="center" id="mini_calendrier"></td>
  				</tr>
  				<tr height="16px"><td>&nbsp;</td></tr>
				</table>
				<script type="text/javascript">
					page.traitecontent("mini_calendrier", "mini_calendrier.php?Udate_mini_calendrier=<?php echo $Udate_now;?>000", true ,"mini_calendrier");
				</script>
  		</div>
  	</td>
	</tr>
	<tr height="4px">
		<td colspan="3" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/trait_entete.gif'); background-repeat:repeat-x;"></td>
	</tr>
	<tr height="75px" id="pied_de_page">
		<td colspan="3" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/pied_de_page_agenda.gif'); background-repeat:repeat-x;"></td>
	</tr>
</table>


<script type="text/javascript">
	Event.observe(window, "resize", function() { resizeMaxHeight(); }, false);
</script>

<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>
