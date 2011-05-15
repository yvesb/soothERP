<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES EXERCICES COMPTABLES
// *************************************************************************************************************


final class compta_exercices {
	protected $id_exercice;

	protected $lib_exercice;
	protected $date_fin;
	protected $etat_exercice;
	protected $date_debut; //date de début de l'exercice
	protected $date_debut_next;	//date de début du prochain exercice

	private $code_extrait_contact_pdf_modele = "extrait_compte"; // code pour la class d'impression de l'extrait de compte d'un contact
	
public function __construct ($id_exercice = "") {
	global $bdd;
	
	if (!$id_exercice) { return false; }
	
	$query = "SELECT ce.id_exercice, ce.lib_exercice, ce.date_fin, ce.etat_exercice
	
						FROM compta_exercices ce
						WHERE ce.id_exercice = '".$id_exercice."' ";
	$resultat = $bdd->query ($query);
	if (!$compta_e = $resultat->fetchObject()) { return false; }

	$this->id_exercice		= $id_exercice;
	$this->lib_exercice		= $compta_e->lib_exercice;
	$this->date_fin				= $compta_e->date_fin;
	$this->etat_exercice 	= $compta_e->etat_exercice;
	
	$this->find_date_debut ();
	
	return true;
}

// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UN EXERCICE COMPTABLE
// *************************************************************************************************************

public function create_compta_exercice ($infos) { 
	global $bdd;
	

	$this->lib_exercice		= $infos['lib_exercice'];
	$this->date_fin				= $infos['date_fin'];
	
	if (!$this->lib_exercice) {
		$this->create_lib_exercice ();
	}

	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}

	// *************************************************
	// Insertion dans la bdd
	$query = "INSERT INTO compta_exercices 
							(lib_exercice, date_fin)
						VALUES ('".addslashes($this->lib_exercice)."', 
										'".$this->date_fin."')"; 
	$bdd->exec ($query);
	$this->id_exercice = $bdd->lastInsertId();
	
	return true;
}

//création d'un lib par defaut
private function create_lib_exercice () {
	
	$this->lib_exercice = date ("Y", strtotime($this->date_fin));
	
	if (!$this->date_debut ) {$this->find_date_debut ();}
	
	if (substr_compare(date ("Y", strtotime($this->date_debut)), date ("Y", strtotime($this->date_fin)), 0) ) {
		$this->lib_exercice = date ("Y", strtotime($this->date_debut))."-".date("Y", strtotime($this->date_fin));
	}
	return true;
}


//verification de la cohérence des exercices
public function check_exercice () {
	global $bdd;
	global $ENTREPRISE_DATE_CREATION;
	
	//on vérifie qu'un exercice précédent existe déjà
	$query = "SELECT ce.id_exercice, ce.lib_exercice, ce.date_fin, ce.etat_exercice
	
						FROM compta_exercices ce
						ORDER BY ce.date_fin DESC
						LIMIT 1
						 ";
	$resultat = $bdd->query ($query);
	//si aucun exercice créé, on cré un exercice  démarrant de la date de création de l'entreprise au 31/12/n+1
	if (!$compta_e = $resultat->fetchObject()) {
		$this->create_date_debut ();
		$infos = array();
		$infos['lib_exercice']= "";
		$infos['date_fin'] = date("Y-m-d H:i:s", mktime(23, 59, 59, 12 , 31, date ("Y", strtotime($this->date_debut_next))+1 ) );
		$this->create_compta_exercice ($infos);
		
		return true;
	} else {
		//sinon il peut sagir d'un exercice en cours
		if ($compta_e->date_fin >= date("Y-m-d") && $compta_e->etat_exercice == 1) {
			$GLOBALS['_ALERTES']['exercice_en_cours'] = 1;
		} 
		//ou un exercice non cloturé ou clorturé du coup il faut en recréer un en cours
		if ($compta_e->date_fin < date("Y-m-d")) {
			$this->create_date_debut ();
			$infos = array();
			$infos['lib_exercice']= "";
			$infos['date_fin'] = date("Y-m-d H:i:s", mktime(23, 59, 59, date ("m", strtotime($this->date_debut_next)) , date ("d", strtotime($this->date_debut_next))-1, date ("Y", strtotime($this->date_debut_next))+1 ) );
			$this->create_compta_exercice ($infos);
		}
	}
	
	
}

