<?php

$_INTERFACE['MUST_BE_LOGIN'] = 0;
require ("__dir.inc.php");
require ($DIR . "_session.inc.php");

if (!empty($_REQUEST['sid']) && !empty($_REQUEST['pass'])) {
    $query = "SELECT ref_coord FROM users_creations_invitations WHERE code = '" . $_POST['sid'] . "'";
    $res = $bdd->query($query);
    if (is_object($res)) {
        $invit = $res->fetchObject();
        $coord = new coordonnee($invit->ref_coord);
        $query = "SELECT ref_user FROM users WHERE ref_coord_user = '$invit->ref_coord'";
        $res = $bdd->query($query);
        $usr = $res->fetchObject();

        $user = new utilisateur($usr->ref_user);
        $user->changer_code($_REQUEST['pass']);

        // On envoie un mail de rappel des identifiants à l'utilisateur
        // Envoi de l'email avec template
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
        $destinataire = $coord->getEmail();
        $sujet = "[" . $nom_entreprise . "] Votre compte utilisateur LMB";
        $message = "<br /><br />Bonjour, <br />
                            Votre changement de mot de passe sur le site de " . $lib_civ . " " . $nom_entreprise . " a bien été effectuée. <br />
                            Vous pouvez maintenant vous connecter au logiciel Lundi Matin Business à l'adresse suivante : <br />
                            <a href=\"" . url_site() . "\">" . url_site() . "</a><br /><br />
                            Pour mémoire, voici vos identifiants : <br />
                            Identifiant : " . $user->getPseudo() . "<br />
                            Mot de passe : " . $_REQUEST['pass'] . "<br />
                            Veuillez conserver cet e-mail dans vos archives.
                            <br /><br />
                            L'équipe " . $nom_entreprise;
        if (!$mail->envoi_email_templated($destinataire, $sujet, $message)) {
            echo "Une erreur est survenue lors de l'envoi à " . $destinataire . "<br />";
        }
        set_error_handler("error_handler");
    }
}
?>
