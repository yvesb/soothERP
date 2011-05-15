<?php
// *************************************************************************************************************
// GESTION des terminaux de paiement electronique et virtuels
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");

if(!$COMPTA_GEST_PRELEVEMENTS){
    echo "Cette fonctionalité est désactivée par votre administrateur.";
    exit();
}

$infos_prelev = array();
$infos_traitena = array();
$infos_echeances_sans_aut = array();
$infos_traitena_sans_aut = array();
$infos_echeances_prog_sans_aut = array();
$infos_traitena_prog_sans_aut = array();
$infos_echeances_prog = array();
$infos_traitena_prog = array();
$prelev_sans_auth_montant = 0;
$prelev_prog_sans_auth_montant = 0;
$traitena_sans_auth_montant = 0;
$traitena_prog_sans_auth_montant = 0;
$echeances_prog = 0;
$traitena_prog = 0;

//chargement des comptes bancaires
$comptes_bancaires	= compte_bancaire::charger_comptes_bancaires("" , 1);

// *************************************************************************************************************
// REQUETES A SYNTHETISER ET PLACER DANS UNE METHODE !! (Fonctionne en l'état mais pas optimisé)
// *************************************************************************************************************


//Sélection des prélèvements AVEC autorisation
$query = "SELECT cb2.id_compte_bancaire,cb2.lib_compte, cb2.iban, sum( montant ) AS a_payer
                FROM `doc_echeanciers` de
                JOIN documents d ON de.ref_doc = d.ref_doc
                JOIN annuaire a1 ON a1.ref_contact = d.ref_contact
                JOIN comptes_bancaires cb1 ON a1.ref_contact = cb1.ref_contact
                JOIN (SELECT cba0.id_compte_bancaire_src, cba0.id_compte_bancaire_dest, cba0.id_reglement_mode FROM comptes_bancaires_autorisations cba0
                    JOIN comptes_bancaires cb ON cb.id_compte_bancaire = cba0.id_compte_bancaire_src
                    WHERE id_reglement_mode = 6
                    GROUP BY ref_contact
                    ORDER BY cba0.ordre) cba ON cb1.id_compte_bancaire = cba.id_compte_bancaire_src
                JOIN comptes_bancaires cb2 ON cb2.id_compte_bancaire = cba.id_compte_bancaire_dest
                WHERE de.date <= '".date("Y-m-d")."'
                    AND de.id_mode_reglement = 6
                    AND d.id_type_doc = 4
                    AND d.id_etat_doc = 18
                    AND cba.id_reglement_mode = 6
                    AND
                     ((
                    SELECT sum( montant )
                    FROM reglements_docs rd
                    WHERE rd.ref_doc = de.ref_doc
                    ) < (
                    SELECT sum( montant )
                    FROM doc_echeanciers de2
                    WHERE de2.ref_doc = de.ref_doc && de2.date < now( ) )
                    OR (
                    SELECT sum( montant )
                    FROM reglements_docs rd
                    WHERE rd.ref_doc = de.ref_doc
                    ) IS NULL)
                GROUP BY cb2.id_compte_bancaire;";
$resultat = $bdd->query ($query);
while ($info_prelev = $resultat->fetchObject()) { $infos_prelev[] = $info_prelev; }

// Selection des echeances Prelevement NON echues AVEC autorisations
$query = "SELECT cb2.id_compte_bancaire,cb2.lib_compte,d.ref_doc,a1.ref_contact ,de.id_doc_echeance, de.date, de.type_reglement ,cb2.iban,  montant
                FROM `doc_echeanciers` de
                JOIN documents d ON de.ref_doc = d.ref_doc
                JOIN annuaire a1 ON a1.ref_contact = d.ref_contact
                JOIN comptes_bancaires cb1 ON a1.ref_contact = cb1.ref_contact
                JOIN (SELECT cba0.id_compte_bancaire_src, cba0.id_compte_bancaire_dest FROM comptes_bancaires_autorisations cba0
                    JOIN comptes_bancaires cb ON cb.id_compte_bancaire = cba0.id_compte_bancaire_src
                    GROUP BY ref_contact
                    ORDER BY cba0.ordre) cba ON cb1.id_compte_bancaire = cba.id_compte_bancaire_src
                JOIN comptes_bancaires cb2 ON cb2.id_compte_bancaire = cba.id_compte_bancaire_dest
                WHERE de.date > '".date("Y-m-d")."'
                    AND de.id_mode_reglement = 6
                    AND d.id_type_doc = 4
                    AND d.id_etat_doc = 18;";
$resultat = $bdd->query ($query);
while ($info_echeance_prog = $resultat->fetchObject()) {
    $infos_echeances_prog[] = $info_echeance_prog;
    $echeances_prog += $info_echeance_prog->montant;
    }

    // Selection des echeances traites NA NON echues AVEC autorisations
