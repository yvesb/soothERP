<?php
// *********************************************
// **  CONFIG $import_tarifs_fournisseur_csv  ** 
// *********************************************
$import_tarifs_fournisseur_csv['folder_name']	= "import_tarifs_fournisseur_csv/";
$import_tarifs_fournisseur_csv['liste_entete']	= 
			array(
				array(
					"main_lib" 		=> "Informations concernant les tarifs de vos fournisseurs : ",
					"champs" 		=> array(
						array("lib"		=>'Référence OEM',"id"=>'ref_oem',
											"corresp"=>array("ref_oem", "ref oem", "reference_oem", "reference oem"), 
											"obligatoire" => true),
						array("lib"		=>'Référence interne',"id"=>'ref_interne',
											"corresp"=>array("reference_interne", "reference interne", 
																"ref_interne", "ref interne")),
						array("lib"		=>'Référence fournisseur',"id"=>'ref_article_externe',
											"corresp"=>array("ref_article_externe", "ref article externe", "reference_article_externe", 
																"reference article externe", "ref four", "Ref four", "Ref Four", "ref_four")),
						array("lib"		=>'Libellé article (chez le fournisseur)',"id"=>'lib_article_externe',
											"corresp"=>array("lib", "lib_article_externe", "lib article externe", "libelle_article_externe", 
																"libelle article externe")),
						array("lib"		=>'Prix Unitaire d\'achat HT',"id"	=>'pa_ht',
											"corresp"=>array("pa_ht", "pa ht", "prix d'achat hors taxe", "prix d'achat ht", "prix achat ht", "Pa HT"), 
											"obligatoire" => true)
					)
				)
			);

// ********************************************************************************
// **  CLASSE REGISSANT les imports de tarifs fournisseur depuis un fichier CSV  **
// ********************************************************************************
final class import_tarifs_fournisseur_csv {
	protected $id_import_tarifs_fournisseur;	// Id auto-increment
	protected $ref_fournisseur;					// La référence du fournisseur
	protected $date_tarif;						// La date de l'import
	protected $etape;							// Etape en cours de l'import
	protected $id_colonne_ref_article_existant;	// L'identifiant de la colonne stockant la référence de l'article existant (trouvée par correspondance ou choisie par l'utilisateur)
	
	/**
	 * Constructeur
	 */
	function __construct() {
		global $bdd;
		// On va chercher en base s'il existe un enregistrement
		$query = "SELECT * 
						FROM csv_import_tarifs_fournisseur 
						LIMIT 0,1";
		$resultat = $bdd->query ($query); 
		if (!$a = $resultat->fetchObject()) { return false;}
		$this->id_import_tarifs_fournisseur = $a->id_import_tarifs_fournisseur;
		$this->ref_fournisseur = $a->ref_fournisseur;
		$this->date_tarif = $a->date_tarif;
		$this->etape = $a->etape;
		$this->id_colonne_ref_article_existant = $a->id_colonne_ref_article_existant;
		return true;
	}
	
	// Import des données
	function import($contenu) {
		global $bdd;
		
		// Gestion des éventuels problèmes
		// Si le fichier est vide
		if (!count($contenu)) {
			$GLOBALS['_ALERTES']['import_fichier_vide'] = 1;
			return false;
		}else{
			$GLOBALS['_INFOS']['nb_lignes'] = count($contenu) - 1;
		}
		
		$ligne_entetes = $contenu[0];
		$nb_col = count($ligne_entetes);
		// Si le nombre de colonnes est trop important
		if ($nb_col > 255) {
			$GLOBALS['_ALERTES']['import_fichier_trop_de_colonnes'] = 1;
			return false;
		}
		
		$count_erreur = 0;
		$count_import = 0;
		
		// On importe les colonnes
		$this->import_colonnes($ligne_entetes);
		
		// On importe les données
		$this->import_donnees($contenu, $count_erreur);
		
		$this->erase();
		// Création de l'information sur l'étape et le profil à créer pour les contacts importés
		$query = "INSERT INTO csv_import_tarifs_fournisseur (ref_fournisseur, date_tarif, etape) 
					VALUES ('".$this->ref_fournisseur."', CURDATE(), 1)";
		$bdd->exec ($query);
		
		foreach ($GLOBALS['_ALERTES']  as $alerte => $value) {
			echo $alerte." => ".$value."<br>";
		}
	
		$GLOBALS['_ALERTES'] = array();
		$GLOBALS['_INFOS']['count_import'] = $count_import;
		$GLOBALS['_INFOS']['count_erreur'] = $count_erreur;
	}
	
