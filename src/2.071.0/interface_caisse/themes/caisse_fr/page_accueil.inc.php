<?php

// *************************************************************************************************************
// ACCUEIL DU PROFIL COLLAB
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("afficher_magasin");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>

<div>
  <div style="text-align:center;">
  	<!-- INFORMATION VENDEUR -->
  	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  		<tr height="20px">
  			<td width="300px" style="text-align:left;">
				Vendeur : <?php echo $_SESSION['user']->getPseudo(); ?>
			</td>
  			<td width="1%"></td>
	  		<td class="info_vendeur_et_date" style="text-align:left;" >
	  			Magasin : <?php echo $_SESSION['magasin']->getLib_magasin(); ?>
	  		</td>
	  		<td width="16%" class="info_vendeur_et_date" style="text-align:right;" >
					<?php echo strtoupper(lmb_strftime('%A %d %B %Y', $INFO_LOCALE)); ?>
	  		</td>
	  		<td width=" 5%" class="info_vendeur_et_date" style="text-align:right;" >
	  			<span id="horloge"></span>
					<script language="JavaScript">
					caisse_heure("horloge");
					</script>
	  		</td>
			  <td width="28%" style="text-align:right;" onmousedown="event.preventDefault();">
				  <div class="panneau_options_grand_conteneur" id="panneau_options_grand_conteneur">
				 		<div class="panneau_options_conteneur" id="panneau_options_conteneur" align="right">
				  		<div id="panneau_options_conteneur0" style="height:36px;">
					  		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_log_out.gif"	style="margin-bottom:-20px; z-index:300; cursor:pointer;" id="log_out" 	alt="Deconnexion" title="Deconnexion" />
						  	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_lock.gif" 		style="margin-bottom:-20px; z-index:300; cursor:pointer;" id="lock" 		alt="Vérouiller" 	title="Vérouiller" />
						  	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_right.gif"		style="margin-bottom:-20px; margin-right:2px; z-index:300; cursor:pointer;" id="options" 	alt="Options" 		title="Options" />
				  		</div>
				  		<div id="panneau_options_conteneur1">
								<table class="panneau_options_options" style="display:none; margin-top:10px; margin-right:2px; margin-bottom:10px;" id="panneau_options_options" align="center" border="0" cellpadding="0" cellspacing="0" id="option_info_stable" width="188px" >
									<tr>
										<td>
											<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
												<tr>
													<td style="padding-left:3px">
														<span id="interface_en_cours" href="#"><strong>Interface en cours</strong></span>
													</td>
												</tr>
											</table>
											
											<table border="0" cellpadding="0" cellspacing="0" width="100%" >
												<?php 
												// Liste des profils autorisés
												$profils_allowed = $_SESSION['user']->getProfils_allowed();
												foreach ($profils_allowed as $id_profil => $profil) { ?>
												<tr>
													<td>
														<a class="subitem" id="option_info_profil_<?php echo $id_profil;?>"  href="#">
															<img src="<?php if ($id_profil == $_SESSION['user']->getId_profil ())
																							{			echo   $DIR.$_SESSION['theme']->getDir_theme().'images/puce_valider.png'; }
																							else {echo   $DIR.$_SESSION['theme']->getDir_theme().'images/blank.gif'; } ?>" />
															<?php echo $_SESSION['profils'][$profil]->getLib_profil() ?>
														</a>
													</td>
												</tr>
												<?php } //puce_valider.png ?>
											</table>
											
											<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/separateur_black.gif" width="100%" height="1px" />
									
											<table border="0" cellpadding="0" cellspacing="0" width="100%"  style="color:white;">
												<tr>
													<td>
														<a class="subitem" id="refresh_content" href="#">Actualiser</a>
													</td>
												</tr>
											</table>
											
											<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/separateur_black.gif" width="100%" height="1px" />
									
											<table border="0" cellpadding="0" cellspacing="0" width="100%"  style="color:white;">
												<tr>
													<td>
														<a class="subitem" id="option_info_licence"  href="#">Licence</a>
													</td>
												</tr>
											</table>
										
											<table border="0" cellpadding="0" cellspacing="0" width="100%" >
												<tr>
													<td>
														<a class="subitem" id="option_info_assistance"  href="#">Assistance</a>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</div>
							<script type="text/javascript">
								Event.observe('options', 'mouseover', function(evt){
									Event.stop(evt);
									$("panneau_options_options").show();
								}, false);
								
								Event.observe('options', 'click',  function(evt){
									Event.stop(evt);
									$("panneau_options_options").show();
								}, false);

								Event.observe('panneau_options_options', 'mouseover',  function(){
									$("panneau_options_options").show();
								}, false);

								Event.observe('panneau_options_conteneur0', 'mouseover',  function(){
									$("panneau_options_options").hide();
								}, false);

								Event.observe('panneau_options_conteneur1', 'mouseout',  function(){
									$("panneau_options_options").hide();
								}, false);

								Event.observe('panneau_options_conteneur1', 'mouseover',  function(){
									$("panneau_options_options").show();
								}, false);

										
								<?php foreach ($profils_allowed as $id_profil => $profil) { ?>
								Event.observe('option_info_profil_<?php echo $id_profil;?>', 'click',  function(evt){
									Event.stop(evt);
									window.open ("<?php echo $DIR;?>site/__user_choix_profil.php?id_profil=<?php echo $id_profil;?>", "_top");
								}, false);
								<?php } ?>

								Event.observe('refresh_content', 'click',  function(evt){
									Event.stop(evt);
									refresh_sub_content();
									return_to_page = "";
								}, false);
								
								Event.observe('option_info_licence', 'click',  function(evt){
									Event.stop(evt);
									window.open ("<?php echo $DIR;?>__licence.rtf", "_blank");
								}, false);
								
								Event.observe('option_info_assistance', 'click',  function(evt){
									Event.stop(evt);
									window.open ("http://community.sootherp.fr/", "_blank");
								}, false);
							</script>	
						</div>
					</div>	  	
				</td>
  		</tr>
  	</table>
  </div>
  <div>
  	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  		<tr>
  			<!-- PANNEAU en HAUT A GAUCHE -->
  	    <td width="292px">
      		<!-- INFORMATION CLIENT -->						
					<table  width="100%" border="0" cellpadding="0" cellspacing="0" style="-moz-user-select:none;" >
						<tr>
							<td width="100%" class="client_cell_info">
								<table width="100%" height="109px" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="63px" 			 class="client_lignes_titre"  >Client : </td>
										<td id="client_ligne1" class="client_lignes_contenu">Client non identifié</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td id="client_ligne2" class="client_lignes_contenu"></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td id="client_ligne3" class="client_lignes_contenu"></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td 														 class="client_tarif_titre"  >Tarif :</td>
										<td id="client_grille_tarifaire" class="client_tarif_contenu"><?php echo $_SESSION['magasin']->getLib_tarif();?></td>
									</tr>
								</table>
							</td>
							<td>
								<img id="bt_recherche_client" style="cursor:pointer;" onmousedown="event.preventDefault();" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_show_panel_right.gif" alt="Rechercher un Client" title="Rechercher un Client" height="125" />
							</td>
						</tr>
					</table>
					
  	    	<!-- CALCULETTE -->
  	    	<div style="height:8px;">
  	    	</div>
      		<table width="100%" border="0" cellspacing="1" cellpadding="2" style="-moz-user-select:none;">
      			<tr onmousedown="event.preventDefault();">
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_7.gif" style="cursor:pointer;" id="calculette_7" /></td>
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_8.gif" style="cursor:pointer;" id="calculette_8" /></td>
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_9.gif" style="cursor:pointer;" id="calculette_9" /></td>
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_plus_moins.gif" style="cursor:pointer;" id="calculette_PLUS_MOINS" /></td>
      			</tr>
      			<tr onmousedown="event.preventDefault();">
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_4.gif" style="cursor:pointer;" id="calculette_4" /></td>
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_5.gif" style="cursor:pointer;" id="calculette_5" /></td>
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_6.gif" style="cursor:pointer;" id="calculette_6" /></td>
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_remise.gif" style="cursor:pointer;" id="calculette_REMISE" /></td>
      			</tr>
      			<tr onmousedown="event.preventDefault();">
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_1.gif" style="cursor:pointer;" id="calculette_1" /></td>
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_2.gif" style="cursor:pointer;" id="calculette_2" /></td>
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_3.gif" style="cursor:pointer;" id="calculette_3" /></td>
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_prix.gif" style="cursor:pointer;" id="calculette_PRIX" /></td>
      			</tr>
      			<tr onmousedown="event.preventDefault();">
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_c.gif" style="cursor:pointer;" id="calculette_C" /></td>
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_0.gif" style="cursor:pointer;" id="calculette_0" name="calculette_0" /></td>
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_virgule.gif" style="cursor:pointer;" id="calculette_VIRGULE" /></td>
      				<td><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_qte.gif" style="cursor:pointer;" id="calculette_QTE" /></td>
      			</tr>
      			<tr>
      				<td width="23%"></td>
      				<td width="23%"></td>
      				<td width="23%"></td>
      				<td width="31%"></td>
      			</tr>
      			<tr>
      				<td colspan="3">
      					<input id="calculette_RESULTAT" style="background-color:black; color:white; font-weight:bold; text-align:right; width:98%; height:25px; font-size:17pt; -moz-border-radius:7px" value="0.0s0">
      				</td>
      				<td  onmousedown="event.preventDefault();"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_ok2.gif" style="cursor:pointer;" id="calculette_OK" /></td>
      			</tr>
      		</table>
  	    </td>
		    <td></td>
			    <!-- PANNEAU en HAUT AU CENTRE -->
		    <td width="598px" style="min-width:598px;">
			    <div>
			    	<table width="100%" class="total" border="0" cellpadding="0" cellspacing="0">
			    		<tr>
			    			<td width="20%" style="text-align:left; ">TOTAL</td>
			    			<td width="80%" style="text-align:right;">
			    				<input id="caisse_total_s" name="caisse_total_s" type="hidden" value="0"/>
			    				<span id="caisse_total"></span>&nbsp;&euro;
			    			</td>
			    		</tr>
			    	</table>
			    </div>
			    <!-- TICKET DE CAISSE -->
			    <div style="margin-top:8px;">
		    			<table width="100%" border="0" cellpadding="3" cellspacing="0" class="ticket_titre">
		    				<tr>
		    					<td width="  4px" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/fond_entete_rouge_left.png');background-repeat: no-repeat;"></td>
		    					<td style="text-align:center; border-right: 1px solid;">
		    						Libellé
		    					</td>
		    					<td width=" 40px" style="text-align:center; border-right: 1px solid;">
		    						Qté
		    					</td>
		    					<td width="100px" style="text-align:center; border-right: 1px solid;">
		    						P.U TTC
		    					</td>
		    					<td width=" 51px" style="text-align:center; border-right: 1px solid;">
		    						%
		    					</td>
		    					<td width=" 96px" style="text-align:center;">
		    						Prix TTC
		    					</td>
		    					<td width=" 24px" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/fond_entete_rouge_right.png');background-repeat: no-repeat;"></td>
		    				</tr>
		    			</table>
		    		
			    		<div id="conteneur_TICKET">
			    			<div>
				    			<table 	width="100%" id="TICKET" border="0" cellpadding="3" cellspacing="0">
				    				<tr>
				    					<td width="  4px"	></td>
				    					<td ></td>
				    					<td width=" 40px" ></td>
				    					<td width="100px" ></td>
				    					<td width=" 51px" ></td>
				    					<td width="108px" ></td>
				    					<td width=" 1px" ></td>
				    				</tr>
				    			</table>
			    			</div>
			    		</div>
			    </div>
			    <!-- LIGNE AJOUTER un article -->
			    <div style="margin-top:10px;">
				    <table width="100%" border="0" cellpadding="0" cellspacing="0">
				    	<tr>
					    	<td align="left">
					    		<input id="art_lib_s" name="art_lib_s" class="input_rechercher_article" style="width:96%;" />
					    	</td>
					    	<td width="72px" style="text-align:right;">
					    	 <img id="bt_ajouter" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_ajouter.gif" style="cursor: pointer;" />
					    	</td>
				    	</tr>
				    </table>
			    </div>
		    </td>
		    <td ></td>
		    <!-- PANNEAU en HAUT A DROITE -->
		    <td width="340px">
		    	<!-- LOGO -->
  	    	<div style="margin-top:10px; height:97px; background-repeat:no-repeat;');">
  	    		<!-- TAILLE du logo 314px x 87px --><br />
			<a href="http://www.lundimatin.fr" target="_blank" rel="noreferrer"><img src="../fichiers/images/powered_by_lundimatin.png" width="120"/></a>
  	    	</div>
  		    
  	    	<div style="-moz-user-select:none; width:100%;" >
  	    		<table style="text-align:center; display:block; background-color:white;" border="0" cellpadding="0" cellspacing="0" width="100%">
  	    			<tr>
  		    			<td width="288px">
  		    				<!-- FONCTIONNALITES COURANTES -->
		  		    		<table  id="panneau_fonctionnalites_courantes" style="text-align:center;display:block;" border="0" cellpadding="0" cellspacing="0">
		  		    			<tr height="48px">
		  		    				<td class="panneau_fonctionnalites_bouton_active" id="supprimer_ligne">
		  		    					Supprimer<br/>ligne
		  		    				</td>
		  		    				<td width="6px"></td>
		  		    				<td class="panneau_fonctionnalites_bouton_active" id="add_infos">
		  		    					Ligne<br/>d'information
		  		    				</td>
		  		    			</tr>
		  		    			<tr height="6px">
		  		    				<td></td>
		  		    				<td></td>
		  		    				<td></td>
		  		    			</tr>
		  		    			<tr height="48px">
		  		    				<td class="panneau_fonctionnalites_bouton_active" id="supprimer_ticket">
		  		    					Supprimer<br/>ticket
		  		    				</td>
		  		    				<td></td>
		  		    				<td class="panneau_fonctionnalites_bouton_active" id="bt_fonction_courante_4">
                                                        </td>
		  		    			</tr>
		  		    			<tr height="6px">
		  		    				<td></td>
		  		    				<td></td>
		  		    				<td></td>
		  		    			</tr>
		  		    			<tr height="48px">
		  		    				<td class="panneau_fonctionnalites_bouton_active" id="en_attente" >
		  		    					Mettre le ticket<br /> en attente
		  		    				</td>
		  		    				<td></td>
		  		    				<!--<td class="panneau_fonctionnalites_bouton_active" id="retrait_caisse">
		  		    					Retrait caisse
		  		    				</td>-->
								<td class="panneau_fonctionnalites_bouton_active" id="">
		  		    				</td>
		  		    			</tr>
		  		    			<tr height="6px">
		  		    				<td></td>
		  		    				<td></td>
		  		    				<td></td>
		  		    			</tr>
		  		    			<tr height="48px">
		  		    				<td class="panneau_fonctionnalites_bouton_active" id="tickets_en_attente">
		  		    					Rappeler<br />un ticket
		  		    				</td>
		  		    				<td></td>
		  		    				<!--<td class="panneau_fonctionnalites_bouton_active" id="ajout_caisse">
		  		    					Entrée caisse
		  		    				</td>-->
								<td class="panneau_fonctionnalites_bouton_active" id="reglement_rapide">
		  		    					Encaissement rapide
		  		    				</td>
		  		    			</tr>
		  		    		</table>
		  		    		
		  		    		<!-- FONCTIONNALITES AVANCEES -->
					  		  <table id="panneau_fonctionnalites_avancees" style="text-align:center; display:none;" border="0" cellpadding="0" cellspacing="0"  width="100%" >
		  		    			<tr height="48px">
		  		    				<td class="panneau_fonctionnalites_bouton_active" id="bt_fonction_avancee_1">
		  		    					Statistiques
		  		    				</td>
		  		    				<td width="6px"></td>
		  		    				<td class="panneau_fonctionnalites_bouton_<?php if($afficher_magasin){echo "active";}else{echo "desactive";}?>" id="choix_pt_vente">
		  		    					Choix du<br/>point de vente
		  		    				</td>
		  		    			</tr>
		  		    			<tr height="6px">
		  		    				<td></td>
		  		    				<td></td>
		  		    				<td></td>
		  		    			</tr>
		  		    			<tr height="48px">
		  		    				<td class="panneau_fonctionnalites_bouton_active" id="bt_fonction_avancee_3">
		  		    					&nbsp;<br/>&nbsp;
		  		    				</td>
		  		    				<td></td>
		  		    				<td class="panneau_fonctionnalites_bouton_<?php if($afficher_magasin){echo "active";}else{echo "desactive";}?>" id="choix_caisse">
		  		    					Choix de<br/>la caisse
		  		    				</td>
		  		    			</tr>
		  		    			<tr height="6px">
		  		    				<td></td>
		  		    				<td></td>
		  		    				<td></td>
		  		    			</tr>
		  		    			<tr height="48px">
		  		    				<td class="panneau_fonctionnalites_bouton_active" id="bt_fonction_avancee_5" >
		  		    					&nbsp;<br />&nbsp;
		  		    				</td>
		  		    				<td></td>
		  		    				<td class="panneau_fonctionnalites_bouton_active" id="bt_fonction_avancee_6">
		  		    					&nbsp;<br />&nbsp;
		  		    				</td>
		  		    			</tr>
		  		    			<tr height="6px">
		  		    				<td></td>
		  		    				<td></td>
		  		    				<td></td>
		  		    			</tr>
		  		    			<tr height="48px">
		  		    				<td class="panneau_fonctionnalites_bouton_active" id="bt_fonction_avancee_7">
		  		    					&nbsp;<br />&nbsp;
		  		    				</td>
		  		    				<td></td>
		  		    				<td class="panneau_fonctionnalites_bouton_active" id="bt_fonction_avancee_8">
		  		    					&nbsp;<br />&nbsp;
		  		    				</td>
		  		    			</tr>
		  		    		</table>
		  		    		
  		    			</td>
  	    				<td width="51px" rowspan="3" style="vertical-align:bottom; text-align:right;" align="right">
  	    					<img id="fonctions_avancees" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_fonct_avancees.png" style="cursor:pointer"/>
  	    				</td>
  	    			</tr>
  	    			<tr height="8px">
  	    				<td></td>
  	    			</tr>		
  		    		<tr>
  	    				<td id="bt_encaisser" height="57px" style="background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_vide_rouge.gif'); background-repeat: no-repeat; cursor: pointer; text-align:center; vertical-align:middle;">
  	    					<span id="bt_encaisser_lib" style="font-size:24px; font-weight:bold; color:white;" >ENCAISSER</span>
  	    				</td>
  	    			</tr>
  	    		</table>
  	    	</div>
		    </td>
		  </tr>
  	</table>
  </div>
