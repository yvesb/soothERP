<?php

$_INTERFACE['MUST_BE_LOGIN'] = 0;
require ("__dir.inc.php");
require ($DIR . "_session.inc.php");

if (!empty($_REQUEST['email'])) {
    $query = "SELECT ref_coord_user, email
                    FROM users u
                            LEFT JOIN coordonnees c ON u.ref_coord_user = c.ref_coord
                    WHERE (u.ref_user = '".addslashes($_POST['email'])."' || u.pseudo = '".addslashes($_POST['email'])."' || c.email = '".addslashes($_POST['email'])."' )
                        AND actif = 1";
    $res = $bdd->query($query);
	if($res->rowCount()>0){
		$coord = $res->fetchObject();

		$code = md5(uniqid());
		$query = "INSERT INTO users_creations_invitations (ref_coord, date_invitation, code)
						VALUES ('".$coord->ref_coord_user."',NOW(), '".$code."')";
		$res = $bdd->exec($query);

		$mail = new email();
		$mail->prepare_envoi(1, 0);
		restore_error_handler();
		error_reporting(0);
		global $ID_MAIL_TEMPLATE_INVITATION_INSCRIPTION;
		global $ID_MAIL_TEMPLATE;
		global $REF_CONTACT_ENTREPRISE;
		// On récupère l'identifiant du template de mail pour l'invitation à la création d'un compte
		$ID_MAIL_TEMPLATE = $ID_MAIL_TEMPLATE_INVITATION_INSCRIPTION;
		// Chargement du nom de l'entreprise
		$contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);
		$nom_entreprise = str_replace(CHR(13), " ", str_replace(CHR(10), " ", $contact_entreprise->getNom()));
		$lib_civ = $contact_entreprise->getLib_civ_court();
		// Envoi de l'email
		$destinataire = $coord->email;
		$sujet = "[" . $nom_entreprise . "] Votre compte utilisateur LMB";
		$message = "<br /><br />Bonjour, <br />
						Votre demande de mot de passe oublié sur le site " . $lib_civ . " " . $nom_entreprise . " a été prise en compte. <br />
						Veuillez cliquer sur le lien suivant pour en définir un nouveau : <br />
						<a href=\"" . url_site() . "/site/_change_mdp.php?sid=$code\">" . url_site() . "</a><br /><br />
						";
		if (!$mail->envoi_email_templated($destinataire, $sujet, $message)) {
			echo "Une erreur est survenue lors de l'envoi à " . $_POST['email'] . "<br />";
		}
		set_error_handler("error_handler");
	}
}
?>
