<?php

class document_echeance{

	public static $nom_table = "doc_echeanciers";	// Le nom de la table dans la base de données
	public static $types_reglements = array (1 => 'Acompte', 2 => 'Arrhes', 3 => 'Echeance', 4 => 'Solde');

	private $id_doc_echeance;
	private $ref_doc;
	private $montant;
	private $pourcentage;
	private $id_mode_reglement;
	private $date;
	private $jour;
	private $type_reglement;

	//******************************************

	public function __construct($id_echeance){

		global $bdd;
		if(is_int(intval($id_echeance))){

			$query = "SELECT *
			FROM ".self::$nom_table."
			WHERE id_doc_echeance = ".$id_echeance."  ORDER BY id_doc_echeance;
			";

			if($resultat = $bdd->query($query)){
				if($echeance = $resultat->fetchObject()){
					$this->id_doc_echeance = $echeance->id_doc_echeance;
					$this->ref_doc = $echeance->ref_doc;
					$this->montant = $echeance->montant;
					$this->pourcentage = $echeance->pourcentage;
					$this->id_mode_reglement = $echeance->id_mode_reglement;
					$this->date = $echeance->date;
					$this->jour = $echeance->jour;
					$this->type_reglement = array_search($echeance->type_reglement,self::$types_reglements);
				}
			}
		}
	}

	//******************************************

	public static function _create($ref_doc, $id_mode_reglement = "NULL", $type_reglement = 1){

		global $bdd;

		//Verifs des parametres
		if( !isset($ref_doc) ) { return false; }
		if(!is_string($ref_doc) || $ref_doc=="" || !(is_int(intval($id_mode_reglement)) || is_null($id_mode_reglement)) || !is_int(intval($type_reglement)) || !array_key_exists($type_reglement, self::$types_reglements)) { return false; }

		$query = "INSERT INTO ".self::$nom_table."
							(ref_doc, id_mode_reglement, type_reglement)
							VALUES ('".$ref_doc."', ".num_or_null($id_mode_reglement).", '".self::$types_reglements[$type_reglement]."');";
		if(!$bdd->query($query)){
			return false;
		}
		$id = $bdd->lastInsertId();
		return new document_echeance($id);

	}

	//******************************************

	public function save(){

		global $bdd;

		$query = "UPDATE ".self::$nom_table."
							SET ref_doc = '".$this->ref_doc."',
									montant = ".num_or_null($this->montant).",
									pourcentage = ".num_or_null($this->pourcentage).",
									id_mode_reglement = ".num_or_null($this->id_mode_reglement).",
									date = ".text_or_null($this->date).",
									jour = ".text_or_null(strval($this->jour)).",
									type_reglement = '".self::$types_reglements[$this->type_reglement]."'
							WHERE id_doc_echeance = ".$this->id_doc_echeance.";";

		if($bdd->query($query)){
			return true;
		}else{
			return false;
		}

	}

	//******************************************

	public function is_fdm(){

		if(strpos($this->jour,"FDM") === false){
			return false;
		}else{
			return true;
		}
	}

	//******************************************

	public function is_acompte(){

		if($this->type_reglement == 1 OR $this->type_reglement == 2){
			return true;
		}else{
			return false;
		}
	}

	//******************************************

	public function is_solde(){

		if( $this->type_reglement == 4 ){
			return true;
		}else{
			return false;
		}
	}

	//******************************************

	public function is_echue(){

		if( $this->date != "" && $this->date <= strftime("%Y-%m-%d",time()) ){
			return true;
		}else{
			return false;
		}
	}


	//******************************************

	public function is_echeance(){

		if( array_search($this->type_reglement,self::$types_reglements) == 3 ){
			return true;
		}else{
			return false;
		}
	}


	//*************************************
	// GETTERS
	//*************************************

	//*****************************************************
	// getter
	// result : int
	function get_Id_doc_echeance(){
		return $this->id_doc_echeance;
	}

	//*****************************************************
	// getter
	// result : varchar
	function get_Ref_doc(){
		return $this->ref_doc;
	}

	//*****************************************************
	// getter
	// result : float
	function get_Montant(){
		return $this->montant;
	}

	//*****************************************************
	// getter
	// result : float
	function get_Pourcentage(){
		return $this->pourcentage;
	}

