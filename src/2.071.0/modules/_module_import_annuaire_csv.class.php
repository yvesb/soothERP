<?php
// *************************************************************************************************************
// CLASSE REGISSANT les import de contact depuis un fichier CSV 
// *************************************************************************************************************


final class import_annuaire_csv {
	protected $id_profil; // profil à créer lors de l'import
	protected $etape;			//etape en cours de l'import
	protected $limite;		// limite des informations importée (1: fiches valides 2: fiches avertissements, 3: toutes les fiches
		

function __construct() {
	global $bdd;
	
	$query = "SELECT id_profil, etape, limite FROM csv_import_annu_etape LIMIT 0,1";
	$resultat = $bdd->query ($query); 
	if (!$a = $resultat->fetchObject()) { return false;}
	$this->id_profil = $a->id_profil;
	$this->etape = $a->etape;
	$this->limite = $a->limite;
	
	return true;
}

//import des données en fiche contact
function import_colonne($contenu, $id_profil) {
	global $bdd;
	global $DIR;
	global $CLIENT_ID_PROFIL;
	
	$count_erreur = 0;
	$count_import = 0;

	 if (isset($GLOBALS['_INFOS']['count_import'])) {$count_import = $GLOBALS['_INFOS']['count_import'];}
	$count_total = 0;
	
	if (!count($contenu)) {
		$GLOBALS['_ALERTES']['import_fichier_vide'] = 1;
	}
	
	// *************************************************
	// Arret en cas d'erreur
	if (count($GLOBALS['_ALERTES'])) {
		return false;
	}
	
	$line_1 = $contenu[0];
	$nb_col = count ($line_1);
	
	if ($nb_col > 255) {
		$GLOBALS['_ALERTES']['import_fichier_trop_de_colonnes'] = 1;
		return false;
	}
	
	$GLOBALS['_COLONNE'] = array();
	// creation des daos
	$dao_csv_import_annu_ligne = new import_annuaire_csv_ligne();
	$dao_csv_import_annu_cols = new import_annuaire_csv_colonne();
	
	// on efface les table
	$dao_csv_import_annu_ligne->erase();
	$dao_csv_import_annu_cols->erase();
	
	//
	$query = "TRUNCATE TABLE `csv_import_annu_etape`";
	$bdd->exec ($query);
	
	for($i=0; $i < $nb_col; $i++) {
		$colonne = new import_annuaire_csv_colonne();
		$colonne->__setLibelle($line_1[$i]);
		
		// ecriture en base
		$GLOBALS['_COLONNE'][] = $i+1;
		$dao_csv_import_annu_cols->write($colonne);	
	}
	
	
	
	// ecriture des ligne
	
	for($curseur_fichier=1; $curseur_fichier < count($contenu); $curseur_fichier++) {
		$count_total++;
		// on retire les crlf
		//$my_wonderful_string = str_replace("\r\n", "", $contenu[$curseur_fichier]);
		//$my_wonderful_string = trim($my_wonderful_string, " \r\n\0\x0B");
		$tmp_line =  $contenu[$curseur_fichier];
		if (count($tmp_line) > $nb_col) { $count_erreur ++; continue;}
		
		for($curseur_ligne=0; $curseur_ligne < $nb_col; $curseur_ligne++) {
//			$ligne = new bean_ligne();
			$ligne = new import_annuaire_csv_ligne();
			if (isset($tmp_line[$curseur_ligne])) {
				$ligne->__setValeur($tmp_line[$curseur_ligne]);
			} else {
				$ligne->__setValeur("");
			}
			$ligne->__setId_colonne($curseur_ligne+1);
			// ecriture en base
			$dao_csv_import_annu_ligne->write($ligne);	
		}
	}
	//création de l'information sur l'étape et le profil à créer pour les contacts importés
	$query = "INSERT INTO csv_import_annu_etape	 (id_profil, etape, limite) VALUES (".num_or_null($id_profil).", 1, 1)
						";
	$bdd->exec ($query);
	
	foreach ($GLOBALS['_ALERTES']  as $alerte => $value) {
		echo $alerte." => ".$value."<br>";
	}

	// print_r($infos_generales);
	// print_r($infos_profils);
	 $GLOBALS['_ALERTES'] = array();
		
	 $GLOBALS['_INFOS']['count_import'] = $count_import;
	 $GLOBALS['_INFOS']['count_erreur'] = $count_erreur;
}

//mise à jour de l'étape de l'import
public function maj_etape($etape) {
	global $bdd;
	// maj dans la base
	$query = "UPDATE csv_import_annu_etape SET etape = '".$etape."' ";
	$bdd->exec ($query);
	return true;
}
//mise à jour de la limite d'import
public function maj_limite($limite) {
	global $bdd;
	// maj dans la base
	$query = "UPDATE csv_import_annu_etape SET limite = '".$limite."' ";
	$bdd->exec ($query);
	return true;
}

//import des données en fiche contact
function create($liste_ligne = array(), $filename) {
    $itest = 0;
    $jtest = 0;
    global $DIR;
	global $bdd;
	global $CLIENT_ID_PROFIL;
	global $FOURNISSEUR_ID_PROFIL;
	global $CONSTRUCTEUR_ID_PROFIL;
	$liste_export = Array();
        $file_lines = file($filename);
        $max_id = count(explode(";", $file_lines[0]));
	$dao_csv_import_annu_cols = new import_annuaire_csv_colonne();
	$arraydao_csv_import_annu_cols = $dao_csv_import_annu_cols->readAll();
	$arrayValidColonne = array();
	$lastIdCols = 0;
	$firstIdCols = 0;
	
	foreach ($arraydao_csv_import_annu_cols as $import_annuaire_csv_colonne){
		if( trim($import_annuaire_csv_colonne->__getChamp_equivalent()) != ""){
			if($firstIdCols == 0){
				$firstIdCols = $import_annuaire_csv_colonne->__getId();
			}
			$arrayValidColonne[$import_annuaire_csv_colonne->__getId()] = $import_annuaire_csv_colonne->__getChamp_equivalent();
			$lastIdCols = $import_annuaire_csv_colonne->__getId();
		}
	}
	$dao_csv_import_annu_ligne = new import_annuaire_csv_ligne();
	$arraydao_csv_import_annu_ligne = $dao_csv_import_annu_ligne->readAll();
	
			$facturation_periodique = '';
			$id_client_categ = '';
			$type_client = 'piste';
			$id_tarif = '';
			$encours = '';
			$delai_reglement = '';
			$defaut_numero_compte = '';
			$id_fournisseur_categ = '';
			$code_client = '';
			$conditions_commerciales = '';
			$id_stock_livraison = '';
			$delai_livraison = '';
			$defaut_numero_compte = '';
			$identifiant_revendeur = '';
			$conditions_garantie = '';
			
			
	$count_total = 0;
	$count_import = 0;
	 if (isset($GLOBALS['_INFOS']['count_import'])) {$count_import = $GLOBALS['_INFOS']['count_import'];}
	$count_erreur = 0;
	foreach ($arraydao_csv_import_annu_ligne as $indexarraydao_csv_import_annu_ligne) {
		if (count($liste_ligne) && !in_array($indexarraydao_csv_import_annu_ligne->__getId(), $liste_ligne)) {continue;}
		
		$id_colonne = $indexarraydao_csv_import_annu_ligne->__getId_colonne();
		$id_valeur = $indexarraydao_csv_import_annu_ligne->__getValeurRenseignee();
		if($id_colonne == $firstIdCols){
			// nombre client(s) ajouté(s)
			// initialisation
			$infos_generales = array();
			$infos_generales['adresses']	= array();
			$infos_generales['coordonnees']	= array();
			$infos_generales['sites']		= array();
			$infos_profils = array();
			$id_civilite = '5';
			$nom = ' ';
			$id_categorie = '5';
			$siret = '';
			$tva_intra = '';
			$note = '';
			$lib_adresse = '';
			$adresse_adresse = '';
			$adresse_cp = '';
			$adresse_ville = '';
			$adresse_id_pays = '';
			$adresse_note = '';
			$email_user_creation = 0;
			$coordonnee_lib = '';
			$tel1 = '';
			$tel2 = '';
			$fax = '';
			$email = '';
			$coordonnee_note = '';
			$site_lib = '';
			$site_url = '';
			$site_login = '';
			$site_pass = '';
			$site_note = '';
			
			// alimentation par défaut
			$infos_generales['nom'] = '';
			$infos_generales['id_civilite'] = $id_civilite;
			$infos_generales['id_categorie'] = $id_categorie;
			$infos_generales['siret'] = $siret;
			$infos_generales['tva_intra'] = $tva_intra;
			$infos_generales['note'] = $note;
		}
		
		if(isset($arrayValidColonne[$id_colonne])){
		
			if($arrayValidColonne[$id_colonne] == "nom" ){
				if ($infos_generales['nom']) {
					$infos_generales['nom'] 		.= " ".$id_valeur ;
				} else {
					$infos_generales['nom'] 		.= $id_valeur ;
				}
			}
			
			if($arrayValidColonne[$id_colonne] == "id_civilite" && is_numeric($id_valeur) ){
				$infos_generales['id_civilite'] = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "id_categorie" && is_numeric($id_valeur) ){
				$infos_generales['id_categorie'] = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "siret" ){
				$infos_generales['siret'] = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "tva_intra" ){
				$infos_generales['tva_intra'] = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "note_gen" ){
				if ($infos_generales['note']) {
					$infos_generales['note'] 		.= "\n".$id_valeur ;
				} else {
					$infos_generales['note'] 		.= $id_valeur ;
				}
			}
			// ADRESSE
			if($arrayValidColonne[$id_colonne] == "lib_adresse" ){
				$lib_adresse = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "adresse" ){
				if ($adresse_adresse) {
					$adresse_adresse 		.= "\n".$id_valeur ;
				} else {
					$adresse_adresse 		.= $id_valeur ;
				}
			}
			if($arrayValidColonne[$id_colonne] == "adresse_cp" ){
				$adresse_cp .= $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "adresse_ville" ){
				$adresse_ville .= $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "id_pays" && is_numeric($id_valeur) ){
				$adresse_id_pays .= $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "adresse_note" ){
				if ($adresse_note) {
					$adresse_note 		.= "\n".$id_valeur ;
				} else {
					$adresse_note 		.= $id_valeur ;
				}
			}
			// COORDONNEES
			if($arrayValidColonne[$id_colonne] == "lib_coord" ){
				$coordonnee_lib .= $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "tel1" ){
				$tel1 .= $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "tel2" ){
				$tel2 .= $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "fax" ){
				$fax .= $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "email" ){
				$email .= $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "coord_note" ){
				if ($coordonnee_note) {
					$coordonnee_note 		.= "\n".$id_valeur ;
				} else {
					$coordonnee_note 		.= $id_valeur ;
				}
			}
			// SITE
			if($arrayValidColonne[$id_colonne] == "lib_site" ){
				$site_lib .= $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "url" ){
				$site_url .= $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "login" ){
				$site_login .= $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "pass" ){
				$site_pass .= $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "note_site" ){
				if ($site_note) {
					$site_note 		.= "\n".$id_valeur ;
				} else {
					$site_note 		.= $id_valeur ;
				}
			}
			//profil client
			if($arrayValidColonne[$id_colonne] == "id_client_categ" && is_numeric($id_valeur)){
				$id_client_categ = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "type" ){
				$type_client = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "id_tarif" ){
				$id_tarif = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "facturation" ){
				$facturation_periodique = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "encours" ){
				$encours = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "delai_reglement" ){
				$delai_reglement = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "defaut_numero_compte" ){
				$defaut_numero_compte = $id_valeur;
			}
			
			//profil fournisseur
			if($arrayValidColonne[$id_colonne] == "id_fournisseur_categ" ){
				$id_fournisseur_categ = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "identifiant" ){
				$code_client = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "conditions_commerciales" ){
				$conditions_commerciales = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "id_stock_livraison" ){
				$id_stock_livraison = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "delai_livraison" ){
				$delai_livraison = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "defaut_numero_compte" ){
				$defaut_numero_compte = $id_valeur;
			}
			//profil constructeur
			if($arrayValidColonne[$id_colonne] == "identifiant_revendeur" ){
				$identifiant_revendeur = $id_valeur;
			}
			if($arrayValidColonne[$id_colonne] == "conditions_garantie" ){
				$conditions_garantie .= $id_valeur;
			}
		}

		if($id_colonne == $lastIdCols){
		
			$infos_generales['adresses'][] = array('lib_adresse' => $lib_adresse, 'text_adresse' => $adresse_adresse, 'code_postal' => $adresse_cp, 'ville' =>  $adresse_ville, 'id_pays' => $adresse_id_pays, 'note' => $adresse_note);		
			$infos_generales['coordonnees'][]	= array('lib_coord' => $coordonnee_lib, 'tel1' => $tel1, 'tel2' => $tel2, 'fax' => $fax, 'email' => trim($email), 'note' => $coordonnee_note, 'ref_coord_parent' => NULL, 'email_user_creation' => $email_user_creation );
			$infos_generales['sites'][] = array('lib_site_web' => $site_lib, 'url' => $site_url, 'login' => $site_login, 'pass' => $site_pass, 'note' => $site_note, );
			
			if (isset($_SESSION['profils'][$CLIENT_ID_PROFIL]) && $this->id_profil == $CLIENT_ID_PROFIL) {
			echo "ding".$id_client_categ;
				$infos_profils[$CLIENT_ID_PROFIL]['id_profil'] 					=	 $CLIENT_ID_PROFIL;
				$infos_profils[$CLIENT_ID_PROFIL]['id_client_categ'] 		=  $id_client_categ;
				$infos_profils[$CLIENT_ID_PROFIL]['type_client'] 				=  $type_client;
				$infos_profils[$CLIENT_ID_PROFIL]['id_tarif'] 					=  $id_tarif;
				$infos_profils[$CLIENT_ID_PROFIL]['ref_adr_livraison'] 	=  '';
				$infos_profils[$CLIENT_ID_PROFIL]['ref_adr_facturation']=  '';
				$infos_profils[$CLIENT_ID_PROFIL]['app_tarifs'] 				=  '';
				$infos_profils[$CLIENT_ID_PROFIL]['facturation_periodique'] 	=  $facturation_periodique;
				$infos_profils[$CLIENT_ID_PROFIL]['encours']					 	=  $encours;
				$infos_profils[$CLIENT_ID_PROFIL]['delai_reglement'] 		=  $delai_reglement;
				$infos_profils[$CLIENT_ID_PROFIL]['ref_commercial'] 		=  '';
				$infos_profils[$CLIENT_ID_PROFIL]['defaut_numero_compte'] 		=  $defaut_numero_compte;
			}
			
			if (isset($_SESSION['profils'][$FOURNISSEUR_ID_PROFIL]) && $this->id_profil == $FOURNISSEUR_ID_PROFIL) {
				$infos_profils[$FOURNISSEUR_ID_PROFIL]['id_profil'] 								=	 $FOURNISSEUR_ID_PROFIL;
				$infos_profils[$FOURNISSEUR_ID_PROFIL]['code_client'] 							=  $code_client;
				$infos_profils[$FOURNISSEUR_ID_PROFIL]['conditions_commerciales'] 	=  $conditions_commerciales;
				$infos_profils[$FOURNISSEUR_ID_PROFIL]['id_fournisseur_categ'] 			=  $id_fournisseur_categ;
				$infos_profils[$FOURNISSEUR_ID_PROFIL]['id_stock_livraison'] 				=  $id_stock_livraison;
				$infos_profils[$FOURNISSEUR_ID_PROFIL]['delai_livraison'] 					=  $delai_livraison;
				$infos_profils[$FOURNISSEUR_ID_PROFIL]['app_tarifs'] 								=  '';
				$infos_profils[$FOURNISSEUR_ID_PROFIL]['defaut_numero_compte'] 			=  $defaut_numero_compte;
			}
			
			if (isset($_SESSION['profils'][$CONSTRUCTEUR_ID_PROFIL]) && $this->id_profil == $CONSTRUCTEUR_ID_PROFIL) {
				$infos_profils[$CONSTRUCTEUR_ID_PROFIL]['id_profil'] 								=	 $CONSTRUCTEUR_ID_PROFIL;
				$infos_profils[$CONSTRUCTEUR_ID_PROFIL]['identifiant_revendeur'] 		=  $identifiant_revendeur;
				$infos_profils[$CONSTRUCTEUR_ID_PROFIL]['conditions_garantie'] 			=  $conditions_garantie;
			}
			// *************************************************
			// Création du contact
			if (isset($infos_generales['nom']) && trim($infos_generales['nom']) ) {
				$email_doublon = 0;
				$nom_doublon = 0;
				//verification des doublon d'email et de nom
				// si on tente d'importer quand même les avertissements
				$libs = explode (" ", trim($infos_generales['nom']));
				
				$query_where 	= "";
                                $comp = 0;
				for ($i=0; $i<count($libs); $i++) {

                                        $lib = trim($libs[$i]);
					if (isset($libs[$i + 1]))
                                            {
                                                $comp = 1;
                                                $query_where 	.= " nom LIKE '%".addslashes($lib)."%' ";
                                                $query_where 	.= " && ";
                                            }
                                        else
                                            {
                                                if ($comp == 1)
                                                    $query_where 	.= " nom LIKE '%".addslashes($lib)."%' ";
                                                else
                                                    $query_where 	.= " nom LIKE '".addslashes($lib)."' ";
                                            }
				}
				$query = "SELECT nom
									FROM annuaire a 
									WHERE ".$query_where."
									LIMIT 0,1";
				$resultat = $bdd->query($query);
				if ($fiche = $resultat->fetchObject()) { 
						$nom_doublon = 1;
				}
				//on vérifie l'email car dans tout les cas on n'ecrassera pas un email déjà présent
				if (isset($email) && trim($email)) {
					
					$query_where 	= "";
					$query_where 	.= " email = '".$email."' && email != ''"; 
					
					$query = "SELECT email
										FROM coordonnees 
										WHERE ".$query_where."
										LIMIT 0,1";
					$resultat = $bdd->query($query);
					if ($fiche = $resultat->fetchObject()) { 
						$email_doublon = 1;
						if (isset($infos_generales['coordonnees'][0]["email"])) {$infos_generales['coordonnees'][0]["email"] = "";}
					}
				}
				// on check en fonction de limite si on importe ou non le contact
				$can_import = 0;
				if ($this->limite == 3) {$can_import = 1;}
				if ($this->limite == 1 && !$nom_doublon) {$can_import = 1;}
				if ($this->limite == 2 && $nom_doublon) {$can_import = 1;}

                                if ($can_import == 0)
                                {
                                    $liste_export[$jtest++] = $indexarraydao_csv_import_annu_ligne->__getId();
                                }
				if ($can_import) {
					$contact = new contact ();
					if (($tset = $contact->create ($infos_generales, $infos_profils)) == false)
                                            $liste_export[$jtest++] = $indexarraydao_csv_import_annu_ligne->__getId();
					$count_import ++;
					$facturation_periodique = '';
					$id_client_categ = '';
					$type_client = 'piste';
					$id_tarif = '';
					$encours = '';
					$delai_reglement = '';
					$defaut_numero_compte = '';
					$id_fournisseur_categ = '';
					$code_client = '';
					$conditions_commerciales = '';
					$id_stock_livraison = '';
					$delai_livraison = '';
					$defaut_numero_compte = '';
					$identifiant_revendeur = '';
					$conditions_garantie = '';
			
				}
			}
			foreach ($GLOBALS['_ALERTES']  as $alerte => $value) {
				echo $alerte." => ".$value."<br>";
			}
			if(count($GLOBALS['_ALERTES'])) {
				$count_erreur ++;
			} else {
			}
			// print_r($infos_generales);
			// print_r($infos_profils);
			 $GLOBALS['_ALERTES'] = array();
		}
	}
	if (count($liste_ligne)) {
		$indexarraydao_csv_import_annu_ligne->supprimer($liste_ligne);
	}
	$GLOBALS['_INFOS']['count_import'] = $count_import;
	$GLOBALS['_INFOS']['count_erreur'] = $count_erreur;
       if (file_exists("retour_import.csv"))
            {
                if (!filesize("retour_import.csv"))
                    {
                        $fichier = file("import_cop.csv");
                        if (isset($fichier[0]))
                            {
                                $fd = fopen("retour_import.csv", "w");
                                fwrite($fd, $fichier[0]);
                                fclose($fd);
                            }
                    }
            }
        else
            {
                $fichier = file("import_cop.csv");
                if (isset($fichier[0]))
                    {
                        $fd = fopen("retour_import.csv", "w");
                        fwrite($fd, $fichier[0]);
                        fclose($fd);
                    }
            }
        $fd = fopen("retour_import.csv", "a");
        chmod("retour_import.csv", 0755);
        foreach($liste_export as $export_fail)
            fwrite($fd, $file_lines[ceil($export_fail / $max_id)]);
        fclose($fd);
}
 
function getId_profil () {
	return $this->id_profil;
}
 
function getEtape () {
	return $this->etape;
}
 
function getLimite () {
	return $this->limite;
}


}


