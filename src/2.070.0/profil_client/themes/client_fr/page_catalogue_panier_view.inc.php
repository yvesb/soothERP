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
						$step = 0;
						$page = "catalogue_panier_view.php";
						$choix_livraison = -1;
						include ($DIR.$_SESSION['theme']->getDir_theme()."page_catalogue_panier_lignes.inc.php"); ?>
					</div>
					<br />
					<span style="float:right">
						<?php if(count($_SESSION["panier_interface_".$_INTERFACE['ID_INTERFACE']]["contenu"]) > 0){?>
						<a href="catalogue_panier_validation_step1.php">Valider mon panier</a> &gt;&gt;
						<?php }?>
					</span>
					<br />
				</div>
			</div>
		</td>
	</tr>
</table>

<?php include("content_after.php"); ?>

<?php include("bottom.php"); ?>

<?php include("footer.php"); ?>
