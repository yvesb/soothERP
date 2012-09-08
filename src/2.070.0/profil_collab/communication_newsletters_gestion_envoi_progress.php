<?php
// *************************************************************************************************************
// PREVIEW DE MODELE DE MAIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ($DIR."config/newsletter.config.php");


if (!$_SESSION['user']->check_permission ("14")) {
		//on indique l'interdiction et on stop le script
		echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
		exit();
}

	// *************************************************
	// Données pour le formulaire && la requete
	$form['page_to_show'] = $search['page_to_show'] = 1;
	if (isset($_REQUEST['page_to_show'])) {
		$form['page_to_show'] = $_REQUEST['page_to_show'];
		$search['page_to_show'] = $_REQUEST['page_to_show'];
	}
	$form['fiches_par_page'] = $search['fiches_par_page'] = 50;
	if (isset($_REQUEST['fiches_par_page'])) {
		$form['fiches_par_page'] = $_REQUEST['fiches_par_page'];
		$search['fiches_par_page'] = $_REQUEST['fiches_par_page'];
	}
		$query_limit	= (($search['page_to_show']-1)*$search['fiches_par_page']).", ".$search['fiches_par_page'];
	
	
	$id_envoi = $_REQUEST["id_envoi"];
	$page_to_show = $_REQUEST["page_to_show"]+1;
	
	$fiches = array();

	// Recherche
	$query = "SELECT id_envoi, nom, email, lecture
						FROM newsletters_destinataires a 
						WHERE id_envoi = '".$_REQUEST["id_envoi"]."' 
						LIMIT ".$query_limit;
	$resultat = $bdd->query($query);
	while ($fiche = $resultat->fetchObject()) { $fiches[] = $fiche; }
	//echo nl2br ($query);
	unset ($fiche, $resultat, $query);
	
	// Comptage des résultats
	if (!isset($_REQUEST["nb_fiches"])) {
		$nb_fiches = 0;
		$query = "SELECT COUNT(id_envoi) nb_fiches
							FROM newsletters_destinataires 
							WHERE  id_envoi = '".$_REQUEST["id_envoi"]."' ";
		$resultat = $bdd->query($query);
		while ($result = $resultat->fetchObject()) { $nb_fiches += $result->nb_fiches; }
		//echo "<br><hr>".nl2br ($query);
		unset ($result, $resultat, $query);
	} else {
		$nb_fiches = $_REQUEST["nb_fiches"];
	}
	
	
	$envoi = charger_envoi_newsletter ($id_envoi);
	$newsletter = new newsletter ($envoi->id_newsletter);
	
	//entete du mail
	$limite = "_parties_".md5(uniqid(rand()));
	$mail_mime = "Date: ".date("r")."\n";
	$mail_mime .= "MIME-Version: 1.0\n";
	$mail_mime .= "Content-Type: multipart/mixed;\n";
	$mail_mime .= " boundary=\"----=$limite\"\n\n";
	
	$texte = "------=".$limite."\n";
	$texte .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$texte .= "Content-Transfer-Encoding: 8bit\n\n";
	
	//url de desinscription et de comptage des lectures
	$url_site	= "http://".$_SERVER['HTTP_HOST'].str_replace("profil_collab/communication_newsletters_gestion_envoi_progress.php", "", $_SERVER['PHP_SELF']);
	$url_desinsciption = $url_site."site/newsletters/desinscription.php?id_newsletter=".$envoi->id_newsletter;
	$url_comptage = $url_site."site/newsletters/lecture.php?id_envoi=".$id_envoi;
	
	$mail = new email();
	$mail->prepare_envoi(1, 0);
	
	//envois email par email
	foreach ($fiches as $fiche) {
		//calcul code de suppression
		$code_unique = creer_code_unique ($fiche->email, $envoi->id_newsletter);

		//maj dans contenu du mail des liens de desinscription et lecture (img php)
		$tmp_pied = str_replace("**liendesinscription**", $url_desinsciption."&email=".$fiche->email."&code=".$code_unique, str_replace("**liendelecture**", $url_comptage."&email=".$fiche->email."&code=".$code_unique, $envoi->pied));
		
		restore_error_handler();
		error_reporting(0);
		//envoi de l'email
		$destinataires = $fiche->email;
		$sujet = $envoi->titre;
		$message = $envoi->entete.$envoi->contenu.$tmp_pied."\n\n";
		$infos['mail_from_mail'] = $newsletter->getMail_expediteur();
		$infos['mail_from_name'] = $newsletter->getNom_expediteur();
		$infos['mail_reply_mail'] = $newsletter->getMail_retour();
		$infos['mail_reply_name'] = $newsletter->getNom_expediteur();
		
		if (!$mail->envoi($destinataires , $sujet , $message , $infos)) {
			echo "Une erreur est survenue lors de l'envoi à ".$fiche->email."<br />";
		}
		set_error_handler("error_handler");
	}
	
	
	// l'envois est terminé, on met à jour la durée
	if (!count($fiches)) {
		$newsletter->save_brouillon ("", "");
	 	duree_newsletter_envoi ($id_envoi);
	}
	
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
include ($DIR.$_SESSION['theme']->getDir_theme()."page_communication_newsletters_gestion_envoi_progress.inc.php");

?>