	//*****************************************************
	// getter
	// result : int
	function get_Mode_reglement(){
		return $this->id_mode_reglement;
	}

	//*****************************************************
	// getter
	// result : date
	function get_Date(){
		return $this->date;
	}

	//*****************************************************
	// getter
	// result : varchar
	function get_Jour(){
		return $this->jour;
	}

	//*****************************************************
	// getter
	// result : int
	function get_Nbjours(){
		if (is_null($this->jour)) { return null; }
		if (strpos($this->jour,"FDM") === false){
			return intval($this->jour);
		}else{
			return intval( substr($this->jour, 0, strlen($this->jour)-3) );
		}
	}

	//*****************************************************
	// getter
	// result : string
	function get_Type_reglement(){
		return self::$types_reglements[$this->type_reglement];
	}

	//*****************************************************
	// getter
	// result : int
	function get_Type_reglement_int(){
		return $this->type_reglement;
	}

        //*****************************************************
	// static
        // param : int
	// result : str
	public static function _get_Type_reglement_lib($type_reglement){
            if ( array_key_exists($type_reglement, self::$types_reglements)){
                return self::$types_reglements[$type_reglement];
            }
            return false;
	}

	//*************************************
	// SETTERS
	//*************************************

	//*****************************************************
	// setter
	// @param : int

	function set_Id_doc_echeance($id_echeance){

		if(is_int($id_echeance)){
			$this->id_doc_echeance = $id_echeance;
			return true;
		}else{
			return false;
		}

	}

	//*****************************************************
	// setter
	// @param : varchar
	function set_Ref_doc($ref_doc){

		if(is_string($ref_doc)){
			$this->ref_doc = $ref_doc;
			return true;
		}else{
			return false;
		}

	}

	//*****************************************************
	// setter
	// @param : float
	function set_Montant($montant){

		if(is_numeric($montant)){
			$this->montant = $montant;
			return true;
		}else{
			return false;
		}
	}

	//*****************************************************
	// setter
	// @param : float
	function set_Pourcentage($pourcentage){

		if(is_numeric($pourcentage)){
			$this->pourcentage = $pourcentage;
			return true;
		}else{
			return false;
		}

	}

	//*****************************************************
	// setter
	// @param : int
	function set_Mode_reglement($id_mode_reglement){

		if(is_int(intval($id_mode_reglement))){
			$this->id_mode_reglement = $id_mode_reglement;
			return true;
		}else{
			return false;
		}

	}

	//*****************************************************
	// setter
	// @param : date
	function set_Date($date){

		if(is_string($date)){
			$this->date = $date;
			return true;
		}else{
			return false;
		}

	}

	//*****************************************************
	// setter
	// @param : jour
	// @param : boolean (Fin de mois)
	function set_Jour($jour, $fdm = false){

		if(is_int($jour)){
			$this->jour = strval($jour);
			if($fdm){
				$this->jour .= "FDM";
				return true;
			}
		}else{
			return false;
		}

	}

	//*****************************************************
	// setter
	// @param : int / string
	function set_Type_reglement($type_reglement){

		if(is_int($type_reglement)){
			 $this->type_reglement = $type_reglement;
			 return true;
		}elseif(is_string($type_reglement)){
				$type_reglement_id = array_search($type_reglement, self::$types_reglements);
				if($type_reglement_id === false){
					return false;
				}else{
					$this->type_reglement = $type_reglement_id;
					return true;
				}
			}else{
			return false;
		}
	}

}

//************************************************************************************************************************************

class document_echeancier{

	private $ref_doc;
	private $echeances = array();
	private $echeances_loaded = false;
	private $papa;
	private $solde_exist = false;
	private $acompte_exist = false;

	public function __construct($ref_doc, &$papa = null){
		if (is_string($ref_doc)){
			$this->ref_doc = $ref_doc;
			$this->load_echeances();
			if(!is_null($papa) && is_subclass_of($papa,"document")){
				$this->papa = $papa;
			}
		}
	}

