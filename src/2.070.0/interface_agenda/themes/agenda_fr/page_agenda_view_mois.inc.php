<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("Udate_used", "Udate_fdm", "Udate_ldm", "Udate_now", "joursMois", "numSemaine", "gride_is_locked");
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<script type="text/javascript">
	// ASSOCIATION DES EVENEMENTS SOURIS AUX FONCTIONS
	document.onmousemove = mouseMoveMois;
	document.onmouseup   = mouseUpMois;
	document.onmousedown = mouseDownMois;

	$("RetourAujourdhui").innerHTML = "<?php echo ucfirst(lmb_strftime("%B %Y", $INFO_LOCALE, ($Udate_fdm))); ?>";
</script>

<script type="text/javascript">
//DECLARATION DES VARIABLES GLOBALES
	scale_used = "mois";
	Udate_deb_mois = <?php echo $Udate_fdm;?>000;
</script>

<div id="grille_mois" style="overflow-y:visible; overflow-x:hidden; max-height:50%; width:100%;">
	<script type="text/javascript">
		$("grille_mois").style.maxHeight = (getWindowHeight()-185)+"px";
	</script>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<?php
		$Udate_tmp = $Udate_first_monday;
		$nbSemaineMax = count($joursMois);
		for($s = 0; $s < $nbSemaineMax; $s++){ ?>
		<tr>
			<td  class="grille_colonne_num_semaine">
				<?php echo $numSemaine; ?>		
			</td>
			
			<?php for($j = 0; $j < count($joursMois[$s]); $j++){ ?>
			<td width="14%">
				<div class="view_month_a_few_events_of_day_grand_conteneur" >
					<div class="view_month_a_few_events_of_day_titre<?php if($Udate_tmp < $Udate_fdm || $Udate_tmp > ($Udate_ldm)){echo "_out_of_month";}?>">
						<?php echo ucfirst(lmb_strftime('%a %d/%m', $INFO_LOCALE , $Udate_tmp)); ?>
					</div>
					<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%" class="view_month_a_few_events_of_day_contenu">
					<?php reset($joursMois[$s][$j]); 
					for($l = 0; $l < $_SESSION["agenda"]["vision_mois"]["NB_ENVENTS_BY_DAY"]; $l++){
						$index = key($joursMois[$s][$j]);
						while(!is_null($index) && $joursMois[$s][$j][$index]->getDuree_all_day_event()){next($joursMois[$s][$j]);}
						if(is_null($index)){ ?>
						<tr>
							<td width="30px" style="font-size:8pt;">&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<?php }else{
							$refAgenda = $joursMois[$s][$j][$index]->getRef_agenda($_SESSION["agenda"]["GestionnaireEvenements"]);
							$typeEvent = $joursMois[$s][$j][$index]->getId_type_event	($_SESSION["agenda"]["GestionnaireEvenements"]);
							
							if(isset($droitsUserAgendas[$refAgenda][1])){$droitvisu = $droitsUserAgendas[$refAgenda][1];} else{$droitvisu = 0;}
							if(isset($droitsUserAgendas[$refAgenda][2])){$droitDetail = $droitsUserAgendas[$refAgenda][2];} else{$droitDetail = 0;}
							if(isset($droitsUserAgendas[$refAgenda][3])){$droitModif = $droitsUserAgendas[$refAgenda][3];} else{$droitModif = 0;}
							?>
						<tr id="eventMois_<?php echo $joursMois[$s][$j][$index]->getRef_event($_SESSION["agenda"]["GestionnaireEvenements"]);?>" style="cursor:pointer;">
							<td width="30px" style="text-align:left; vertical-align:bottom; font-size:8pt; color:<?php echo $joursMois[$s][$j][$index]->getCouleur_1();?>" >
								<?php if($droitvisu == 0){echo strftime("%H:%M", $joursMois[$s][$j][$index]->getUdate_event($_SESSION["agenda"]["GestionnaireEvenements"]));}else{echo "&nbsp;";}?>
							</td>
							<td style="color:<?php echo $joursMois[$s][$j][$index]->getCouleur_1();?>" >
								<?php $lib_event = $joursMois[$s][$j][$index]->getLib_event($_SESSION["agenda"]["GestionnaireEvenements"]);
								if($droitDetail == 0){
								if(strlen($lib_event) > 9)
								{			echo substr($lib_event, 0, 7)."...";}
								else{	echo $lib_event;}
								} ?>
								<script type="text/javascript">
									Event.observe("eventMois_<?php echo $joursMois[$s][$j][$index]->getRef_event($_SESSION["agenda"]["GestionnaireEvenements"]);?>", "click",  function(ev){
										Event.stop(ev);
										var ref_event = "<?php echo $joursMois[$s][$j][$index]->getRef_event($_SESSION["agenda"]["GestionnaireEvenements"]);?>";
										panneau_eition_reset_formulaire();
										<?php if($droitDetail == 0){?>
										<?php if($droitModif == 0){?>
										enableContenu("panneau_event_edition");
										showOnPanel("MOIS", 0, ref_event, "", "", false);
										<?php }else{?>
										disableContenu("panneau_event_edition");
										showOnPanel("MOIS", 0, ref_event, "", "", true);
										<?php }}?>										
									}, false);
								</script>
							</td>
						</tr>
						<?php }
						next($joursMois[$s][$j]);
						} ?>
						<tr>
							<?php if(count($joursMois[$s][$j]) > $_SESSION["agenda"]["vision_mois"]["NB_ENVENTS_BY_DAY"]){?>
							<td colspan="2" align="right" >
								<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_case_plus_gris.png" id="view_all_events_<?php echo $s.'_'.$j;?>" style="cursor:pointer;" title="Voir tous les agendas" alt="Plus" />
							</td>
							<?php }else{ ?>
							<td colspan="2" align="right" id="view_all_events_<?php echo $s.'_'.$j;?>" >
								&nbsp;
							</td>
							<?php } ?>
						</tr>
					</table>
					<?php $nbEvents = count($joursMois[$s][$j]);
					if($nbEvents > $_SESSION["agenda"]["vision_mois"]["NB_ENVENTS_BY_DAY"]){ ?> 
					<div id="all_events_<?php echo $s.'_'.$j;?>" class="view_month_all_events_of_day_grand_conteneur" style="display:none; <?php echo Lib_interface_agenda::grilleMoisFenetreAllEvent_getY($s, $nbSemaineMax-1, $nbEvents).Lib_interface_agenda::grilleMoisFenetreAllEvent_getX($j);?>" >
						<div style="width:100%;">
							<div class="view_month_all_events_of_day_titre<?php if($Udate_tmp < $Udate_fdm || $Udate_tmp > ($Udate_ldm+86400)){echo "_out_of_month";}?>">
								<?php echo ucwords(lmb_strftime('%A %d %B %Y', $INFO_LOCALE , $Udate_tmp)); ?>
							</div>
						</div>
						<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%" class="view_month_all_events_of_day_contenu" >
							<?php
							reset($joursMois[$s][$j]); 
							$index = key($joursMois[$s][$j]);
							while(!is_null($index)){
								if($joursMois[$s][$j][$index]->getDuree_all_day_event())
								{		next($joursMois[$s][$j]); continue; } ?>
								<tr id="eventMoisBIS_<?php echo $joursMois[$s][$j][$index]->getRef_event($_SESSION["agenda"]["GestionnaireEvenements"]);?>" style="cursor:pointer;" >
									<td width="30px" align="left" style="font-size:8pt; vertical-align:bottom; color:<?php echo $joursMois[$s][$j][$index]->getCouleur_1();?>">
										<?php echo strftime("%H:%M", $joursMois[$s][$j][$index]->getUdate_event($_SESSION["agenda"]["GestionnaireEvenements"])); ?>&nbsp;
									</td>
									<td style="color:<?php echo $joursMois[$s][$j][$index]->getCouleur_1();?>">
										<?php echo $joursMois[$s][$j][$index]->getLib_event($_SESSION["agenda"]["GestionnaireEvenements"]); ?>
										<script type="text/javascript">
											Event.observe('eventMoisBIS_<?php echo $joursMois[$s][$j][$index]->getRef_event($_SESSION["agenda"]["GestionnaireEvenements"]);?>', 'click',  function(){
												var ref_event = "<?php echo $joursMois[$s][$j][$index]->getRef_event($_SESSION["agenda"]["GestionnaireEvenements"]);?>";
												panneau_eition_reset_formulaire();
												showOnPanel("MOIS", 0, ref_event, "", "", false);
											}, false);
										</script>
									</td>
								</tr>
							<?php
							next($joursMois[$s][$j]);
							$index = key($joursMois[$s][$j]);
							} ?>
						</table>
						<script type="text/javascript">
							Event.observe("view_all_events_<?php echo $s.'_'.$j;?>", "click", function(ev) {
								Event.stop(ev);
								var listeEventsGrandeTaille = $("all_events_<?php echo $s.'_'.$j;?>")
								if(listeEventsGrandeTaille.style.display == "none")
								{			$("all_events_<?php echo $s.'_'.$j;?>").show();}
								else{	$("all_events_<?php echo $s.'_'.$j;?>").hide();}
							}, false);
										
							Event.observe("all_events_<?php echo $s.'_'.$j;?>", "mouseover",  function(){
								$("all_events_<?php echo $s.'_'.$j;?>").show();
							}, false);

							Event.observe("all_events_<?php echo $s.'_'.$j;?>", "mouseout",  function(){
								$("all_events_<?php echo $s.'_'.$j;?>").hide();
							}, false);
						</script>
					</div>
					<?php } ?>
				</div>
			</td>												
			<?php 
				$Udate_tmp = strtotime("+1 day", $Udate_tmp);
			} ?>
		</tr>
		<?php
			$numSemaine++;
		} ?>
	</table>
</div>



<script type="text/javascript">
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
resizeMaxHeight();
</script>