// ******
// repartition des colonnes
// ******


final class import_annuaire_csv_colonne{

	private $id;
	private $libelle;
	private $champ_equivalent;
	

function __construct() {
	return true;
}

/**
 * @return unknown_type
 */
public function __getId() {
	return $this->id;
}

/**
 * @param $id
 * @return unknown_type
 */
public function __setId($id) {
	$this->id = $id;
}

/**
 * @return unknown_type
 */
public function __getLibelle() {
	return $this->libelle;
}

/**
 * @param $libelle
 * @return unknown_type
 */
public function __setLibelle($libelle) {
	$this->libelle = $libelle;
}

/**
 * @return unknown_type
 */
public function __getChamp_equivalent() {
	return $this->champ_equivalent;
}

/**
 * @param $champ_equivalent
 * @return unknown_type
 */
public function __setChamp_equivalent($champ_equivalent) {
	$this->champ_equivalent = $champ_equivalent;
}

//effacement table
public function erase() {
	global $bdd;
	$query = "ALTER TABLE `csv_import_annu_lines` DROP FOREIGN KEY `csv_import_annu_lines_ibfk_1`";
	$bdd->exec ($query);
	$query = "TRUNCATE TABLE `csv_import_annu_cols`";
	$bdd->exec ($query);
	$query = "ALTER TABLE `csv_import_annu_lines` ADD CONSTRAINT `csv_import_annu_lines_ibfk_1` FOREIGN KEY (`id_colonne`) REFERENCES `csv_import_annu_cols` (`id_colonne`) ON DELETE CASCADE ON UPDATE CASCADE;";
	$bdd->exec ($query);
	return true;
}

//ecriture
public function write($pimport_annuaire_csv_ligne) {
	global $bdd;
	// Insertion dans la base
	$query = "INSERT INTO csv_import_annu_cols (lib_colonne, champ_equivalent)
						VALUES (	'".addslashes(trim($pimport_annuaire_csv_ligne->__getLibelle()))."',
								 	'".addslashes(trim($pimport_annuaire_csv_ligne->__getChamp_equivalent()))."') ";
	$bdd->exec ($query);
	return true;
}

//update
public function update($pId, $pValue) {
	global $bdd;
	// lecture dans la base
	$query = "UPDATE csv_import_annu_cols SET champ_equivalent = '".$pValue."' WHERE id_colonne = '" .$pId. "'"; 
	
	$bdd->exec ($query);
	return true;
}



//lecture
public function read($pId) {
	global $bdd;
	// lecture dans la base
	$query = "SELECT * FROM csv_import_annu_cols where id_colonne = '" .$pId. "'"; 
	
	$colonne_array = array();
	$colonne = new import_annuaire_csv_colonne();
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $colonne_array[] = $tmp; }
	$colonne->__setId($colonne_array[0]->id_colonne);
	$colonne->__setLibelle($colonne_array[0]->lib_colonne);
	$colonne->__setChamp_equivalent($colonne_array[0]->champ_equivalent);

