<?php
// *************************************************************************************************************
// CLASSES ET FONCTIONS DE GESTION DES EXCEPTIONS
// *************************************************************************************************************



// *************************************************************************************************************
// RECUPERATION DES EXCEPTIONS NON RECUES
// *************************************************************************************************************


function exception_handler ($exception) {
    global $bdd, $ETAT_APPLICATION;
    $exceptions = $exception->getTrace();


    // Exceptions à l'affichage complet du message d'erreur visant a ne pas afficher d'informations techniques sur le serveur.
    // Soyez plus restrictif si vous le souhaitez pour ne rien laisser filtrer en cas de bug
    if (substr($exception->getMessage(), 0, strlen("could not find driver")) == "could not find driver") {
        $erreur = "Driver PDO non installé";
    }
    elseif (substr_count($exception->getMessage(),"SQLSTATE[42000]") || substr_count($exception->getMessage(),"SQLSTATE[HY000]")) {
        $erreur = "Erreur lors de la requête serveur MySQL ";
        if($ETAT_APPLICATION == 'DEV') {
            $erreur .= "<br />";
            $erreur .= "Dernières requêtes : '".$bdd->affiche_stats()."'";
        }
    }
    else {
        $erreur = "<b>EXCEPTION NON RECEPTIONNEE</b>: <br>";
        $erreur .= "Message : ".$exception->getMessage()." [".$exception->getCode()."] <br>
		Localisation : <b>Ligne ".$exception->getLine()."</b> - <b>".$exception->getFile()."</b><br><br><hr>";

        $erreur .= "Retour d'information du script : ";
        foreach ($GLOBALS['_INFOS'] as $info => $un) {
            $erreur .= "<li>".$info;
        }
        $erreur .= "<br><br>Retour d'alerte du script : ";
        foreach ($GLOBALS['_INFOS'] as $alerte => $un) {
            $erreur .= "<li>".$alerte;
        }
        $erreur .= "<br><hr>";
        for ($i=0; $i<count($exceptions); $i++) {
            foreach ($exceptions[$i]['args'] as $index => $trace) {
                $erreur .= "<b>#".$index."</b> ";
                if (is_object($trace)) {
                    $erreur.= "OBJET ".get_class($trace);
                }
                else {
                    $erreur .= $trace;
                }
                $erreur .= " <br>";
            }
        }
        $erreur .= "<br>";
    }

    $mess = $exception->getMessage();
    if($exception instanceof PDOException){
        $mess .= "| \n".$exception->errorInfo[999];
    }

    // Il s'agit d'une exception non reçues, donc à traiter comme une erreur
    alerte_dev ($erreur, " ".substr($exception->getFile(),strlen($_SERVER['DOCUMENT_ROOT']))." - ".$exception->getLine(), $exception->getCode(), $mess, $exception->getFile(), $exception->getLine());
}

// Déclaration de la fonction de récupération des exceptions non recues
set_exception_handler('exception_handler');


// *************************************************************************************************************
// GESTION DES EXCEPTIONS: Accès restreint
// *************************************************************************************************************
class AccesException extends Exception {
	private $stop;
	
	public function __construct($id_profil) {
		parent::__construct();
	}
	
	public function alerte () {
		global $DIR;
		global $ID_PROFIL;
			// Affichage du message d'erreur
			echo "<b>Erreur : Accès à la page ".$_SERVER['PHP_SELF']." restreint.</b><br>
			Vous n'etes pas autorisé à consulter cette page.<br>
			Votre profil : ".$_SESSION['user']->getId_profil()."<br>
			Profil de la page : ".$ID_PROFIL."<br><br>
	
			<a href='".$DIR."'>Retour à l'accueil</a>";
			
			exit();
	}
}



// *************************************************************************************************************
// GESTION DES EXCEPTIONS: Exception générique
// *************************************************************************************************************
class IyException extends Exception {
	private $stop;
	
	public function __construct($message = NULL, $stop = 1, $code = 0) {
		$this->stop = $stop;
		parent::__construct($message, $code);
	}
	
	public function alerte () {
		// Affichage du message d'erreur
		echo "<b>Erreur : ".$this->message."</b><br>";

		// Choix concernant la suite des évennements
		switch ($this->stop) {
			case 0:
				// Simple affichage, le script continuera a etre executé
			break;
			case 1:
				echo "Script arreté";
				exit();
			break;
			case 2: 
				alerte_dev ($this->message);
			break;
		}
	}
}

?>