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
	<tr>
		<td colspan="3" style="height:150px; width:500px">
		
		
		<br />
		<br />
		<div class="para"  style="text-align:center; margin:20px 0px;">
		<br />
		<br />

		<div style="width:500px;	margin:0px auto;">
		
			<table border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFFF">
				<tr>
					<td class="lightbg_liste1">&nbsp;</td>
					<td class="lightbg_liste"></td>
					<td class="lightbg_liste2">&nbsp;</td>
				</tr>
				<tr>
					<td class="lightbg_liste">&nbsp;</td>
					<td class="lightbg_liste">
					<div class="title_content" style="text-align:right">MODIFICATION DE VOS DONNEES PERSONNELLES <img  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/icone_contact.gif" style="vertical-align:text-bottom"/> </div>
					<br />
					<br />
					
				<?php if ($MODIFICATION_ALLOWED ) {?>
				<div style="text-align:left">
				Bonjour votre demande a bien été prise en compte.<br />
					
					<br />
				<?php if (isset($GLOBALS['_INFOS']["mail_change"] )) {?>
					Un email de confirmation vient de vous être envoyé afin de valider votre inscription.<br />
					<br />
				<?php } ?>
				<?php if (isset($GLOBALS['_INFOS']["verification_collab"])) {?>
					L'un de nos collaborateurs va prochainement valider votre fiche. Vous recevrez un email de confirmation prochainement.
<br />
					<br />
				<?php } ?>
					
					</div>
				<?php } ?>
		
					<td class="lightbg_liste">&nbsp;</td>
				</tr>
				<tr>
					<td class="lightbg_liste4"></td>
					<td class="lightbg_liste">&nbsp;</td>
					<td class="lightbg_liste3">&nbsp;</td>
				</tr>
			</table>
		</div>
		<br />
		<br />
		</div>
		</td>
	</tr>
</table>

<?php include("content_after.php"); ?>

<?php include("bottom.php"); ?>

<?php include("footer.php"); ?>
