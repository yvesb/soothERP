<?php

// *************************************************************************************************************
// AFFICHAGE DU CHOIX DES CAISSES
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_common_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_annuaire_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_formulaire.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/mini_moteur.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_articles.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_documents.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/annuaire_modif_fiche.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_small_wysiwyg.css" rel="stylesheet" type="text/css" />
</head>
<body style="OVERFLOW-Y: auto; OVERFLOW-X: auto;">
<script type="text/javascript">

	
</script>
<div  class="emarge"><br />

<div class="titre" id="titre_crea_art" style="width:60%; padding-left:140px">Liste des abonnés &gt;&gt; <?php echo $newsletter->getNom_newsletter() ?> 
 
</div>
<br />
<div class="emarge" style="text-align:right" >
<div>

			<table style="width:100%" border="0" cellpadding="0" cellspacing="0"  >
			<tr>
			<td class="bolder" style="text-align:left">Nom
			</td>
			<td class="bolder" style="text-align:left">Email
			</td>
			<td>&nbsp;
			</td>
			</tr>
			<?php 
			$colorise=0;
			foreach ($liste_envois as $dest) {
				$colorise++;
				$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
				?>
				<tr class="<?php  echo  $class_colorise?>">
				<td style="text-align:left"> <?php echo ($dest->nom);?> 
				</td>
				<td style="text-align:left"><?php echo ($dest->email);?>
				</td>
				<td>
				</td>
				</tr>
				<?php 
			}
			?>
			</table>

</div>
</div>

</div>
</body>
</html>