	return $colonne;
}

//lecture total
public function readAll() {
	global $bdd;
	// lecture dans la base
	$query = "SELECT * FROM csv_import_annu_cols"; 
	
	$array_retour = array();
	$colonne_array = array();
	
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		$colonne = new import_annuaire_csv_colonne(); 
		$colonne->__setId($tmp->id_colonne);
		$colonne->__setLibelle($tmp->lib_colonne);
		$colonne->__setChamp_equivalent($tmp->champ_equivalent);
		$array_retour[] = $colonne;
	}
	return $array_retour;
}


}

// *******
// répartition des lignes
// *******


final class import_annuaire_csv_ligne{

	private $id;
	private $id_colonne;
	private $valeur;
	private $valeur_equivalente;
	

function __construct() {
	return true;
}

public function __getId() {
	return $this->id;
}

public function __setId($id) {
	$this->id = $id;
}

public function __getId_colonne() {
	return $this->id_colonne;
}

public function __setId_colonne($id_colonne) {
	$this->id_colonne = $id_colonne;
}

public function __getValeur() {
	return $this->valeur;
}

public function __setValeur($valeur) {
	$this->valeur = $valeur;
}

public function __getValeur_equivalente() {
	return $this->valeur_equivalente;
}

public function __setValeur_equivalente($valeur_equivalente) {
	$this->valeur_equivalente = $valeur_equivalente;
}

public function __getValeurRenseignee() {
	if(isset($this->valeur_equivalente) && $this->valeur_equivalente != "" ){
		return $this->valeur_equivalente;
	}else{
		return $this->valeur;
	}
}
//effacement table
function erase() {
	global $bdd;
	// Insertion dans la base
	$query = "TRUNCATE TABLE `csv_import_annu_lines`";
	$bdd->exec ($query);
	$bdd->commit();
	return true;
}

//ecriture
function write(import_annuaire_csv_ligne   $pimport_annuaire_csv_ligne) {
	global $bdd;
	// Insertion dans la base
	$query = "INSERT INTO csv_import_annu_lines (id_colonne, valeur, valeur_equivalente)
						VALUES (	'".trim($pimport_annuaire_csv_ligne->__getId_colonne())."',
									'".addslashes(trim($pimport_annuaire_csv_ligne->__getValeur()))."',
								 	'".addslashes(trim($pimport_annuaire_csv_ligne->__getValeur_equivalente()))."') ";
	$bdd->exec ($query);
	return true;
}

//supression de lignes
function supprimer($liste_ligne) {
	global $bdd;
	// Insertion dans la base
	$query = "DELETE FROM  csv_import_annu_lines WHERE id_ligne IN (".implode(",",$liste_ligne).")  ";
	$bdd->exec ($query);
	return true;
}

//lecture unitaire
function read($pId) {
	global $bdd;
	// lecture dans la base
	$query = "SELECT * FROM csv_import_annu_lines where id_ligne = '" .$pId. "'"; 
	
	$ligne_array = array();
	$ligne = new import_annuaire_csv_ligne();
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) { $ligne_array[] = $tmp; }
	$ligne->__setId($ligne_array[0]);
	$ligne->__setId_colonne($ligne_array[1]);
	$ligne->__setValeur($ligne_array[2]);
	$ligne->__setValeur_equivalente($ligne_array[3]);
	return $ligne;
}

