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
		<td colspan="3" >
			<br />
			<br />
			<div class="para"  style="text-align:center; margin:20px 0px;">
				<br />
				<br />
				<div style="width:800px;	margin:0px auto;">
					<table border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFFF">
						<tr>
							<td class="lightbg_liste1">&nbsp;</td>
							<td class="lightbg_liste"></td>
							<td class="lightbg_liste2">&nbsp;</td>
						</tr>
						<tr>
							<td class="lightbg_liste">&nbsp;</td>
							<td class="lightbg_liste">
								<!-- Centre de la page -->
								<table class="conteneir">
									<tr>
										<td class="top_log" colspan="2">
											Connexion à <?php echo $_SESSION['interfaces'][$_INTERFACE['ID_INTERFACE']]->getLib_interface();?> de  <?php echo addslashes($nom_entreprise);?>
										</td>
									</tr>
									<tr>
										<td class="bgmain_menu">
											<br />
											<br />
											<div style="text-align:left">
												Veuillez utiliser un identifiant et un mot de passe valide pour accéder à l'application.
											</div>
											<br />
											<div style="text-align:left; color:#0000FF">
												<a href="<?php echo $DIR."/site";?>" >Retour à la page d'accueil du site web.</a>
											</div>
											<br />
											<div style="text-align:center">
												<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/verrou.gif"/>
											</div>
										</td>
										<td class="content">
											<div style="display:block; width:455px">
												<br />
												<br />
												<form action="" method="post" name="form_login" id="form_login">
													<input type=hidden name="page_from" value="<?php echo $page_from;?>">
													<?php if (isset($_REQUEST["uncache"])) { ?>
													<input type=hidden name="uncache" value="1">
													<?php } ?>
													
													<table cellpadding="0" cellspacing="0" border=0  style="display:block; width:455px; height: 185px" class="radius_main"  id="global">
														<tr>
															<td style="text-align:right">
																<table width="355px" border="0" >
																	<tr>
																		<td colspan="2" style="text-align:right; padding-right=25px;">
																			<br />
																		</td>
																	</tr>
																	<tr>
																		<td class="voidlogin" style="width:185px">
																			<span class="grey_bold_text">Identifiant </span> 
																		</td>
																		<td>
																			<div style="position:relative; top:0px; left:0px; width:100%; height:0px;">
																				<div id="choix_user" class="choix_users_liste" style="display:none"></div>
																			</div>
																			<input type=text name="login"  id="login" class="focusinput_xsize" value="<?php if (isset($predefined_user[0])) { echo $predefined_user[0]; }?>">
																		</td>
																	</tr>
																	<tr>
																		<td colspan="2" style="text-align:right; padding-right=25px;">
																			<br />
																		</td>
																	</tr>
																	<tr>
																		<td class="voidlogin">
																			<span class="grey_bold_text">Mot de passe </span> 
																		</td>
																		<td>
																			<input type="password" name="code" id="code_c" value="" class="focusinput_xsize">
																		</td>
																	</tr>
																	<tr>
																		<td colspan="2" style="text-align:right; padding-right=25px;">
																			<?php // Affichage des erreurs
																			foreach ($_ALERTES as $alerte => $value) {
																				if ($alerte == "login_faux") { ?>
																					Connexion impossible.<br />Veuillez vérifiez vos identifiants de connexion.
																				<?php }
																			} ?>
																			<br />
																		</td>
																	</tr>
																	<tr>
																		<td class="voidlogin">
																			
																		</td>
																		<td>
																			<input type="submit" name="submit" class="bt_connex" value="Connexion">
																		</td>
																	</tr>
																	<tr>
																		<td colspan="2" style="text-align:right; padding-right=25px;">
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</form>
											</div>
											<br />
											<div style="text-align:right"></div>
											<?php if ($INSCRIPTION_ALLOWED) {?>
											<div style="text-align:right">
												<a href="_inscription.php" style="color:#000000;" >Pas encore inscrits?</a>
											</div>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<div style="text-align:right; vertical-align: bottom" class="grey_text" >
												<a href="http://www.lundimatin.fr" target="_blank" class="grey_text">Lundi Matin Business</a> 
												est un logiciel libre de gestion d'entreprise, distribué sous licence 
												LMPL
											</div>
										</td>
									</tr>
								</table>
								<!-- Fin Centre de la page -->
							</td>
							<td class="lightbg_liste">&nbsp;</td>
						</tr>
						<tr>
							<td class="lightbg_liste4"></td>
							<td class="lightbg_liste">&nbsp;</td>
							<td class="lightbg_liste3">&nbsp;</td>
						</tr>
					</table>
					<br />
					<br />
				</div>
			</div>
		</td>
	</tr>
</table>

<?php include("content_after.php"); ?>

<?php include("bottom.php"); ?>

<?php include("footer.php"); ?>
