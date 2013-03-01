<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("prise_en_compte_de_inscription");
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
							<div class="title_content" style="text-align:right">
								INSCRIPTION&nbsp;
								<img  src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/icone_contact.gif" style="vertical-align:text-bottom"/>
							</div>
							
							<br />
							<br />
							<div style="text-align:left">
							<!-- -------------- -->
							<!-- CORPS DU TEXTE -->
							<!-- -------------- -->
							<?php 
							
							// $prise_en_compte_de_inscription = 0 ou 1
							switch($INSCRIPTION_ALLOWED + ($prise_en_compte_de_inscription*10)){
								case 1	: { //inscription d'un contact avec une validation par un collaborateur mais sans un mail de confirmation 
														//-> l'inscription à échouée ?>
									Bonjour,<br />
									<br />
									Nous sommes au regret que votre inscription n'a pas pu aboutir, <br/>
									Nous vous invitons à prendre directement contact avec nous.
									<br />
								<?php break;}
								case 3	: { //inscription d'un contact avec une validation par un collaborateur mais avec un mail confirmation
														//-> l'inscription à échouée ?>
									Bonjour,<br />
									<br />
									Nous sommes au regret que votre inscription n'a pas pu aboutir, <br/>
									Nous vous invitons à prendre directement contact avec nous.
									<br />
								<?php break;}
								case 2	: { //inscription d'un contact automatique sans mail de confirmation
														//-> l'inscription à échouée ?>
									Bonjour,<br />
									<br />
									Nous sommes au regret que votre inscription n'a pas pu aboutir, <br/>
									Nous vous invitons à prendre directement contact avec nous.
									<br />
								<?php break;}
								case 4	: { //inscription d'un contact automatique avec mail de confirmation
														//-> l'inscription à échouée ?>
									Bonjour,<br />
									<br />
									Nous sommes au regret que votre inscription n'a pas pu aboutir, <br/>
									Nous vous invitons à prendre directement contact avec nous.
									<br />
								<?php break;}
								case 11 : { //inscription d'un contact avec une validation par un collaborateur mais sans un mail de confirmation
														//-> l'inscription à réussie ?>
									Bonjour,<br /> 
									<br />
									votre demande a bien été prise en compte.<br />
									Un de nos collaborateur va maintenant valider votre incsription.
									A la fin de cette opération, vous recevrai un mail de confirmation 
									qui vous annoncera que votre inscription sera terminée.<br />
									<br />
								<?php break;}
								case 13 : { //inscription d'un contact avec une validation par un collaborateur mais avec un mail confirmation
														//-> l'inscription à réussie ?>
									Bonjour,<br /> 
									<br />
									votre demande a bien été prise en compte.<br />
									Cette validation se fait en deux temps.<br />
									<ul>
										<li>Premièrement, un email vient de vous être envoyé afin que vous puissiez confirmer votre incription.</li>
										<li>Deuxièmement, notre équipe validera celle-ci.</li>
									</ul>
									<br />
								<?php break;}
								case 12 : { //inscription d'un contact automatique sans mail de confirmation
														//-> l'inscription à réussie ?>
									Bonjour,<br /> 
									<br />
									Votre inscription &agrave; réussie.<br />
								<?php break;}
								case 14 : { //inscription d'un contact automatique avec mail de confirmation
														//-> l'inscription à réussie ?>
									Bonjour,<br /> 
									<br />
									votre demande a bien été prise en compte.<br />
									Un email vient de vous être envoyé afin que vous puissiez confirmer votre incription.<br />
								<?php break;}
								case 0	: case 10 : //inscription interdite !
								default : { ?>
									Bonjour,<br />
									<br />
									Nous sommes au regret de vous dire que les inscriptions ne sont pas autorisées sur ce site.<br />
									<br />
								<?php //header ("Location: _user_login.php");
									break;}
							}?>
							</div>
						</td>
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
