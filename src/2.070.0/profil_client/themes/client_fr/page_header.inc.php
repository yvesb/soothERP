<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php //include ($DIR."site/referencement/referencement.php"); ?>
		<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_common_style.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_content.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_formulaire.css" rel="stylesheet" type="text/css" />
		
		<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/prototype.js"	></script>
		<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_general.js"	></script>
		<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_documents.js"></script>
		<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/_panier.js"		></script>
		<script type="text/javascript">
		
			function PopupCentrer(page,largeur,hauteur,optionsi) {
			  var top=(screen.height-hauteur)/2;
			  var left=(screen.width-largeur)/2;
			  window.open(page,"","top="+top+",left="+left+",width="+largeur+",height="+hauteur+","+optionsi);
			}
		</script>
	</head>
<body>
<div class="conteneur">