</div>


<!-- GESTION DU PANNEAU DU BAS -->
<div id="panneau_bas" style="margin-top:2px;"></div>

<!-- Les input cachés -->
<div style="display: none;">
	<table width="100%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td><input name="ref_ticket" id="ref_ticket" type="text" /> -&gt; ref_ticket</td>
			<td><input name="ref_contact" id="ref_contact" type="text" /> -&gt; ref_contact</td>
			<td><input type="text" name="art_page_to_show_s" id="art_page_to_show_s" /> -&gt; art_page_to_show_s</td>
	    <td></td>
		</tr>
	  <tr>
	    <td><input type="text" name="categ_racine_page_to_show_s" id="categ_racine_page_to_show_s" /> -&gt; categ_racine_page_to_show_s</td>
	    <td><input type="text" name="categ_sous_page_to_show_s" id="categ_sous_page_to_show_s" /> -&gt; categ_sous_page_to_show_s</td>
	    <td><input type="text" name="print_s" id="print_s" /> -&gt; print_s</td>
	    <td></td>
	  </tr>
	</table>
</div>

<script type="text/javascript">
	selected_line_name = "";
	selected_col_name = "";
	ticket_is_unlock = true;
	
	lib_in_encaisser = "ENCAISSER";
	lib_out_encaisser = "RETOUR";
	
	lib_in_afficher_tickets_en_attente = "Rappeler<br />un ticket";
	lib_out_afficher_tickets_en_attente = "Retour<br />au catalogue";
	
	lib_grille_tarifaire = "<?php echo $_SESSION['magasin']->getLib_tarif();?>";
