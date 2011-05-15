<?php

// *************************************************************************************************************
// insertion d'image dans un descriptif
// *************************************************************************************************************

// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<SCRIPT type="text/javascript">


parent.document.getElementById("image_choix_editor").style.display="none";
parent.document.getElementById("<?php echo $_REQUEST['ifr']?>").contentWindow.focus();
//parent.<?php echo $_REQUEST['proto']?>.restoreRange();
parent.<?php echo $_REQUEST['proto']?>.HTML_exeCmd(parent.command, "<?php echo $complete_url;?>");
//on masque le chargement
parent.H_loading();
</SCRIPT>
</div>