	/**
	 * Mise à jour de l'étape de l'import
	 */
	public function maj_etape($etape) {
		global $bdd;
		// MAJ dans la base
		$query = "UPDATE csv_import_tarifs_fournisseur SET etape = '".$etape."'";
		$bdd->exec ($query);
		return true;
	}
	
	/**
	 * Import des données
	 */
	function create($liste_ligne = array()) {
		global $bdd;
		
		$count_total = 0;
		$count_import = 0;
		$count_erreur = 0;
		
		if (count($liste_ligne)) {
			$csv_cols = new import_tarifs_fournisseur_csv_colonne();
			$csv_donnees = new import_tarifs_fournisseur_csv_donnee();
			$colonnes = $csv_cols->readAll();
			$colonnes_valides = array();
			
			foreach ($colonnes as $col){
				if( trim($col->getChamp_equivalent()) != ""){
					$colonnes_valides[$col->getId_colonne()] = $col->getChamp_equivalent();
				}
			}
			
			if (isset($GLOBALS['_INFOS']['count_import'])) {
				$count_import = $GLOBALS['_INFOS']['count_import'];
			}
			foreach ($liste_ligne as $l) {
				$ligne = array();
				foreach ($colonnes_valides as $id_col => $col) {
					$donnee = $csv_donnees->readData($l, $id_col);
					$ligne[$col] = $donnee->getValeur();
				}
				
				// On met à jour l'enregistrement de la table articles_ref_fournisseur
				if(isset($ligne["ref_article_existant"]) && $ligne["ref_article_existant"] != ""){
					$article = new article($ligne["ref_article_existant"]);
					if($article->add_ref_article_externe($this->ref_fournisseur, isset($ligne["ref_article_externe"])?$ligne["ref_article_externe"]:"", 
											$ligne["lib_article_externe"], $ligne["pa_ht"], date('Y-m-d'))){
						$count_import++;
					}elseif($article->mod_ref_article_externe ($this->ref_fournisseur, $this->ref_fournisseur, isset($ligne["ref_article_externe"])?$ligne["ref_article_externe"]:"", 
																isset($ligne["ref_article_externe"])?$ligne["ref_article_externe"]:"", $ligne["lib_article_externe"], $ligne["pa_ht"], date('Y-m-d'))){
							$count_import++;
					}else{
						$count_erreur++;
					}
				}else{
					// On ne fait rien car on n'a pas retrouvé l'article correspondant dans notre catalogue
					echo "On fait rien : pas de ref_article_existant renseignée <br />";
				}
			}
			// On supprime les lignes que l'on a importées
			$this->delete_lines($liste_ligne);
		}
		
		$GLOBALS['_INFOS']['count_import'] = $count_import;
		$GLOBALS['_INFOS']['count_erreur'] = $count_erreur;
	}
	 
	function getId_import_tarifs_fournisseur () {
		return $this->id_import_tarifs_fournisseur;
	}
	 
	function getEtape () {
		return $this->etape;
	}
	
	function getRef_fournisseur(){
		return $this->ref_fournisseur;
	}
	
	function getDate_tarif(){
		return $this->date_tarif;
	}
	
	function getId_colonne_ref_article_existant(){
		return $this->id_colonne_ref_article_existant;
	}
	
	function setId_colonne_ref_article_existant($new_id_colonne_ref_article_existant){
		$this->id_colonne_ref_article_existant = $new_id_colonne_ref_article_existant;
		global $bdd;
		// MAJ dans la base
		$query = "UPDATE csv_import_tarifs_fournisseur SET id_colonne_ref_article_existant = '" . $new_id_colonne_ref_article_existant . "';";
		$bdd->exec($query);
		return true;
	}
	
