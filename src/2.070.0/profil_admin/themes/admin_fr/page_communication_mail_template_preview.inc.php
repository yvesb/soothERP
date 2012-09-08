<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************




// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $mail_template->getMail_html_charset();?>" />
<title><?php echo $mail_template->getLib_mail_template();?></title>

<link href="http://<?php echo $_SERVER['HTTP_HOST'].str_replace("profil_admin/communication_mail_template_preview.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $MAIL_TEMPLATES_CSS_DIR)."defaut_css.css";?>" rel="stylesheet" type="text/css" />

<?php if ($mail_template->getMail_css_template()) { ?>
<link href="http://<?php echo $_SERVER['HTTP_HOST'].str_replace("profil_admin/communication_mail_template_preview.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $MAIL_TEMPLATES_CSS_DIR.$mail_template->getMail_css_template());?>" rel="stylesheet" type="text/css" />
<?php } ?>
</head>

<body>
<div class="content">
	<?php if ($mail_template->getHeader_img_template()) { ?>
	<img src="http://<?php echo $_SERVER['HTTP_HOST'].str_replace("profil_admin/communication_mail_template_preview.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $MAIL_TEMPLATES_IMAGES_DIR.$mail_template->getHeader_img_template());?>" style="border:0px;"/><br />
	<?php } ?>
	
	<div>
	<?php echo $mail_template->getHeader_mail_template();?><br />
	Contenu de votre email.<br />
	<br />
	<br />
	<br />
	<?php echo $mail_template->getFooter_mail_template();?><br />
	</div>
	
	<?php if ($mail_template->getFooter_img_template()) { ?><br />
	<img src="http://<?php echo $_SERVER['HTTP_HOST'].str_replace("profil_admin/communication_mail_template_preview.php", "", $_SERVER['PHP_SELF']).str_replace("..", "", $MAIL_TEMPLATES_IMAGES_DIR.$mail_template->getFooter_img_template());?>" style="border:0px"/>
	<?php } ?>
</div>
</body>
</html>