//cré la date de début du prochain exercice (afin de générer la date_fin correspondante dans le check_exercice)
public function create_date_debut () {
	global $bdd;
	global $ENTREPRISE_DATE_CREATION;
	
	//on vérifie qu'un exercice précédent existe déjà
	$query = "SELECT ce.id_exercice, ce.lib_exercice, ce.date_fin, ce.etat_exercice
						FROM compta_exercices ce
						ORDER BY ce.date_fin DESC
						LIMIT 1
						 ";
	$resultat = $bdd->query ($query);
	if (!$compta_e = $resultat->fetchObject()) {
		$this->date_debut_next = $ENTREPRISE_DATE_CREATION;
	} else {
		$this->date_debut_next = date("Y-m-d", mktime(0, 0, 0, date("m" ,strtotime($compta_e->date_fin)) , date ("d", strtotime($compta_e->date_fin))+1, date ("Y", strtotime($compta_e->date_fin)) ) );
	}
	
	return true;
	
}

//recupère la date de début de l'exercice 
public function find_date_debut () {
	global $bdd;
	global $ENTREPRISE_DATE_CREATION;
	
	$where ="";
	if ($this->id_exercice) {$where ="WHERE id_exercice < '".$this->id_exercice."' ";}
	//on vérifie qu'un exercice précédent existe déjà
	$query = "SELECT ce.id_exercice, ce.lib_exercice, ce.date_fin, ce.etat_exercice
						FROM compta_exercices ce
						".$where."
						ORDER BY ce.date_fin DESC
						LIMIT 1
						 ";
	$resultat = $bdd->query ($query);
	if (!$compta_e = $resultat->fetchObject()) {
		$this->date_debut = $ENTREPRISE_DATE_CREATION;
	} else {
		$this->date_debut = date("Y-m-d", mktime(0, 0, 0, date("m" ,strtotime($compta_e->date_fin)) , date ("d", strtotime($compta_e->date_fin))+1, date ("Y", strtotime($compta_e->date_fin)) ) );
	}
	
	return true;
	
}

// *************************************************************************************************************
// FONCTIONS DE MISE A JOUR DES DONNEES 
// *************************************************************************************************************
public function maj_exercice ($lib_exercice , $date_fin) {
	global $bdd;

	// *************************************************
	// Réception des données
	$this->lib_exercice 	= $lib_exercice;
	
	if (!$this->lib_exercice) {
		$this->create_lib_exercice ();
	}
	
	//si la date de fin est modifiée et passée avant la date de debut alors on bloque la maj
	if (!$this->date_debut ) {$this->find_date_debut ();}
	if ($date_fin < $this->date_debut) {$GLOBALS['_ALERTES']["bad_date_fin"] = 1;}
	
	//si l'exercice est cloturé on bloque la maj
	if (!$this->etat_exercice) {$GLOBALS['_ALERTES']["etat_exercice"] = "cloturé";}
	
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	//si la date de fin de l'exercice est augmentée alors on doit supprimer les exercices en trop
	if ($date_fin > $this->date_fin	) {
		$query_max_date = " && date_fin <= '".$date_fin." 23:59:59' ";
		
		//si le changement de date nous fait passer l'exercice à "en cours", alors tout les exercices suivant sont supprimés
		if ($date_fin > date("Y-m-d")) {
			$query_max_date = "";
		}
		
		$query = "DELETE FROM compta_exercices WHERE id_exercice != '".$this->id_exercice."' && date_fin > '".$this->date_fin."' ".$query_max_date;
		$bdd->exec ($query);
	}
	
	$this->date_fin				= $date_fin;

	// *************************************************
	// MAJ de la bdd
	$query = "UPDATE compta_exercices 
						SET lib_exercice = '".addslashes($this->lib_exercice)."',
								date_fin = '".$this->date_fin." 23:59:59'
						WHERE id_exercice = '".$this->id_exercice."' "; 
	$bdd->exec ($query);

	return true;
}


// Suppression d'un exercice
public function suppression () {
	global $bdd;

	if ($this->etat_exercice != 0) {
		// Suppression dans la BDD
		$query = "DELETE FROM compta_exercices WHERE id_exercice = '".$this->id_exercice."' ";
		$bdd->exec ($query);
	
		unset ($this);
		return true;
	}
}