	function setRef_fournisseur($ref_fournisseur){
		$this->ref_fournisseur = $ref_fournisseur;
		global $bdd;
		// MAJ dans la base
		$query = "UPDATE csv_import_tarifs_fournisseur SET ref_fournisseur = '".$ref_fournisseur."'";
		$bdd->exec ($query);
		return true;
	}
	
	/**
	 * Méthode d'import des colonnes
	 * @param La ligne d'entetes du fichier CSV
	 */
	public function import_colonnes($ligne_entetes){
		// Création de l'objet colonne
		$colonne = new import_tarifs_fournisseur_csv_colonne();
		// On vide la table
		$colonne->erase();
		
		// On créé les différentes colonnes présentes dans le fichier
		for($i=0; $i < count($ligne_entetes); $i++) {
			$colonne = new import_tarifs_fournisseur_csv_colonne();
			$colonne->setId_colonne($i+1);
			$colonne->setLibelle($ligne_entetes[$i]);
			// Ecriture en base
			$colonne->write();
		}
	}
	
	public function import_donnees($contenu, &$count_erreur){
		// Création de l'objet donnee
		$donnee = new import_tarifs_fournisseur_csv_donnee();
		// On vide la table
		$donnee->erase();
		
		$ligne_entetes = $contenu[0];
		$nb_col = count($ligne_entetes);
		// On créé les différentes lignes présentes dans le fichier
		for($i=1; $i < count($contenu); $i++) {
			$tmp_line =  $contenu[$i];
			// On vérifie qu'il n'y a pas plus de colonnes que dans la ligne d'entêtes
			if (count($tmp_line) > $nb_col) {
				$count_erreur++;
			}else{
				for($j=0; $j < count($tmp_line); $j++) {
					$donnee = new import_tarifs_fournisseur_csv_donnee();
					if (isset($tmp_line[$j])) {
						$donnee->setValeur($tmp_line[$j]);
					} else {
						$donnee->setValeur("");
					}
					$donnee->setId_ligne($i);
					$donnee->setId_colonne($j+1);
					// Ecriture en base de la donnée
					$donnee->write();	
				}
			}
		}
	}
	
	/**
	 * Fonction permettant de vider la table 'csv_import_tarifs_fournisseur'
	 */
	function erase(){
		global $bdd;
		$query = "TRUNCATE table csv_import_tarifs_fournisseur;";
		$bdd->exec($query);
		$bdd->commit();
	}
	
	/**
	 * Fonction permettant de supprimer des lignes de l'import
	 * @param liste_lignes : La liste des identifiants des lignes à supprimer
	 */
	function delete_lines($liste_lignes){
		$csv_donnees = new import_tarifs_fournisseur_csv_donnee();
		$csv_donnees->delete_lines($liste_lignes);
	}
	
	/**
	 * Fonction permettant de supprimer une colonne et les données associées
	 * @param id_col : L'identifiant de la colonne à supprimer
	 */
	public function deleteColumn($id_col){
		$col = new import_tarifs_fournisseur_csv_colonne();
		$donnee = new import_tarifs_fournisseur_csv_donnee();
		$col->delete($id_col);
		$donnee->deleteDataForColumn($id_col);
		return true;
	}
	
	/**
	 * Fonction permettant de récupérer les données à importer sous la forme d'un tableau
	 */
	public function recupererDonneesAImporter(){
		global $bdd;
		$array_retour = array();
		$query = "SELECT champ_equivalent, id_colonne FROM csv_import_tarifs_fournisseur_cols WHERE champ_equivalent <> '';";
		$resultat = $bdd->query ($query);
		while ($tmp = $resultat->fetchObject()) {
			$query2 = "SELECT valeur, id_ligne FROM csv_import_tarifs_fournisseur_donnees WHERE id_colonne = " . $tmp->id_colonne ; 
			$resultat2 = $bdd->query ($query2);
			while ($tmp2 = $resultat2->fetchObject()) {
				$array_retour[$tmp2->id_ligne][$tmp->champ_equivalent] = $tmp2->valeur;
			}
			unset ($query2, $resultat2, $tmp2);
		}
		unset($resultat, $query, $tmp);
		return $array_retour;
	}
	
