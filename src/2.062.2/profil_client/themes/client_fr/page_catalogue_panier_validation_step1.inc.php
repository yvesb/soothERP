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

<?php include("header.php"); ?>

<?php include("top.php"); ?>

<?php include("menu.php"); ?>

<?php include("content_before.php"); ?>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" >
	<tr>
		<td >
		<br />
		<br />

		<div class="catalogue" style="padding-left:45px; padding-right:45px">
		<div style="background-color:#FFFFFF; padding:15px">
		<div class="bg_ico_panier">
		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/icone_panier.gif" />
		<div class="colorise0">
		</div>
		</div><br />
		<div style="color:#000000" >
			<table  width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="panier_text_etape">
					Votre commande
					</td>
					<td class="panier_text_etape">
					Identification
					</td>
					<td class="panier_text_etape">
					Livraison
					</td>
					<td class="panier_text_etape">
					Paiement
					</td>
					<td class="panier_text_etape">
					Confirmation
					</td>
				</tr>
				<tr >
					<td class="panier_line_etape">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_grey_dot.gif" />
					</td>
					<td class="panier_line_etape">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_white_dot.gif" />
					</td>
					<td class="panier_line_etape">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_grey_dot.gif" />
					</td>
					<td class="panier_line_etape">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_grey_dot.gif" />
					</td>
					<td class="panier_line_etape">
						<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_grey_dot.gif" />
					</td>
				</tr>
			</table>
			
			<br />
		<div ><br />

		Avant de valider votre commande , veuillez vérifier la justesse des informations de facturation et de livraison saisies et les modifier le cas échéant en vous rendant dans "<a href="_user_infos.php">Mon compte</a>".<br />&nbsp;

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr style="">
		<td style="height:150px; width:380px; padding-left:25px; padding-right:25px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td class="yw_topleft"></td>
				<td class="yw_top"></td>
				<td class="yw_topright"></td>
			</tr>
			<tr>
				<td class="yw_left"></td>
				<td class="yw_content">
		<div class="title_content"> MES DONNEES PERSONNELLES</div>

	<div  style="width:100%;	margin:0px auto;">
		<table class="conteneir">
		<tr>
			<td class="top_log" colspan="4">



		<div id="block_contact">
		<div style="width:100%; display:" id="view_infos_contact">
		<table cellpadding="0" cellspacing="0" border="0" style="width:100%" id="infos_contact_affichage">
			<tr style=" line-height:20px; height:20px;" class="panier_head_list">
				<td style=" padding-left:3px;" class="doc_bold" ><input type="hidden" name="ref_contact"  id="ref_contact" value="<?php echo $contact->getRef_contact();?>"/>
				</td>
				<td >
				
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;
				</td>
			</tr>
			<tr>
				<td  class="main_info_user" >
					D&eacute;nomination: 
				</td>
				<td   class="text_variable_user">
				<?php echo nl2br($contact->getNom());?>
				</td>
			</tr>
			<tr>
				<td  class="text_variable" >
					Civilité: 
				</td>
				<td   class="text_variable_user">
				<?php echo nl2br($contact->getLib_civ_court());?>
				</td>
				<td>
			</tr>
			<tr>
				<td  class="text_variable" >
					Type: 
				</td>
				<td   class="text_variable_user">
				<?php echo nl2br($contact->getLib_Categorie());?>
				</td>
				<td>
			</tr>
			<?php if ($contact->getSiret()) { ?>
			<tr>
				<td  class="text_variable" >
					Siret: 
				</td>
				<td   class="text_variable_user">
				<?php echo nl2br($contact->getSiret());?>
				</td>
				<td>
			</tr>
			<?php } ?>
			<?php if ($contact->getTva_intra()) { ?>
			<tr>
				<td  class="text_variable" >
					T.V.A. intra: 
				</td>
				<td   class="text_variable_user">
				<?php echo nl2br($contact->getTva_intra());?>
				</td>
				<td>
			</tr>
			<?php } ?>
			
			<tr>
				<td colspan="2">&nbsp;
				</td>
			</tr>
						<tr>
							<td colspan="2" class="main_info_user" >
								Adresse de Facturation:
							</td>
						</tr>
						<tr>
							<td class="text_variable">
							Adresse:<br />
							</td>
							<td class="text_variable_user">
							<?php echo  nl2br($adresse_facturation->getText_adresse());?>
							</td>
						</tr>
						<tr>
							<td class="text_variable">
							Code Postal:<br />
							</td>
							<td class="text_variable_user">
							<?php echo  ($adresse_facturation->getCode_postal());?><br />
							</td>
						</tr>
						<tr>
							<td class="text_variable">
							Ville:<br />
							</td>
							<td class="text_variable_user">
							<?php echo  ($adresse_facturation->getVille());?><br />
							</td>
						</tr>
						<tr>
							<td class="text_variable">
							Pays:<br />
							</td>
							<td class="text_variable_user">

								<?php
									$separe_listepays = 0;
									foreach ($listepays as $payslist){
										if ((!$separe_listepays) && (!$payslist->affichage)) { 
											$separe_listepays = 1; ?>
											<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
											<?php 		 
										}
										?>
										<?php if ($adresse_facturation->getId_pays() == $payslist->id_pays) {echo htmlentities($payslist->pays);}?> <?php if (!$adresse_facturation->getId_pays() && $DEFAUT_ID_PAYS == $payslist->id_pays) {echo htmlentities($payslist->pays);}?>
										<?php 
									}
									?>
							</td>
						</tr>
			<tr>
				<td colspan="2">&nbsp;
				</td>
			</tr>
						<tr>
							<td colspan="2" class="main_info_user">
							Adresse de Livraison: 
							</td>
						</tr>
						<tr>
							<td class="text_variable">
							Adresse:<br />
							</td>
							<td class="text_variable_user">
							<?php echo  nl2br($adresse_livraison->getText_adresse());?>
							</td>
						</tr>
						<tr>
							<td class="text_variable">
							Code Postal:<br />
							</td>
							<td class="text_variable_user">
							<?php echo  ($adresse_livraison->getCode_postal());?><br />
							</td>
						</tr>
						<tr>
							<td class="text_variable">
							Ville:<br />
							</td>
							<td class="text_variable_user">
							<?php echo  ($adresse_livraison->getVille());?><br />
							</td>
						</tr>
						<tr>
							<td class="text_variable">
							Pays:<br />
							</td>
							<td class="text_variable_user">

								<?php
									$separe_listepays = 0;
									foreach ($listepays as $payslist){
										if ((!$separe_listepays) && (!$payslist->affichage)) { 
											$separe_listepays = 1; ?>
											<OPTGROUP disabled="disabled" label="__________________________________" ></OPTGROUP>
											<?php 		 
										}
										?>
										<?php if ($adresse_livraison->getId_pays() == $payslist->id_pays) {echo htmlentities($payslist->pays);}?> <?php if (!$adresse_livraison->getId_pays() && $DEFAUT_ID_PAYS == $payslist->id_pays) {echo htmlentities($payslist->pays);}?>
										<?php 
									}
									?>
							</td>
						</tr>
					
			<tr>
				<td colspan="2">&nbsp;
				</td>
			</tr>
			<?php if (isset($liste_coordonnees[0])) {?>
						<tr>
							<td colspan="2" class="main_info_user" >
										Coordonnées:
							</td>
						</tr>
						<tr>
							<td class="text_variable">
							Tél:<br />
							</td>
							<td  class="text_variable_user">
							<?php echo  ($liste_coordonnees[0]->getTel1());?><br />
							</td>
						</tr>
						<tr>
							<td class="text_variable">
							Tél 2:<br />
							</td>
							<td  class="text_variable_user">
							<?php echo  ($liste_coordonnees[0]->getTel2());?><br />
							</td>
						</tr>
						<tr>
							<td class="text_variable">
							Fax:<br />
							</td>
							<td  class="text_variable_user">
							<?php echo  ($liste_coordonnees[0]->getFax());?><br />
							</td>
						</tr>
						<tr>
							<td class="text_variable">
							Email:<br />
							</td>
							<td  class="text_variable_user">
							<?php echo  ($liste_coordonnees[0]->getEmail());?><br />
							</td>
						</tr>
			<tr>
				<td colspan="2">&nbsp;
				</td>
			</tr>
			<?php } ?>
			
		</table>
		
		<script type="text/javascript">

		</script>
		
		</div>
		</div>
			</td>
		</tr>
		</table>
			</td>
				<td class="yw_right"></td>
			</tr>
			<tr>
				<td class="yw_botleft"></td>
				<td class="yw_bot"></td>
				<td class="yw_botright"></td>
			</tr>
		</table>
		<br />

		<span style="float:right">
		<a href="catalogue_panier_validation_step2.php">Poursuivre la commande</a> >>
		</span>
		
		
		</td>
	</tr>
</table>

<?php include("content_after.php"); ?>

<?php include("bottom.php"); ?>

<?php include("footer.php"); ?>
