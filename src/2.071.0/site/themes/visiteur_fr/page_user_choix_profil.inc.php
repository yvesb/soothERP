<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("profils_allowed", "_ALERTES");
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>javascript/prototype.js"/></script>
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/swfobject.js"></script>
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_common_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>css/_log.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="header" style="background-image:url(<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/head_bg.gif); background-repeat:repeat-x; height:61px">
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
		var so = new SWFObject("<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/waiting.swf", "Lundi_Matin", "142", "14", "7", "#ffffff" );
		so.addVariable("flashVarText", "Lundi_Matin");
		so.addParam("wmode", "transparent");
		so.addParam("quality", "high");
		so.addParam("id", "swf_waiting");
		so.addParam("allowScriptAccess", "always");
		so.write("boxcontent");
		// ]]>
	</script>

<div id="choix_profil">
			<?php
			$i=1;
			foreach ($profils_allowed as $id_profil => $profil) {
			if ($id_profil == $VISITEUR_ID_PROFIL) {continue;}
		$dsl = ($i % 2)? '<div style="width:100%; height:173px; ">' : '';
		echo $dsl;
				?>
				
				<div style="width:143px; height:143px; float:left; background-image: url(<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/profil_<?php echo $i?>.gif); background-repeat:no-repeat; margin:10px; cursor:pointer;" onclick="document.choix_profil.id_profil.value='<?php echo $id_profil?>'; document.choix_profil.submit();document.getElementById('waiting').style.display='block';" > 
					<div style=" width:100%; height:143px; text-align:center; line-height:143px; margin-left: auto; margin-right: auto; font-family:Arial, Helvetica, sans-serif; font-weight:bolder; font-size:1em; color:#636363;">
					<?php echo $_SESSION['profils'][$id_profil]->getLib_profil(); ?>
					</div>
				</div>
				<?php 
		$dsl = ($i % 2)? '' : '</div>';
		echo $dsl;
				if ($i == 4) {$i = 1; } else {$i++;}
				
			}
			?>
</div>
</form>
<br /><a href="http://www.lundimatin.fr" target="_blank" rel="noreferrer"><img src="<?php echo $DIR;?>/fichiers/images/powered_by_lundimatin.png" width="150"/></a>
</div></div>
</body>