	/**
	 * Fonction permettant de supprimer les colonnes et données qui ne seront pas importées
	 */
	public function supprimerDonneesNonImportees(){
		global $bdd;
		$query = "SELECT id_colonne FROM csv_import_tarifs_fournisseur_cols WHERE champ_equivalent = '';";
		$resultat = $bdd->query($query);
		while ($tmp = $resultat->fetchObject()) {
			$query2 = "DELETE FROM csv_import_tarifs_fournisseur_donnees WHERE id_colonne = '" . $tmp->id_colonne . "';";
			$bdd->exec($query2);
			$query2 = "DELETE FROM csv_import_tarifs_fournisseur_cols WHERE id_colonne = '" . $tmp->id_colonne . "';";
			$bdd->exec($query2);
		}
		unset($query, $resultat, $tmp, $query2);
	}
	
	
	public function save_import_params(){
		global $bdd;
		$import = new fournisseurs_import_tarifs($this->ref_fournisseur);
		$colonne = new import_tarifs_fournisseur_csv_colonne();
		$cols = $colonne->readAll();
		foreach($cols as $col){
			switch($col->getChamp_equivalent()){
				case 'ref_oem':
					$import->setId_ref_oem($col->getId_colonne());
					break;
				case 'ref_interne':
					$import->setId_ref_interne($col->getId_colonne());
					break;
				case 'ref_article_externe':
					$import->setId_ref_fournisseur($col->getId_colonne());
					break;
				case 'lib_article_externe':
					$import->setId_lib_fournisseur($col->getId_colonne());
					break;
				case 'pa_ht':
					$import->setId_pua_ht($col->getId_colonne());
					break;
				default:
					break;
			}
		}
		$import->save();
		return true;
		
	}
}


// ********************************
// **  Répartition des colonnes  **
// ********************************
final class import_tarifs_fournisseur_csv_colonne{
	private $id_colonne;
	private $libelle;
	private $champ_equivalent;
	
	function __construct() {
		return true;
	}
	
	/**
	 * @return unknown_type
	 */
	function getId_colonne() {
		return $this->id_colonne;
	}
	
	/**
	 * @param $id
	 * @return unknown_type
	 */
	function setId_colonne($id_colonne) {
		$this->id_colonne = $id_colonne;
	}
	
	/**
	 * @return unknown_type
	 */
	function getLibelle() {
		return $this->libelle;
	}
	
	/**
	 * @param $libelle
	 */
	function setLibelle($libelle) {
		$this->libelle = $libelle;
	}
	
	/**
	 * @return unknown_type
	 */
	function getChamp_equivalent() {
		return $this->champ_equivalent;
	}
	
	/**
	 * @param $champ_equivalent
	 */
	function setChamp_equivalent($champ_equivalent) {
		$this->champ_equivalent = $champ_equivalent;
	}
	
	/**
	 * Ecriture de la colonne dans la base
	 */
	function write() {
		global $bdd;
		// Insertion dans la base
		$query = "INSERT INTO csv_import_tarifs_fournisseur_cols (id_colonne, lib_colonne, champ_equivalent)
							VALUES (	'" . $this->id_colonne . "', 
										'".addslashes(trim($this->libelle))."',
									 	'".addslashes(trim($this->champ_equivalent))."') ";
		$bdd->exec ($query);
		$this->id_colonne = $bdd->lastInsertId();
		return true;
	}
	
	/**
	 * Mise à jour de la table
	 * @param id_colonne : L'identifiant de la colonne à modifier
	 * @param value : Le libellé du champ correspondant
	 */
	function update($id_colonne, $value) {
		global $bdd;
		// MAJ dans la base
		$query = "UPDATE csv_import_tarifs_fournisseur_cols SET champ_equivalent = '".$value."' WHERE id_colonne = '" .$id_colonne. "'";
		$bdd->exec ($query);
		return true;
	}