	public function create_from_ref_contact(){

		global $CLIENT_ID_PROFIL;

		if(!$this->papa_est_la()) { return false; }
		$contact = $this->papa->getContact();
		if ($contact != ""){
			$profils 	= $contact->getProfils();
			if(isset($profils[$CLIENT_ID_PROFIL]) ) {
				$client_profil = $profils[$CLIENT_ID_PROFIL];
				if(!is_null($client_profil->getPrepaiement_ratio()) && !is_null($client_profil->getPrepaiement_type()) && $client_profil->getPrepaiement_ratio()>0 ){
					$this->maj_acompte($client_profil->getPrepaiement_ratio(), $client_profil->getPrepaiement_type());
				}
				if(!is_null($client_profil->getDelai_reglement())){
					$this->maj_solde_delai_reglement($client_profil->getDelai_reglement());
				}
                                $this->set_Mode_Reglement($client_profil->getId_reglement_mode_favori());
			}
		}

	}

	//******************************************


        function set_Mode_Reglement($id_reglement_mode)
            {
                foreach ($this->echeances as $echeance)
                    {
                        $echeance->set_Mode_Reglement($id_reglement_mode);
                        $echeance->save();
                    }
            }

	function maj_acompte($prepaiement_ratio, $prepaiement_type){
		if (!is_null($prepaiement_ratio) && !is_null($prepaiement_type) && $prepaiement_ratio>0 ){
			if (!$this->echeances_loaded) { $this->load_echeances(); }
			if ($this->acompte_exist){
				$this->echeances[$this->acompte_exist]->set_Pourcentage($prepaiement_ratio);
				$this->echeances[$this->acompte_exist]->set_Type_reglement($prepaiement_type);
				$this->echeances[$this->acompte_exist]->save();
			}else{
				$acompte = document_echeance::_create($this->ref_doc, null, array_search($prepaiement_type, document_echeance::$types_reglements ));
				$acompte->set_Pourcentage($prepaiement_ratio);
				$acompte->set_Jour(0,false);
				$acompte->save();
				$this->echeances[$acompte->get_Id_doc_echeance()] = $acompte;
				$this->acompte_exist = $acompte->get_Id_doc_echeance();
			}
			$this->sort_echeances();
		}
	}

	//******************************************

	function maj_solde_delai_reglement($delai_reglement){

		if (!is_null($delai_reglement)){
			if (!$this->echeances_loaded) { $this->load_echeances(); }

			if (strpos($delai_reglement,"FDM") === false){
				$nbjours = intval( $delai_reglement );
				$fdm = false;
			}else{
				$nbjours = intval( substr($delai_reglement, 0, strlen($delai_reglement)-3) );
				$fdm = true;
			}

			if ($this->solde_exist){
				$this->echeances[$this->solde_exist]->set_Jour($nbjours,$fdm);
				$this->echeances[$this->solde_exist]->save();
			}else{
				$solde = document_echeance::_create($this->ref_doc, null, 4);
				$solde->set_Jour($nbjours,$fdm);
				$solde->save();
				$this->echeances[$solde->get_Id_doc_echeance()] = $solde;
				$this->solde_exist = $solde->get_Id_doc_echeance();
			}
		}
	}

	//******************************************

	private function papa_est_la(){

		if(is_object($this->papa)){
			if(is_subclass_of($this->papa,"document")){
				return true;
			}
		}
		return false;
	}

	//******************************************

	public function exist(){

		if (!$this->echeances_loaded) { $this->load_echeances(); }
		if ($this->echeances_loaded){
			if(count($this->echeances) > 0){
				return true;
			}
		}
	return false;
	}

	//******************************************

	function get_Nb_echeances_restantes(){

		if(!$this->papa_est_la()){ return false; }

		$echeances = $this->get_echeances_etat();
		//$date_du_jour = strftime("%Y-%m-%d",time());
		$nb_echeances = 0;
		foreach ($echeances as $echeance){
			if( $echeance->etat == 0 || $echeance->etat == 3 ){
				$nb_echeances++;
			}
		}
	return $nb_echeances;
	}

	//******************************************