</script>

<!-- JAVASCRIPT DU PANNEAU EN HAUT A DROITE -->

<!-- FONCTIONNALITES COURANTES -->
<script type="text/javascript">
Event.observe("supprimer_ligne", "click", function(evt){
	Event.stop(evt);
	if(selected_line_name != ""){
		caisse_suppr_article($("ref_ticket").value, selected_line_name);
	}
	$("art_lib_s").focus();
}, false);
</script>

<!-- POPUP STATS -->
<?php
echo '
<div id="popup_stats" style="display:none;" class="popup_stats"></div>';
?>

<script type="text/javascript">
 Event.observe("bt_fonction_avancee_1","click",function(ev){
	$('popup_stats').show();
	centrage_element($('popup_stats'));
	new Ajax.Updater("popup_stats","popup_stats.php",{
		evalScripts:true
	});
});
</script>

<script type="text/javascript">
Event.observe("supprimer_ticket", "click", function(evt){
	Event.stop(evt);
	if($("ref_ticket").value!=""){
		var fonction_called_after_maj_etat =  "script_called_after_maj_etat_ticket_from_acceuil()";
		caisse_suppr_ticket($("ref_ticket").value, fonction_called_after_maj_etat);
	}
}, false);
</script>

<script type="text/javascript">
Event.observe("en_attente", "click", function(evt){
	Event.stop(evt);
	if($("ref_ticket").value!=""){
		var fonction_called_after_maj_etat_ticket =  "script_called_after_maj_etat_ticket_from_acceuil()";
		maj_etat_ticket($("ref_ticket").value, "61", fonction_called_after_maj_etat_ticket); // ID_ETAT_EN_ATTENTE = 61
	}
}, false);
</script>

