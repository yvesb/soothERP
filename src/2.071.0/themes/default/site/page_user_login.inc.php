<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************
// Variables nécessaires à l'affichage
$page_variables = array("page_from", "MODE_IDENTIFICATION", "users", "predefined_user", "_ALERTES");
check_page_variables($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Logiciel de gestion Sooth ERP, page d'identification de <?php echo $nom_entreprise; ?></title>
        <script src="<?php echo $DIR . $_SESSION['theme']->getDir_js(); ?>prototype.js"/></script>
        <script src="<?php echo $DIR . $_SESSION['theme']->getDir_js(); ?>swfobject.js"></script>
        <style src="<?php echo $DIR . $_SESSION['theme']->getDir_css(); ?>_client.css"></style>
        <script type="text/javascript">
            function LoadCss_log(url) {
                var scriptObj = document.createElement('link');

                scriptObj.type = 'text/css';
                scriptObj.rel = 'stylesheet';
                scriptObj.href = url;

                document.getElementsByTagName("head")[0].appendChild(scriptObj);
            }

            if (window.parent.$("sub_content")) {
<?php
if (isset($_REQUEST["uncache"])) {
    ?>
                    window.parent.uncache = true;
                    window.parent.refresh_cache();

    <?php
}
?>
                window.parent.$("alert_pop_up").style.display = "block";
                window.parent.$("framealert").style.display = "block";
                window.parent.$("alert_fin_session").style.display = "block";
            }
            if ($("sub_content")) {
<?php
if (isset($_REQUEST["uncache"])) {
    ?>
                    uncache = true;
                    refresh_cache();

    <?php
}
?>
                $("alert_pop_up").style.display = "block";
                $("framealert").style.display = "block";
                $("alert_fin_session").style.display = "block";

            } else {
                LoadCss_log("<?php echo $DIR . $_SESSION['theme']->getDir_css(); ?>_common_style.css");
                LoadCss_log("<?php echo $DIR . $_SESSION['theme']->getDir_css(); ?>_log.css");
            }
        </script>
    </head>

    <body>
		
<?php
// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
//	echo $alerte." => ".$value."<br>";
}
?>
<div class="header" style="background-image:url(<?php echo $DIR . $_SESSION['theme']->getDir_gtheme(); ?>images/head_bg.gif); background-repeat:repeat-x; height:61px">
<span style="height:60px; width:450px; float:right; vertical-align: middle; line-height:60px; padding-right:25px;">
	<div id="waiting" style="display:none; text-align:right">
		<div id="backupwait" style="display:inline">
			<?php echo $SESSION_START_BACKUP ? "Sauvegarde de la base de donnée en cours... &nbsp;&nbsp;" : ""; ?>
		</div>
	<div id="boxcontent" style="display:inline"><strong>Chargement en cours</strong></div>
	</div>
