<?php
// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ("id_graphic_event");
check_page_variables ($page_variables);


// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<script type="text/javascript">
panneau_eition_reset_formulaire();
page.traitecontent("agenda_mois","agenda_view_mois.php?Udate_used="+Udate_used, true ,"grille_agenda");
</script>