	/**
	 * Lecture dans la base d'une colonne
	 * @param id_colonne : L'identifiant de la colonne à lire
	 */
	function read($id_colonne) {
		global $bdd;
		// Lecture dans la base
		$query = "SELECT * FROM csv_import_tarifs_fournisseur_cols where id_colonne = '" .$id_colonne. "'"; 
		$colonne = new import_tarifs_fournisseur_csv_colonne();
		$resultat = $bdd->query ($query);
		$res = $resultat->fetchObject();
		$colonne->setId_colonne($res->id_colonne);
		$colonne->setLibelle($res->lib_colonne);
		$colonne->setChamp_equivalent($res->champ_equivalent);
		return $colonne;
	}
	
	/**
	 * Lecture de toutes les colonnes en base de données
	 * @return Un tableau contenant toutes les colonnes
	 */
	function readAll() {
		global $bdd;
		$array_retour = array();
		$colonne_array = array();
		// Lecture dans la base
		$query = "SELECT * FROM csv_import_tarifs_fournisseur_cols";
		$resultat = $bdd->query ($query);
		while ($tmp = $resultat->fetchObject()) {
			$colonne = new import_tarifs_fournisseur_csv_colonne(); 
			$colonne->setId_colonne($tmp->id_colonne);
			$colonne->setLibelle($tmp->lib_colonne);
			$colonne->setChamp_equivalent($tmp->champ_equivalent);
			$array_retour[] = $colonne;
		}
		return $array_retour;
	}

	/**
	 * Fonction permettant de vider la table 'csv_import_tarifs_fournisseur_cols'
	 */
	function erase() {
		global $bdd;
		// Insertion dans la base
		$query = "TRUNCATE TABLE `csv_import_tarifs_fournisseur_cols`";
		$bdd->exec ($query);
		return true;
	}

	/**
	 * Fonction permettant de supprimer une colonne
	 * @param id_col : 
	 */
	function delete($id_col){
		global $bdd;
		$query = "DELETE FROM csv_import_tarifs_fournisseur_cols WHERE id_colonne = '" . $id_col . "';";
		$bdd->exec($query);
		return true;
	}
}

// *******************************
// **  Répartition des données  **
// *******************************
final class import_tarifs_fournisseur_csv_donnee{
	private $id;
	private $id_ligne;
	private $id_colonne;
	private $valeur;
	
	function __construct() {
		return true;
	}
	
	function getId() {
		return $this->id;
	}
	
	function setId($id) {
		$this->id = $id;
	}
	
	function getId_ligne() {
		return $this->id_ligne;
	}
	
	function setId_ligne($id_ligne) {
		$this->id_ligne = $id_ligne;
	}
	
	function getId_colonne() {
		return $this->id_colonne;
	}
	
	function setId_colonne($id_colonne) {
		$this->id_colonne = $id_colonne;
	}
	
	function getValeur() {
		return $this->valeur;
	}
	
	function setValeur($valeur) {
		$this->valeur = $valeur;
	}
	
	/**
	 * Vidage de la table
	 */
	function erase() {
		global $bdd;
		$query = "TRUNCATE TABLE `csv_import_tarifs_fournisseur_donnees`";
		$bdd->exec ($query);
		$bdd->commit();
		return true;
	}
	
	/**
	 * Ecriture en base de la donnée
	 */
	function write() {
		global $bdd;
		// Insertion dans la base
		$query = "INSERT INTO csv_import_tarifs_fournisseur_donnees (id_ligne, id_colonne, valeur)
							VALUES (	'".trim($this->id_ligne)."',
										'".trim($this->id_colonne)."',
										'".addslashes(trim($this->valeur))."');";
		$bdd->exec ($query);
		return true;
	}
	
	/**
	 * Suppression de lignes
	 * @param liste_lignes : Les identifiants des lignes à supprimer
	 */
	function delete_lines($liste_lignes) {
		global $bdd;
		// Insertion dans la base
		$query = "DELETE FROM  csv_import_tarifs_fournisseur_donnees WHERE id_ligne IN (".implode(",",$liste_lignes).")  ";
		$bdd->exec ($query);
		echo "On supprime la ligne : ";
		print_r($liste_lignes);
		echo "<br />";
		return true;
	}
	