<script type="text/javascript">
/*Event.observe("retrait_caisse", "click", function(evt){
	Event.stop(evt);
	change_panneau_bas("retrait_caisse");
}, false);*/
</script>

<script type="text/javascript">
Event.observe("tickets_en_attente", "click", function(evt){
	Event.stop(evt);
	change_panneau_bas("tickets_en_attente");
}, false);
</script>

<script type="text/javascript">
/*Event.observe("ajout_caisse", "click", function(evt){
	Event.stop(evt);
	change_panneau_bas("ajout_caisse");
}, false);*/
</script>
<script type="text/javascript">
$('reglement_rapide').observe('click', function(evt){
	Event.stop(evt);
	if($("ref_ticket").value != ""){
		if(ticket_is_unlock)
			{change_panneau_bas("encaissement_rapide");}
		else{change_panneau_bas("recherche_article");}
	}
});
</script>
<script type="text/javascript">
$('add_infos').observe('click', function(evt){
	Event.stop(evt);
	addLineInfo($("ref_ticket").value, {});
});
</script>


<!-- FONCTIONNALITES AVANCEES -->
<?php if($afficher_magasin){?>
<script type="text/javascript">
Event.observe("choix_pt_vente", "click", function(evt){
	Event.stop(evt);
	change_panneau_bas("choix_point_vente");
}, false);
</script>

<script type="text/javascript">
Event.observe("choix_caisse", "click", function(evt){
	Event.stop(evt);
	change_panneau_bas("choix_caisse");
}, false);
</script>
<?php }?>

