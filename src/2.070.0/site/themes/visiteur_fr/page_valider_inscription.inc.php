<?php
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Inscription</title>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>javascript/prototype.js"/></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>javascript/swfobject.js"></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>javascript/_general.js"></script>
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_log.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_common_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_content.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_site.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="alert_pop_up">
</div>
<div id="alert_pop_up_tab" class="alert_pop_up_tab">
	<div id="titre_alert"></div>
	<div id="texte_alert"></div>
	<div id="bouton_alert"><input type="submit" name="bouton0" id="bouton0" value="Annuler" /><input type="submit" id="bouton1" name="bouton1" value="Valider" />
	</div>
</div>
<iframe id="framealert" frameborder="0" scrolling="no" src="about:blank"></iframe>

<script type="text/javascript">
	// Lancement proto des alertes
	var alerte = new alerte_message();
</script>

<div class="conteneur">
	<div id="logoSociete">
	</div>
	<div id="arrondiHaut">
		&nbsp;
	</div>
	<div id="contenu">
		<div style="width:800px;margin:0px auto;" align="center">
			<table border="0" cellspacing="20">
				<tr>
					<td align="center" colspan="2">
						<h2>Inscription sur le site de  <?php echo $nom_entreprise;?></h2>
					</td>
				</tr>
				<tr>
				<td class="content" align="center" style="padding-left:30px;"><div style="display:block; width:455px">
				<?php 
				if($inscription_ok){
					// Inscription OK : Rappel des identifiants
				?>
					<b>Votre inscription a bien été effectuée.</b><br />
					Vous pouvez maintenant vous connecter au logiciel à l'adresse suivante : <br />
					<a href="<?php echo url_site(); ?>"><?php echo url_site(); ?></a><br /><br />
					<span style="text-align:left;">
					Pour mémoire, voici vos identifiants: <br />
					Identifiant: <?php echo $_REQUEST['login']; ?><br />
					Mot de passe: ******
					</span>
				<?php 
				} else if(!count($_ALERTES)){ ?>
				<form action="<?php echo $_SERVER['PHP_SELF'];?>?coord=<?php echo $ref_coord; ?>&code=<?php echo $code; ?>" method="post" name="form_inscription" id="form_inscription">
				<table cellpadding="0" cellspacing="0" border="0"  style="display:block; width:455px;" class="radius_main" id="global">
				<tr>
				<td>
				<table width="380px" border="0" style="text-align:right" >
				<tr>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;"><b>Choisir un identifiant et un mot de passe : </b></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;">&nbsp;</td>
				</tr>
					<?php 
					if(count($_ERREURS)){
					?>
					<tr>
					<td colspan="2" style="text-align:center;">
					<?php 
					// Affichage des erreurs
					foreach ($_ERREURS as $alerte => $value) {
						if ($alerte == "login_used" || $alerte == "used_pseudo") { ?>
						Erreur détectée : Le nom d'utilisateur <i><b><?php echo $pseudo;?></b></i> est déjà utilisé.<br />
						<?php } elseif ($alerte == "params" || $alerte == "no_ref_coord_user" || $alerte == "no_uci_existing") {
						?>
						Erreur détectée : Veuillez vérifier le lien !
						<?php 	
						} elseif ($alerte == "no_pseudo") {
						?>
						Erreur : Veuillez saisir un pseudo !
						<?php 	
						} elseif ($alerte == "used_ref_coord_user") {
						?>
						Erreur détectée : Un utilisateur a déjà été créé pour ce compte !
						<?php 
						} else {
							echo $alerte . ' => ' . $value;
						}
					}
					?>
					</td>
					</tr>
					<tr>
					<td colspan="2" style="text-align:center;">&nbsp;
					<?php
					}
					?>
					</td>
				</tr>
				<tr>
					<td>
						<span>Identifiant : </span> 
					</td>
					<td>
					<input type="text" name="login" id="login" value="" <?php if(isset($_ERREURS["login_used"])){ ?>style="background-color: #DD3333;"<?php }?>>
					<?php if(isset($_ERREURS["login_used"])){ ?>
					<script type="text/javascript">
						Event.observe("login", "change", function(evt){
							Event.stop(evt);
							$("login").style.backgroundColor = "#FFF";
						}, false);
					</script>
					<?php } ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>
						<span>Mot de passe : </span> 
					</td>
					<td>
						<input type="password" name="password" id="password" value="">
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>
						<span>Confirmez le mot de passe : </span> 
					</td>
					<td>
						<input type="password" name="password_confirm" id="password_confirm" value="">
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>
						<span>Langage : </span>
					</td>
					<td>
						<select id="user_id_langage"  name="user_id_langage">
							<?php foreach ($langages as $langage){ ?>
								<option value="<?php echo $langage['id_langage']?>">
								<?php echo htmlentities($langage['lib_langage'])?>
								</option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" class="txt_violet"></td>
				</tr>
				<tr>
					<td class="voidlogin">
						
					</td>
					<td>
						<input type="button" id="bt_inscription" class="bt_connex" value="Inscription">
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding-right=25px;"></td>
				</tr>
				</table>
				</td></tr></table>
				</form>
				<script type="text/javascript">
				Event.observe("bt_inscription", "click", function(evt){
					Event.stop(evt);
					if($('login').value == ""){
						alerte.alerte_message('Erreur !', 
								'Veuillez saisir un identifiant !', 
								'<input type="button" id="bouton0" value="Retour" />');
					}else if($('password').value == ""){
						alerte.alerte_message('Erreur !', 
								'Veuillez saisir un mot de passe !', 
								'<input type="button" id="bouton0" value="Retour" />');
					}else if($('password_confirm').value  == ""){
						alerte.alerte_message('Erreur !', 
								'Veuillez confirmer votre mot de passe !', 
								'<input type="button" id="bouton0" value="Retour" />');
					}else if($('password').value != $('password_confirm').value){
						alerte.alerte_message('Erreur !', 
								'Les mots de passe saisis ne correspondent pas !', 
								'<input type="button" id="bouton0" value="Retour" />');
					}else{
						$('form_inscription').submit();
					}
				}, false);
				</script>
				<?php } else {
					// Affichage des erreurs
					foreach ($_ALERTES as $alerte => $value) {
						if ($alerte == "login_used" || $alerte == "used_pseudo") { ?>
						Erreur ! <br />
						Le nom d'utilisateur <i><b><?php echo $pseudo;?></b></i> est déjà utilisé.<br />
						Veuillez en choisir un autre : 
						<a href="_valider_inscription.php?coord=<?php echo $ref_coord;?>&code=<?php echo $code;?>">Inscription</a>
						<?php } elseif ($alerte == "params" || $alerte == "no_ref_coord_user" || $alerte == "no_uci_existing") {
						?>
						Erreur détectée : Veuillez vérifier le lien !
						<?php 	
						} elseif ($alerte == "no_pseudo") {
						?>
						Erreur : Veuillez saisir un pseudo !
						<?php 	
						} elseif ($alerte == "used_ref_coord_user") {
						?>
						Erreur détectée : Un utilisateur a déjà été créé pour ce compte !
						<?php 
						} else {
							echo $alerte . ' => ' . $value;
						} 
					}
				} 
				?>
				</div>

				</td>
				<td width="185px"><a href="http://www.lundimatin.fr" target="_blank"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme(); ?>images/lmb_connexion.jpg" border="0" /></a></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
				<td colspan="2" style="padding-left:80px;">
				<div style="text-align:left; vertical-align: bottom" class="grey_text" >
					<a href="http://www.lundimatin.fr" target="_blank" class="grey_text">
						Lundi Matin Business est un logiciel libre de gestion d'entreprise</a>, 
						distribu&eacute; sous licence 
						LMPL
				</div>
				
				La présente version modifiée de Lundi Matin Business est une distribution <a href="http://www.groovyprog.com/sootherp/" target="_blank" class="grey_text" rel="noreferrer">SoothERP</a>
				
				</td>
				</tr>
			</table>
		</div>
	</div>
	<div id="arrondiBas">
		&nbsp;
	</div>
</div>
<script type="text/javascript">
	centrage_element('alert_pop_up');
</script>
</body>
</html>