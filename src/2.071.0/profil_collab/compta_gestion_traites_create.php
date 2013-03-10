<?php
// *************************************************************************************************************
// Prelevements creation
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if ( isset($_REQUEST["id_compte_bancaire_destination"]) && isset($_REQUEST["indentation_exist_cheques"]) ){
    if ( $_REQUEST["indentation_exist_cheques"] >= 0){
        $query = "INSERT INTO comptes_bancaires_prelevements(id_compte_bancaire_destination, date_ordre, ref_user, numero_ordre, commentaire)
                    VALUES(".intval($_REQUEST["id_compte_bancaire_destination"]).", now(), '".$_SESSION["user"]->getRef_contact()."','".$_REQUEST["num_prelev"]."','".$_REQUEST["commentaire"]."');";
        $bdd->exec($query);
        $id_compte_bancaire_prelevement = $bdd->lastInsertId();

        $montant_total = 0;
        for($j=0; $j<=$_REQUEST["indentation_exist_cheques"]; $j++){
            if ( isset($_REQUEST["CHK_EXIST_PRELEV_$j"]) && isset($_REQUEST["DOC_PRELEV_$j"]) ){
                $document = open_doc ($_REQUEST["DOC_PRELEV_$j"]);
                $infos = array();
                $infos ["id_reglement_mode"]            =	$PRB_E_ID_REGMT_MODE;
                $infos ["ref_contact"]                  =	$document->getRef_contact();
                $infos ["direction_reglement"]          =	"entrant";
                $infos ["montant_reglement"]            =	$_REQUEST["EXIST_PRELEV_$j"];
                $infos ["date_reglement"]               = date_Fr_to_Us($_REQUEST["date_prelev_$j"]);
                $infos ["date_echeance"]                =	date_Fr_to_Us($_REQUEST["date_prelev_$j"]);
                $infos ["id_compte_bancaire_source"]    =	$_REQUEST["id_compte_bancaire_source_$j"];
                $infos ["id_compte_bancaire_dest"]      =	$_REQUEST["id_compte_bancaire_destination"];
                $cb_autorisation =                              $_REQUEST["id_compte_bancaire_autorisation_$j"];
                $reglement = new reglement ();
                $reglement->create_reglement ($infos);

                $query = "INSERT INTO comptes_bancaires_prelevements_montants(id_compte_bancaire_prelevement, id_compte_bancaire_source, ref_reglement, id_mode_reglement, montant_prelevement)
                            VALUES ($id_compte_bancaire_prelevement, ".intval($_REQUEST["id_compte_bancaire_source_$j"]).", '".$reglement->getRef_reglement()."', 18, '".$_REQUEST["EXIST_PRELEV_$j"]."');";
                $bdd->exec($query) ;

                $document->rapprocher_reglement ($reglement);
                echo "Reglement enregistre pour le document ".$document->getRef_doc()."<BR>";
                $montant_total += $reglement->getMontant_reglement();
                $query = "DELETE FROM comptes_bancaires_autorisations WHERE id_compte_bancaire_autorisation = $cb_autorisation;";
                $bdd->exec($query);
            }
        }
        $query = "UPDATE comptes_bancaires_prelevements SET montant_prelevement_total = '".$montant_total."' WHERE id_compte_bancaire_prelevement = $id_compte_bancaire_prelevement;";
        $bdd->exec($query);
    }
}
?>
<script type="text/javascript">
    window.parent.page.traitecontent('compta_gestion_traites_tb','compta_gestion_traites_tb.php?id_compte_bancaire=<?php echo $_REQUEST["id_compte_bancaire_destination"]; ?>','true','sub_content');
</script>