$query = "SELECT cb2.id_compte_bancaire,cb2.lib_compte,d.ref_doc,a1.ref_contact ,de.id_doc_echeance, de.date, de.type_reglement ,cb2.iban,  montant
                FROM `doc_echeanciers` de
                JOIN documents d ON de.ref_doc = d.ref_doc
                JOIN annuaire a1 ON a1.ref_contact = d.ref_contact
                JOIN comptes_bancaires cb1 ON a1.ref_contact = cb1.ref_contact
                JOIN (SELECT cba0.id_compte_bancaire_src, cba0.id_compte_bancaire_dest FROM comptes_bancaires_autorisations cba0
                    JOIN comptes_bancaires cb ON cb.id_compte_bancaire = cba0.id_compte_bancaire_src
                    GROUP BY ref_contact
                    ORDER BY cba0.ordre) cba ON cb1.id_compte_bancaire = cba.id_compte_bancaire_src
                JOIN comptes_bancaires cb2 ON cb2.id_compte_bancaire = cba.id_compte_bancaire_dest
                WHERE de.date > '".date("Y-m-d")."'
                    AND de.id_mode_reglement = 5
                    AND d.id_type_doc = 4
                    AND d.id_etat_doc = 18;";

$resultat = $bdd->query ($query);
while ($info_traitena_prog = $resultat->fetchObject()) {
    $infos_traitena_prog[] = $info_traitena_prog;
    $traitena_prog += $info_traitena_prog->montant;
    }


// Selection des echeances Prelevement SANS autorisations Echues
$query = "SELECT DISTINCT d.ref_doc,a1.ref_contact ,de.id_doc_echeance, de.date, de.type_reglement ,  montant
                FROM `doc_echeanciers` de
                INNER JOIN documents d ON de.ref_doc = d.ref_doc
                INNER JOIN annuaire a1 ON a1.ref_contact = d.ref_contact
                INNER JOIN comptes_bancaires cb1 ON a1.ref_contact = cb1.ref_contact
                WHERE id_mode_reglement = 6 AND
                cb1.id_compte_bancaire NOT IN
                (
                 SELECT cba0.id_compte_bancaire_src
                 FROM comptes_bancaires_autorisations cba0
                 JOIN comptes_bancaires cb ON cb.id_compte_bancaire = cba0.id_compte_bancaire_src
                 WHERE id_reglement_mode = 6
                ) 
                AND d.id_type_doc = 4
                AND d.id_etat_doc = 18
                AND de.date <= '".date("Y-m-d")."'
      AND
    (
        (
            SELECT sum( montant ) FROM reglements_docs rd
                    WHERE rd.ref_doc = de.ref_doc
        ) 
        <
        (
            SELECT sum( montant ) FROM doc_echeanciers de2
                    WHERE de2.ref_doc = de.ref_doc && de2.date < now( )
        )
        OR
        (
             SELECT sum( montant ) FROM reglements_docs rd
                    WHERE rd.ref_doc = de.ref_doc
        )
        IS NULL
     );";
$resultat = $bdd->query ($query);
while ($info_echeance_sans_aut = $resultat->fetchObject()) {
    $infos_echeances_sans_aut[] = $info_echeance_sans_aut;
    $prelev_sans_auth_montant += $info_echeance_sans_aut->montant;
    }
// Selection des echeances Prelevement SANS autorisations Non Echues
$query = "SELECT DISTINCT d.ref_doc,a1.ref_contact ,de.id_doc_echeance, de.date, de.type_reglement ,  montant
                FROM `doc_echeanciers` de
                INNER JOIN documents d ON de.ref_doc = d.ref_doc
                INNER JOIN annuaire a1 ON a1.ref_contact = d.ref_contact
                INNER JOIN comptes_bancaires cb1 ON a1.ref_contact = cb1.ref_contact
                WHERE id_mode_reglement = 6 AND
                cb1.id_compte_bancaire NOT IN
                (
                 SELECT cba0.id_compte_bancaire_src
                 FROM comptes_bancaires_autorisations cba0
                 JOIN comptes_bancaires cb ON cb.id_compte_bancaire = cba0.id_compte_bancaire_src
                 WHERE id_reglement_mode = 6
                )
                AND d.id_type_doc = 4
                AND d.id_etat_doc = 18
                AND de.date > '".date("Y-m-d")."';";
$resultat = $bdd->query ($query);
while ($info_echeance_prog_sans_aut = $resultat->fetchObject()) {
    $infos_echeances_prog_sans_aut[] = $info_echeance_prog_sans_aut;
    $prelev_prog_sans_auth_montant += $info_echeance_prog_sans_aut->montant;
    }


