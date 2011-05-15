<?php

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if (array_key_exists("cp", $_REQUEST)) {
  $tomorrow = 0;//60*60*24; // en nb de secondes
  header("Cache-Control: max-age=$tomorrow");
  print_plain();
}
else {
  print "Usage : $_SERVER[PHP_SELF]?cp=un-nom";
}

function print_plain() {
  header("Content-type: text/html; charset=windows-1252");
  get_communes(str_replace(" ", "",$_REQUEST["cp"]));
  
}

function get_communes($cp) {
	global $bdd;
	global $DIR;
	global $NB_VILLES_AFFICHEES;
  $citys = array();
		$sql = "SELECT `ville`,`code_postal`,`id_ville`
				FROM `villes`
				WHERE `code_postal` LIKE '%$cp%'";
		$req 	= $bdd->query ($sql );
	
	// on boucle sur tous les éléments
	while ($row = $req->fetchObject()) { $citys[] = $row; }
		$i=0;
		if (count($citys)>0){
			echo '<a href="#" id="supprime_'.$_REQUEST["choix_ville"].'" style="float: right;"><img src="'.$DIR.$_SESSION['theme']->getDir_theme().'images/supprime.gif" border="0"></a>';
			echo '<ul class="complete_ville" style="width:250px">'; 
			foreach ($citys as $city) {
				if ($i < $NB_VILLES_AFFICHEES) {
				echo ' <li class="complete_ville" id="'.$_REQUEST["choix_ville"].'_'.$i.'">'.htmlentities($city->ville).'</li>'; 
				} elseif ($i == $NB_VILLES_AFFICHEES)  {echo('<li>...</li>'); }
			$i++;
		} 
		echo '</ul>'; 
		echo '<script type="text/javascript"> ';
		echo 'Event.observe("supprime_'.$_REQUEST["choix_ville"].'", "click",  function(evt){Event.stop(evt); $("'.$_REQUEST["choix_ville"].'").style.display="none"; $("'.$_REQUEST["iframe_choix_ville"].'").style.display="none";}, false);';
			
		$i=0;
		foreach ($citys as $city) {
			echo 'Event.observe("'.$_REQUEST["choix_ville"].'_'.$i.'", "mouseout",  function(){changeclassname ("'.$_REQUEST["choix_ville"].'_'.$i.'", "complete_ville");}, false);
						Event.observe("'.$_REQUEST["choix_ville"].'_'.$i.'", "mouseover",  function(){changeclassname ("'.$_REQUEST["choix_ville"].'_'.$i.'", "complete_ville_hover");}, false);
						Event.observe("'.$_REQUEST["choix_ville"].'_'.$i.'", "click",  function(){$("'.$_REQUEST["ville"].'").value="'.htmlentities($city->ville).'"; $("'.$_REQUEST["choix_ville"].'").style.display="none"; $("'.$_REQUEST["iframe_choix_ville"].'").style.display="none";}, false);';
				$i++;
			if ($i >= $NB_VILLES_AFFICHEES)  exit('</script>'); 
		} 
	echo '</script>';
	}
}

?>