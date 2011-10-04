<?php

// *************************************************************************************************************
// PAGE INDEX DU PROFIL COLLAB
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
<div >
	<?php
	if (@remote_file_exists ("http://www.lundimatin.fr/site/user_LMB_rss.xml")) {
		Universal_Reader("http://www.lundimatin.fr/site/user_LMB_rss.xml");
		echo Universal_Display(15, false, true, false);
	}
	?>
</div>