</span>
	<div class="title_install">SoothERP <span class="compl_title">logiciel de gestion d'entreprise, fork de la version community de Lundi Matin Business®</span></div>
	</div><br />
	<div style="text-align:center; margin:80px 0px;">
		<div class="radius_main" style="width:750px;margin:0px auto;">
			<table class="conteneir"><tr>
					<td class="top_log" colspan="2">Connexion à l'interface de  <?php echo addslashes($nom_entreprise); ?></td>
					</tr><tr>
						<td class="bgmain_menu"><br /><br />
							<div style="text-align:left">Veuillez utiliser un identifiant et un mot de passe valide pour accéder à l'application.</div><br />
							
                <div style="text-align:left; color:#0000FF">
                <a href="<?php echo $DIR . "/site"; ?>" style="color:#0000FF">Retour à la page d'accueil du site web.</a>
                </div>
                <br />
                <div style="text-align:center"><img src="<?php echo $DIR . $_SESSION['theme']->getDir_gtheme(); ?>images/verrou.gif"/></div>
                			</td>
                			<td class="content"><div style="display:block; width:455px">


                <br /><br />
                <form action="" method="post" name="form_login" id="form_login" autocomplete="off">
                <input type=hidden name="page_from" value="<?php echo urlencode($page_from); ?>">

					<?php if (isset($_REQUEST["uncache"])) { ?> <input type=hidden name="uncache" value="1"> <?php } ?>

                <table cellpadding="0" cellspacing="0" border=0  style="display:block; width:455px; height: 185px" class="radius_main"  id="global"><tr><td style="text-align:right">
                <table width="355px" border="0" >
                <tr>
                  <td colspan="2" style="text-align:right; padding-right:25px;"><br />
                  </td>
                </tr>
                <tr>
                  <td class="voidlogin" style="width:185px">
                    <span class="grey_bold_text">Identifiant </span> 
                  </td>
               <td>

						
        <script language='javascript'>
            if (!$("sub_content") && !window.parent.$("sub_content")) {
<?php if ($MODE_IDENTIFICATION == "TEXTE") { ?>
                    document.write(' <div style="position:relative; top:0px; left:0px; width:100%; height:0px;"> ');
                    document.write(' <div id="choix_user"  class="choix_users_liste" style="display:none"> ');
					
    <?php if (isset($_COOKIE['predefined_user'])) {
        $u = 1;
        if (count($predefined_user) > 1) {
            foreach ($predefined_user as $p_user) {
                ?>document.write('<li id="us_<?php echo $u; ?>"><?php echo $p_user; ?></li>');
                                                Event.observe("us_<?php echo $u; ?>", "click", function (evt) {
                                                    Event.stop(evt);
                                                    $("login").value = "<?php echo $p_user; ?>";
                                                    $("code_c").focus();
                                                }, false);
                <?php
                $u ++;
            }
        }
    }
    ?>
                                    document.write('</div></div>');
                                    document.write('	<input type=text name="login"  id="login" class="focusinput_xsize">');
    <?php
} else {
    ?>
                                    document.write('  		<select name="login" class="focusinput_xsize">');
    <?php 
    for ($i = 0; $i < count($users); $i++) {
        ?>
                                        document.write('				<option value="<?php echo $users[$i]->ref_user; ?> <?php if (isset($predefined_user[0]) && $predefined_user[0] == $users[$i]->ref_user) {
            echo 'selected="selected"';
        } ?>" ><?php echo str_replace("\r\n", " - ", $users[$i]->pseudo) ?></option>');
        <?php
    }
    ?>
                                    document.write('  		</select>');
    <?php
}
?>
                                document.write('	</td>');
                                document.write('</tr>');
                                document.write('<tr>');
                                document.write('  <td colspan="2" style="text-align:right; padding-right=25px;"><br />');
                                document.write('  </td>');
                                document.write('</tr>');
                                document.write('<tr>');
                                document.write('  <td class="voidlogin">');
                                document.write('    <span class="grey_bold_text">Mot de passe </span> ');
                                document.write('  </td>');
                                document.write('  <td>');
                                document.write('    <input type="password" name="code" id="code_c" value="" class="focusinput_xsize">');
                                document.write('  </td>');
                                document.write('</tr>');
                                document.write('<tr>');
                                document.write('  <td colspan="2" style="text-align:right; padding-right=25px;">');

<?php
// Affichage des erreurs
foreach ($_ALERTES as $alerte => $value) {
    if ($alerte == "login_faux") {
        ?>
                                        document.write('Connexion impossible.<br />Veuillez vérifiez vos identifiants de connexion.');
    <?php
    }
}
?>
                                document.write('<br />');
                                document.write('</td>');
                                document.write('</tr>');
                                document.write('<tr>');
                                document.write('  <td class="voidlogin">');
                                document.write('    ');
                                document.write('  </td>');
                                document.write('  <td>');
                                document.write('    <input type="submit" name="submit" class="bt_connex" value="Connexion">');
                                document.write('  </td>');
                                document.write('</tr>');
                                document.write('<tr>');
                                document.write('  <td colspan="2" style="text-align:right; padding-right=25px;">');
                                document.write('  </td>');
                                document.write('</tr>');
                                document.write('</table>');
                                document.write('<div style="text-align:right"><a href="" style="color:#000000; display:none" >J\'ai oublié mon mot de passe</a></div></td></tr></table>');
                                document.write('</form>');
                                document.write('</div><br /><div>');
                                document.write('<!--<a href="http://www.sootherp.fr" target="_blank" rel="noreferrer"><img src="<?php echo $FICHIERS_DIR; ?>images/powered_by_sootherp.png" width="150"/></a>-->');
                                document.write('<a href="http://www.lundimatin.fr" target="_blank" rel="noreferrer"><img src="<?php echo $FICHIERS_DIR; ?>images/powered_by_lundimatin.png" width="150"/></a></div></td></tr>');
                                document.write('		<tr>');
                                document.write('			<td colspan="2">');
                                document.write('<div style="text-align:center; vertical-align: bottom; padding-left:15px" class="grey_text" >');
                                document.write('<a href="http://www.sootherp.fr" target="_blank" class="grey_text" rel="noreferrer">SoothERP</a> est un logiciel libre de gestion d\'entreprise, distribué sous licence LMPL et en sous-licence SMPL');
                                document.write('</div></td></tr>');
                                document.write('		<tr>');
                                document.write('			<td colspan="2">');
                                document.write('<div style="text-align:center; vertical-align: bottom; padding-left:15px" class="grey_text" >');
                                document.write('<small>SoothERP ne possède aucun lien commercial ou quel qu\'il soit avec la société Lundi Matin S.A.S.</small>');
                                document.write('</div></td></tr>');
                                document.write('</table></div></div>');

                                // <![CDATA[

                                swfobject.embedSWF("<?php echo $DIR . $_SESSION['theme']->getDir_gtheme() ?>images/waiting.swf", "boxcontent", "142", "15", "9.0.0", "expressInstall.swf", false, {wmode: "transparent", quality: "high", allowScriptAccess: "always"}, {id: "swf_waiting"});

                                // ]]>
                            }

<?php
if ($MODE_IDENTIFICATION == "TEXTE" && isset($_COOKIE['predefined_user']) && (count(explode(";", $_COOKIE['predefined_user'])) > 1)) {
    ?>
                                Event.observe("login", "focus", function (evt) {
                                    Event.stop(evt);
                                    $("choix_user").style.display = "block";
                                }, false);
                                Event.observe("choix_user", "click", function (evt) {
                                    Event.stop(evt);
                                    $("choix_user").style.display = "none";
                                }, false);
                                Event.observe("code_c", "focus", function (evt) {
                                    Event.stop(evt);
                                    $("choix_user").style.display = "none";
                                }, false);
    <?php
}
?>

        // Selection du champs a entrer pour s'identifier
                            if ($("code_c")) {
                                $("code_c").focus();
        //affichage du chargement en cours
                            }
                            if ($("form_login")) {
                                document.form_login.onsubmit = function () {
                                    document.getElementById("waiting").style.display = "block";
                                }
                            }
        </script>
    </body>

