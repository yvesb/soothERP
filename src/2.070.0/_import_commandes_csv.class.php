<?php
// *************************************************************************************************************
// CLASSE REGISSANT les import de commandes depuis un fichier CSV 
// *************************************************************************************************************

class import_commandes_csv {
	
	private $id_import;
	
	private $etape;		//etape en cours de l'import
		
	private $commandes;
	private $type_ref_art;
	private $id_categ_client;
	
	private $ligne_number;
	private $erreurs;
	
	
	public function __construct($id = 0) {
		global $bdd;
		
		//*********************************
		// INITAILISATION DES MEMBRES
		$this->etape = 0;
		$this->commandes = array();
		$this->erreur = array();
		$this->id_categ_client = 1;
		
		//création d'un import
		if($id == 0){
			$this->id_import = $this->create();
		}else{
			$this->id_import = $id;
		}
		
		return true;
	}
	
	/**
	 * @return int l'id de l'import en base de données
	 */
	private function create(){
		global $bdd;
		
		$query= "INSERT INTO csv_import_cdc 
					VALUES('', '' ,'', NOW(), 0);";
		$res = $bdd->exec($query);
		if($res==1){return $bdd->lastInsertId();}
		return 0;
	}
	
	

	/**
	 * @param unknown_type $file
	 * @return unknown_type
	 */
	public function parser_fichier($file){
		global $bdd;
		global $DEFAUT_ID_PAYS;
		
		$tab_ref_cdc = array();
		
		$fp = fopen($_FILES['fichier_csv']['tmp_name'], "r");
		if($fp){
			
			//*****************************************
			// INITIALISATION DES ID
			$this->ligne_number = 0;
			
			$query = "SELECT MAX(id_import_cdc_infos_doc) as id FROM csv_import_cdc_infos_doc";
			$stt = $bdd->query($query);
			$ref_commande_tmp = 0;
			if(is_object($stt) && $cdc = $stt->fetchObject()){
				$ref_commande_tmp = $cdc->id;
				$stt->closeCursor();
				
			}
			
			$query = "SELECT MAX(id_import_cdc_infos_lines) as id FROM csv_import_cdc_infos_lines";
			$stt = $bdd->query($query);
			$ligne_article_number = 0;
			if(is_object($stt) && $cdc_line = $stt->fetchObject()){
				$ligne_article_number = $cdc_line->id;
				$stt->closeCursor();
			}

			//********************************************
			// parcours du fichier
			
			while($ligne = fgets($fp)){
				++$this->ligne_number;

				//si commentaire
				if($ligne[0] == '#'){ continue; }
				
				$infos_ligne = explode(';',$ligne);
				switch($infos_ligne[0]){
					case 'CDC':
						++$ref_commande_tmp;
						
						//*****************************************
						//attribution des colonnes
						$ref_cdc_externe 	= $infos_ligne[1];
						$ref_client 		= $infos_ligne[2];
						$nom_client 		= $infos_ligne[3];
						
						$adr_fac_text		= $infos_ligne[4];
						$adr_fac_cp			= $infos_ligne[5];
						$adr_fac_ville		= $infos_ligne[6];
						$adr_fac_id_pays	= (is_numeric($infos_ligne[7]))? $infos_ligne[7] : $DEFAUT_ID_PAYS ;

						$adr_liv_text		= $infos_ligne[8];
						$adr_liv_cp			= $infos_ligne[9];
						$adr_liv_ville		= $infos_ligne[10];
						$adr_liv_id_pays	= (is_numeric($infos_ligne[11]))? $infos_ligne[11] : $DEFAUT_ID_PAYS ;
						
						$note 				= $infos_ligne[12];
						$date 				= $infos_ligne[13];
						
						$tab_ref_cdc[$ref_cdc_externe] = $ref_commande_tmp; 
						
						$query = "INSERT INTO csv_import_cdc_infos_doc VALUES
										('".$ref_commande_tmp."', '".$this->id_import."', '".$ref_cdc_externe."',  '".$ref_client."', '".$nom_client."',
										 '".$adr_fac_text."','".$adr_fac_cp."','".$adr_fac_ville."','".$adr_fac_id_pays."', 
										 '".$adr_liv_text."','".$adr_liv_cp."','".$adr_liv_ville."','".$adr_liv_id_pays."', '".$note."', '".$date."' );
								   ";
						$val = $bdd->exec($query);
						break;
						
					case 'ART':
						++$ligne_article_number;
					
						//*****************************************
						//attribution des colonnes
						$ref_cdc_externe 	= $infos_ligne[1];
						$ref_lmb			= $infos_ligne[2];
						$ref_interne 		= $infos_ligne[3];
						$ref_oem			= $infos_ligne[4];
						$lib				= $infos_ligne[5];
						$pu_ht 				= $infos_ligne[6];
						$qte 				= $infos_ligne[7];
						$remise				= $infos_ligne[8];
						$tva				= $infos_ligne[9];
						$desc_courte		= $infos_ligne[10];
						
						//Gestion des erreurs
						if(count($infos_ligne) != 12 ){ $this->erreurs[] = "Nombre de colonne incorrect ligne $this->ligne_number."; }
						if(is_numeric($infos_ligne[2])){ $this->erreurs[] = "La colonne PU doit être de type numerique ligne $this->ligne_number."; }
						
						if(!empty($ref_cdc_externe) && empty($tab_ref_cdc[$ref_cdc_externe])){
							$this->erreurs[] = "La commande de référence $ref_cdc_externe n'est pas défini à la ligne $this->ligne_number .";
							return false;
						}
						$id_cdc = (!empty($ref_cdc_externe))? $tab_ref_cdc[$ref_cdc_externe]  : $ref_commande_tmp;						
						
						
						$query = "INSERT INTO csv_import_cdc_infos_lines VALUES
										('".$ligne_article_number ."', '".$id_cdc."', '".$ref_lmb."', '".$ref_interne."', '".$ref_oem."', '".$lib."',
										'".$pu_ht."', '".$qte."', '".$remise."', '".$tva."', '".$desc_courte."' );
								   ";
						$val = $bdd->exec($query);
						
						break;
						
					default:
						$this->erreurs[] = "Type de ligne incorrect ligne $this->ligne_number.";
						break;
						
				}
			}
			
			
			//*****************************************
			// ETAPE SUIVANTE
			//*****************************************
			if(empty($this->erreurs)){
				$this->setEtape(1);
			}else{
				$this->delete();
			}
			
		}
				
	}
	