	/**
	 * Lecture d'une donnée depuis la base
	 * @param id : L'identifiant de la donnée à lire
	 */
	function read($id) {
		global $bdd;
		// Lecture dans la base
		$query = "SELECT * FROM csv_import_tarifs_fournisseur_donnees where id = '" .$id. "' LIMIT 0,1;";
		$donnee = new import_tarifs_fournisseur_csv_donnee();
		$resultat = $bdd->query ($query);
		if ($tmp = $resultat->fetchObject()) {
			$donnee->setId($tmp->id);
			$donnee->setId_ligne($tmp->id_ligne);
			$donnee->setId_colonne($tmp->id_colonne);
			$donnee->setValeur($tmp->valeur);
		}
		return $donnee;
	}
	
	/**
	 * Lecture d'une donnée depuis la base
	 * @param id_ligne : L'identifiant de la ligne de la donnée à lire
	 * @param id_col : L'identifiant de la colonne de la donnée à lire
	 */
	function readLigneColonne() {
		global $bdd;
		// Lecture dans la base
		$query = "SELECT * 
					FROM csv_import_tarifs_fournisseur_donnees 
					WHERE id_ligne = '" .$this->id_ligne. "' AND id_colonne = '" . $this->id_colonne . "' 
					LIMIT 0,1;";
		$resultat = $bdd->query ($query);
		if ($tmp = $resultat->fetchObject()) {
			$this->id = $tmp->id;
			$this->id_ligne = $tmp->id_ligne;
			$this->id_colonne = $tmp->id_colonne;
			$this->valeur = $tmp->valeur;
		}
		return $this;
	}
	
	/**
	 * Mise à jour de la valeur
	 * @param id : L'identifiant de la donnée
	 * @param value : La nouvelle valeur de la donnée 
	 */
	public function update($id, $value) {
		global $bdd;
		$query = "UPDATE csv_import_tarifs_fournisseur_donnees SET valeur = '".trim($value)."' WHERE id = '" .$id. "'"; 
		$bdd->exec ($query);
		return true;
	}
	
	/**
	 * Lecture de toutes les lignes en base de données
	 */
	function readAll() {
		global $bdd;
		$query = "SELECT * FROM csv_import_tarifs_fournisseur_donnees"; 
		$array_retour = array();
		$resultat = $bdd->query ($query);
		while ($tmp = $resultat->fetchObject()) {
			$ligne = new import_tarifs_fournisseur_csv_donnee();
			$ligne->setId($tmp->id); 
			$ligne->setId_ligne($tmp->id_ligne);
			$ligne->setId_colonne($tmp->id_colonne);
			$ligne->setValeur($tmp->valeur);
			$array_retour[] = $ligne;
		}
		return $array_retour;
	}
	
	/**
	 * Fonction permettant de lire une donnée en fonction de la ligne et de la colonne
	 * @param id_ligne : L'identifiant de la ligne de la données à lire
	 * @param id_colonne : L'identifiant de la colonne de la données à lire
	 */
	function readData($id_ligne, $id_colonne){
		global $bdd;
		// Lecture dans la base
		$query = "SELECT * from csv_import_tarifs_fournisseur_donnees 
					WHERE id_colonne = '" . $id_colonne . "' 
					AND id_ligne = '" . $id_ligne . "'
					LIMIT 0,1;";
		$resultat = $bdd->query($query);
		$donnee = new import_tarifs_fournisseur_csv_donnee();
		if($tmp = $resultat->fetchObject()){
			$donnee->setId($tmp->id);
			$donnee->setId_ligne($tmp->id_ligne);
			$donnee->setId_colonne($tmp->id_colonne);
			$donnee->setValeur($tmp->valeur);
		}
		return $donnee;
	}

	/**
	 * Fonction permettant de supprimer toutes les données correspondants à une colonne
	 * @param id_col : L'identifiant de la colonne pour laquelle il faut supprimer toutes les données
	 */
	function deleteDataForColumn($id_col){
		global $bdd;
		$query = "DELETE FROM csv_import_tarifs_fournisseur_donnees WHERE id_colonne = '" . $id_col . "';";
		$bdd->exec($query);
		return true;
	}
}

?>