	private static function _cmpAscDate($m, $n) {

		if( $n->get_Type_reglement_int() == 1 || $n->get_Type_reglement_int() == 2){
			if( $m->get_Type_reglement_int() == $n->get_Type_reglement_int() ){
				return 0;
			}else{
				return 1;
			}
		}
		if( $n->get_Type_reglement_int() == 4 ){
			if( $m->get_Type_reglement_int() == $n->get_Type_reglement_int() ){
				return 0;
			}else{
				return -1;
			}
		}
		/*if( $n->get_Type_reglement_int() == 3 ){
			if( $m->get_Type_reglement_int() == $n->get_Type_reglement_int() ){
				if ($m->get_Date() == $n->get_Date()) {
				return 0;
                                }
                                return ($m->get_Date() < $n->get_Date()) ? -1 : 1;
			}else{
				return ($m->get_Type_reglement_int() < $n->get_Type_reglement_int()) ? -1 : 1;
			}
		}*/
                if( $n->get_Type_reglement_int() == 3 ){
			if( $m->get_Type_reglement_int() == $n->get_Type_reglement_int() ){
				if ($m->get_Jour() == $n->get_Jour()) {
				return 0;
                                }
                                return ($m->get_Jour() < $n->get_Jour()) ? -1 : 1;
			}else{
				return ($m->get_Type_reglement_int() < $n->get_Type_reglement_int()) ? -1 : 1;
			}
                }
		if ($m->get_Date() == $n->get_Date()) {
			return 0;
		}
		return ($m->get_Date() < $n->get_Date()) ? -1 : 1;

	}

	//******************************************

	public function add_pourcent_jours($id_mode_reglement, $type_reglement, $pourcentage, $nb_jours, $findemois = false){

		if(!isset($pourcentage) || !isset($nb_jours) || !isset($id_mode_reglement) || !isset($type_reglement)){
			return false;
		}

		if ($echeance = document_echeance::_create($this->ref_doc, $id_mode_reglement, $type_reglement)){
			$echeance->set_Pourcentage($pourcentage);
			$echeance->set_Jour($nb_jours, $findemois);
			if ($echeance->save()){
				$this->echeances[$echeance->get_Id_doc_echeance()] = $echeance;
				$this->sort_echeances();
			}
		}
	}

        public function add_montant_jours($id_mode_reglement, $type_reglement, $montant, $nb_jours, $findemois = false){
            if (!isset($id_mode_reglement) || !isset($type_reglement) || !isset($montant) || !isset($nb_jours)){
                return false;
            }

            if ($echeance = document_echeance::_create($this->ref_doc, $id_mode_reglement, $type_reglement)){
                $echeance->set_Montant($montant);
                $echeance->set_Jour($nb_jours, $findemois);
                if ($echeance->save()){
                    $this->echeances[$echeance->get_Id_doc_echeance()] = $echeance;
                    $this->sort_echeances();
                }
            }
        }
	//******************************************


	public function maj_pourcent_jours($id_mode_reglement, $type_reglement, $pourcentage, $nb_jours, $findemois = false){

		if(!isset($pourcentage) || !isset($nb_jours) || !isset($id_mode_reglement) || !isset($type_reglement)){
			return false;
		}
                global $bdd;
		$query = "INSERT INTO ".document_echeance::$nom_table."
							(ref_doc, id_mode_reglement, type_reglement)
							VALUES ('".$this->ref_doc."', ".num_or_null($id_mode_reglement).", '".$type_reglement."');";
                if(!$bdd->query($query)){
			return false;
		}
		$id = $bdd->lastInsertId();
		$echeance = new document_echeance($id);

                $echeance->set_Pourcentage($pourcentage);
                $echeance->set_Jour($nb_jours, $findemois);
                if ($echeance->save()){
                        $this->echeances[$echeance->get_Id_doc_echeance()] = $echeance;
                        $this->sort_echeances();
                }
	}

	public function maj_montant_jours($id_mode_reglement, $type_reglement, $montant, $nb_jours, $findemois = false){

		if(!isset($montant) || !isset($nb_jours) || !isset($id_mode_reglement) || !isset($type_reglement)){
			return false;
		}
                global $bdd;
		$query = "INSERT INTO ".document_echeance::$nom_table."
							(ref_doc, id_mode_reglement, type_reglement)
							VALUES ('".$this->ref_doc."', ".num_or_null($id_mode_reglement).", '".$type_reglement."');";
                if(!$bdd->query($query)){
			return false;
		}
		$id = $bdd->lastInsertId();
		$echeance = new document_echeance($id);

                $echeance->set_Montant($montant);
                $echeance->set_Jour($nb_jours, $findemois);
                if ($echeance->save()){
                        $this->echeances[$echeance->get_Id_doc_echeance()] = $echeance;
                        $this->sort_echeances();
                }
	}
	//******************************************
      	public function suppr_echeancier(){
                global $bdd;
                if (isset($this->ref_doc)){
			$query = "DELETE FROM ".document_echeance::$nom_table."
								WHERE ref_doc = '".$this->ref_doc."';";
			$bdd->query($query);
                }
                $this->echeances = null;
	}

