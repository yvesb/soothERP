<?php

// *************************************************************************************************************
// ERREUR 404 DANS PROFIL COLLAB
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
</script><div class="emarge">
<div style="font:16px Arial, Helvetica, sans-serif; text-align:center">
	<br />
	<br />
	<br />
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/404.png" align="absbottom" />
</div>
<SCRIPT type="text/javascript">
//on masque le chargement
H_loading();
</SCRIPT>