<!-- AUTRES FONCTIONNALITES -->

<script type="text/javascript">
Event.observe("bt_encaisser", "click", function(evt){
	Event.stop(evt);
	if($("ref_ticket").value != ""){
		if(ticket_is_unlock)
			{change_panneau_bas("encaissement");}
		else{change_panneau_bas("recherche_article");}
	}
}, false);
</script>

<script type="text/javascript">
fonctionnalites_courantes = true;
function afficher_fonctions_avancees(){
	fonctionnalites_courantes = false;
	$("panneau_fonctionnalites_courantes").hide();
	$("panneau_fonctionnalites_avancees").show();
	$("fonctions_avancees").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_fonct_basiques.png";
}

function afficher_fonctions_courantes(){
	fonctionnalites_courantes = true;
	$("panneau_fonctionnalites_avancees").hide();
	$("panneau_fonctionnalites_courantes").show();
	$("fonctions_avancees").src = "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_fonct_avancees.png";
}

Event.observe("fonctions_avancees", "click", function(evt){
	Event.stop(evt);
	if(fonctionnalites_courantes)
	{			afficher_fonctions_avancees();}
	else {afficher_fonctions_courantes();}
}, false);

</script>

<!-- FIN DU JAVASCRIPT DU PANNEAU EN HAUT A DROITE -->

