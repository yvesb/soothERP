<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("Udate_used", "Udate_deb_jour", "Udate_now", "eventsGrilleAvecDroit", "gride_is_locked");
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
//86400  = 1 jour = 60s * 60m * 24h
//604800 = 7 jours
//2419200 = 4*7 jours = 1 mois
if($Udate_deb_jour <= $Udate_now && ($Udate_deb_jour+86400) > $Udate_now)
{			$colonne_coloree = true;}
else{	$colonne_coloree = false;}
?>

<script type="text/javascript">
	// ASSOCIATION DES EVENEMENTS SOURIS AUX FONCTIONS
	document.onmousemove = mouseMoveJour;
	document.onmouseup   = mouseUpJour;
	document.onmousedown = mouseDownJour;

	$("RetourAujourdhui").innerHTML = "<?php echo ucwords(lmb_strftime("%d %B %Y", $INFO_LOCALE, $Udate_deb_jour)); ?>";
</script>

<script type="text/javascript">
//DECLARATION DES VARIABLES GLOBALES
	scale_used = "jour";

	HEURE_DE_DEPART = <?php 		echo $_SESSION["agenda"]["vision_jour"]["HEURE_DE_DEPART"]; ?>;
	HAUTEUR_DEMIE_HEURE = <?php echo $_SESSION["agenda"]["vision_jour"]["HAUTEUR_DEMIE_HEURE"]; ?>;

	Udate_deb_jour = <?php echo $Udate_deb_jour; ?>000;
	
	iMouseDown  = false;
	mousePos = null;
	beginMousePos = null;
	action = "";
	
	evenementUsed = null;
	target = null;

	matriceDemieHeure = new Array();
	matriceDemieHeure.push(new Array());
	for(h = 0; h<48; h++)
	{		matriceDemieHeure[0].push(new Array());}
	
	evenements = new Array();
	autoUpdate = false;
	
	<?php if($gride_is_locked){ ?>
	gride_is_locked = true;
	<?php }else{ ?>
	gride_is_locked = false;	
	<?php } ?>
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="grille_grand_conteneur">
	<tr height="20px">
		<td width="100px"></td>
		<td class="grille_titre_colonne">
			<?php echo ucwords(lmb_strftime('%A %d %B %Y', $INFO_LOCALE , $Udate_deb_jour)); ?>
		</td>
		<td width="15px"></td>
	</tr>
	<tr>
		<td></td>
		<td colspan="3" class="grille_conteneur_EventsEtendus">
			<table id="Evenements_etendus" ></table>
		</td>
		<td></td>
	</tr>
	<tr>
		<td colspan="9">
			<div id="grille_jour" style="overflow:auto; width:100%; max-height:50%">
				<script type="text/javascript">
					var grille_jour = $("grille_jour");
					grille_jour.style.maxHeight = (getWindowHeight()-185)+"px";
					grille_jour.scrollTop = HEURE_DE_DEPART;
				</script>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="grille_colonne_heure">
					<tr>
						<td width="60px" align="right">
							<table border="0" cellpadding="0" cellspacing="0" class="grille_colonne_heure">
								<?php $switch = true;
								for($i=0; $i<48; $i++){
									if($switch){
										$heure = floor($i/2).":00";if(strlen($heure) == 4)$heure =  "0".$heure;?>
								<tr>
									<td><?php echo $heure; ?></td>
								</tr>
								<?php }else{?>
								<tr>
									<td></td>
								</tr>
								<?php }
								$switch = !$switch;
								}?>
							</table>
						</td>
						<td>
							<table id="grilleDemieHeure" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td id="gride_0_0" class="grille_colonne_jour_deb_heure<?php if($colonne_coloree) echo '_TODAY'?>">
										<div id="ZEROjour"></div>
									</td>
								</tr>
								<?php $switch = false;
								for($i=1; $i<(48); $i++){
									if($switch){?>
								<tr height="<?php echo $_SESSION["agenda"]["vision_semaine"]["HAUTEUR_DEMIE_HEURE"];?>px">
									<td id="<?php echo "gride_".$i."_0";?>" class="grille_colonne_jour_deb_heure<?php if($colonne_coloree) echo '_TODAY'?>"></td>
								</tr>
								<?php }else{ ?>
								<tr height="<?php echo $_SESSION["agenda"]["vision_semaine"]["HAUTEUR_DEMIE_HEURE"];?>px">
									<td id="<?php echo "gride_".$i."_0";?>" class="grille_colonne_jour_fin_heure<?php if($colonne_coloree) echo '_TODAY'?>"></td>
								</tr>
								<?php }
								$switch = !$switch;
								}?>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>

