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
	if (@remote_file_exists ("http://www.sootherp.fr/feed/") && $AFFICHAGE_NEWS) {
		Universal_Reader("http://www.sootherp.fr/feed/");
		echo '<div class="titre_accueil_news">
		News Sooth ERP
		</div>';
		echo utf8_decode(Universal_Display(15, false, true, false));
	}
	?>
</div>