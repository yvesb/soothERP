<?php

// *************************************************************************************************************
// CONTROLE DU THEME
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<br><br><br>
Ceci est la page d'accueil du site Internet de la société.
<br><br><br><br><br>

<?php
if ($_SESSION['user']->getLogin()) {
	echo "<a href='user_choix_profil.php'>Choix de votre profil</a>";
}
else {
	echo "Vous n'etes pas identifié: 
	<a href = 'user_login.php' target='_self'>IDENTIFICATION</a>";
}
?>

<br>
<br>
<br>
<a href = '_session_stop.php' target='_self'>FIN DE SESSION</a>