<script type="text/javascript">
var id;
var table;
var tr;
var td;
var cellJourDeb;

<?php /*
reset($events_etendus);
for($i = 0; $i < count($events_etendus); $i++){
	$index = key($events_etendus);
	
	$j = strftime("%w", $events_etendus[$index]->getUdate_event() );
	if($j == "0"){ echo "cellJourDeb = 6;";} else {echo "var cellJourDeb = ".($j-1).";";}
	$j = strftime("%w", $events_etendus[$index]->getUdate_event() + $events_etendus[$index]->getDuree_event());
	if($j == "0"){ echo "cellJourFin = 6;";} else {echo "var cellJourFin = ".($j-1).";";} ?>
	
	id = genIdGraphicEvent();
	table = $("Evenements_etendus");

	tr = document.createElement("tr");
	tr.setAttribute("id", "Evenements_etendus_TR_"+id);
	tr.className = "Evenements_etendus_TR";
	table.appendChild(tr);
	
	if(cellJourDeb >= 1){
		td = document.createElement("td");
		td.setAttribute("id", "Evenements_etendus_TD_avantEV_"+id);
		td.className = "Evenements_etendus_TD_VIDE";
		td.setAttribute("colspan", cellJourDeb);
		td.innerHTML = "&nbsp;";
		td.setAttribute("width", (cellJourDeb*14)+"%");
		tr.appendChild(td);
	}

	td = document.createElement("td");
	td.setAttribute("id", "Evenements_etendus_TD_EV_"+id);
	td.className = "Evenements_etendus_TD_EV";
	td.setAttribute("colspan", "" + (cellJourFin - cellJourDeb +1) );
	td.setAttribute("width", ((cellJourFin - cellJourDeb +1)*14)+"%");
	td.style.backgroundColor = "<?php $agenda =& $events_etendus[$index]->getAgenda(); echo $agenda->getCouleur_1(); ?>";
	td.innerHTML = "<?php echo $events_etendus[$index]->getLib_event(); ?>";
	tr.appendChild(td);
	
	if(cellJourFin <= 5){
		td = document.createElement("td");
		td.setAttribute("id", "Evenements_etendus_TD_apresEV_"+id);
		td.className = "Evenements_etendus_TD_VIDE";
		td.setAttribute("colspan", "" + (6 - cellJourFin) );
		td.setAttribute("width", ((6 - cellJourFin)*14)+"%");
		td.innerHTML = "&nbsp;";
		tr.appendChild(td);
	}
<?php next($events_etendus);
} 
*/
?>

var eventNode;
var event_x; 
var event_y;
var event;
var duree = 0;
var coords = getCoordsOnGride($("ZEROjour").parentNode);






<?php echo $_SESSION["agenda"]["GestionnaireAgendas"]->getJAVASCRIPTagendasPermissions("var", "agendasPermissions"); ?>


var typesEventsPermissions = new Object();
<?php 
$typesEventsPermissions = $_SESSION["agenda"]["GestionnaireEvenements"]->getDroitsTypesEvents();
reset($typesEventsPermissions);
for($i = 0; $i < count($typesEventsPermissions); $i++){
	$index = key($typesEventsPermissions);
	echo "typesEventsPermissions[".$index."] = ".$typesEventsPermissions[$index].";";
	next($typesEventsPermissions);
} ?>
gestionnaireEvent = new_GestionnaireEvenement(agendasPermissions, typesEventsPermissions);

