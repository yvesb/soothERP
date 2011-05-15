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
$infos_echeances_sans_aut = array();
$prelev_sans_auth_montant = 0;

$query = "SELECT cb2.id_compte_bancaire,cb2.lib_compte, cb2.iban, cba.id_compte_bancaire_autorisation, sum( montant ) AS a_payer
                FROM `doc_echeanciers` de
                JOIN documents d ON de.ref_doc = d.ref_doc
                JOIN annuaire a1 ON a1.ref_contact = d.ref_contact
                JOIN comptes_bancaires cb1 ON a1.ref_contact = cb1.ref_contact
                JOIN (SELECT cba0.id_compte_bancaire_src, cba0.id_compte_bancaire_dest, cba0.id_compte_bancaire_autorisation, cba0.id_reglement_mode FROM comptes_bancaires_autorisations cba0
                    JOIN comptes_bancaires cb ON cb.id_compte_bancaire = cba0.id_compte_bancaire_src
                    GROUP BY ref_contact
                    ORDER BY cba0.ordre) cba ON cb1.id_compte_bancaire = cba.id_compte_bancaire_src
                JOIN comptes_bancaires cb2 ON cb2.id_compte_bancaire = cba.id_compte_bancaire_dest
                WHERE de.date <= '".date("Y-m-d")."'
                    AND id_mode_reglement = 18
                    AND d.id_type_doc = 4
                    AND d.id_etat_doc = 18
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
//_vardump($infos_prelev);

// Selection des echeances Prelevement SANS autorisations
$query = "SELECT d.ref_doc,a1.ref_contact ,de.id_doc_echeance, de.date, de.type_reglement ,  montant
                FROM `doc_echeanciers` de
                JOIN documents d ON de.ref_doc = d.ref_doc
                JOIN annuaire a1 ON a1.ref_contact = d.ref_contact
                WHERE id_mode_reglement = 18
                AND d.id_type_doc = 4
                AND d.id_etat_doc = 18
  AND d.ref_contact NOT IN (SELECT DISTINCT cb.ref_contact FROM comptes_bancaires_autorisations cba LEFT JOIN comptes_bancaires cb ON
   cba.id_compte_bancaire_src = cb.id_compte_bancaire)
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
                    ) IS NULL);";

$resultat = $bdd->query ($query);
while ($info_echeance_sans_aut = $resultat->fetchObject()) {
    $infos_echeances_sans_aut[] = $info_echeance_sans_aut;
    $prelev_sans_auth_montant += $info_echeance_sans_aut->montant;
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

include ($DIR.$_SESSION['theme']->getDir_theme()."page_compta_gestion_traites.inc.php");

?>