        //******************************************

	private function load_echeances(){

		global $bdd;

		if ($this->echeances_loaded) { $this->echeances = array(); $this->echeances_loaded= false; }

		$query = "SELECT id_doc_echeance FROM ".document_echeance::$nom_table."
							WHERE ref_doc = '".$this->ref_doc."' ORDER BY id_doc_echeance;";
		if($resultat = $bdd->query($query)){
			while($echeance = $resultat->fetchObject()){
				$this->echeances[$echeance->id_doc_echeance] = new document_echeance($echeance->id_doc_echeance);
				if( $this->echeances[$echeance->id_doc_echeance]->is_acompte() ){ $this->acompte_exist = $echeance->id_doc_echeance; }
				if( $this->echeances[$echeance->id_doc_echeance]->is_solde() ){ $this->solde_exist = $echeance->id_doc_echeance; }
			}
		$this->echeances_loaded = true;
		}
	}

	//******************************************

	public function sort_echeances(){

		if (!$this->echeances_loaded) { $this->load_echeances(); }
		if($this->echeances_loaded){
				$this->update_dates();
				usort($this->echeances, array('document_echeancier', '_cmpascDate'));
				$this->update_montants();
		}
	}

	//******************************************

	private function fin_du_mois($date_stamp){

	return strtotime('-1 second',strtotime('+1 month',strtotime(date('m',$date_stamp).'/01/'.date('Y',$date_stamp).' 00:00:00')));

	}

	//******************************************

	private function update_dates(){

		if(!$this->papa_est_la()){ return false; }
		if (!$this->echeances_loaded) { $this->load_echeances(); }
		if($this->echeances_loaded){
			foreach( $this->echeances as $echeance_id => $echeance ){
				$this->update_date_echeance($echeance_id);
			}
		}
	}

	//******************************************

	private function update_montants(){

		if (!$this->echeances_loaded) { $this->load_echeances(); }
		if($this->echeances_loaded){
			foreach( $this->echeances as $echeance_id => $echeance ){
				$this->update_montant_echeance($echeance_id);
			}
		}
	}

	//******************************************

	private function update_date_echeance($id_echeance){

		global $COMMANDE_CLIENT_ID_TYPE_DOC;
		global $LIVRAISON_CLIENT_ID_TYPE_DOC;

		if(!$this->papa_est_la()){ return false; }
		if (!$this->echeances_loaded) { $this->load_echeances(); }
		if (!isset($this->echeances[$id_echeance])){ return false; }

		$echeance = &$this->echeances[$id_echeance];

		//Conditions de recalcul des dates ( si acompte ou arrhes que pour les CDC / si solde que pour les FAC)
		$type_reglement = $echeance->get_Type_reglement_int();
		switch ( $type_reglement ){

			case ($type_reglement == 1 || $type_reglement == 2) :
					$nb_jours = $echeance->get_Nbjours();
					$new_date_stamp = 0;
					$date_commande = $this->get_Date_commande();
					if (!is_null($nb_jours) && ($date_commande) ){
						$new_date_stamp = strtotime("+ ".$nb_jours."days",strtotime($date_commande));
						if($echeance->is_fdm()){
							$new_date_stamp = $this->fin_du_mois($new_date_stamp);
						}
					}
					if($new_date_stamp != 0){
						$echeance->set_Date(strftime("%Y-%m-%d",$new_date_stamp));
						$echeance->save();
					}
				break;

			case ($type_reglement == 3 || $type_reglement == 4) :
					$nb_jours = $echeance->get_Nbjours();
					$new_date_stamp = 0;
					$date_facture = $this->get_Date_facture();
					if (!is_null($nb_jours) && ($date_facture) ){
						$new_date_stamp = strtotime("+ ".$nb_jours."days",strtotime($date_facture));
						if($echeance->is_fdm()){
							$new_date_stamp = $this->fin_du_mois($new_date_stamp);
						}
					}
					if($new_date_stamp != 0){
						$echeance->set_Date(strftime("%Y-%m-%d",$new_date_stamp));
						$echeance->save();
					}
					if($date_facture === false){
						$echeance->set_Date("");
						$echeance->save();
					}
				break;
		}
	}

