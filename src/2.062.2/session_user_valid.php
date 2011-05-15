<?php

// *************************************************************************************************************
// PAGE DE RESULTAT DU RE-LOGIN DE L'UTILISATEUR ()
// *************************************************************************************************************

$_PAGE['MUST_BE_LOGIN'] = 0;

require ("_dir.inc.php");
require ($DIR."_session.inc.php");


// Vérification de la page de provennance
if (isset ($_REQUEST['page_from'])) {  $page_from = &$_REQUEST['page_from'];  }
else {                                 $page_from = "";  }
// Vérification de l'id_profil
if (isset ($_REQUEST['id_profil'])) {  $id_profil = &$_REQUEST['id_profil'];  }
else {                                 $id_profil = "";  }


// Identification de l'utilisateur
if (isset ($_REQUEST['login'])) { 
  $login_result = $_SESSION['user']->login ($_REQUEST['login'], $_REQUEST['code'] , $page_from, $id_profil);
  
	if ($login_result) {
		?>
		<script type="text/javascript">
			window.parent.restart_session();
			window.parent.refresh_cache ();
		</script>
		<?php 
		
		} elseif (isset ($GLOBALS['_INFOS']['redirection'])) {
				
		?>
			<script type="text/javascript">
				window.parent.location.replace("<?php echo $GLOBALS['_INFOS']['redirection']; ?>");
			</script>
		<?php 
				
		} else {
						
		?>
			<script type="text/javascript">
				window.parent.document.getElementById("session_user_message").innerHTML = "Identification incorrecte! <br/><?php echo $_REQUEST["try"]+1;?>éme essai.";
				window.parent.document.getElementById("try").value = <?php echo $_REQUEST["try"]+1;?>;
			</script>
		<?php 
		}
}


?>