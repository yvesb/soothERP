<?php

function get_Factures_pour_niveau_relance($niveau_relance, $ref_contact_filtre=""){
	
	global $bdd;
	
        $result = array();
	$ref_contact = "";
        $query_where = "";
        $query_niveau_relance = "";
        
	if (is_array($niveau_relance)){
            $query_niveau_relance = "&& niveau_relance IN (";
            foreach ($niveau_relance as $niveau){
                $query_niveau_relance .= $niveau.",";
                }
            $query_niveau_relance = substr($query_niveau_relance,0,-1).")";
        }else{
            $niveau_relance = intval($niveau_relance);
            $query_niveau_relance = "&& niveau_relance=".$niveau_relance;
        }
        if($ref_contact_filtre != "")
	$query_where = "AND ref_contact = '".$ref_contact_filtre."' ";
	$query = "SELECT d.ref_contact,d.ref_doc
						FROM documents d
						LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc
						LEFT JOIN factures_relances_niveaux frn ON df.id_niveau_relance = frn.id_niveau_relance
						WHERE id_etat_doc=18 ".$query_niveau_relance." ".$query_where."
						ORDER BY ref_contact,ref_doc ASC;";
	$resultat = $bdd->query($query);
	
	while ($doc = $resultat->fetchObject()){
		
		if ( $ref_contact != $doc->ref_contact){
			if ( isset($result[$ref_contact]) ){
				if ( count($result[$ref_contact]) <= 0 ){
					unset($result[$ref_contact]);
					$ref_contact = $doc->ref_contact;
				}else{
					$ref_contact = $doc->ref_contact;
					$result[$ref_contact] = array();
				}
			}else{
					$ref_contact = $doc->ref_contact;
					$result[$ref_contact] = array();
				}
		}

		$facture = open_doc($doc->ref_doc);

		if ( $facture->getRef_doc() ){
			$facture_niveau_relance = new facture_niveau_relance( $facture->getId_niveau_relance() );
			if ( $facture_niveau_relance && $facture_niveau_relance->getActif() ){
				$last_relance = $facture->getDate_last_relance();
				$delai_before_next = $facture_niveau_relance->getDelai_before_next();
				if ( is_null($last_relance) || ( strtotime(strftime("%Y-%m-%d")." 00:00") >= strtotime("+$delai_before_next day",strtotime($last_relance." 00:00")) ) ){
                                        if ( ($facture->getMontant_echu() >= $facture_niveau_relance->getMontant_mini()) || $facture_niveau_relance->getSuite_avant_echeance() ){
						$ref_doc = array();
						$ref_doc["ref_doc"] 		= $facture->getRef_doc();
						$ref_doc["etat_doc"]            = $facture->getLib_etat_doc();
						$ref_doc["nom_contact"] 	= $facture->getNom_contact();
						$ref_doc["date_creation"]       = $facture->getDate_creation();
						$ref_doc["id_niveau_relance"]   = $facture->getId_niveau_relance();
						$ref_doc["montant"]		= $facture->getMontant_ttc();
						$ref_doc["echeances"]		= array();
						$echeances                      = $facture->getEcheancier();
						foreach ($echeances as $echeance){
							if ($echeance->etat == 3 || $facture_niveau_relance->getSuite_avant_echeance()){
								$ref_doc["echeances"][] = $echeance;
							}
						}
						$result[$ref_contact][$facture->getRef_doc()] = $ref_doc;
					}
                                        if ( isset($result[$ref_contact][$facture->getRef_doc()]["echeances"]) ){
                                            if(count($result[$ref_contact][$facture->getRef_doc()]["echeances"]) == 0)
                                                unset($result[$ref_contact][$facture->getRef_doc()]);
                                        }
				}
			}
		}
                if ( isset($result[$ref_contact]) ){
                    if(count($result[$ref_contact]) == 0)
                        unset($result[$ref_contact]);
                }
	}
	return $result;
}

