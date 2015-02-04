<?php
// *****************************************************************
// ERREUR 404 DANS PROFIL COLLAB
// *****************************************************************
// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);

// AFFICHAGE
?>
<div class="emarge">
<div style="font:16px Arial, Helvetica, sans-serif; text-align:center;margin-top:85px;">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_gtheme()?>images/404.png" align="absbottom" />
</div>
<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>