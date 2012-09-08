<?php
// *************************************************************************************************************
// IMPORT D'INSCRIT A LA NEWSLETTER AU FORMAT CSV
// *************************************************************************************************************

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (preg_match("`\.csv$`i", $_FILES['liste_csv']['name']) == 0)
    {?>
<script type="text/javascript">
    window.parent.alerte.alerte_erreur('Erreur saisie', "Le fichier que vous avez indiqué n'est pas au format csv.",'<input type="submit" id="bouton1" name="bouton1" onClick="window.parent.location.reload()" value="Ok" />');
	window.parent.location.reload();
</script><?php
    }
else
{
    $fichier = file_get_contents($_FILES['liste_csv']['tmp_name']);
    $fichier = preg_split("`[;|\n]`", $fichier);


    $newsletter = new newsletter ($_REQUEST['id_news']);
    $id_newsletter =$newsletter->getId_newsletter();
    $i = 0;

	if ($_POST['format_csv'] == "nom;email")
	{
		while (!empty($fichier[$i]))
		{
			if ($fichier[$i] != "email" && $fichier[$i] != "nom")
				$newsletter->add_newsletter_inscrit ($fichier[$i + 1], $fichier[$i]);
			$i += 2;
		}
	}

	else 
	{
		 while (!empty($fichier[$i]))
		{
			if ($fichier[$i] != "email" && $fichier[$i] != "nom")
				$newsletter->add_newsletter_inscrit ($fichier[$i++], $fichier[$i++]);
			else
				$i += 2;
		}
}	
    ?>
<script type="text/javascript">
    window.parent.alerte.alerte_erreur('Import réussi', "L'import a bien été effectué.",'<input type="submit" id="bouton2" name="bouton2" onClick="window.parent.location.reload()" value="Ok" />');
</script> <?php
}
?>