<!-- JAVASCRIPT DU PANNEAU EN HAUT A GAUCHE : GESTION DU CLIENT -->
<script type="text/javascript">
Event.observe("bt_recherche_client", "click", function(evt){
	Event.stop(evt);
	change_panneau_bas("recherche_client");
}, false);

Event.observe("client_ligne1", "click", function(evt){
	Event.stop(evt);
	change_panneau_bas("recherche_client");
}, false);
</script>
<!-- FIN DU JAVASCRIPT DU PANNEAU EN HAUT A GAUCHE : GESTION DU CLIENT -->

<!-- JAVASCRIPT DU PANNEAU EN HAUT A GAUCHE : CALCULETTE -->
<script type="text/javascript">

var impRes = $("calculette_RESULTAT");
var bt_Ok = $("calculette_OK");
var bt_c = $("calculette_C");
var bt_point = $("calculette_VIRGULE");
var bt_PlusMoins = $("calculette_PLUS_MOINS");
var bt_remise = $("calculette_REMISE");
var bt_prix = $("calculette_PRIX");
var bt_qte = $("calculette_QTE");
var bt_0 = $("calculette_0");
var bt_1 = $("calculette_1");
var bt_2 = $("calculette_2");
var bt_3 = $("calculette_3");
var bt_4 = $("calculette_4");
var bt_5 = $("calculette_5");
var bt_6 = $("calculette_6");
var bt_7 = $("calculette_7");
var bt_8 = $("calculette_8");
var bt_9 = $("calculette_9");
var retour = $("art_lib_s");

