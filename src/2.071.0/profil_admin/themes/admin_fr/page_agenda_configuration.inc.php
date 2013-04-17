<?php
$path_parts = pathinfo(__FILE__);
include ($path_parts["dirname"]."/_redirection_extension.inc.php");

// *************************************************************************************************************
// CONTROLE DU THEME
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

?>

<script type="text/javascript">
	tableau_smenu[0] = Array("smenu_entreprise", "smenu_entreprise.php" ,"true" ,"sub_content", "Entreprise");
	tableau_smenu[1] = Array('agenda_configuration','agenda_configuration.php',"true" ,"sub_content", "Agenda");
	update_menu_arbo();
</script>
<?php include $DIR.$_SESSION['theme']->getDir_theme()."page_annuaire_recherche_mini.inc.php" ?>
<div class="emarge">
	<p class="titre">Agenda</p>
	<div style="height:50px;">
		<table class="minimizetable">
			<tr>
				<td class="contactview_corps">
					<div id="magasins" style=" padding-left:10px; padding-right:10px">
						<p>Ajouter un agenda </p>
						<table>
							<tr>
								<td>
									<table border="0">
										<tr class="smallheight">
											<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
											<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
											<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
											<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
											<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										</tr>	
										<tr>
											<td>
												<span class="labelled">Libell&eacute;:</span>
											</td>
											<td>
												<span class="labelled">Type:</span>
											</td>
											<td>
												<span class="labelled">Couleurs:</span>
											</td>
											<td></td>
											<td></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<div class="caract_table">
							<table border="0">
								<tr class="smallheight">
									<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
								</tr>	
								<tr>
									<td>
										<input name="lib_agenda_add" id="lib_agenda" type="text" value=""  class="classinput_lsize" style="width:90%"/>
										<input name="type_agenda" id="type_agenda" type="hidden" value="" />
									</td>
									<td>
										<?php	//STRUCTURE : resultat[id_type][lib_type]
										
										reset($all_agenda_types); ?>
										<script type="text/javascript">
											$("type_agenda").value = <?php echo key($all_agenda_types); ?>;
										</script>
										
										<select id="type_agenda_add"  name="type_agenda_add" style="width:90%">
										<?php for ($i = 0; $i< count($all_agenda_types); $i++){
										$index = key($all_agenda_types); ?>
											<option value="<?php echo $index; ?>" >
												<?php echo $all_agenda_types[$index]["lib_type"]; ?>
											</option>
										<?php next($all_agenda_types);
										} ?>
										</select>
										
										<script type="text/javascript">
										divAffichee = "";
		
										function showAgendaPanel(){
											switch ( $("type_agenda_add").options[$("type_agenda_add").selectedIndex].value) {
											case "<?php echo AgendaReservationRessource::_getId_type_agenda(); ?>":{
												if(divAffichee != "")
												{		$(divAffichee).hide();}
												divAffichee = "agenda_AgendaReservationRessource";
												//initialisation des éléments de la div agenda_AgendaReservationRessource
												$("type_agenda").value = <?php echo AgendaReservationRessource::_getId_type_agenda(); ?>;
												$(divAffichee).show();
												break;}
											case "<?php echo AgendaContact::_getId_type_agenda(); ?>":{
												if(divAffichee != "")
												{		$(divAffichee).hide();}
												divAffichee = "agenda_AgendaContact";
												$("type_agenda").value = <?php echo AgendaContact::_getId_type_agenda(); ?>;
												//initialisation des éléments de la div agenda_AgendaReservationRessource
												$(divAffichee).show();
												break;}
											case "<?php echo AgendaLoacationMateriel::_getId_type_agenda(); ?>":{
												if(divAffichee != "")
												{		$(divAffichee).hide();}
												divAffichee = "agenda_AgendaLoacationMateriel";
												$("type_agenda").value = <?php echo AgendaLoacationMateriel::_getId_type_agenda(); ?>;
												//initialisation des éléments de la div agenda_AgendaReservationRessource
												$(divAffichee).show();
												break;}
											default:{
												if(divAffichee != "")
												{		$(divAffichee).hide();}
												break;}
											}
										}
		
										showAgendaPanel();
										
										Event.observe("type_agenda_add", "change", function(ev) {
											Event.stop(ev);
											showAgendaPanel();
											}, false);
										</script>
									</td>
									<td>
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td width="45%">
													<div id="nouvAg_couleur_1" style="position:relative; width:100%; height:100%; background-color:#FFFFFF;-moz-border-radius: 5px; border: 1px solid black;">
														&nbsp;
														<input type="hidden" id="nouvAg_valCouleur_1" name="nouvAg_valCouleur_1" value="#FFFFFF"/>
														<iframe width="150px" height="245px;" id="coupleCouleur_nouvAg_couleur" 
																	src="color_selection_couple.php?monNom=coupleCouleur_nouvAg_couleur&fonctionRetour=agenda_setCouleur(couleur_1,'nouvAg_couleur_1','nouvAg_valCouleur_1');agenda_setCouleur(couleur_2,'nouvAg_couleur_2','nouvAg_valCouleur_2')" 
																	style="display:none; position:absolute; border:1px solid #000000; padding:5px; -moz-border-radius:10px; background-color:white; z-index:200;" frameborder="1" >
														</iframe>
													</div>
												</td>
												<td width="10%"></td>
												<td width="45%">
													<div id="nouvAg_couleur_2" style="position:relative; width:100%; height:100%; background-color:#FFFFFF;-moz-border-radius: 5px; border: 1px solid black;">
														&nbsp;
														<input type="hidden" id="nouvAg_valCouleur_2" name="nouvAg_valCouleur_2" value="#FFFFFF"/>
													</div>
												</td>
												<?php /*
												<td width="10px"></td>
												<td width="70px">
											
													<div id="nouvAg_couleur_3" style="position:relative; width:100%; height:100%; background-color:#FFFFFF;-moz-border-radius: 5px; border: 1px solid black;">
														&nbsp;
														<input type="hidden" id="nouvAg_valCouleur_3" name="nouvAg_valCouleur_3" value="#FFFFFF"/>
														<iframe width="161px" height="140px" id="paletteCouleur_nouvAg_couleur_3" 
																	src="color_selection.php?monNom=paletteCouleur_nouvAg_couleur_3&codeCouleurActivated=1&fonctionRetour=agenda_setCouleur(couleur,'nouvAg_couleur_3','nouvAg_valCouleur_3');" 
																	style="display:none; position:absolute; border:1px solid #000000; OVERFLOW: hidden; z-index:200;" frameborder="1" scrolling="no">
														</iframe>
													</div>
												
												</td>
												<td width="10px"></td>
													*/ ?>
											</tr>
										</table> 
										<script type="text/javascript">

											function coupleCouleur_nouvAg_couleur(){
												$("coupleCouleur_nouvAg_couleur").style.left = 0+"px";
												$("coupleCouleur_nouvAg_couleur").style.top = 20+"px";
												if($("coupleCouleur_nouvAg_couleur").style.display == "none")
												{			$("coupleCouleur_nouvAg_couleur").show();}
												else{	$("coupleCouleur_nouvAg_couleur").hide();}
											}
											
											Event.observe('nouvAg_couleur_1', "click", function(evt){
												Event.stop(evt);
												coupleCouleur_nouvAg_couleur();
											}, false);

											Event.observe('nouvAg_couleur_2', "click", function(evt){
												Event.stop(evt);
												coupleCouleur_nouvAg_couleur();
											}, false);
																						
											<?php /*
											Event.observe('nouvAg_couleur_3', "click", function(evt){
												Event.stop(evt);
												$("paletteCouleur_nouvAg_couleur_3").style.left = 0+"px";
												$("paletteCouleur_nouvAg_couleur_3").style.top = 20+"px";
												if($("paletteCouleur_nouvAg_couleur_3").style.display == "none")
												{			$("paletteCouleur_nouvAg_couleur_3").show();}
												else{	$("paletteCouleur_nouvAg_couleur_3").hide();}
											}, false);
											*/ ?>
										</script>
									</td>
									<td></td>
									<td></td>
								</tr>
							</table>
							<div id="agenda_AgendaLoacationMateriel" style="display:none;">
								<table>
									<tr class="smallheight">
										<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									</tr>
									<tr>
										<td>Ref article : </td>
										<td>
											<input name="ref_article_AgendaLoacationMateriel" id="ref_article_AgendaLoacationMateriel" type="text" value=""  class="classinput_lsize" style="width:90%"/>
										</td>
										<td></td>
										<td></td>
										<td style="text-align:right">
											<img name="add_agenda_AgendaLoacationMateriel" id="add_agenda_AgendaLoacationMateriel" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" style="cursor:pointer"/>
											<script type="text/javascript">
												Event.observe("add_agenda_AgendaLoacationMateriel", "click", function(ev) {
													Event.stop(ev);
													var error = false;
													if($("lib_agenda").value == ""){
														//erreur
														alert("le libélé de l'agenda est vide");
														error = true;
													}
													if($("ref_article_AgendaLoacationMateriel").value == ""){
														//erreur
														alert("la ref article est vide");
														error = true;
													}
													if(!error){
														//$("agenda_configuration_add").submit();
														agenda_create_AgendaLoacationMateriel($F("lib_agenda"), $F("ref_article_AgendaLoacationMateriel"), $F("nouvAg_valCouleur_1"), $F("nouvAg_valCouleur_2"));
													}
												}, false);
											</script>
										</td>
									</tr>
								</table>
							</div>
							<div id="agenda_AgendaContact" style="display:none;">
								<table border="0">
									<tr class="smallheight">
										<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									</tr>
									<tr>
										<td>Ref_Contact : </td>
										<td>
											<table cellpadding="0" cellspacing="0" width="100%" border="0">
												<tr>
													<td>
														<input name="nom_contact_AgendaContact" id="nom_contact_AgendaContact" type="text" value=""  class="classinput_lsize"  style="width:95%"/>
														<input name="ref_contact_AgendaContact" id="ref_contact_AgendaContact" type="hidden" value="" />
													</td>
													<td width="10%" align="right">
														<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right; cursor:pointer" id="rechercher_contact">
													</td>
													<td  width="10%" align="right">
														<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif"/ style=" cursor:pointer" id="supprimer_contact">
													</td>
													<td width="10%"></td>
												</tr>
											</table>
											<script type="text/javascript">
												Event.observe("supprimer_contact", "click",  function(evt){Event.stop(evt); 
													$("nom_contact_AgendaContact").value = "";
													$("ref_contact_AgendaContact").value = "";
												}, false);
												Event.observe('rechercher_contact', 'click',  function(evt){
													Event.stop(evt);
													
													show_mini_moteur_contacts ("recherche_client_set_contact", "\'ref_contact_AgendaContact\', \'nom_contact_AgendaContact\' "); 
													preselect ('<?php echo $COLLAB_ID_PROFIL; ?>', 'id_profil_m'); 
													page.annuaire_recherche_mini();
												}, false);
											</script>
										</td>
										<td></td>
										<td></td>
										<td style="text-align:right">
											<img name="add_agenda_AgendaContact" id="add_agenda_AgendaContact" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" style="cursor:pointer" />
											<script type="text/javascript">
												Event.observe("add_agenda_AgendaContact", "click", function(ev) {
													Event.stop(ev);
													var error = false;
													if($("lib_agenda").value == ""){
														//erreur
														alert("le libélé de l'agenda est vide");
														error = true;
													}
													if($("ref_contact_AgendaContact").value == ""){
														//erreur
														alert("la ref contact est vide");
														error = true;
													}
													if(!error){
														//$("agenda_configuration_add").submit();
														agenda_create_AgendaContact($F("lib_agenda"), $F("ref_contact_AgendaContact"), $F("nouvAg_valCouleur_1"), $F("nouvAg_valCouleur_2"));
													}
												}, false);
											</script>
										</td>
									</tr>
								</table>
							</div>
							<div id="agenda_AgendaReservationRessource" style="display:none;">
								<table border="0">
									<tr class="smallheight">
										<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									</tr>
									<tr>
										<td>Ressource associée à cet agenda : </td>
										<td>
											<select id="ressources_AgendaReservationRessource"  name="ressources_AgendaReservationRessource" style="width:90%">
											<?php /*STRUCTURE : $all_ressource_AgendaReservationRessource[ref_ressource] = lib_ressource*/
											reset($allRessources_AgendaReservationRessource);
											for ($i = 0; $i< count($allRessources_AgendaReservationRessource); $i++){
											$index = key($allRessources_AgendaReservationRessource); ?>
												<option value="<?php echo $index; ?>" >
													<?php echo $allRessources_AgendaReservationRessource[$index]; ?>
												</option>
											<?php next($allRessources_AgendaReservationRessource);
											} ?>
											</select>
										</td>
										<td></td>
										<td></td>
										<td style="text-align:right">
											<img name="add_agenda_AgendaReservationRessource" id="add_agenda_AgendaReservationRessource" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" style="cursor:pointer" />
											<script type="text/javascript">
												Event.observe("add_agenda_AgendaReservationRessource", "click", function(ev) {
													Event.stop(ev);
													if($("lib_agenda").value == ""){
														//erreur	
														alert("le libélé de l'agenda est vide");
													}else{
														agenda_create_AgendaReservationRessource($F("lib_agenda"), $("ressources_AgendaReservationRessource").options[$("ressources_AgendaReservationRessource").selectedIndex].value, $F("nouvAg_valCouleur_1"), $F("nouvAg_valCouleur_2"));
													}
												}, false);
											</script>
										</td>
									</tr>
								</table>
							</div>
						</div>
						<br />
						<?php if ($all_agendas) { ?>
						<p>Liste des agendas</p>
						<table>
							<tr>
								<td width="50%">
									<span class="labelled">Libell&eacute;:</span>
								</td>
								<td width="25%">
									<span class="labelled">Type:</span>
								</td>
								<td width="25%"></td>
							</tr>
						</table>
	
						<script type="text/javascript">
							AgendaContact_origanContact = new Array();
							AgendaLoacationMateriel_origanArticle = new Array();
						</script>
						
						<?php }
						reset($all_agendas);
						for ($i = 0; $i < count($all_agendas); $i++){
							$index = key($all_agendas); ?>
						<div class="caract_table" id="agenda_table_<?php echo $index; ?>">
								<table border="0">
									<tr class="smallheight">
										<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:30%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
										<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
									</tr>
									<tr>
										<td>
												<input name="lib_agenda_<?php echo $index; ?>" id="lib_agenda_<?php echo $index; ?>" type="text" value="<?php echo $all_agendas[$index]->getLib_agenda(); ?>" class="classinput_lsize"  style="width:90%"/>
										</td>
										<td>
											<span style="font-style:italic"><?php echo $all_agendas[$index]->getLib_type(); ?></span>
										</td>
										<td>
											<table border="0" cellpadding="0" cellspacing="0">
												<tr>
													<td width="45%">
														<div id="ag_<?php echo $index;?>_couleur_1" style="position:relative; width:100%; height:100%; background-color:<?php echo $all_agendas[$index]->getCouleur_1();?>;-moz-border-radius: 5px; border: 1px solid black;">
															&nbsp;
															<input type="hidden" id="ag_<?php echo $index;?>_valCouleur_1" name="ag_<?php echo $index;?>_valCouleur_1" value="<?php echo $all_agendas[$index]->getCouleur_1();?>"/>
															<iframe width="150px" height="245px;" id="coupleCouleur_ag_<?php echo $index;?>_couleur" 
																	src="color_selection_couple.php?monNom=coupleCouleur_ag_<?php echo $index;?>_couleur&fonctionRetour=agenda_setCouleur(couleur_1, 'ag_<?php echo $index;?>_couleur_1','ag_<?php echo $index;?>_valCouleur_1');agenda_setCouleur(couleur_2, 'ag_<?php echo $index;?>_couleur_2','ag_<?php echo $index;?>_valCouleur_2')"
																	style="display:none; position:absolute; border:1px solid #000000; padding:5px; -moz-border-radius:10px; background-color:white; z-index:200;" frameborder="1" >
															</iframe>
														</div>
													</td>
													<td width="10%"></td>
													<td width="45%">
														<div id="ag_<?php echo $index;?>_couleur_2" style="position:relative; width:100%; height:100%; background-color:<?php echo $all_agendas[$index]->getCouleur_2();?>;-moz-border-radius: 5px; border: 1px solid black;">
															&nbsp;
															<input type="hidden" id="ag_<?php echo $index;?>_valCouleur_2" name="ag_<?php echo $index;?>_valCouleur_2" value="<?php echo $all_agendas[$index]->getCouleur_2();?>"/>
														</div>
													</td>
													<?php /*
													<td width="10px"></td>
													<td width="20px">
													
														<div id="ag_<?php echo $index;?>_couleur_3" style="position:relative; width:100%; height:100%; background-color:<?php echo $all_agendas[$index]->getCouleur_3();?>;-moz-border-radius: 5px; border: 1px solid black;">
															&nbsp;
															<input type="hidden" id="ag_<?php echo $index;?>_valCouleur_3" name="ag_<?php echo $index;?>_valCouleur_3" value="<?php echo $all_agendas[$index]->getCouleur_3();?>"/>
															<iframe width="161px" height="140px" id="paletteCouleur_ag_<?php echo $index;?>_couleur_3"
																	src="color_selection.php?monNom=paletteCouleur_ag_<?php echo $index;?>_couleur_3&couleur=<?php echo substr($all_agendas[$index]->getCouleur_3(), 1);?>&codeCouleurActivated=1&fonctionRetour=agenda_setCouleur(couleur,'ag_<?php echo $index;?>_couleur_3','ag_<?php echo $index;?>_valCouleur_3')"
																	style="display:none; position:absolute; border:1px solid #000000; OVERFLOW: hidden; z-index:200;" frameborder="1" scrolling="no">
															</iframe>
														</div>
														
													</td>
													<td width="10px"></td>
													*/ ?>
												</tr>
											</table> 
											<script type="text/javascript">
												function coupleCouleur_ag(index){
													$("coupleCouleur_ag_"+index+"_couleur").style.left = 0+"px";
													$("coupleCouleur_ag_"+index+"_couleur").style.top = 20+"px";
													if($("coupleCouleur_ag_"+index+"_couleur").style.display == "none")
													{			$("coupleCouleur_ag_"+index+"_couleur").show();}
													else{	$("coupleCouleur_ag_"+index+"_couleur").hide();}
												}
											
												Event.observe('ag_<?php echo $index;?>_couleur_1', "click", function(evt){
													Event.stop(evt);
													coupleCouleur_ag("<?php echo $index;?>");
												}, false);
												
												Event.observe('ag_<?php echo $index;?>_couleur_2', "click", function(evt){
													Event.stop(evt);
													coupleCouleur_ag("<?php echo $index;?>");
												}, false);
												
												<?php /*
												Event.observe('ag_<?php echo $index;?>_couleur_3', "click", function(evt){
													Event.stop(evt);
													$("paletteCouleur_ag_<?php echo $index;?>_couleur_3").style.left = 0+"px";
													$("paletteCouleur_ag_<?php echo $index;?>_couleur_3").style.top = 20+"px";
													if($("paletteCouleur_ag_<?php echo $index;?>_couleur_3").style.display == "none")
													{			$("paletteCouleur_ag_<?php echo $index;?>_couleur_3").show();}
													else{	$("paletteCouleur_ag_<?php echo $index;?>_couleur_3").hide();}
												}, false);
												*/ ?>
											</script>
										</td>
										<td></td>
										<td align="right" valign="top">
											<form action="agenda_configuration_supp.php" method="post" id="suppr_<?php echo $index; ?>" name="suppr_<?php echo $index; ?>" target="formFrame" >
												<input name="ref_agenda" id="ref_agenda" type="hidden" value="<?php echo $index; ?>" />
											</form>
											<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" id="supprimer_<?php echo $index; ?>" style="cursor:pointer" title="supprimer"/>
											<script type="text/javascript">
												Event.observe("supprimer_<?php echo $index; ?>", "click",  function(evt){
													Event.stop(evt);
													alerte.confirm_supprimer("agenda_sup", "suppr_<?php echo $index; ?>");
												}, false);
											</script>
										</td>
									</tr>
									<tr>
										<td>
										<?php 
											switch ($all_agendas[$index]->getId_type_agenda()) {
											case AgendaReservationRessource::_getId_type_agenda() :{ ?>
											<!-- ************************************************************************ -->
												Ressource
											</td>
											<td>
												<!-- POUR l'instant 1 AGENDA gère 1 RESSOURCE, MAIS A l'AVENIR 1 AGENDA gèrera plusiseurs ressources -->
												<select id="ressources_<?php echo $index; ?>"  name="ressources_<?php echo $index; ?>" style="width:90%">
												<?php //STRUCTURE : $all_ressource_AgendaReservationRessource[ref_ressource] = lib_ressource
												$ressources = $all_agendas[$index]->getRessources();
												reset($allRessources_AgendaReservationRessource);
												for ($j = 0; $j< count($allRessources_AgendaReservationRessource); $j++){
												$ref_ressource = key($allRessources_AgendaReservationRessource); ?>
													<option <?php echo 'value="'.$ref_ressource.'"'; if($ref_ressource == $ressources[0]["ref_ressource"]) echo 'selected="selected"'; ?> >
														<?php echo $allRessources_AgendaReservationRessource[$ref_ressource]; ?>
													</option>
												<?php next($allRessources_AgendaReservationRessource);
												} ?>
												</select>
												<script type="text/javascript">
													Event.observe("modifier_<?php echo $index; ?>", "click",  function(evt){
														Event.stop(evt); 
														if($("lib_agenda_<?php echo $index; ?>").value == ""){		alert("le libélé de l'agenda est vide");}
															else{		agenda_modif_AgendaReservationRessource("<?php echo $index; ?>", $F("lib_agenda_<?php echo $index; ?>"), $("ressources_<?php echo $index; ?>").options[$("ressources_<?php echo $index; ?>").selectedIndex].value, $F("ag_<?php echo $index; ?>_valCouleur_1"), $F("ag_<?php echo $index; ?>_valCouleur_2"));
														}
													}, false);														
												</script>
											</td>
												<!-- ************************************************************************ -->
												<?php break;}
											case AgendaContact::_getId_type_agenda() :{
											$contact = $all_agendas[$index]->getContact(); ?>
											<!-- ************************************************************************ -->
											<script type="text/javascript">
												AgendaContact_origanContact["<?php echo $index; ?>"] = new Array();
												AgendaContact_origanContact["<?php echo $index; ?>"]["ref_contact"] = "<?php echo $contact->getRef_contact(); ?>";
												AgendaContact_origanContact["<?php echo $index; ?>"]["nom_contact"] = "<?php echo $contact->getNom(); ?>";
											</script>
											Contact : 
										</td>
										<td>
											<table cellpadding="0" cellspacing="0" width="100%" border="0">
												<tr>
													<td>													
														<input name="nom_contact_<?php echo $index; ?>" id="nom_contact_<?php echo $index; ?>" type="text" value="<?php echo $contact->getNom(); ?>" class="classinput_lsize"  style="width:95%"/>
														<input name="ref_contact_<?php echo $index; ?>" id="ref_contact_<?php echo $index; ?>" type="hidden" value="<?php echo $contact->getRef_contact();?>" >
													</td>
													<td width="10%" align="right">
														<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_contact_find.gif"/ style="float:right; cursor:pointer" id="rechercher_contact_<?php echo $index; ?>">
													</td>
													<td width="10%" align="right">
														<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif"/ style=" cursor:pointer" id="supprimer_contact_<?php echo $index; ?>">
													</td>
													<td width="10%"></td>
												</tr>
											</table>
											<script type="text/javascript">
												Event.observe("supprimer_contact_<?php echo $index; ?>", "click",  function(evt){Event.stop(evt); 
													$("nom_contact_<?php echo $index; ?>").value = AgendaContact_origanContact["<?php echo $index; ?>"]["nom_contact"];
													$("ref_contact_<?php echo $index; ?>").value = AgendaContact_origanContact["<?php echo $index; ?>"]["ref_contact"];
													}, false);
												
												Event.observe('rechercher_contact_<?php echo $index; ?>', 'click',  function(evt){
													Event.stop(evt);
													
													show_mini_moteur_contacts ("recherche_client_set_contact", "\'ref_contact_<?php echo $index; ?>\', \'nom_contact_<?php echo $index; ?>\' "); 
													preselect ('<?php echo $COLLAB_ID_PROFIL; ?>', 'id_profil_m'); 
													page.annuaire_recherche_mini();
													}, false);
											
													Event.observe("modifier_<?php echo $index; ?>", "click",  function(evt){
														Event.stop(evt); 
														var error = false;
														if($("lib_agenda_<?php echo $index; ?>").value == ""){
															//erreur
															alert("le libélé de l'agenda est vide");
															error = true;
														}
														if($("ref_contact_<?php echo $index; ?>").value == ""){
															//erreur
															alert("la contact est vide");
															error = true;
														}
														if(!error){
															//$("agenda_configuration_add").submit();
															agenda_modif_AgendaContact("<?php echo $index; ?>", $F("lib_agenda_<?php echo $index; ?>"), $F("ref_contact_<?php echo $index; ?>"), $F("ag_<?php echo $index; ?>_valCouleur_1"), $F("ag_<?php echo $index; ?>_valCouleur_2"));
														}
													}, false);
												</script>
											</td>
												<!-- ************************************************************************ -->
												<?php break;}
											case AgendaLoacationMateriel::_getId_type_agenda() :{?>
											<!-- ************************************************************************ -->
												<script type="text/javascript">
													AgendaLoacationMateriel_origanArticle["<?php echo $index; ?>"] = new Array();
													AgendaLoacationMateriel_origanArticle["<?php echo $index; ?>"]["ref_article"] = "<?php echo $all_agendas[$index]->getRef_article();?>";
													AgendaLoacationMateriel_origanArticle["<?php echo $index; ?>"]["lib_article"] = "";
												</script>
												ref article
											</td>
											<td>
												<table cellpadding="0" cellspacing="0" width="100%" border="0">
													<tr>
														<td>													
															<input name="ref_article_<?php echo $index; ?>" id="ref_article_<?php echo $index; ?>" type="text" value="<?php echo $all_agendas[$index]->getRef_article(); ?>"  class="classinput_lsize" style="width:100%"/>
														</td>
														<td width="10%" align="right">
															<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif"/ style=" cursor:pointer" id="supprimer_article_<?php echo $index; ?>">
														</td>
														<td width="10%"></td>
													</tr>
												</table>
												<script type="text/javascript">
													Event.observe("supprimer_article_<?php echo $index; ?>", "click",  function(evt){
														Event.stop(evt);
														$("ref_article_<?php echo $index; ?>").value = AgendaLoacationMateriel_origanArticle["<?php echo $index; ?>"]["ref_article"];
													}, false);
													
													Event.observe("modifier_<?php echo $index; ?>", "click",  function(evt){
														Event.stop(evt); 
														var error = false;
														if($("lib_agenda_<?php echo $index; ?>").value == ""){
															//erreur
															alert("le libélé de l'agenda est vide");
															error = true;
														}
														if($("ref_article_<?php echo $index; ?>").value == ""){
															//erreur
															alert("la article est vide");
															error = true;
														}
														if(!error){
															agenda_modif_AgendaLoacationMateriel("<?php echo $index; ?>", $F("lib_agenda_<?php echo $index; ?>"), $F("ref_article_<?php echo $index; ?>"), $F("ag_<?php echo $index; ?>_valCouleur_1"), $F("ag_<?php echo $index; ?>_valCouleur_2"));
														}
													}, false);
												</script>
											</td>
												<!-- ************************************************************************ -->
												<?php break;}
											default:{ ?>
												&nbsp;</td><td>&nbsp;</td>
												<?php break;}
											}
										?>
											<td></td>
											<td></td>
											<td align="center" valign="middle">
												<input name="modifier_<?php echo $index; ?>" id="modifier_<?php echo $index; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-modifier.gif" />
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
									</table>
						</div>
						<br/>
						<?php
	 						next($all_agendas);
						} ?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<SCRIPT type="text/javascript">
	
	centrage_element("pop_up_mini_moteur");
	centrage_element("pop_up_mini_moteur_iframe");

	Event.observe(window, "resize", function(evt){
		centrage_element("pop_up_mini_moteur_iframe");
		centrage_element("pop_up_mini_moteur");
	});

	H_loading();
</SCRIPT>