	public function traitement(){
		global $bdd;
		
		if($this->etape != 1 ){ 
			return false;
		}
		
		
		//******************************************************
		// Chargement des commandes
		$query = "SELECT * FROM csv_import_cdc_infos_doc
					WHERE id_import = '".$this->id_import."' ";
		$stt = $bdd->query($query);
		if(is_object($stt)){
			//parcours des commandes
			while($cdc = $stt->fetchObject()){
				
			
				//*************************************************************
				// Création du contact
				$contact = null;
				if(!empty($cdc->ref_client)){					
					$contact = new contact_client($cdc->ref_client);					
					if(!$contact->getRef_contact()){
						$contact = null;
					}
				}
				if($contact == null){
					//@TODO verifier si ok
					$infos_generales['nom'] = $cdc->nom_client;
					$infos_generales['id_civilite'] = 1;
					$infos_generales['id_categorie'] = $this->id_categ_client;
					$infos_generales['note'] = '';
					$infos_generales['siret'] = '';
					$infos_generales['tva_intra'] = '';
					
					$infos_profils['profil']['id_client_categ'] = 1; 
					$infos_profils['profil']['id_profil'] = $GLOBALS['CLIENT_ID_PROFIL'];
					$infos_profils['profil']['app_tarifs'] = "";
				
					$contact = new contact();
					$contact->create($infos_generales, $infos_profils);
				}
				

				//*************************************************************
				// Création de la commande
				$GLOBALS['_OPTIONS']['CREATE_DOC']['ref_contact'] 		= $contact->getRef_contact();
				$GLOBALS['_OPTIONS']['CREATE_DOC']['id_etat_doc'] 		= '8';
				$GLOBALS['_OPTIONS']['CREATE_DOC']['id_stock']			= $_SESSION['magasin']->getId_stock();
				$GLOBALS['_OPTIONS']['CREATE_DOC']['description'] 		= $cdc->note;
								
				$doc = create_doc(2);
				$doc->maj_date_creation($cdc->date);

				$doc->maj_text_adresse_contact($cdc->adr_fac_text);
				$doc->maj_text_code_postal_contact($cdc->adr_fac_cp);
				$doc->maj_text_ville_contact($cdc->adr_fac_ville);
				$doc->maj_text_id_pays_contact ($cdc->adr_fac_id_pays);
				
				$doc->maj_text_adresse_livraison($cdc->adr_liv_text);
				$doc->maj_text_code_postal_livraison($cdc->adr_liv_cp);
				$doc->maj_text_ville_livraison($cdc->adr_liv_ville);
				$doc->maj_text_id_pays_livraison ($cdc->adr_liv_id_pays);
				
				
				//**************************************************************
				// Création des lignes de la commande
				$query2 = "SELECT * FROM csv_import_cdc_infos_lines
							WHERE id_import_cdc_infos_doc = '".$cdc->id_import_cdc_infos_doc."' ";
				$stt2 = $bdd->query($query2);
				if(is_object($stt2)){
					while($art = $stt2->fetchObject()){
						
						
						$article = new article($art->ref_lmb);
						if(!$article->getRef_article()){
							$article = article::getArticle_by_ref_interne($art->ref_interne);
							if(is_null($article)){ return article::getArticle_by_ref_oem($art->ref_oem); }
						}
						
						if($article->getRef_article()){

							
							$infos['type_of_line'] = 'article';
							$infos['ref_article'] = $article->getRef_article();
							$infos['pu_ht'] = $art->pu_ht;
							$infos['qte'] = $art->qte;
							$infos['remise'] = $art->remise;
							$infos['tva'] = $art->tva;
							$infos['desc_courte'] = $art->desc_courte;
							
							$doc->add_line($infos);
						
						}else{
							$this->erreurs[] = "l'article $art->ref_lmb / $art->ref_interne / $art->ref_oem / $art->lib n'a pas été trouvé";
							//@TODO Création de l'article ?
						}
					}
				}
			}// end while
			
			//*****************************************
			// ETAPE SUIVANTE
			//*****************************************
			
			if(empty($this->erreurs)){
				$this->setEtape(2);
				
			}
			$this->delete();
		}
		
	}