function get_nb_Factures_pour_niveau_relance($niveau_relance, $ref_contact_filtre=""){

	global $bdd;
	$nb_fact = 0;
        $result = array();
	$ref_contact = "";
        $query_where = "";
        $query_niveau_relance = "";

	if (is_array($niveau_relance)){
            $query_niveau_relance = "&& niveau_relance IN (";
            foreach ($niveau_relance as $niveau){
                $query_niveau_relance .= $niveau.",";
                }
            $query_niveau_relance = substr($query_niveau_relance,0,-1).")";
        }else{
            $niveau_relance = intval($niveau_relance);
            $query_niveau_relance = "&& niveau_relance=".$niveau_relance;
        }
        if($ref_contact_filtre != "")
	$query_where = "AND ref_contact = '".$ref_contact_filtre."' ";
	$query = "SELECT d.ref_contact,d.ref_doc
						FROM documents d
						LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc
						LEFT JOIN factures_relances_niveaux frn ON df.id_niveau_relance = frn.id_niveau_relance
						WHERE id_etat_doc=18 ".$query_niveau_relance." ".$query_where."
						ORDER BY ref_contact,ref_doc ASC;";
	$resultat = $bdd->query($query);

	while ($doc = $resultat->fetchObject()){

		if ( $ref_contact != $doc->ref_contact){
			if ( isset($result[$ref_contact]) ){
				if ( count($result[$ref_contact]) <= 0 ){
					unset($result[$ref_contact]);
					$ref_contact = $doc->ref_contact;
				}else{
					$ref_contact = $doc->ref_contact;
					$result[$ref_contact] = array();
				}
			}else{
					$ref_contact = $doc->ref_contact;
					$result[$ref_contact] = array();
				}
		}

		$facture = open_doc($doc->ref_doc);

		if ( $facture->getRef_doc() ){
			$facture_niveau_relance = new facture_niveau_relance( $facture->getId_niveau_relance() );
			if ( $facture_niveau_relance && $facture_niveau_relance->getActif() ){
				$last_relance = $facture->getDate_last_relance();
				$delai_before_next = $facture_niveau_relance->getDelai_before_next();
				if ( is_null($last_relance) || ( strtotime(strftime("%Y-%m-%d")." 00:00") >= strtotime("+$delai_before_next day",strtotime($last_relance." 00:00")) ) ){
                                        if ( ($facture->getMontant_echu() >= $facture_niveau_relance->getMontant_mini()) || $facture_niveau_relance->getSuite_avant_echeance() ){
						$ref_doc = array();
						$ref_doc["ref_doc"] 		= $facture->getRef_doc();
						$ref_doc["etat_doc"]            = $facture->getLib_etat_doc();
						$ref_doc["nom_contact"] 	= $facture->getNom_contact();
						$ref_doc["date_creation"]       = $facture->getDate_creation();
						$ref_doc["id_niveau_relance"]   = $facture->getId_niveau_relance();
						$ref_doc["montant"]		= $facture->getMontant_ttc();
						$ref_doc["echeances"]		= array();
						$echeances                      = $facture->getEcheancier();
						foreach ($echeances as $echeance){
							if ($echeance->etat == 3 || $facture_niveau_relance->getSuite_avant_echeance()){
								$ref_doc["echeances"][] = $echeance;
							}
						}
						$result[$ref_contact][$facture->getRef_doc()] = $ref_doc;
					}
                                        if ( isset($result[$ref_contact][$facture->getRef_doc()]["echeances"]) ){
                                            $nb_fact++;
                                            if(count($result[$ref_contact][$facture->getRef_doc()]["echeances"]) == 0){
                                                unset($result[$ref_contact][$facture->getRef_doc()]);$nb_fact--;}
                                        }
				}
			}
		}
                if ( isset($result[$ref_contact]) ){
                    if(count($result[$ref_contact]) == 0)
                        unset($result[$ref_contact]);
                }
	}
	return $nb_fact;
}

function generer_relance_client($ref_client,$id_niveau_relance,$id_edition_mode){

    $client = new contact($ref_client);
    if ( $ref_client == $client->getRef_contact()){
        $relances = get_Factures_pour_niveau_relance($id_niveau_relance,$ref_client);
        _vardump($relances);
    }
}

?>