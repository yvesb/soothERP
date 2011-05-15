<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

$Montant_ht = $Montant_ttc = 0;


// Variables nécessaires à l'affichage
$page_variables = array ("Montant_ht", "Montant_ttc");
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
		<td>
			<br />
			<br />
			
			<div class="catalogue" style="background-color:#FFFFFF; padding-left:45px; padding-right:45px">
				<div style=" padding:15px;">
					<div>
					<?php 
							$step = 3;
							$page = "catalogue_panier_validation_step3.php";
							$choix_livraison = $id_livraison_mode;
							include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_panier_lignes.inc.php"); ?>
					</div>
				</div>
				<?php if (count($reglements_dispos)) {?>
				Sélectionnez votre mode de règlement:<br />
				<br />
				<form action="catalogue_panier_validation_step4.php" method="post" name="panier_step3" id="panier_step3">
					<input type="hidden" name="id_reglement_mode" id="id_reglement_mode">
					<table>
						<?php foreach ($reglements_dispos as $reg_dispo) { ?>
						<tr>
							<td>
								<?php echo $reg_dispo->lib_reglement_mode;?>
							</td>
							<td>
								<input type="radio" name="Rid_reglement_mode" id="Rid_reglement_mode_<?php echo $reg_dispo->id_reglement_mode;?>" value="<?php echo $reg_dispo->id_reglement_mode;?>" /><br />
								<script type="text/javascript">
									Event.observe('Rid_reglement_mode_<?php echo $reg_dispo->id_reglement_mode;?>', 'click',  function(evt){
										$("id_reglement_mode").value = "<?php $reg_dispo->id_reglement_mode; ?>";
										alert("<?php echo $reg_dispo->lib_reglement_mode;?>"); 
									},false);
								</script>
							</td>
						</tr>						
						<?php }
						} ?>
					</table>
				</form>
				
				<div style="text-align:center">
					<a href="#" id="lauch_paiement">Confirmez définitivement votre commande</a>
					<script type="text/javascript">
						Event.observe("lauch_paiement", 'click',  function(evt){
						Event.stop(evt);
						$("panier_step3").submit();
						},false);
					</script>
				</div>
		<br />
		<br />
		<div class="colorise_td_deco">
		</div><br />
		<div class="colorise_td_deco">
		</div>
		</div>
		</td>
	</tr>
</table>

<?php include("content_after.php"); ?>

<?php include("bottom.php"); ?>

<?php include("footer.php"); ?>