<?php reset($eventsGrilleAvecDroit);
for($i = 0; $i < count($eventsGrilleAvecDroit); $i++){
	$index = key($eventsGrilleAvecDroit); 
		$refAgenda = $eventsGrilleAvecDroit[$index]->getRef_agenda($_SESSION["agenda"]["GestionnaireEvenements"]);
		$typeEvent = $eventsGrilleAvecDroit[$index]->getId_type_event	($_SESSION["agenda"]["GestionnaireEvenements"]);
		
		if(isset($droitsUserAgendas[$refAgenda][1])){$droitvisu = $droitsUserAgendas[$refAgenda][1];} else{$droitvisu = 0;}
		if(isset($droitsUserAgendas[$refAgenda][2])){$droitDetail = $droitsUserAgendas[$refAgenda][2];} else{$droitDetail = 0;}
		if(isset($droitsUserAgendas[$refAgenda][3])){$droitModif = $droitsUserAgendas[$refAgenda][3];} else{$droitModif = 0;}

		if($droitvisu == 0){?>
		id = genIdGraphicEvent();
		event_x = 0;
		event_y = Math.floor(<?php echo strftime("(%H+%M/60)", $eventsGrilleAvecDroit[$index]->getUdate_event($_SESSION["agenda"]["GestionnaireEvenements"])); ?> * 2 * HAUTEUR_DEMIE_HEURE);
		duree = Math.floor(<?php echo $eventsGrilleAvecDroit[$index]->getDuree_event($_SESSION["agenda"]["GestionnaireEvenements"]); ?> * HAUTEUR_DEMIE_HEURE / 30);//durée en px
		eventNode = CreateDivEvenement("eventId_"+id, event_y, event_x, evenementMaxWidthJour(), duree, "");
		$("ZEROjour").appendChild(eventNode);
		
		event = new_Evenement($("grille_jour"), $("ZEROjour"), eventNode, gestionnaireEvent, <?php 
													echo $eventsGrilleAvecDroit[$index]->getId_type_agenda($_SESSION["agenda"]["GestionnaireEvenements"]).", '";
													echo $eventsGrilleAvecDroit[$index]->getRef_agenda		($_SESSION["agenda"]["GestionnaireEvenements"])."', ";
													echo $eventsGrilleAvecDroit[$index]->getId_type_event	($_SESSION["agenda"]["GestionnaireEvenements"]).", '";
													echo $eventsGrilleAvecDroit[$index]->getRef_event			($_SESSION["agenda"]["GestionnaireEvenements"])."', ";
													echo $droitDetail.", ";
													echo $droitModif;?>);
		event.setRef_Event("<?php echo $index; ?>");
		event.setColors("<?php echo $eventsGrilleAvecDroit[$index]->getCouleur_1($_SESSION["agenda"]["GestionnaireEvenements"]).'", "'.$eventsGrilleAvecDroit[$index]->getCouleur_2($_SESSION["agenda"]["GestionnaireEvenements"]).'", "'.$eventsGrilleAvecDroit[$index]->getCouleur_3($_SESSION["agenda"]["GestionnaireEvenements"]); ?>");
		event.setTitre("<?php echo strftime("%H:%M", $eventsGrilleAvecDroit[$index]->getUdate_event($_SESSION["agenda"]["GestionnaireEvenements"]))." - ".strftime("%H:%M", $eventsGrilleAvecDroit[$index]->getUdate_event($_SESSION["agenda"]["GestionnaireEvenements"])+($eventsGrilleAvecDroit[$index]->getDuree_event($_SESSION["agenda"]["GestionnaireEvenements"])*60)); ?>");
		<?php if($droitDetail == 0){?>
		if(gestionnaireEvent.getDescription(event)){
			event.setDescription("<?php echo $eventsGrilleAvecDroit[$index]->getLib_event($_SESSION["agenda"]["GestionnaireEvenements"]); ?>");
		}
		<?php }?>
		evenements[id] = event;
		event.addIntoMatrice();
<?php } next($eventsGrilleAvecDroit);
} ?>

ecarterEvenements(0);
</script>

<script type="text/javascript">

<?php 
//@TODO mettre ici le script qui met à jour le petit calendrier 
?>
</script>