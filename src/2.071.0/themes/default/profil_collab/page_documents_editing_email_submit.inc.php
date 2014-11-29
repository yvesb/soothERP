<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Envois du document par email</title>

        <link href="<?php echo $DIR . $_SESSION['theme']->getDir_css() ?>_common_style.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $DIR . $_SESSION['theme']->getDir_js() ?>prototype.js"/></script>
        <style type="text/css">
            <!--
            body {
                margin: 5px;
                font:12px Arial, Helvetica, sans-serif;
            }
            img {
                border:0px;
            }
            -->
        </style>
    </head>

    <body>
        <div style="display:block; float:right; position:absolute; top:0px; right:0px; z-index:500"><br>
                <a href="http://www.sootherp.fr" target="_blank" rel="noreferrer"><img src="<?php echo $FICHIERS_DIR; ?>images/powered_by_sootherp.png" width="120"/></a>
                <a href="http://www.lundimatin.fr" target="_blank" rel="noreferrer"><img src="<?php echo $FICHIERS_DIR; ?>images/powered_by_lundimatin.png" width="120"/></a>
        </div>
        <p><strong>Envoi du document par email</strong></p>
        <p style="text-align:center">L'envoi du document a bien &eacute;t&eacute; effectu&eacute;. <br />
            <script type="text/javascript">
            </script>
        </p>
    </body>
</html>
