<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

$Montant_ht = $Montant_ttc = 0;


// Variables nécessaires à l'affichage
$page_variables = array ("Montant_ht", "Montant_ttc", "liste_contenu");
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
							$step = 2;
							$page = "catalogue_panier_validation_step2.php";
							$choix_livraison = 0;
							include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_panier_lignes.inc.php"); ?>
					</div>
				
					<?php if (!isset($exist_mode_livraison) || !$exist_mode_livraison) { ?>
					<span style="float:right; color:#6e0a14">
					Poursuite de la commande impossible.
					<br />
					Aucun mode de transport n'est disponible pour cette zone de livraison.<br />
					</span>
					<?php }elseif (isset($_REQUEST["id_livraison_mode"])) { ?>
					<span style="float:right">
						<a href="#" id="lauch_livraison">Poursuivre la commande</a> &gt;&gt;
					</span>
					<script type="text/javascript">
						Event.observe('lauch_livraison', 'click',  function(evt){
						Event.stop(evt);
						$ ("panier_step2").submit();
						},false);
					</script>
					<?php } ?>
				</div>
				<br />
				<br />
				<div class="colorise_td_deco"></div>
				<br />
			</div>
		</td>
	</tr>
</table>

<?php include("content_after.php"); ?>

<?php include("bottom.php"); ?>

<?php include("footer.php"); ?>
