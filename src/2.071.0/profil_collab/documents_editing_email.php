<?php
// *************************************************************************************************************
// ENVOI D'UN DOCUMENT PAR EMAIL
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");
require ("_contact_collab.class.php");

if (isset($_REQUEST["ref_doc"])) {
    $document = open_doc ($_REQUEST['ref_doc']);
    $liste_email = array();

    $contact_entreprise = new contact($REF_CONTACT_ENTREPRISE);

    if ($document->getRef_contact()) {
            $liste_email = get_contact_emails ($document->getRef_contact());
    }

    //Récupération des emails de tous lkes collaborateurs
    $collaborateurs = contact_collab::get_list_collaborateurs();
    $emails_collaborateurs = array();
    if(!empty($collaborateurs)) {
            foreach($collaborateurs as $c) {
                    $contact = new contact($c['ref_contact']);
                    $coordonnees_collab = $contact->getCoordonnees();
                    if(!empty($coordonnees_collab)){
                            foreach($coordonnees_collab as $collaborateur) {
                                    $string = $collaborateur->getEmail();
                                    if(!empty($string)) $emails_collaborateurs[] = $string;
                            }
                    }
            }
    }
}

// *************************************************************************************************************
// AFFICHAGE
// -*************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_documents_editing_email.inc.php");

?>