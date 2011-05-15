<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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
</script>
<div class="emarge">
<div style="height:50px">
<p class="titre">Mes T&acirc;ches</p>

<div id="liste_taches_content" class="articletview_corps"  style="OVERFLOW-Y: auto; OVERFLOW-X: auto; width:100%; height:350px;">
<?php 
include $DIR.$_SESSION['theme']->getDir_theme()."page_planning_taches_liste.inc.php";
?>
</div>



</div>
</div>


<SCRIPT type="text/javascript">

function setheight_taches(){
set_tomax_height("liste_taches_content" , -32);
}
Event.observe(window, "resize", setheight_taches, false);
setheight_taches();


//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>