// Fonction de cloture d'un exercice
public function cloture_exercice () {
	global $bdd;
	global $TARIFS_NB_DECIMALES;
	
	// *************************************************
	// MAJ de la bdd
	$query = "UPDATE compta_exercices 
						SET etat_exercice = 0
						WHERE id_exercice = '".$this->id_exercice."' "; 
	$bdd->exec ($query);
	
	//on selectionne l'ensemble des contacts pour calculer 
	
	$query = "SELECT ref_contact
						FROM annuaire";
	$resultat = $bdd->query ($query);
	
	
	while ($tmp_contact = $resultat->fetchObject()) {
		//on récupère le report à nouveau si il existe
		$ran = 0;
		$query_ran = "SELECT ref_contact, date_ran, montant_ran
									FROM compta_exercices_reports
									WHERE date_ran = '".$this->date_debut." 00:00:00' && ref_contact = '".$tmp_contact->ref_contact."' ";
		$resultat_ran = $bdd->query ($query_ran);
		if ($tmp_ran = $resultat_ran->fetchObject()) { $ran = $tmp_ran->montant_ran; }
		
		// on sélectionne les montant des opérations du contact (factures et règlements)
		// Sélection des documents du contact
		$grand_livre_documents = array();
		$query_doc = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, ref_contact, de.lib_etat_doc,
	
											( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
												FROM docs_lines dl
												WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,
	
												date_creation_doc as date,
												fnr.lib_niveau_relance 	
	
							FROM documents d 
								LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
								LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
								LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc 
								LEFT JOIN factures_relances_niveaux fnr ON fnr.id_niveau_relance = df.id_niveau_relance 
							WHERE ref_contact = '".$tmp_contact->ref_contact."' &&   d.date_creation_doc >= '".$this->date_debut." 00:00:00' && d.date_creation_doc < '".$this->date_fin."'  && (d.id_type_doc = '4' || d.id_type_doc = '8') && (d.id_etat_doc != '17' && d.id_etat_doc != '33')
							GROUP BY d.ref_doc 
							ORDER BY date ASC";
	
		$resultat_doc = $bdd->query ($query_doc);
		while ($var_doc = $resultat_doc->fetchObject()) {
			$grand_livre_documents[$var_doc->ref_doc] = $var_doc; 
		}
		
		// Sélection des règlements du contact
		$grand_livre_reglements = array();
		$query_reg = "SELECT r.ref_reglement, r.id_reglement_mode, r.ref_contact, rm.lib_reglement_mode,
										 r.date_reglement as date, r.montant_reglement as montant_ttc, rm.type_reglement
	
							FROM reglements r  
								LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode 
							WHERE r.ref_contact = '".$tmp_contact->ref_contact."' &&  date_reglement >= '".$this->date_debut." 00:00:00' && date_reglement < '".$this->date_fin."'  && valide = 1
							GROUP BY r.ref_reglement 
							ORDER BY date ASC";
	
		$resultat_reg = $bdd->query ($query_reg);
		while ($var_reg = $resultat_reg->fetchObject()) {
			// Association des ref_doc correspondant au reglement
			$var_reg->ref_doc = array();
			$query2 = "SELECT ref_doc
								FROM reglements_docs 
								WHERE ref_reglement = '".$var_reg->ref_reglement."' && liaison_valide = '1'";
		
			$resultat2 = $bdd->query ($query2);
			while ($var2 = $resultat2->fetchObject()) { $var_reg->ref_doc[$var2->ref_doc] = $var2->ref_doc; }
			
			$grand_livre_reglements[$var_reg->ref_reglement] = $var_reg; 
			unset ($resultat2, $var2, $query2);
		}
		unset ($tmp_ran, $var_doc, $var_reg, $resultat_doc, $resultat_reg, $resultat_ran, $query_reg, $query_doc, $query_ran);
		
		
		
	$solde = $ran;
		foreach ($grand_livre_documents as $documents) {	$grand_livre_tmp[] = $documents;
			if (!is_array($documents->ref_doc) && (($documents->id_type_doc == 4 && $documents->montant_ttc < 0) || ($documents->id_type_doc == 8 && $documents->montant_ttc >= 0)) ) { 
				$solde = $solde + abs(number_format($documents->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			} 
			
			if (!is_array($documents->ref_doc) && (($documents->id_type_doc == 4 && $documents->montant_ttc >= 0) || ($documents->id_type_doc == 8 && $documents->montant_ttc < 0))) {
				$solde = $solde - abs(number_format($documents->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			} 
		}
		foreach ($grand_livre_reglements as $reglement) {	
			if (isset($reglement->ref_reglement) && $reglement->type_reglement == "sortant") {
				$solde = $solde - abs(number_format($reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			} 
			if (isset($reglement->ref_reglement) && $reglement->type_reglement == "entrant") { 
				$solde = $solde + abs(number_format($reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
			} 
		}

		//si le report à nouveau est différent de zéro
		if ($solde != 0) {
			// *************************************************
			// Insertion dans la bdd
			$query_ran = "INSERT INTO compta_exercices_reports 
									(ref_contact, date_ran, montant_ran)
								VALUES ('".$tmp_contact->ref_contact."', 
												'".date("Y-m-d", mktime(0, 0, 0, date("m" ,strtotime($this->date_fin)) , date ("d", strtotime($this->date_fin))+1, date ("Y", strtotime($this->date_fin)) ) )." 00:00:00', 
												'".$solde."' )"; 
			$bdd->exec ($query_ran);
			
			unset ($query_ran);
		}
	}
	return true;
}


//impression pdf d'un extrait de compte d'un contact
public function imprimer_extrait_compte ($ref_contact, $print = 0) {
	global $bdd;
	global $TARIFS_NB_DECIMALES;
	global $PDF_MODELES_DIR;
	global $ENTREPRISE_DATE_CREATION;
	
	if (!$ref_contact) {return false;}
	
	$query_where 	= "";
	$query_where2 	= "";
	if ($this->date_debut) {
		$query_where .=  " &&   d.date_creation_doc >= '".$this->date_debut." 00:00:00' "; 
		$query_where2 .=  " &&  date_reglement >= '".$this->date_debut." 00:00:00' "; 
	}
	if ($this->date_fin) {
		$query_where .=  "&& d.date_creation_doc < '".$this->date_fin."'"; 
		$query_where2 .=  " && date_reglement < '".$this->date_fin."'"; 
	}
	
	// on sélectionne les montant des opérations du contact (factures et règlements)
	// Sélection des documents du contact
	$grand_livre_documents = array();
	$query_doc = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, ref_contact, de.lib_etat_doc,

										( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
											FROM docs_lines dl
											WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,

											date_creation_doc as date,
											fnr.lib_niveau_relance 	

						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc 
							LEFT JOIN factures_relances_niveaux fnr ON fnr.id_niveau_relance = df.id_niveau_relance 
						WHERE ref_contact = '".$ref_contact."' ".$query_where."  && (d.id_type_doc = '4' || d.id_type_doc = '8') && (d.id_etat_doc != '17' && d.id_etat_doc != '33')
						GROUP BY d.ref_doc 
						ORDER BY date ASC";

	$resultat_doc = $bdd->query ($query_doc);
	while ($var_doc = $resultat_doc->fetchObject()) {
		$grand_livre_documents[$var_doc->ref_doc] = $var_doc; 
	}
	
	// Sélection des règlements du contact
	$grand_livre_reglements = array();
	$query_reg = "SELECT r.ref_reglement, r.id_reglement_mode, r.ref_contact, rm.lib_reglement_mode,
									 r.date_saisie, r.date_reglement as date, r.montant_reglement as montant_ttc, rm.type_reglement, 
									 rec.numero_cheque as nchq_e, rsc.numero_cheque as nchq_s

						FROM reglements r  
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode 
							LEFT JOIN regmt_e_chq rec ON r.ref_reglement = rec.ref_reglement 
							LEFT JOIN regmt_s_chq rsc ON r.ref_reglement = rsc.ref_reglement 
						WHERE r.ref_contact = '".$ref_contact."' ".$query_where2."  && valide = 1
						GROUP BY r.ref_reglement 
						ORDER BY date ASC";

	$resultat_reg = $bdd->query ($query_reg);
	while ($var_reg = $resultat_reg->fetchObject()) {
		// Association des ref_doc correspondant au reglement
		$var_reg->ref_doc = array();
		$query2 = "SELECT ref_doc
							FROM reglements_docs 
							WHERE ref_reglement = '".$var_reg->ref_reglement."' && liaison_valide = '1' ";
	
		$resultat2 = $bdd->query ($query2);
		while ($var2 = $resultat2->fetchObject()) { $var_reg->ref_doc[$var2->ref_doc] = $var2->ref_doc; }
		
		$grand_livre_reglements[$var_reg->ref_reglement] = $var_reg; 
		unset ($resultat2, $var2, $query2);
	}
			
	// Gestion du Lettrage
	$lettrage = "AA";
	foreach ($grand_livre_documents as $documents) {
	$use_lettrage = 0;
			// A moins qu'un lettrage existe pour le document
			if (isset($documents->lettrage)) {$use_lettrage = $documents->lettrage;}
			
			// Sinon on récupére le lettrage attribué à un autre documents qui fait parti des règlements
			if ($use_lettrage == 0) {
				foreach ($grand_livre_reglements as $reglement) {
					foreach ($reglement->ref_doc as $nref_doc) {
						if ($use_lettrage != 0) {continue;}
						if (isset($grand_livre_documents[$nref_doc]->lettrage)) {
							$use_lettrage = $grand_livre_documents[$nref_doc]->lettrage ;
							foreach ($reglement->ref_doc as $lref_doc) {
								if (isset($grand_livre_documents[$lref_doc]) && !isset($grand_livre_documents[$lref_doc]->lettrage)) {
								$grand_livre_documents[$lref_doc]->lettrage = $use_lettrage;
								}
								$reglement->lettrage = $use_lettrage;
							}
						}
					}
				}
			}
			// On recupére le lettrage si un reglement correspondant au document est deja existant
			if ($use_lettrage == 0) {
				foreach ($grand_livre_reglements as $reglement) {
					if ($use_lettrage != 0) {continue;}
					if (isset($reglement->ref_doc[$documents->ref_doc]) && isset($reglement->lettrage)) {
						$use_lettrage = $reglement->lettrage;
					}
				}
			}
			// Si aucun lettrage n'as été trouvé
			if ($use_lettrage == 0) { $use_lettrage = $lettrage; $lettrage = cre_lettrage ($lettrage);}
			
			// Alors on injecte le lettrage dans tout les règlements et les documents associés
			foreach ($grand_livre_reglements as $reglement) {
				if (isset($reglement->ref_doc[$documents->ref_doc]) && !isset($reglement->lettrage)) {
				$reglement->lettrage = $use_lettrage;
				}
			}
		// Par sécurité on attribut le lettrage au document actuel
		if (!isset($documents->lettrage)) {
		$documents->lettrage = $use_lettrage;
		}
	}
	// On attribut des lettrages aux règlements n'étant pas relié à des factures (en vérifiant si il n'y a pas de document auquel il est lié qui aurait un letttrage)
	foreach ($grand_livre_reglements as $reglement) {
		if (!isset($reglement->lettrage)) {
			//$lettrage = cre_lettrage ($lettrage);
		 	$reglement->lettrage = "--";
		}
	}
	
	// On injecte les résultats des factures et des règlements
	$grand_livre_tmp = array();
	//on récupère le report à nouveau relatif au précédent exercice
	$query_ran = "SELECT id_exercice_ran, ref_contact, date_ran as date, montant_ran
								FROM compta_exercices_reports
								WHERE date_ran = '".$this->date_debut." 00:00:00' && ref_contact = '".$ref_contact."' ";
	$resultat_ran = $bdd->query ($query_ran);
	if ($tmp_ran = $resultat_ran->fetchObject()) {
		$tmp_ran->lettrage = "--";
		$grand_livre_tmp[] = $tmp_ran;
	} else {
		//sauf si le précédent exercice n'est pas clôturé alors on va calculer le report depuis le dernier exercice clôturé
		$query_ran_last = "SELECT id_exercice_ran, ref_contact, date_ran as date, montant_ran
											FROM compta_exercices_reports
											WHERE date_ran < '".$this->date_debut." 00:00:00' && ref_contact = '".$ref_contact."' 
											ORDER BY date_ran DESC
											LIMIT 1";
		$resultat_ran_last = $bdd->query ($query_ran_last);
		if (!$tmp_ran_last = $resultat_ran_last->fetchObject()) {
			if ($this->date_debut != $ENTREPRISE_DATE_CREATION) {
			$tmp_ran_last = new stdclass;
			$tmp_ran_last->date = $ENTREPRISE_DATE_CREATION;
			$tmp_ran_last->id_exercice_ran = "1";
			$tmp_ran_last->ref_contact = $ref_contact;
			$tmp_ran_last->montant_ran = 0;
			}
		}
		
		if ($tmp_ran_last) {
			$ran_last_livre_documents = array();
			$query_ran_last_doc = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, ref_contact, de.lib_etat_doc,
		
												( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
													FROM docs_lines dl
													WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,
		
													date_creation_doc as date,
													fnr.lib_niveau_relance 	
		
								FROM documents d 
									LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
									LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
									LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc 
									LEFT JOIN factures_relances_niveaux fnr ON fnr.id_niveau_relance = df.id_niveau_relance 
								WHERE ref_contact = '".$ref_contact."' &&   d.date_creation_doc >= '".$tmp_ran_last->date." 00:00:00' && d.date_creation_doc < '".$this->date_debut."'  && (d.id_type_doc = '4' || d.id_type_doc = '8') && (d.id_etat_doc != '17' && d.id_etat_doc != '33')
								GROUP BY d.ref_doc 
								ORDER BY date ASC";
		
			$ran_last_doc = $bdd->query ($query_ran_last_doc);
			while ($var_ran_last_doc = $ran_last_doc->fetchObject()) {
				$ran_last_livre_documents[$var_ran_last_doc->ref_doc] = $var_ran_last_doc; 
			}
			
			// Sélection des règlements du contact
			$ran_last_livre_reglements = array();
			$query_ran_last_reg = "SELECT r.ref_reglement, r.id_reglement_mode, r.ref_contact, rm.lib_reglement_mode,
											 r.date_reglement as date, r.montant_reglement as montant_ttc, rm.type_reglement, 
											 rec.numero_cheque as nchq_e, rsc.numero_cheque as nchq_s
		
								FROM reglements r  
									LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode 
									LEFT JOIN regmt_e_chq rec ON r.ref_reglement = rec.ref_reglement 
									LEFT JOIN regmt_s_chq rsc ON r.ref_reglement = rsc.ref_reglement 
								WHERE r.ref_contact = '".$ref_contact."' &&  date_reglement >= '".$tmp_ran_last->date." 00:00:00' && date_reglement < '".$this->date_debut."'  && valide = 1
								GROUP BY r.ref_reglement 
								ORDER BY date ASC";
		
			$resultat_ran_last_reg = $bdd->query ($query_ran_last_reg);
			while ($var_ran_last_reg = $resultat_ran_last_reg->fetchObject()) {
				$ran_last_livre_reglements[$var_ran_last_reg->ref_reglement] = $var_ran_last_reg; 
			}
			//on calcul un ran qui cumule l'ensemble des résultats
			foreach ($ran_last_livre_documents as $ran_last_documents) {
				//document en débit
				if (isset($ran_last_documents->ref_doc) && !is_array($ran_last_documents->ref_doc) && (($ran_last_documents->id_type_doc == 4 && $ran_last_documents->montant_ttc >= 0) || ($ran_last_documents->id_type_doc == 8 && $ran_last_documents->montant_ttc < 0))) {
					$tmp_ran_last->montant_ran = $tmp_ran_last->montant_ran - abs(number_format($ran_last_documents->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
				} 
				//document en crédit
				if (isset($ran_last_documents->ref_doc) && !is_array($ran_last_documents->ref_doc) && (($ran_last_documents->id_type_doc == 4 && $ran_last_documents->montant_ttc < 0) || ($ran_last_documents->id_type_doc == 8 && $ran_last_documents->montant_ttc >= 0)) ) { 
					$tmp_ran_last->montant_ran = $tmp_ran_last->montant_ran + abs(number_format($ran_last_documents->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
				} 
				
			}
			foreach ($ran_last_livre_reglements as $ran_last_reglement) {	
				// Règlement en débit
				if (isset($ran_last_reglement->ref_reglement) && $ran_last_reglement->type_reglement == "sortant") {
					$tmp_ran_last->montant_ran = $tmp_ran_last->montant_ran - abs(number_format($ran_last_reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
				} 
				//règlement en crédit
				if (isset($ran_last_reglement->ref_reglement) && $ran_last_reglement->type_reglement == "entrant") { 
					$tmp_ran_last->montant_ran = $tmp_ran_last->montant_ran + abs(number_format($ran_last_reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
				} 
			}
			$tmp_ran_last->date = $this->date_debut;
			$tmp_ran_last->lettrage = "--";
			$grand_livre_tmp[] = $tmp_ran_last;
		}
	}
		
	unset ($tmp_ran, $var_doc, $var_reg, $resultat_doc, $resultat_reg, $resultat_ran, $query_reg, $query_doc, $query_ran);
		
	foreach ($grand_livre_documents as $documents) {	$grand_livre_tmp[] = $documents; }
	foreach ($grand_livre_reglements as $reglement) {	$grand_livre_tmp[] = $reglement; }
		
	$grand_livre = tri($grand_livre_tmp, "date");
	$pdf_grand_livre = array();
	foreach ($grand_livre as $line_livre) {
		$pdf_grand_livre[] = $line_livre;
	}
	// Affichage du pdf
	// Préférences et options
	$GLOBALS['PDF_OPTIONS']['HideToolbar'] = 0;
	$GLOBALS['PDF_OPTIONS']['AutoPrint'] = $print;
	
	include_once ($PDF_MODELES_DIR.$this->code_extrait_contact_pdf_modele.".class.php");
	$class = "pdf_".$this->code_extrait_contact_pdf_modele;
	$pdf = new $class;
	
	// Création
	$pdf->create_pdf($this, $pdf_grand_livre, $ref_contact);
	
	// Sortie
	$pdf->Output();
	
}

//solde d'un extrait de compte d'un contact
static function solde_extrait_compte ($ref_contact) {
	global $bdd;
	global $TARIFS_NB_DECIMALES;
	global $PDF_MODELES_DIR;
	global $ENTREPRISE_DATE_CREATION;
	
	if (!$ref_contact) {return false;}
	

			
	$grand_livre_tmp = array();
	$solde_contact = 0;
	//on récupère le report à nouveau relatif au dernier exercice
	$query_ran = "SELECT id_exercice_ran, ref_contact, date_ran as date, montant_ran
								FROM compta_exercices_reports
								WHERE ref_contact = '".$ref_contact."' 
								ORDER BY date_ran DESC
								LIMIT 1";
	$resultat_ran = $bdd->query ($query_ran);
	if ($tmp_ran = $resultat_ran->fetchObject()) {
		$date_debut = $tmp_ran->date;
		$solde_contact = $solde_contact + $tmp_ran->montant_ran;
	} else {
		//si aucun exercice alors on calcule depuis la création  de l'entreprise
		$date_debut = $ENTREPRISE_DATE_CREATION;
	}
	$ran_last_livre_documents = array();
	$query_ran_last_doc = "SELECT d.ref_doc, d.id_type_doc, dt.lib_type_doc, d.id_etat_doc, ref_contact, de.lib_etat_doc,

										( SELECT SUM(qte * pu_ht * (1-remise/100) * (1+tva/100))
											FROM docs_lines dl
											WHERE d.ref_doc = dl.ref_doc && ISNULL(dl.ref_doc_line_parent) && visible = 1 ) as montant_ttc,

											date_creation_doc as date,
											fnr.lib_niveau_relance 	

						FROM documents d 
							LEFT JOIN documents_types dt ON d.id_type_doc = dt.id_type_doc 
							LEFT JOIN documents_etats de ON d.id_etat_doc = de.id_etat_doc 
							LEFT JOIN doc_fac df ON d.ref_doc = df.ref_doc 
							LEFT JOIN factures_relances_niveaux fnr ON fnr.id_niveau_relance = df.id_niveau_relance 
						WHERE ref_contact = '".$ref_contact."' &&   d.date_creation_doc >= '".$date_debut." 00:00:00' && (d.id_type_doc = '4' || d.id_type_doc = '8') && (d.id_etat_doc != '17' && d.id_etat_doc != '33')
						GROUP BY d.ref_doc 
						ORDER BY date ASC";

	$ran_last_doc = $bdd->query ($query_ran_last_doc);
	while ($var_ran_last_doc = $ran_last_doc->fetchObject()) {
		$ran_last_livre_documents[$var_ran_last_doc->ref_doc] = $var_ran_last_doc; 
	}
	
	// Sélection des règlements du contact
	$ran_last_livre_reglements = array();
	$query_ran_last_reg = "SELECT r.ref_reglement, r.id_reglement_mode, r.ref_contact, rm.lib_reglement_mode,
									 r.date_reglement as date, r.montant_reglement as montant_ttc, rm.type_reglement, 
									 rec.numero_cheque as nchq_e, rsc.numero_cheque as nchq_s

						FROM reglements r  
							LEFT JOIN reglements_modes rm ON r.id_reglement_mode = rm.id_reglement_mode 
							LEFT JOIN regmt_e_chq rec ON r.ref_reglement = rec.ref_reglement 
							LEFT JOIN regmt_s_chq rsc ON r.ref_reglement = rsc.ref_reglement 
						WHERE r.ref_contact = '".$ref_contact."' &&  date_reglement >= '".$date_debut." 00:00:00' && valide = 1
						GROUP BY r.ref_reglement 
						ORDER BY date ASC";

	$resultat_ran_last_reg = $bdd->query ($query_ran_last_reg);
	while ($var_ran_last_reg = $resultat_ran_last_reg->fetchObject()) {
		$ran_last_livre_reglements[$var_ran_last_reg->ref_reglement] = $var_ran_last_reg; 
	}
	//on calcul un ran qui cumule l'ensemble des résultats
	foreach ($ran_last_livre_documents as $ran_last_documents) {
		//document en débit
		if (isset($ran_last_documents->ref_doc) && !is_array($ran_last_documents->ref_doc) && (($ran_last_documents->id_type_doc == 4 && $ran_last_documents->montant_ttc >= 0) || ($ran_last_documents->id_type_doc == 8 && $ran_last_documents->montant_ttc < 0))) {
			$solde_contact = $solde_contact - abs(number_format($ran_last_documents->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
		} 
		//document en crédit
		if (isset($ran_last_documents->ref_doc) && !is_array($ran_last_documents->ref_doc) && (($ran_last_documents->id_type_doc == 4 && $ran_last_documents->montant_ttc < 0) || ($ran_last_documents->id_type_doc == 8 && $ran_last_documents->montant_ttc >= 0)) ) { 
			$solde_contact = $solde_contact + abs(number_format($ran_last_documents->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
		} 
		
	}
	foreach ($ran_last_livre_reglements as $ran_last_reglement) {	
		// Règlement en débit
		if (isset($ran_last_reglement->ref_reglement) && $ran_last_reglement->type_reglement == "sortant") {
			$solde_contact = $solde_contact - abs(number_format($ran_last_reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
		} 
		//règlement en crédit
		if (isset($ran_last_reglement->ref_reglement) && $ran_last_reglement->type_reglement == "entrant") { 
			$solde_contact = $solde_contact + abs(number_format($ran_last_reglement->montant_ttc, $TARIFS_NB_DECIMALES, ".", ""	));
		} 
	}
	
	return $solde_contact;
}




// *************************************************************************************************************
// FONCTIONS EXTERNES 
// *************************************************************************************************************


// Fonction permettant de charger tous les exercices
static function charger_compta_exercices () {
	global $bdd;


	$compta_e = array();
	$query = "SELECT ce.id_exercice, ce.lib_exercice, ce.date_fin , ce.etat_exercice
						FROM compta_exercices ce
						ORDER BY ce.date_fin DESC";
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		
		$compta_tmp = new compta_exercices ($tmp->id_exercice);
		$tmp->date_debut = $compta_tmp-> getDate_debut ();
		$compta_e[] = $tmp;
		unset($compta_tmp);
	}
	
	return $compta_e;
}



// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************

function getId_exercice () {
	return $this->id_exercice;
}

function getLib_exercice () {
	return $this->lib_exercice;
}

function getDate_fin () {
	return $this->date_fin;
}

function getEtat_exercice () {
	return $this->etat_exercice;
}

function getDate_debut () {
	if (!$this->date_debut) { $this->find_date_debut ();}
	return $this->date_debut;
}

}





?>