	//******************************************

	private function update_montant_echeance($id_echeance){

		global $CALCUL_TARIFS_NB_DECIMALS;

		if (!$this->echeances_loaded) { $this->load_echeances(); }

		if (!isset($this->echeances[$id_echeance])){ return false; }

		$echeance = &$this->echeances[$id_echeance];
		$pourcentage = $echeance->get_Pourcentage();
		$new_montant = null;
		if ($echeance->get_Type_reglement_int() == 4){
			$new_montant = $this->get_Montant_ref() - $this->get_Montant_jusqua_moi($id_echeance);
		}
		if (!is_null($pourcentage)){
			$new_montant = $this->get_Montant_ref() * $pourcentage / 100;
		}
		if(!is_null($new_montant)){
			$echeance->set_Montant(round($new_montant,$CALCUL_TARIFS_NB_DECIMALS));
			$echeance->save();
		}
	}

	//******************************************

	public function get_echeances(){

		if (!$this->echeances_loaded) { $this->load_echeances(); }
		$this->sort_echeances();
		return $this->echeances;
	}

	//******************************************

	protected function get_Reglements_montant_todate($date){

		if ( !$this->papa_est_la() ){ return false; }

		$solde = 0;

		$reglements = $this->papa->getReglements();
		foreach($reglements as $reglement){
			if ($reglement->valide && substr($reglement->date_reglement,0,10) <= $date) {
				$solde += round($reglement->montant_on_doc,2);
			}
		}
		return $solde;
	}

	//******************************************
	public function get_echeances_etat(){

		if ( !$this->papa_est_la() ){ return false; }

		$base_echeances = $this->get_echeances();
		$reglements = $this->papa->getReglements();

		$solde = 0;
		$montant_echeances = 0;
		$result = array();

		foreach($reglements as $reglement){
			if ($reglement->valide) {
				$solde += $reglement->montant_on_doc;
			}
		}

		foreach ($base_echeances as $echeance){
			$res = new stdclass;
			$res->id_echeance = $echeance->get_Id_doc_echeance();
			$res->date = $echeance->get_Date();
			$res->jour = $echeance->get_Jour();
			$res->type_reglement = $echeance->get_Type_reglement();
			$res->mode_reglement = $echeance->get_Mode_reglement();
			$res->pourcentage = $echeance->get_Pourcentage();
			$res->montant = round($echeance->get_Montant(),2);
			if ($echeance->is_echue()){
				$montant_echeances += $res->montant;
				$solde -= $res->montant;
				if ( $solde<0 ){
                                        $res->etat = 3;
				}else{
					if ( $this->get_Reglements_montant_todate( $echeance->get_Date() ) >= $montant_echeances ){
						$res->etat = 1;
					}else{
						$res->etat = 2;
					}
				}
			}else{
				$res->etat = 0;
			}
			$result[] = $res;
		}

		return $result;

	}

	//******************************************

	public function get_Date_ref(){

		if ( !$this->papa_est_la() ){ return false; }

		return substr( $this->papa->getDate_creation(), 0, 10 );

	}

	//******************************************

	public function get_Date_livraison(){

		global $LIVRAISON_CLIENT_ID_TYPE_DOC;

		if ( !$this->papa_est_la() ){ return false; }

		$liaisons = $this->papa->getLiaisons();

			$ref_doc = self::get_ref_doc_from_type ($LIVRAISON_CLIENT_ID_TYPE_DOC, $this->papa->getID_TYPE_DOC(), $this->papa->getRef_doc());
			if ($ref_doc){
				$doc = open_doc ($ref_doc);
				return substr( $doc->getDate_creation(), 0, 10 );
			}
		return false;
	}

	//******************************************

	public function get_Date_facture(){

		global $FACTURE_CLIENT_ID_TYPE_DOC;

		if ( !$this->papa_est_la() ){ return false; }

		$liaisons = $this->papa->getLiaisons();

			$ref_doc = self::get_ref_doc_from_type ($FACTURE_CLIENT_ID_TYPE_DOC, $this->papa->getID_TYPE_DOC(), $this->papa->getRef_doc());
			if ($ref_doc){
				$doc = open_doc ($ref_doc);
				return substr( $doc->getDate_creation(), 0, 10 );
			}
		return false;
	}