//Sélection des traites echues avec autorisation
$query = "SELECT cb2.id_compte_bancaire,cb2.lib_compte, cb2.iban, sum( montant ) AS a_payer
                FROM `doc_echeanciers` de
                JOIN documents d ON de.ref_doc = d.ref_doc
                JOIN annuaire a1 ON a1.ref_contact = d.ref_contact
                JOIN comptes_bancaires cb1 ON a1.ref_contact = cb1.ref_contact
                JOIN (SELECT cba0.id_compte_bancaire_src, cba0.id_compte_bancaire_dest, cba0.id_reglement_mode FROM comptes_bancaires_autorisations cba0
                    JOIN comptes_bancaires cb ON cb.id_compte_bancaire = cba0.id_compte_bancaire_src
                    WHERE id_reglement_mode = 5
                    GROUP BY ref_contact
                    ORDER BY cba0.ordre) cba ON cb1.id_compte_bancaire = cba.id_compte_bancaire_src
                JOIN comptes_bancaires cb2 ON cb2.id_compte_bancaire = cba.id_compte_bancaire_dest
                WHERE de.date <= '".date("Y-m-d")."'
                    AND de.id_mode_reglement IN (5)
                    AND d.id_type_doc = 4
                    AND d.id_etat_doc = 18
                    AND cba.id_reglement_mode IN (5)
                    AND
                     ((
                    SELECT sum( montant )
                    FROM reglements_docs rd
                    WHERE rd.ref_doc = de.ref_doc
                    ) < (
                    SELECT sum( montant )
                    FROM doc_echeanciers de2
                    WHERE de2.ref_doc = de.ref_doc && de2.date < now( ) )
                    OR (
                    SELECT sum( montant )
                    FROM reglements_docs rd
                    WHERE rd.ref_doc = de.ref_doc
                    ) IS NULL)
                GROUP BY cb2.id_compte_bancaire;";
$resultat = $bdd->query ($query);
while ($info_traitena = $resultat->fetchObject()) { $infos_traitena[] = $info_traitena; }

//Sélection des traites SANS autorisation Echues
$query = "SELECT DISTINCT d.ref_doc,a1.ref_contact ,de.id_doc_echeance, de.date, de.type_reglement ,  montant
                FROM `doc_echeanciers` de
                INNER JOIN documents d ON de.ref_doc = d.ref_doc
                INNER JOIN annuaire a1 ON a1.ref_contact = d.ref_contact
                INNER JOIN comptes_bancaires cb1 ON a1.ref_contact = cb1.ref_contact
                WHERE id_mode_reglement = 5 AND
                cb1.id_compte_bancaire NOT IN
                (
                 SELECT cba0.id_compte_bancaire_src
                 FROM comptes_bancaires_autorisations cba0
                 JOIN comptes_bancaires cb ON cb.id_compte_bancaire = cba0.id_compte_bancaire_src
                 WHERE id_reglement_mode = 5
                )
                AND d.id_type_doc = 4
                AND d.id_etat_doc = 18
                AND de.date <= '".date("Y-m-d")."'
      AND
    (
        (
            SELECT sum( montant ) FROM reglements_docs rd
                    WHERE rd.ref_doc = de.ref_doc
        )
        <
        (
            SELECT sum( montant ) FROM doc_echeanciers de2
                    WHERE de2.ref_doc = de.ref_doc && de2.date < now( )
        )
        OR
        (
             SELECT sum( montant ) FROM reglements_docs rd
                    WHERE rd.ref_doc = de.ref_doc
        )
        IS NULL
     );";

$resultat = $bdd->query ($query);
while ($info_traitena_sans_aut = $resultat->fetchObject()) {
    $infos_traitena_sans_aut[] = $info_traitena_sans_aut;
    $traitena_sans_auth_montant += $info_traitena_sans_aut->montant;
    }

 // Selection des echeances Traites SANS autorisations Non Echues
$query = "SELECT DISTINCT d.ref_doc,a1.ref_contact ,de.id_doc_echeance, de.date, de.type_reglement ,  montant
                FROM `doc_echeanciers` de
                INNER JOIN documents d ON de.ref_doc = d.ref_doc
                INNER JOIN annuaire a1 ON a1.ref_contact = d.ref_contact
                INNER JOIN comptes_bancaires cb1 ON a1.ref_contact = cb1.ref_contact
                WHERE id_mode_reglement = 5 AND
                cb1.id_compte_bancaire NOT IN
                (
                 SELECT cba0.id_compte_bancaire_src
                 FROM comptes_bancaires_autorisations cba0
                 JOIN comptes_bancaires cb ON cb.id_compte_bancaire = cba0.id_compte_bancaire_src
                 WHERE id_reglement_mode = 5
                )
                AND d.id_type_doc = 4
                AND d.id_etat_doc = 18
                AND de.date > '".date("Y-m-d")."';";
$resultat = $bdd->query ($query);
while ($info_traitena_prog_sans_aut = $resultat->fetchObject()) {
    $infos_traitena_prog_sans_aut[] = $info_traitena_prog_sans_aut;
    $traitena_prog_sans_auth_montant += $info_traitena_prog_sans_aut->montant;
    }

$laste_date = "";

$query = "SELECT date_ordre FROM comptes_bancaires_prelevements ORDER BY date_ordre DESC LIMIT 1;";
if ( $result = $bdd->query($query) ){
    if ( $data = $result->fetchObject() ){
        $laste_date = $data->date_ordre;
    }
}

// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_gestion_traites_prelev.inc.php");

?>