calculette_caisse = new calculette(impRes, bt_Ok, bt_c, bt_point, bt_PlusMoins, bt_remise, bt_prix, bt_qte, bt_0, bt_1, bt_2, bt_3, bt_4, bt_5, bt_6, bt_7, bt_8, bt_9, retour);
calculette_caisse.setCible_type_action("TICKET");

Event.observe(bt_PlusMoins.id, "click", function(evt){ Event.stop(evt); calculette_caisse.bt_PlusMoins_click(); }, false);

Event.observe(bt_remise.id, "click", function(evt){
	Event.stop(evt);
	if(selected_line_name != "")
	{		caisse_select_col("REMISE");}
	calculette_caisse.bt_remise_click();
}, false);

Event.observe(bt_prix.id, "click", function(evt){
	Event.stop(evt);
	if(selected_line_name != "")
	{		caisse_select_col("PUTTC");}
	calculette_caisse.bt_prix_click();
}, false);

Event.observe(bt_qte.id, "click", function(evt){
	Event.stop(evt);
	if(selected_line_name != "")
	{		caisse_select_col("QTE");}
	calculette_caisse.bt_qte_click();
}, false);

Event.observe(bt_Ok.id, "click", function(evt){ 
	Event.stop(evt);
	calculette_caisse.bt_Ok_click();
	caisse_unselect_col();
}, false);

