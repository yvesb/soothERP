<?php
// *************************************************************************************************************
// FONCTIONS DE GESTION DES ERREURS
// *************************************************************************************************************

// AFFICHAGE DE TOUTES LES ERREURS
error_reporting(E_ALL);


// *************************************************************************************************************
// RECUPERATION DES ERREURS SYSTEMES
// *************************************************************************************************************
function error_handler ($errno, $errstr, $errfile, $errline) {
	if(error_reporting() == 0) {
            return;
        }
        $erreur = "ERREUR PHP: [".$errno."] \n
	".$errstr."\n
	<b>".$errfile."</b> - ligne <b>".$errline."</b> \n\n";
	alerte_dev ($erreur);
	
	return true;
}

// Déclaration de la fonction de récupération des erreurs systèmes
set_error_handler("error_handler");



// *************************************************************************************************************
// ALERTE LE DEVELOPPEUR DES ERREURS RENCONTREES
// *************************************************************************************************************
function alerte_dev ($erreur) {
	global $_SERVER;
	global $EMAIL_DEV;
	global $ETAT_APPLICATION;
	global $REF_CONTACT_ENTREPRISE;
	global $bdd_user;
	global $bdd_pass;
	
	
	$rapport = "
	<b>Alerte de développement LMB</b><br />
	--------------<br />";
	
		
		$rapport .= "
		Serveur : ".$_SERVER['REF_SERVEUR']." / ".$_SERVER['SERVER_NAME']." / ".affiche_version ($_SERVER['VERSION'])."<br /> ";
		
		$rapport .= "--------------\n 
		Script en erreur : ".$_SERVER["PHP_SELF"]."\n"; 
		if (isset($_SERVER["HTTP_REFERER"])) {
			$rapport .= "Referer = ".$_SERVER["HTTP_REFERER"]."\n ";
		}
		if (isset($_SERVER["HTTP_USER_AGENT"])) {
		$rapport .= "
			Navigateur : ".$_SERVER["HTTP_USER_AGENT"]."
		--------------\n";
		}
	
	$rapport .= "
	===========================================================================\n
	<b>RAPPORT D'ERREUR SUR SERVEUR ".$_SERVER['REF_SERVEUR']."</b>\n\n

	===========================================================================\n
	".$erreur."

	===========================================================================\n
	<b>INFORMATIONS COMPLEMENTAIRES</b> :\n\n

	Page = ".$_SERVER["PHP_SELF"]."\n
	Page complète = ".$_SERVER["REQUEST_URI"]."\n
  Heure: ".date('d-m-Y H:m:i', time())."\n

  IP = ".$_SERVER['REMOTE_ADDR']."(".$_SERVER["REMOTE_PORT"].")\n\n

  Methode = ".$_SERVER["REQUEST_METHOD"]."\n
  Variables transmises = ".$_SERVER["QUERY_STRING"]."\n "; 
  if (isset($_SERVER["HTTP_REFERER"])) {
  	$rapport .= "Referer = ".$_SERVER["HTTP_REFERER"]."\n ";
  }
  $rapport .= "\n

  Navigateur = "; 
  if (isset($_SERVER["HTTP_USER_AGENT"])) {
  	$rapport .= $_SERVER["HTTP_USER_AGENT"];
  }
  $rapport .= "\n\n

  ============================================================================\n";
  $rapport = str_replace ($bdd_user, "toto", $rapport);
  $rapport = str_replace ($bdd_pass, "toto", $rapport);
  
	if ($ETAT_APPLICATION == "DEV") {
		echo nl2br($rapport);
		echo "<b>ENVIRONNEMENT COMPLET </b>:\n\n";

		$tab = debug_backtrace();
		html_entity_decode(elegant_dump( $tab ));
	}
	else {
		if (isset($_SERVER['SERVER_NAME']) && (substr_count($_SERVER['SERVER_NAME'], 'localhost') || substr_count($_SERVER['SERVER_NAME'], '127.0.0.'))) {
		
			echo "<br><br><b>
	LundiMatin Business, le <a href='http://www.lundimatin.fr'>logiciel de gestion commerciale</a> des entreprises <br />
	Une erreur critique a été détectée. <span id='view_rapport' style='cursor: pointer;' onClick='javascript:document.getElementById(\"erreur_report\").style.display=\"\";' >Cliquez ici pour plus d’information.</span><br />

			Veuillez informer l'équipe de Lundi Matin en nous envoyant <a href=\"mailto:dev_team@lundimatin.fr?subject=Erreur d'application LMB&body=".str_replace("\n", "", nl2br(addslashes($rapport)))."\" >un email</a></b><br/> <span id='view_rapport' style='cursor: pointer;' 
			<div id='erreur_report' style='display: none;'>".nl2br($rapport);
			
			echo "<b>ENVIRONNEMENT COMPLET </b>:\n\n";
	
			$tab = debug_backtrace();
			html_entity_decode(elegant_dump( $tab ));
			echo "</div><br/>";
		} else {
			// Envoyer un email au développeur
			if($EMAIL_DEV!=null) {
				@mail ($EMAIL_DEV, "ERREUR LMB", $rapport);
				$mailStatus = "Une alerte a été envoyée à votre administrateur.<br />";
			}
			else {
				$mailStatus = "Configurez l'adresse email de l'administrateur dans le fichier de configuration serveur afin qu'il reçoive automatiquement les erreurs par email.<br />";
			}
	
			echo "<br><br>
	LundiMatin Business, le <a href='http://www.lundimatin.fr'>logiciel de gestion commerciale</a> des entreprises <br />
	Une erreur critique a été détectée. <span id='view_rapport' style='cursor: pointer;' onClick='javascript:document.getElementById(\"erreur_report\").style.display=\"\";' >Cliquez ici pour plus d'information.</span><br />".$mailStatus."

			<div id='erreur_report' style='display: none;'>".nl2br($rapport)."</div>";
		}
	}

	exit();
}


