<?php

class msg_modele_relance_client extends msg_modele{

    function initvars($ref_contact=false,$niveau_relance=false){

        global $TARIFS_NB_DECIMALES;

        if ($ref_contact){
            $contact = new contact($ref_contact);
            if ($contact->getRef_contact() == $ref_contact){
                $solde_comptable = compta_exercices::solde_extrait_compte ($contact->getRef_contact());
                $this->template->_assign_vars(array("SOLDECOMPTABLE" => "$solde_comptable"));
                }
            $factures_relances = get_Factures_pour_niveau_relance($niveau_relance, $ref_contact);
            if (isset($factures_relances[$ref_contact])){
                if (count($factures_relances[$ref_contact]) > 0){
                    $factures_relances = $factures_relances[$ref_contact];
                }
            }
            if (is_array($factures_relances)){
                $dataset = array();
                foreach($factures_relances as $facture){
                    $tmp_record = array();
                    $tmp_record["date"] = date_Us_to_Fr($facture["date_creation"]);
                    $tmp_record["ref_doc"] = $facture["ref_doc"];
                    foreach ($facture["echeances"] as $echeance){
                        $tmp_record["date_echeance"] = date_Us_to_Fr($echeance->date);
                        $tmp_record["type_echeance"] = $echeance->type_reglement;
                        $tmp_record["montant_echeance"] = number_format($echeance->montant, $TARIFS_NB_DECIMALES )." &euro;";
                        $dataset[] = $tmp_record;
                    }
                    
                }
                $this->template->_assign_block_vars("factures_relance",$dataset,true);
            }
        }
    }
}

?>