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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr style="">
		<td>
		<br />
		<br />
		<br />
		<br />
		<div class="para_accueil">
			<a href="_user_infos.php" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/accueil_ico_compte_modif.gif"  class="img_accueil" style="padding-left:20px; padding-right:20px;" /></a>
			<a href="_user_infos.php" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/accueil_ico_compte_devval.gif"  class="img_accueil" /></a>
			<a href="_user_infos.php" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/accueil_ico_compte_siv_comm.gif"  class="img_accueil" /></a>
			<a href="_user_infos.php" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/accueil_ico_compte_regfac.gif"  class="img_accueil" /></a>
			<a href="contact.php" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/accueil_ico_contact.gif"  class="img_accueil" /></a>
		</div>
		<br />
		<br />
		<br />
<?php if ((!$_SESSION['user']->getLogin() && $AFF_CAT_VISITEUR) || ($_SESSION['user']->getLogin() && $AFF_CAT_CLIENT)) {?>
		<br />
		<div class="para_accueil">
			
			<a href="catalogue_liste_articles.php" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/accueil_ico_cata_consult.gif"  class="img_accueil" /></a>
			<a href="catalogue_liste_articles.php" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/accueil_ico_cata_recher.gif"  class="img_accueil" /></a>
			<a href="catalogue_panier_view.php" ><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/accueil_ico_cata_panier.gif"  class="img_accueil" /></a>

		</div>
		<br />
		<br />
<?php } ?>
		</td>
	</tr>
</table>

<?php include("content_after.php"); ?>

<?php include("bottom.php"); ?>

<?php include("footer.php"); ?>