// Fonction affichant de manière lisible le dump d'une variable.
// Source INTERNET
function elegant_dump(&$var, $var_name='', $indent='', $reference='') {
	global $bdd_user;
	global $bdd_pass;
	
	static $elegant_dump_indent = '.&nbsp;&nbsp;&nbsp;&nbsp; ';
   
   $reference=$reference.$var_name;

   // first check if the variable has already been parsed
   $keyvar = 'the_elegant_dump_recursion_protection_scheme';
   $keyname = 'referenced_object_name';
   if (is_array($var) && isset($var[$keyvar])) {
       // the passed variable is already being parsed!
       $real_var=&$var[$keyvar];
       $real_name=&$var[$keyname];
       $type=gettype($real_var);
       echo "<br /> $indent<b>$var_name</b> (<i>$type</i>) = <font color=\"red\">&amp;$real_name</font>\n";
   } else {

       // we will insert an elegant parser-stopper
       $var=array($keyvar=>$var,
                   $keyname=>$reference);
       $avar=&$var[$keyvar];

       // do the display
       $type=gettype($avar);
       // array?
         if (is_array($avar)) {
           $count=count($avar);
           echo "<br /> $indent<b>$var_name</b> (<i>$type($count)</i>) {\n";
           $keys=array_keys($avar);
           foreach($keys as $name) {
               $value=&$avar[$name];
               elegant_dump($value, "['$name']", $indent.$elegant_dump_indent, $reference);
           }
           echo "$indent}\n";
       } else
       // object?
         if (is_object($avar)) {
           echo "<br /> $indent<b>$var_name</b> (<i>$type</i>) {\n";
           foreach($avar as $name=>$value) elegant_dump($value, "-&gt;$name", $indent.$elegant_dump_indent, $reference);
           echo "<br /> $indent}\n";
       } else
       // string?
       if (is_string($avar)){
       	  $avar = str_replace ($bdd_user, "toto", $avar);
  				$avar = str_replace ($bdd_pass, "toto", $avar);
       	echo "<br />  $indent<b>$var_name</b> (<i>$type</i>) = \"".htmlentities($avar)."\"\n";
       }
       // any other?
       else echo "<br /> $indent<b>$var_name</b> (<i>$type</i>) = $avar\n";

       $var=$var[$keyvar];
   }
}



// *************************************************************************************************************
// GESTION DES ERREURS : VARIABLE D'AFFICHAGE NON DEFINIE  
// *************************************************************************************************************
function error_checking_page_variables ($tab) {
	global $THEME_NAME;
	global $THEME_DIR;

	$erreur = "
	<b>ERREUR THEME </b>: Les variables d'affichage ne sont pas toutes définies.\n\n
	
	Nom du thème : <b>".$_SESSION['theme']->getLib_theme()." [".$_SESSION['theme']->getId_theme()."]</b>\n
	Répertoire : <b>".$_SESSION['theme']->getDir_theme()."</b>\n\n

	<table border=1 cellpadding=3 cellspacing=0 width='60%'>";
	foreach ($tab as $variable) {
		// Recherche du nom de la variable si il s'agit d'un élément de tableau
		$var_name = $variable;
		$var_component = "";
		
		if (strpos($variable, "[")) {
			$var_name = substr($variable, 0, strpos($variable, "["));
			$var_component = substr($variable, strpos($variable, "[")+2, strlen($variable)-strpos($variable, "]")-3);
		}
		global ${$var_name};

		$erreur .= "<tr>
			<td>".$variable." </td>";
		
		if (isset(${$variable})) { 
			$erreur .= "<td>OK</td>
									<td>&nbsp;";
			if (is_object(${$variable})) {
				$erreur.= "OBJET[".$variable."]";
			}
			else {
				$erreur.= ${$variable}."</td>";
			}
		}
		elseif (isset(${$var_name}[$var_component])) {
			$erreur .= "<td>OK</td>
									<td>&nbsp;".${$var_name}[$var_component]."</td>";
		}
		else {
			$erreur .= "<td>Non définie</td><td>&nbsp;</td>";
		}
		$erreur .= "</tr>";
	}
	$erreur .= "</table>\n";
	
	alerte_dev ($erreur);
}


?>