	//******************************************

	public function get_Date_commande(){

		global $COMMANDE_CLIENT_ID_TYPE_DOC;

		if ( !$this->papa_est_la() ){ return false; }

		$liaisons = $this->papa->getLiaisons();

			$ref_doc = self::get_ref_doc_from_type ($COMMANDE_CLIENT_ID_TYPE_DOC, $this->papa->getID_TYPE_DOC(), $this->papa->getRef_doc());
			if ($ref_doc){
				$doc = open_doc ($ref_doc);
				return substr( $doc->getDate_creation(), 0, 10 );
			}
		return false;
	}

	//******************************************

	public static function get_ref_doc_from_type ($id_type_doc_search, $mon_id_type_doc, $ref_doc_depart, $ref_doc_init = ""){

            if ($ref_doc_init == $ref_doc_depart){
                return (false);
            }
            if ($ref_doc_init == ""){
                $ref_doc_init = $ref_doc_depart;
            }
		global $DEVIS_CLIENT_ID_TYPE_DOC, $LIVRAISON_CLIENT_ID_TYPE_DOC, $COMMANDE_CLIENT_ID_TYPE_DOC, $FACTURE_CLIENT_ID_TYPE_DOC;
		$id_type_doc_allowed = array ($DEVIS_CLIENT_ID_TYPE_DOC, $LIVRAISON_CLIENT_ID_TYPE_DOC, $COMMANDE_CLIENT_ID_TYPE_DOC, $FACTURE_CLIENT_ID_TYPE_DOC);

		if ($id_type_doc_search == $mon_id_type_doc) { return $ref_doc_depart; }
		$sens = ($mon_id_type_doc > $id_type_doc_search);
		$liaisons = document::charger_liaisons_doc($ref_doc_depart);
		foreach ($liaisons[$sens ? 'source' : 'dest'] as $doc){
			if (in_array($doc->id_type_doc, $id_type_doc_allowed)){
				$doc = get_object_vars($doc);
				if ($doc['id_type_doc'] == $id_type_doc_search ){
					return $doc[$sens ? 'ref_doc_source' : 'ref_doc_destination'] ;
				}else{
						if ($result = self::get_ref_doc_from_type ($id_type_doc_search, $doc['id_type_doc'], $doc[$sens ? 'ref_doc_source' : 'ref_doc_destination'], $ref_doc_init)){
							return $result;
						}else{
							return $ref_doc_depart;
						}
				}
			}
		}
		if ($sens) {
			return $ref_doc_depart;
		}
		return false;
	}

	//******************************************

	public function get_Montant_ref(){

		if ( !$this->papa_est_la() ){ return false; }

		return $this->papa->getMontant_ttc();

	}

	//******************************************

	public function get_Montant_jusqua_moi($id){

		if($this->echeances_loaded){
			$montant = 0;
			foreach($this->echeances as $echeance_id => $echeance){
				if( $echeance_id == $id ) { break; }
				$montant += $echeance->get_Montant();
			}
			return $montant;
		}else{
			return false;
		}
	}

	//******************************************

        public function get_Last_echeance($ref_doc = "")
        {
            global $bdd;
            if ($ref_doc == "")
                return false;
            $query = "SELECT date FROM `doc_echeanciers`
                                  WHERE type_reglement LIKE 'Solde'
                                  AND ref_doc = '".$ref_doc."';";
            $resultat = $bdd->query($query);
            if (($result = $resultat->fetchObject()) != false)
                return $result->date;
            else
                return false;
        }

        //******************************************

	public function copie_to_doc($ref_doc){

		global $bdd;

		if (isset($this->ref_doc) && $ref_doc!=""){
			$query = "DELETE FROM ".document_echeance::$nom_table."
								WHERE ref_doc = '".$ref_doc."';";
			$bdd->query($query);
			$query = "INSERT INTO ".document_echeance::$nom_table."
								(ref_doc,montant,pourcentage,id_mode_reglement,date,jour,type_reglement)
								SELECT '".$ref_doc."',montant,pourcentage,id_mode_reglement,date,jour,type_reglement
								FROM ".document_echeance::$nom_table."
								WHERE ref_doc = '".$this->ref_doc."' ORDER BY id_doc_echeance;";
			if($bdd->query($query)){
				return true;
			}
		}
		return false;
	}

}
?>
