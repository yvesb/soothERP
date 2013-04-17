<?php
// Variable pour renvoi à page d'erreur
$location = "Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/#erreur_download_backup.php";

if (isset($_GET['file']))
{

// Prévient d'une injection qui tenterait de remonter vers un répertoire parent du répertoire backup

if (strpos($_GET['file'], "../backup/") == 0)
	{
	// le seul chemin autorisé possible débute par ce pattern, on le masque provisoirement pour tester d'autres inclusions malveillantes
	// qui checheraient à remonter l'arborescence
	$_GET['file']= str_replace ("../backup/", "", $_GET['file']); 
	}
	else
		{
		// Si pas le pattern recherché => envoi vers page d'erreur
		header ("$location");
		}

// en dehors du chemin autorisé (masqué pour le moment), il ne doit pas y avoir de ./ possible
if (preg_match( '#\..*/#',$_GET['file'])) 
	{
	// Tentative possible de remonter l'arborescense => envoi vers page d'erreur
	header ("$location");
	}
	else
		{
		// on a passé les tests, on est donc bien situé sous ..backup/ où il ne peut y avoir accès qu'à des backups.
		// on replace le début de chemin masqué.
		$_GET['file'] = '../backup/'.$_GET['file'];
		}
}
	else
		{
		// Pas de fichier passé dans la variable => envoi vers page d'erreur
		header ("$location");
		}

  // Le fichier existe-il ?
  if( file_exists($_GET['file']) )
  { 
  // Download
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename='. basename($_GET['file']));
  header('Content-Transfer-Encoding: binary');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');
  header('Content-Length: ' . filesize($_GET['file']));
  readfile($_GET['file']);
  exit;  

  } 
  
  else 
  {
  // Pas de fichier correspondant => envoi vers page d'erreur
  header ("$location");
  }

?>