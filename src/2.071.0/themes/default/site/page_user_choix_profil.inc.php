<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************
// Variables nécessaires à l'affichage
$page_variables = array("profils_allowed", "_ALERTES");
check_page_variables($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <script src="<?php echo $DIR . $_SESSION['theme']->getDir_js(); ?>prototype.js"/></script>
        <script src="<?php echo $DIR . $_SESSION['theme']->getDir_js() ?>swfobject.js"></script>
        <link href="<?php echo $DIR . $_SESSION['theme']->getDir_css() ?>_common_style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $DIR . $_SESSION['theme']->getDir_css(); ?>_log.css" rel="stylesheet" type="text/css" />
    </head>

    <body>

        <div class="header" style="background-image:url(<?php echo $DIR . $_SESSION['theme']->getDir_gtheme(); ?>images/head_bg.gif); background-repeat:repeat-x; height:61px">
            <span style="height:60px; float:right; vertical-align: middle; line-height:60px; padding-right:25px;"><div id="waiting" style="display:none; text-align:center">
                    <div id="boxcontent">
                        <strong>Chargement en cours</strong>
                    </div>
                </div></span>
            <div class="title_install">SoothERP <span class="compl_title">logiciel de gestion d'entreprise, fork de la version community de Lundi Matin Business®</span></div>
        </div><br /><div style="text-align:center; margin:80px 0px;">
            <div class="radius_main" style="width:710px;	margin:0px auto;">
                <form action = "" method="post" name="choix_profil">
                    <input type="hidden" name="id_profil" value="0">


                        <script type="text/javascript">
                            // <![CDATA[

                            swfobject.embedSWF("<?php echo $DIR . $_SESSION['theme']->getDir_gtheme() ?>images/waiting.swf", "boxcontent", "142", "15", "9.0.0", "expressInstall.swf", false, {wmode: "transparent", quality: "high", allowScriptAccess: "always"}, {id: "swf_waiting"});

                            // ]]>
                        </script>

                        <div id="choix_profil">
<?php
$i = 1;
foreach ($profils_allowed as $id_profil => $profil) {
    if ($id_profil == $VISITEUR_ID_PROFIL) {
        continue;
    }
    $dsl = ($i % 2) ? '<div style="width:100%; height:173px; ">' : '';
    echo $dsl;
    ?>

                                <div style="width:143px; height:143px; float:left; background-image: url(<?php echo $DIR . $_SESSION['theme']->getDir_gtheme() ?>images/profil_<?php echo $i ?>.gif); background-repeat:no-repeat; margin:10px; cursor:pointer;" onclick="document.choix_profil.id_profil.value = '<?php echo $id_profil ?>';
                            document.choix_profil.submit();
                            document.getElementById('waiting').style.display = 'block';" > 
                                    <div style=" width:100%; height:143px; text-align:center; line-height:143px; margin-left: auto; margin-right: auto; font-family:Arial, Helvetica, sans-serif; font-weight:bolder; font-size:1em; color:#636363;">
                                        <?php echo $_SESSION['profils'][$id_profil]->getLib_profil(); ?>
                                    </div>
                                </div>
                                <?php
                                $dsl = ($i % 2) ? '' : '</div>';
                                echo $dsl;
                                if ($i == 4) {
                                    $i = 1;
                                } else {
                                    $i++;
                                }
                            }
                            ?>
                        </div>
                </form>
                <br />
				<div style="display:block; float:right; position:absolute; bottom:0px; right:0px; z-index:500">
					<!--<a href="http://www.sootherp.fr" target="_blank" rel="noreferrer"><img src="<?php echo $FICHIERS_DIR; ?>images/powered_by_sootherp.png" width="120"/></a><br />-->
					<span style="color: #888; font-size: 11px; position:absolute; bottom:4px; right:130px;">SoothERP,&nbsplogiciel&nbspde&nbspgestion&nbspd'entreprise&nbspopen&nbspsource&nbspet&nbspgratuit&nbsp<a href="http://www.sootherp.fr" style="color: #888;text-decoration: none;" target="_blank">http://www.sootherp.fr</a></span>				
					<a href="http://www.lundimatin.fr" target="_blank" rel="noreferrer"><img src="<?php echo $FICHIERS_DIR; ?>images/powered_by_lundimatin.png" width="120"/></a>
				</div>
            </div></div>
    </body>
