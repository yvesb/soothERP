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
Ceci est la page d'accueil.
<br><br><br><br><br>

<?php
if ($_SESSION['user']->getLogin()) {
	echo "<a href='user_choix_profil.php'>Choix de votre profil</a>";
}
else {
	echo "Vous n'etes pas identifié: 
	<a href = 'http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."../site/__user_login.php' target='_self'>IDENTIFICATION</a>";
}
?>

<br>
<br>
<br>
<a href = '<?php echo"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."../site/"; ?>__session_stop.php' target='_self'>FIN DE SESSION</a>