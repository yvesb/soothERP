<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<div class="panneau_bas">
	<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
		<tr class="panneau_bas_barre_titre">
			<td class="panneau_bas_barre_titre_left"	></td>
			<td class="panneau_bas_barre_titre_coprs"	>Encaissement</td>
			<td class="panneau_bas_barre_titre_right"	></td>
		</tr>
	</table>

	<div style="height: 10px"></div>

	<div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width: 8px"></td>
				<td style="width:290px">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr style="color: white; text-align: left; background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/fond_entete_rouge.gif');background-repeat: no-repeat repeat-x;height:23px">
							<td style="width:5px"></td>
							<td style="vertical-align:middle;font-weight:bold;">Moyens de Paiement</td>
							<td style="width:5px"></td>
						</tr>
						<tr style="height: 5px">
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
						<td colspan="3" >
							<table border="0" cellspacing="0" cellpadding="0" width="100%">
								<tr height="48px">
									<td id="mdp_cheque" class="panneau_encaissement_moyents_de_paiement" style="background-position:left;">
										Chèque
										<script type="text/javascript">
											Event.observe("mdp_cheque", "click", function(evt){
												Event.stop(evt);
												caisse_ajouter_moyen_de_paiement($("ref_ticket").value, "mdp_cheque");
											}, false);
										</script>
									</td>
									<td></td>
									<td id="mdp_cb" class="panneau_encaissement_moyents_de_paiement" style="background-position:right;">
                                                                        <?php if (count($comptes_tpes)){ ?>
										CB
										<script type="text/javascript">
											Event.observe("mdp_cb", "click", function(evt){
												Event.stop(evt);
												caisse_ajouter_moyen_de_paiement($("ref_ticket").value, "mdp_cb");
											}, false);
										</script>
                                                                        <?php } ?>
                                                                        </td>
								</tr>
								<tr style="height: 5px">
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr height="48px">
									<td id="mdp_especes" class="panneau_encaissement_moyents_de_paiement" style="background-position:left;">
										Espèces
										<script type="text/javascript">
											Event.observe("mdp_especes", "click", function(evt){
												Event.stop(evt);
												caisse_ajouter_moyen_de_paiement($("ref_ticket").value, "mdp_especes");
											}, false);
										</script>
									</td>
									<td></td>
									<td class="panneau_encaissement_moyents_de_paiement" style="background-position:right;">
										&nbsp;
									</td>
								</tr>
								<tr style="height: 5px">
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr height="48px">
									<td id="mdp_avoir" class="panneau_encaissement_moyents_de_paiement" style="background-position:left;">
										<?php if($ref_contact !="" && count($liste_avoir_to_use)>0){ ?>
											Avoir
											<script type="text/javascript">
												Event.observe("mdp_avoir", "click", function(evt){
													Event.stop(evt);
													alert("Les avoirs ne sont pas encore gérés");
													//caisse_ajouter_moyen_de_paiement($("ref_ticket").value, "mdp_avoir");
												}, false);
											</script>
										<?php }?>
									</td>
									<td></td>
									<td id="mdp_6" class="panneau_encaissement_moyents_de_paiement" style="background-position:right;">
										<?php /*
										if($ref_contact !=""){
											if($enCompte){ ?>En Compte<?php }
											else{ ?>&nbsp;<?php } ?>
										<script type="text/javascript">
											Event.observe("mdp_compte", "click", function(evt){
												Event.stop(evt);
												caisse_ajouter_moyen_de_paiement($("ref_ticket").value, "mdp_compte");
											}, false);
										</script>
										<?php }?>
										*/ ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				</td>
				<td></td>
				<td style="width:360px">
					<div>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr style="color: white; text-align: left; background-image:url('<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/fond_entete_rouge.gif');background-repeat: no-repeat repeat-x;height:23px">
								<td width="5px"></td>
								<td style="vertical-align:middle; font-weight:bold;">
									Règlements effectués
								</td>
								<td style="vertical-align:middle; font-weight:bold; text-align:right;">
									<img id="reset_reglement" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-supprimer-gris.png"/>
								</td>
								<td width="5px">
									<script type="text/javascript">
										Event.observe("reset_reglement", "click", function(evt){
											Event.stop(evt);
											var table = $("reglements_effectues");
											while(table.rows.length>1){
												table.removeChild(table.rows[1]);
											}
											cible_id_MONTANT = "";
											calculette_caisse.setCible_type_action("MOYENS_DE_PAIEMENT");
											caisse_afficher_a_rendre();
										}, false);
									</script>
								</td>
							</tr>
							<tr style="height: 5px">
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</table>
					</div>
					<div style="background-color:white; overflow: auto; height:127px">
						<script type="text/javascript">
							cible_id_MONTANT = "";
							calculette_caisse.setCible_type_action("MOYENS_DE_PAIEMENT");
						</script>
						<table id="reglements_effectues" width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="5px"></td>
								<td ></td>
								<td width="100px"></td>
								<td width="17px"></td>
							</tr>
						</table>
					</div>
					<div>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr style="height: 5px">
								<td width="5px"></td>
								<td></td>
								<td></td>
								<td width="5px"></td>
							</tr>
							<tr style="background-color:black;color:white;height:23px">
								<td ></td>
								<td style="vertical-align:middle; font-weight:bold;">
									<span id="lib__reste_a_payer_OU_a_rendre">&nbsp;</span>
								</td>
								<td style="vertical-align:middle; font-weight:bold; text-align:right;">
									<span id="reglement_a_rendre">&nbsp;</span>
								</td>
								<td>
								<script type="text/javascript">
									caisse_afficher_a_rendre();
								</script>
								</td>
							</tr>
						</table>
					</div>
				</td>
				<td></td>
				<td style="width:280px">
					<table border="0" cellpadding="0" cellspacing="0" width="100%" >
						<tr id="print_ticket">
							<td width="47px"><img id="cb_print_ticket" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/check_box_checked.png"/></td>
							<td width="5px"></td>
							<td style="vertical-align:middle; font-weight:bold; text-align:left;">
								Imprimer un Ticket
							</td>
						</tr>
						<tr height="17px">
							<td colspan="3"></td>
						</tr>
						<tr id="print_factrure">
							<td><img id="cb_print_factrure" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/check_box.png"/></td>
							<td></td>
							<td style="vertical-align:middle; font-weight:bold; text-align:left;">
								Imprimer une Facture
							</td>
						</tr>
						<tr height="17px">
							<td colspan="3"></td>
						</tr>
						<tr id="no_print">
							<td><img id="cb_no_print" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/check_box.png"/></td>
							<td></td>
							<td style="vertical-align:middle; font-weight:bold; text-align:left;">
								Aucune Impression
							</td>
						</tr>
					</table>
					<script type="text/javascript">
						Event.observe("print_ticket", "click", function(evt){
							Event.stop(evt);
							document.images["cb_print_ticket"].src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/check_box_checked.png";
							document.images["cb_print_factrure"].src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/check_box.png";
							document.images["cb_no_print"].src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/check_box.png";
							$("print_s").value = "print_ticket";
						}, false);

						Event.observe("print_factrure", "click", function(evt){
							Event.stop(evt);
							document.images["cb_print_ticket"].src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/check_box.png";
							document.images["cb_print_factrure"].src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/check_box_checked.png";
							document.images["cb_no_print"].src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/check_box.png";
							$("print_s").value = "print_factrure";
						}, false);

						Event.observe("no_print", "click", function(evt){
							Event.stop(evt);
							document.images["cb_print_ticket"].src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/check_box.png";
							document.images["cb_print_factrure"].src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/check_box.png";
							document.images["cb_no_print"].src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/check_box_checked.png";
							$("print_s").value = "no_print";
						}, false);
					</script>
				</td>
				<td></td>
				<td width="200px" style="vertical-align:middle; text-align:center;">
					<img id="print_valider" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt_valider_geant.gif" style="opacity:0.7;" />
					<script type="text/javascript">
						Event.observe("print_valider", "click", function(evt){
							Event.stop(evt);
							var table = $("reglements_effectues");
							var reglement_a_rendre = caisse_calculer_a_rendre();
							if(reglement_a_rendre >= 0){
									var moyens_de_paiement = "";
									var motants = "";
									for(var i = 1; i < table.rows.length; i++){
										if(i!=1){	moyens_de_paiement += ";";		motants += ";";	}
										moyens_de_paiement += $("MDP_"+i).value ;
										motants += $("MONTANT_"+i).value ;
									}
									//alert("ref_ticket:"+$("ref_ticket").value + " moyens_de_paiement[" + moyens_de_paiement + "] motants[" + motants + "] print_s:" + $("print_s").value);
									caisse_encaisser_ticket ($("ref_ticket").value, moyens_de_paiement, motants, $("print_s").value)
							}else{
								if(table.rows.length>1)
								{			alert("RESTE A PAYER : "+(-1)*reglement_a_rendre+"&nbsp;&euro;");}//			\u20ac	=		euro
								else{	alert("Vous devez d'abord sélectionner un Moyen de Paiement");}
							}
						}, false);
					</script>
				</td>
				<td style="width: 8px"></td>
			</tr>
		</table>
	</div>

	<div style="visibility: hidden">
		Avoirs<br/>
		<table width="100%" border="0"  cellspacing="0">
			<tr>
				<td style="width:20%"></td>
				<td style="width:20%"></td>
				<td style="width:20%"></td>
				<td style="width:20%"></td>
				<td style="width:20%"></td>
			</tr>
			<?php
			$montant_total = 0;
			foreach ($liste_avoir_to_use as $avoir) {
				if (isset($avoir->montant_ttc)) {?>
			<tr>
				<td>
					<?php echo date_Us_to_Fr($avoir->date_creation);?>
				</td>
				<td>
					<?php echo $avoir->ref_doc;?>
				</td>
				<td><?php
					if ($avoir->montant_reglements){
						$montant_reglements = $avoir->montant_reglements;
					}else{
						$montant_reglements = 0;
					}
					if ($avoir->montant_ttc){
						echo number_format($avoir->montant_ttc- $montant_reglements, $TARIFS_NB_DECIMALES, ".", ""	)." ";
						$montant_total += number_format($avoir->montant_ttc - $montant_reglements , $TARIFS_NB_DECIMALES, ".", ""	);
					}?>
				</td>
				<td style="text-align:left;">
					/<?php if ($avoir->montant_ttc)	{echo number_format($avoir->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	);}?>
				</td>
				<td>
					<span id="use_avoir_<?php echo $avoir->ref_doc; ?>" style="cursor:pointer">Utiliser</span>
					<script type="text/javascript">
						Event.observe('use_avoir_<?php echo $avoir->ref_doc; ?>', "click", function(evt){
							alert("utilisation de l'avoir venant du document : <?php echo $avoir->ref_doc; ?>");
							<?php /*add_avoir  ("<?php echo $avoir->ref_doc; ?>", "<?php echo $document->getRef_doc ();?>");*/?>
						});
					</script>
				</td>
			</tr>
			<?php } } ?>
			<tr>
				<td style="width:25%">&nbsp;</td>
				<td style="font-weight:bolder; width:40%; text-align:right; padding-right:10px"> Total: </td>
				<td style="font-weight:bolder; text-align:right "><?php echo $montant_total." ".$MONNAIE[1];;?> </td>
				<td ></td>
				<td ></td>
			</tr>
		</table>
	</div>

</div>
