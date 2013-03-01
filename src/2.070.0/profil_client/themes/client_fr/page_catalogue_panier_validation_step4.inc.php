<?php
// *************************************************************************************************************
// visualisation du panier
// *************************************************************************************************************

$Montant_ht = $Montant_ttc = 0;

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<?php include("header.php"); ?>

<?php include("top.php"); ?>

<?php include("menu.php"); ?>

<?php include("content_before.php"); ?>
<div id="contenu">
	<br />
	<div id="panierRight">
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
				<font class="txt_violet">Confirmation</font>
				</td>
			</tr>
			<tr >
				<td class="panier_line_etape">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_grey_dot.gif" />
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
				<td class="panier_line_etape">
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/panier_purple_dot.gif" />
				</td>
			</tr>
			<tr>
				<td class="panier_text_etape" colspan="5"><br />
				<br />
				</td>
			</tr>
		</table>
		
		<div id="form_nouv_clientH" style="margin-top:0px;">&nbsp;</div>
		<div id="form_nouv_client">
		
			<table width="681px" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="25px">&nbsp;</td>
					<td class="nomPrd">Commande enregistr&eacute;e</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="25px">&nbsp;</td>
					<td class="txt_black" colspan="2" style="font-weight:normal;">Vous avez choisi de nous r&eacute;gler par ch&egrave;que.<br /><br />Nous vous remercions de bien vouloir indiquer le num&eacute;ro de votre commande avec votre r&egrave;glement afin que nous puissions facilement attribuer votre paiement.</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="25px">&nbsp;</td>
					<td style="font-weight:normal;" class="txt_black">R&eacute;f&eacute;rence : <b><?php echo $cdc->getRef_doc();?></b></td>
				</tr>
				<tr>
					<td width="25px">&nbsp;</td>
					<td class="colorise_td_deco2" colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="25px">&nbsp;</td>
					<td class="nomPrd" colspan="2"><font class="txt_gris">Coordonn&eacute;es</font></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="25px">&nbsp;</td>
					<td width="300px" style="font-weight:normal;">
					<?php 
						$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
						$nom_entreprise = str_replace (CHR(13), " " ,str_replace (CHR(10), " " , $contact_entreprise->getNom()));
						$adresse_entreprise = $contact_entreprise->getAdresses();
						$coordonnees_entreprise = $contact_entreprise->getCoordonnees();
					?>
						<div>
							<?php echo $nom_entreprise; ?>						
						</div>
						<div>
							<?php // Controle de l'adresse de l'entreprise
							if($adresse_entreprise[0]->getText_adresse())
							{		echo $adresse_entreprise[0]->getText_adresse(); }?>
							<br />
							<?php // Controle du code postal de l'entreprise
							if($adresse_entreprise[0]->getCode_postal())
							{		echo $adresse_entreprise[0]->getCode_postal(), " ";}		
							// Controle de la ville de l'entreprise
							if($adresse_entreprise[0]->getVille())
							{		echo $adresse_entreprise[0]->getVille(); } ?>
							<br />
							<br />
							<?php // Controle du numéro de téléphone de l'entreprise
							if($coordonnees_entreprise[0]->getTel1())
							{		echo " Tél : ", $coordonnees_entreprise[0]->getTel1();} ?>
							<br />
							<?php // Controle du numéro de fax de l'entreprise
							if($coordonnees_entreprise[0]->getFax())
							{		echo " Fax : ", $coordonnees_entreprise[0]->getFax();} ?>
						</div>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
		</div>
		<div id="form_nouv_clientB">&nbsp;</div>
		
		<div class="valid_login" style="display:none;">
			<table width="680px" cellpadding="0" cellspacing="0">
			<tr>
				<td><a href="catalogue_panier_validation_step4.php">Valider</a>&nbsp;&nbsp;<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/fleche_verte.png" border="0" /></td>
			</tr>
			</table>
		</div>
		
		<div style="clear:both; font-size:0px; line-height:0px;">&nbsp;</div><!-- /div de fermeture -->
	</div><!-- /centreIndexRight -->
	<div style="clear:both; font-size:0px; line-height:0px;">&nbsp;</div><!-- /div de fermeture -->
</div><!-- /centreIndex -->

<?php include("content_after.php"); ?>

<?php include("bottom.php"); ?>

<?php include("footer.php"); ?>