Event.observe(impRes.id, "keypress", function(evt){
	var key = evt.which || evt.keyCode;
	calculette_caisse.impRes_keypress(key);
	Event.stop(evt);
}, false);

Event.observe(impRes.id, "keydown",  function(evt){
	if(calculette_caisse.impRes_keydown(evt.keyCode))
	{		Event.stop(evt);}
}, false);

Event.observe(bt_c.id, "click",  function(evt){
	Event.stop(evt);
	calculette_caisse.bt_c_click();
}, false);

Event.observe(bt_point.id, "click",  function(evt){
	Event.stop(evt);
	calculette_caisse.bt_point_click();
}, false);

Event.observe(bt_0.id, "click", function(evt){ Event.stop(evt); calculette_caisse.bt_0_9_click("0"); }, false);
Event.observe(bt_1.id, "click", function(evt){ Event.stop(evt); calculette_caisse.bt_0_9_click("1"); }, false);
Event.observe(bt_2.id, "click", function(evt){ Event.stop(evt); calculette_caisse.bt_0_9_click("2"); }, false);
Event.observe(bt_3.id, "click", function(evt){ Event.stop(evt); calculette_caisse.bt_0_9_click("3"); }, false);
Event.observe(bt_4.id, "click", function(evt){ Event.stop(evt); calculette_caisse.bt_0_9_click("4"); }, false);
Event.observe(bt_5.id, "click", function(evt){ Event.stop(evt); calculette_caisse.bt_0_9_click("5"); }, false);
Event.observe(bt_6.id, "click", function(evt){ Event.stop(evt); calculette_caisse.bt_0_9_click("6"); }, false);
Event.observe(bt_7.id, "click", function(evt){ Event.stop(evt); calculette_caisse.bt_0_9_click("7"); }, false);
Event.observe(bt_8.id, "click", function(evt){ Event.stop(evt); calculette_caisse.bt_0_9_click("8"); }, false);
Event.observe(bt_9.id, "click", function(evt){ Event.stop(evt); calculette_caisse.bt_0_9_click("9"); }, false);

</script>

<!-- JAVASCRIPT POUR AJOUTER UN ARTICLE -->
<script type="text/javascript">
Event.observe('bt_ajouter', "click", function(evt){
	Event.stop(evt);
	$("art_page_to_show_s").value = "1";
	$("categ_racine_page_to_show_s").value = "1";
	$("categ_sous_page_to_show_s").value = "1";

	change_panneau_bas("recherche_article", "bt_ajouter");
}, false);
</script>

<script type="text/javascript">
Event.observe('art_lib_s', "keypress", function(evt){
	var key = evt.which || evt.keyCode; 
	switch (key) {
	case Event.KEY_RETURN:     
		Event.stop(evt);
		$("art_page_to_show_s").value = "1";
		$("categ_racine_page_to_show_s").value = "1";
		$("categ_sous_page_to_show_s").value = "1";
		change_panneau_bas("recherche_article", "bt_ajouter");
		break;   
	}
}, false);
</script>
<!-- FIN DU JAVASCRIPT POUR AJOUTER UN ARTICLE -->

<!-- JAVASCRIPT DES BOUTONS TT EN HAUT A DROITE -->
<script type="text/javascript">
Event.observe('log_out', 'click',  function(evt){
	Event.stop(evt);
	window.open ("<?php echo $DIR;?>site/__session_stop.php", "_top");
}, false);
</script>

<script type="text/javascript">
Event.observe("lock", "click",  function(evt){
	Event.stop(evt);
	session_user_lock("<?php echo $DIR;?>");
}, false);
</script>
<!-- FIN DU JAVASCRIPT DES BOUTONS TT EN HAUT A DROITE -->

<script type="text/javascript">
caisse_reset("recherche_article");
//on masque le chargement
H_loading();
</SCRIPT>