//update
public function update($pId, $pValue) {
	global $bdd;
	
	$query = "UPDATE csv_import_annu_lines SET valeur_equivalente = '".trim($pValue)."' WHERE id_ligne = '" .$pId. "'"; 
	$bdd->exec ($query);
	
	return true;
}

//update par lot
public function updateParLot($pIdColonne, $pValeur, $pValeurEquivalente) {
	global $bdd;
	
	$query = "UPDATE csv_import_annu_lines SET valeur_equivalente = '".trim($pValeurEquivalente)."' WHERE id_colonne = '" .$pIdColonne. "' AND valeur = '".trim($pValeur)."'";
	$bdd->exec ($query);
	
	return true;
}


//lecture total
function readAll() {
	global $bdd;
	$query = "SELECT * FROM csv_import_annu_lines"; 
	
	$array_retour = array();
	$ligne_array = array();
	
	$resultat = $bdd->query ($query);
	while ($tmp = $resultat->fetchObject()) {
		$ligne = new import_annuaire_csv_ligne(); 
		$ligne->__setId($tmp->id_ligne);
		$ligne->__setId_colonne($tmp->id_colonne);
		$ligne->__setValeur($tmp->valeur);
		$ligne->__setValeur_equivalente($tmp->valeur_equivalente);
		$array_retour[] = $ligne;
	}
	return $array_retour;
}


//lecture total suivant un id_colonne
function readAllColonne($pIdColonne) {
	global $bdd;
	// lecture dans la base
	$query = "SELECT DISTINCT(valeur) valeur FROM csv_import_annu_lines where id_colonne = " . $pIdColonne ; 
	
	$array_retour = array();
	$resultat = $bdd->query ($query);
	
	while ($tmp = $resultat->fetchObject()) {
		$ligne = new import_annuaire_csv_ligne(); 
		$ligne->__setValeur($tmp->valeur);
		$array_retour[] = $ligne;
	}
	return $array_retour;
}
}

?>