	private function delete(){
		global $bdd;
		$query = " DELETE FROM csv_import_cdc
							WHERE id_import_cdc = '".$this->id_import."' ";
		$bdd->exec($query);
	}
	
	//***********************************************************************************************
	//	 SETTERS
	//***********************************************************************************************
	
	/*public function setType_ref_article($type_ref_article){
		global $bdd;
		
		if($type_ref_article == 'interne' || $type_ref_article == 'oem' || $type_ref_article == 'lmb'){
			$this->type_ref_art = $type_ref_article;
			$query = "UPDATE csv_import_cdc SET
						type_ref_article = '".$type_ref_article."'
						WHERE id_import_cdc = '".$this->id_import."' ;";
			$bdd->exec($query);
		}else{
			$this->erreurs[] = 'Type de référence article incorrect.';
		}
	}
	
	public function setId_categ_client($id_categ_client){
		global $bdd;
		
		if(!is_numeric($id_categ_client)){ $this->erreurs[] = 'Identifiant de catégorie client incorrect.';	}
		
		$this->id_categ_client = $id_categ_client;
		$query = "UPDATE csv_import_cdc SET
					id_categ_client = '".$id_categ_client."'
					WHERE id_import_cdc = '".$this->id_import."' ;";
		$bdd->exec($query);
		
	}*/
	
	public function setEtape($id_etape){
		global $bdd;
		
		$this->etape = $id_etape;
		$query = "UPDATE csv_import_cdc SET
						etape = '".$this->etape."'
						WHERE id_import_cdc = '".$this->id_import."' ;";
		$bdd->exec($query);
	}
	
	//***********************************************************************************************
	//	 GETTERS
	//***********************************************************************************************
	
	public function getId_import(){
		return $this->id_import;
	}
	
	public function getContenu(){
		return $this->commandes;
	}	
		
	public function getErreurs(){
		$erreurs = $this->erreurs;
		$this->erreurs = array();
		return $erreurs;
	}	
	
	function getEtape () {
		return $this->etape;
	}
	
	/**
	 * @return int le nombre de lignes traitées.
	 */
	public function getNb_lignes(){
		return $this->ligne_number;
	}
	
	//***********************************************************************************************
	//	FONCTIONS STATIQUES
	//***********************************************************************************************
	

	public static function getAncien_import($id){
		global $bdd;

		$query = "SELECT * FROM csv_import_cdc WHERE id_import_cdc = '".$id."' ;";
		$stt = $bdd->query($query);
		if(is_object($stt) && $imp = $stt->fetchObject()){
		
			$import = new import_commandes_csv($id);
			$import->etape = $imp->etape;
			return $import;
		}
		return null;
	}
	
	public static function getLast_import($etape){
		global $bdd;
		
		$query = "SELECT MAX(id_import_cdc) as id FROM csv_import_cdc WHERE etape = '".$etape."' ;";
		$stt = $bdd->query($query);
		if(is_object($stt) && $import = $stt->fetchObject()){
			return self::getAncien_import($import->id);
		}
		return null;
	}
	


 

 


}



?>