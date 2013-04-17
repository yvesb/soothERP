<?php


/**
 * @author FLATTET Sylvain
 *
 */
/**
 * @author Administrateur
 *
 */
final class compta_export {
	
	
	//	Vars
	private $etat;
	private $id_journaux;
	private $id_modele;
	private $date_debut;
	private $date_fin;
	private $id_export_logiciel;
	private $error;
	private $ref_contact;
	
	//	flags
	private $flag_fileinit;
	private $flag_endtraitements;
	private $debugstate;
	private $querydebug;
	
	//	traitements
	private $nb_docs_ventes_traites;
	private $nb_docs_achats_traites;
	private $nb_moves_traites;
	private $nb_traitements;
	private $nb_traitements_effectues;
	
	//	process
	private $process_nextstep;
	private $process_poucentage;
	private $process_actual_type;
	private $process_nbexports;
	private $process_nbexports_doc_ventes;
	private $process_nbexports_doc_achats;
	private $process_nbexports_moves;
	private $process_nbexports_caisses;
	private $process_nbexports_comptescomptables;
	
	//	Modeles vars
	private $separateur;
	private $finaliseur;
	private $extention;
	private $id_ligne;
	
	//	fichier
	private $fichier;
	private $fichiers_url;
	private $fileurl;
	
	
	//	Objets & tableaux
	private $fiches;
	private $docs_ventes;
	private $docs_achats;
	private $moves;
	private $champs;
	private $comptescomptables_cli;
	private $comptescomptables_fou;
	
	function __construct(){
		//	intit recherche et modele
		$this->etat						= 0;
		$this->id_journaux 				= array();
		$this->id_modele				= array();
		$this->date_debut				= date("Y-b-d",time());
		$this->date_fin					= date("Y-b-d",time());
		$this->id_export_logiciel		= 0;
		$this->error					= array();
		$this->ref_contact				= '';
		//	traitements
		$this->nb_docs_ventes_traites 	= 0;
		$this->nb_docs_achats_traites 	= 0;
		$this->nb_moves_traites 		= 0;
		$this->nb_traitements 			= 0;
		$this->nb_traitements_effectues = 0;
		$this->process_nbexports_doc_ventes			= 0;
		$this->process_nbexports_doc_achats			= 0;
		$this->process_nbexports_moves				= 0;
		$this->process_nbexports_caisses			= 0;
		$this->process_nbexports_comptescomptables	= 0;
		//	flags
		$this->flag_fileloaded 			= false;
		$this->flag_endtraitements 		= false;
		$this->debugstate 				= 0;
		//	fichiers
		$this->fichiers_url				= array();
		
		$this->querydebug = '';
		
		return true;
	}
	
	/***********************************/
	/**  FICHIERS			          **/
	/***********************************/
	
	private function fic_process_loadfile( ){
		
		switch ( $this->process_actual_type ){
			case '1': $prefix = "VENTES"; break;
			case '2': $prefix = "ACHATS"; break;
			case '8': $prefix = "BANQUES"; break;
			case '9': $prefix = "CAISSES"; break;
			case '10': $prefix = "COMPTESCOMPTABLES"; break;
			default : $prefix = "EXPORTLMB"; break;
		}
		global $DIR;
		$complement_nom_fichier = "";
		$complement_nom_fichier .=  "-".$this->date_debut; 
		$complement_nom_fichier .=  "-".$this->date_fin; 
		$root = $DIR.'exports/';
		$filename = $prefix.'_ECRITURES'.$complement_nom_fichier;
		//	si le fichier existe
		if( file_exists( $root.$filename.'.'.$this->extention ) &&
			//	mais pas de flag lancé
			( !isset($this->flag_fileinit[$this->process_actual_type]) or
			//	ou flag est faux
			( 	isset($this->flag_fileinit[$this->process_actual_type]) && 
				$this->flag_fileinit[$this->process_actual_type] == false ) )
			) {
				//	on rename le fichier avec l'heure actuelle
				$filename = $filename."_".time();
		}
		$this->fichiers_url[$this->process_actual_type] = $root.$filename.'.'.$this->extention;
		//	change flag
		$this->flag_fileinit[$this->process_actual_type] = true;
		
	}
	
	private function fic_process_writeline ( $line ){
				//	si le fichier n'est pas chargé 
				if( !$this->flag_fileinit[$this->process_actual_type]){
					$this->fic_process_loadfile(); 
				}
				//	open file
				$this->fichier = fopen($this->fichiers_url[$this->process_actual_type], "a+"); 
				//	ecriture de l'information
				fwrite ($this->fichier, $line );
				//	close file
		 		fclose ($this->fichier);
		 		unset ($this->fichier);
	}
	
	public function obj_cleanup(){
		// unset
		unset($this->docs_ventes);
		unset($this->docs_achats);
		unset($this->fiches);
		unset($this->champs);
		unset($this->fichier);
		unset($this->comptescomptables_cli);
		unset($this->comptescomptables_fou);
		
		//	reset
		$this->docs_ventes = array();
		$this->docs_achats = array();
		$this->fiches = array();
		$this->champs = array();
		$this->comptescomptables_cli = array();
		$this->comptescomptables_fou = array();
		$this->process_nbexports_doc_ventes			= 0;
		$this->process_nbexports_doc_achats			= 0;
		$this->process_nbexports_moves				= 0;
		$this->process_nbexports_caisses			= 0;
		$this->process_nbexports_comptescomptables	= 0;
		
		//	flags
		$this->flag_fileinit = false;
		$this->flag_endtraitements = false;
		
		$this->querydebug = '';
	}
	
	/***********************************/
	/**  CHECKLISTS			          **/
	/***********************************/
	/**
	 * @return bool
	 */
	private function check_infos(){
		//	reset status erreur
		unset ($this->exp_error );
		$no_error = true;
		
		//	checklist //
		//	journaux cible existe
		if( !isset ($this->id_journaux) ){
			$this->exp_error[] = 'id_journaux';
			$no_error = false;
		}
		//	logiciel cible existe
		if( !isset ($this->id_export_logiciel) ){
			$this->exp_error[] = 'id_export_logiciel';
			$no_error = false;
		}
		//	modele existe
		if( !isset ($this->id_modele) ){
			$exp_error[] = 'id_modele';
			$no_error = false;
		}
		//	date debut existe
		if( !isset ($this->date_debut) ){
			$this->exp_error[] = 'date_debut';
			$no_error = false;
		}
		//	date fin existe
		if( !isset ($this->date_fin) ){
			$this->exp_error[] = 'date_fin';
			$no_error = false;
		}
		
		//	retourn le status erreur
		return $no_error;
	}
	
	/**
	 * @return bool
	 */
	private function check_modele(){
		global $bdd;
		unset($this->id_modele);
		$this->id_modele = array();
		$exist_model = false;
		$query_where =" 1";
		if($this->id_export_logiciel != 0){ $query_where .= " && cel.idcompta_export_logiciels = ".$this->id_export_logiciel; }
		$query_where .= " && cem.compatible LIKE '%";
		foreach ($this->id_journaux as $id ){
			$query_where .= $id."%";
			$query_where .= "'";
			$query = "
				SELECT *
					FROM compta_export_modele cem
					LEFT JOIN compta_export_logiciels cel
					ON cem.idcompta_export_logiciels = cel.idcompta_export_logiciels
					WHERE ".$query_where.";";
			$resultat = $bdd->query ($query);
			$this->querydebug = $query;
			$options = array();
			if($resultat->rowCount() == 0){ 
				$exist_model = false;
			}
			if($resultat->rowCount() == 1){ 
				$modele = $resultat->fetchObject();
				$this->id_modele[] = $modele->idcompta_export_modele;
				$exist_model = true;
			}
		}/*
		if($resultat->rowCount() > 1){ 
			while ($modele = $resultat->fetchObject()){
				$option = new stdClass();
				$option->id = $modele->idcompta_export_modele;
				$option->value = $modele->lib_modele;
				$option->selected = ($this->id_modele == $option->id)?true:false;
				$options[] = $option; 
			}
			return $options;
		}*/
		return $exist_model; 
	}
	
	public function check_modelinfos(){
		if ( ! isset($this->id_export_logiciel) ){
			return false;
		}
		if( ! isset ( $this->id_journal ) ){
			return false;
		}
		
		// checklist ok
		return true;
	}
	
	/***********************************/
	/**        DEBUG                  **/
	/***********************************/
	
	public function debug_get_infostring($show = false){
		//	si le systeme en DEV > debug autorisé
		global $ETAT_APPLICATION;
		if( $show && $ETAT_APPLICATION == "DEV"){
		//	on print un debug des variables de l'objet + debugstate (trace)	
		$script =
				"<b>ETAT APPLICATION : ".$ETAT_APPLICATION." - DEBUG AUTORISE</b>"
				."<ul id='debug_string_dev_state_03' class='infotable_form'><li>"
				."Etat de l'objet: ".htmlspecialchars($this->etat).";"
				."&nbsp;Date debut : ".htmlspecialchars($this->date_debut).";"
				."&nbsp;Date fin : ".htmlspecialchars($this->date_fin).";"
				."&nbsp;ID Logiciel : ".strval($this->id_export_logiciel).";"
				."&nbsp;ID Modèle : ".htmlspecialchars(serialize($this->id_modele)).";"
				."&nbsp;ID(s) journaux: ".htmlspecialchars(serialize($this->id_journaux)).";"
				."</li><li>"
				."Nb contents : ".htmlspecialchars($this->nb_traitements).";"
				."&nbsp;Nb contents done : ".htmlspecialchars($this->nb_traitements_effectues).";"
				."&nbsp;Last DebugState = ".htmlspecialchars($this->debugstate).";"
				."</li><li>"
				."Nb exports : ".htmlspecialchars($this->process_nbexports).";"
				."</li><li>"
				."querydebug : ".htmlspecialchars($this->querydebug).";"
				."</li></ul>";
				
		print "<script type='text/javascript'>"
				."$('dev_debug_compta_export').innerHTML = \""
				.$script
				."\";</script>";
		}
	}
	
	
	public function debug_debugMe_all($state_to_debug){
		//	si le systeme en DEV > debug autorisé
		//	debug obj, necessite class DebugMe en session
		global $ETAT_APPLICATION;
		if($ETAT_APPLICATION == "DEV" && isset($GLOBALS['dm'])){
			//	utilisation de la classe DebugMe en feed
			//	cf: DebugMe (class)
			if($this->etat  < 4 && $this->etat >= $state_to_debug ){
			$GLOBALS['dm']->newFeed('obj state',$this->etat,$this);
			$GLOBALS['dm']->newFeed('d.date',$this->date_debut,$this);
			$GLOBALS['dm']->newFeed('f.date',$this->date_fin,$this);
			$GLOBALS['dm']->newFeed('id.log',$this->id_export_logiciel,$this);
			$GLOBALS['dm']->newFeed('id.mod',$this->id_modele,$this);
			$GLOBALS['dm']->newFeed('id.jou',$this->id_journaux,$this);
			}	
			if($this->etat  >= 4 && $this->etat >= $state_to_debug){
				$GLOBALS['dm']->newFeed('id.mod',$this->id_modele,$this);
				$GLOBALS['dm']->newFeed('fic.handle',$this->fichier,$this);
			}
		}
	}
	
	/***********************************/
	/**  GETTERS SUR THIS			  **/
	/***********************************/

	/**
	 * @return stdClass avec attribut "href"
	 */
	public function get_fic_urlformated (){
		//	return stdClass ahref formated
		$links = array();
		foreach ($this->fichiers_url as $url){
			$link = new stdClass();
			$link->href =  htmlspecialchars($url);
			$links[] = $link;
		}
		return $links;
	}
	
	
	
	
	
	/***********************************/
	/**    SETTERS PUBLICS            **/
	/***********************************/

	/**
	 * @param $state
	 * @return unknown_type
	 */
	public function set_datedebut ($date){
		$this->date_debut = $date;
		return true;
	}
	/**
	 * @param $state
	 * @return unknown_type
	 */
	public function set_datefin ($date){
		$this->date_fin = $date;
		return true;
	}
	/**
	 * @param $state
	 * @return unknown_type
	 */
	public function set_etat ($state){
		$this->etat = $state;
		return true;
	}
	/**
	 * @param $id
	 * @return unknown_type
	 */
	public function set_idjournaux( $id ){
		unset($this->id_journaux);
		if( is_array($id) ){
			foreach( $id as $id_journal ){
				$this->id_journaux[] = $id_journal;
			}
		} else {
			$this->id_journaux[] = $id;
		}
		return true;
	}
	
	/**
	 * @param $id
	 * @return unknown_type
	 */
	public function set_idlogiciel ( $id ){
		$this->id_export_logiciel = $id;
		return true;
	}
	
	/**
	 * @param $id
	 * @return unknown_type
	 */
	public function set_idmodele ( $id ){
		$this->id_modele = $id;
		return true;
	}
	
	/***********************************/
	/**    PROCESS                    **/
	/***********************************/
	
	public function process_valid($step){
			// selon le step de l'export
			switch ($step){
				case "4":
					if( ! $this->check_modele() ) { return false ; }
					return 'a';
				// verifications des valeurs de l'objet
				case "4a" :
					if( ! $this->check_infos() ) { print_r($this->exp_error); return false ; }
					// préparation du modèle d'exportation dans l'objet
					$this->process_init_export();
					$this->process_set_formatmodel();
					return true;
					break;
					
				// export du modele
				case "4b" :
					$this->debugstate = "s.4b.precheck";
					if( ! $this->check_infos() ) { print_r($this->exp_error); return false ; }
					$this->debugstate = "s.4b.checked";
					$step = $this->process_traite_content();
					//	traite le content et retourne le step
					return $step;
					break;
					
				default :
					return false;
					break;
			}
	}	
	
	private function process_init_export(){
		//	init process vars
		unset($this->docs_ventes);
		unset($this->docs_achats);
		unset ($this->moves);
		$this->docs_ventes = array();
		$this->docs_achats = array();
		$this->moves = array();
		//	traitements
		$this->nb_docs_ventes_traites = 0;
		$this->nb_docs_achats_traites = 0;
		$this->nb_moves_traites = 0;
		$this->nb_traitements = 0;
		$this->nb_traitements_effectues = 0;
		//	compteurs d'exports 'id_ligne'
		$this->process_nbexports_doc_ventes			= 0;
		$this->process_nbexports_doc_achats			= 0;
		$this->process_nbexports_moves				= 0;
		$this->process_nbexports_caisses			= 0;
		$this->process_nbexports_comptescomptables	= 0;
		//	process
		$this->process_nextstep = 'b';
		$this->process_poucentage = 0;
		$this->process_actual_type = '';
		
		//	docs/move
		$this->id_ligne = 0;
		//	process_nbexports
		$this->process_nbexports = 0;
		
		$this->debugstate = "p.init";
		//	init process content
		foreach( $this->id_journaux as $id_journal ){
			if( $id_journal == "1"){
				//	prepare docs ventes
				$this->process_set_docs_ventes();
			}
			if( $id_journal == "2"){
				//	prepare docs achats
				$this->process_set_docs_achats();
			}
			if( $id_journal == "9"){
				//	prepare movements
				$this->process_set_moves();
			}
			if( $id_journal == "10"){
				//	en dev
			}
			if( $id_journal == "999"){
				//	prepare compte comptables
				$this->process_set_comptescomptables();
			}
			$this->nb_traitements = 0;
			$this->nb_traitements += count($this->docs_ventes);
			$this->nb_traitements += count($this->docs_achats);
			$this->nb_traitements += count($this->moves);
			
		}
	}
	
	private function process_set_formatmodel(){
		global $bdd;
		
		$this->debugstate = "model.init";
		// query bdd du modele d'export.
		$query = "SELECT * FROM compta_export_modele as cem
					WHERE cem.idcompta_export_modele = ".$this->id_modele[0];
		$result = $bdd->query($query);
		// affectations du modele
		$modele = $result->fetchObject();
		$this->separateur = $modele->separateur;
		$this->finaliseur = $modele->finaliseur;
		$this->extention = $modele->extention;
		// query bdd des champs modele d'export.
		$query = "SELECT * FROM compta_export_modeles_champs as cemc
					LEFT JOIN compta_export_champs cec ON cec.idcompta_export_champs = cemc.idcompta_export_champs
					WHERE cemc.idcompta_export_modele = ".$this->id_modele[0]."
					ORDER BY cemc.ordre
				";
		$result = $bdd->query($query);
		// affectations des champs
		while($champ = $result->fetchObject() ){
			$this->champs[] = $champ;
		}
		
		// tjrs ok
		return true;
	}
	
	private function process_set_docs_ventes(){
		global $bdd;
		$this->debugstate = "d.init";
		// *************************************************
		// Résultat de la recherche
		// Préparation de la requete
		// en fonction du journal selectioné :
		// type 1 : vente
		// Recherche des FAC
		$query_join 	= "";
		$query_where 	= "  cj.id_journal_parent = '1' ";
		$query_group	= "";
		$query_limit	= "";
		
		$count_modes = 0;
		
		if ($this->ref_contact) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " d.ref_contact = '".$this->ref_contact."' "; 
		}
		if ($this->date_debut) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " d.date_creation_doc >= '".date_Fr_to_Us($this->date_debut)." 00:00:00' "; 
		}
		if ($this->date_fin) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " d.date_creation_doc <= '".date_Fr_to_Us($this->date_fin)." 23:59:59' "; 
		}
		
		
		//recherche des documents
		$queryd = "	SELECT cd.ref_doc 
					FROM compta_docs cd
					LEFT JOIN documents d ON d.ref_doc = cd.ref_doc
					LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
					LEFT JOIN plan_comptable pc ON pc.numero_compte = cd.numero_compte
					LEFT JOIN compta_journaux cj ON cj.id_journal = cd.id_journal
									
					WHERE ".$query_where." 
					GROUP BY ref_doc
					".$query_limit;
		$resultatd = $bdd->query($queryd);
		//	docs vide, index 0, sinon index = count
		while ($doc = $resultatd->fetchObject()) {
			$doc->type_journal = 1;
			$this->docs_ventes[] = $doc;
		}
		unset ($queryd, $resultatd, $doc);
		
		return true;
	}
	
	private function process_set_docs_achats(){
		global $bdd;
		$this->debugstate = "d.init";
		// *************************************************
		// Résultat de la recherche
		// Préparation de la requete
		// en fonction du journal selectioné :
		// type 1 : vente
		// Recherche des FAC
		$query_join 	= "";
		$query_where 	= "  cj.id_journal_parent = '2' ";
		$query_group	= "";
		$query_limit	= "";
		
		$count_modes = 0;
		
		if ($this->ref_contact) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " d.ref_contact = '".$this->ref_contact."' "; 
		}
		if ($this->date_debut) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " d.date_creation_doc >= '".date_Fr_to_Us($this->date_debut)." 00:00:00' "; 
		}
		if ($this->date_fin) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " d.date_creation_doc <= '".date_Fr_to_Us($this->date_fin)." 23:59:59' "; 
		}
		
		
		//recherche des documents
		$queryd = "	SELECT cd.ref_doc 
					FROM compta_docs cd
					LEFT JOIN documents d ON d.ref_doc = cd.ref_doc
					LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
					LEFT JOIN plan_comptable pc ON pc.numero_compte = cd.numero_compte
					LEFT JOIN compta_journaux cj ON cj.id_journal = cd.id_journal
									
					WHERE ".$query_where." 
					GROUP BY ref_doc
					".$query_limit;
		$resultatd = $bdd->query($queryd);
		$index = count($this->docs_achats);//	docs vide, index 0, sinon index = count
		while ($doc = $resultatd->fetchObject()) {
			$doc->type_journal = 2;
			$this->docs_achats[$index] = $doc;
			$index++;
		}
		unset ($queryd, $resultatd, $doc);
		
		return true;
	}
	
	private function process_set_moves(){
			global $bdd;
			$this->debugstate = "m.init";
			// Préparation de la requete
			$query_join 	= "";
			$query_where 	= "";
			$query_group	= "";
			$query_limit	= "";
			
			$count_modes = 0;
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " cbm.date_move > '".date_Fr_to_Us($this->date_debut)." 00:00:00' ";
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " cbm.date_move <= '".date_Fr_to_Us($this->date_fin)." 23:59:59' "; 
			 //recherche des operations
	 		$queryd = "SELECT cbm.id_compte_bancaire_move
						FROM comptes_bancaires_moves cbm
							LEFT JOIN compta_journaux_opes cjo ON cjo.id_operation = cbm.id_operation
							LEFT JOIN comptes_bancaires  cb ON cb.id_compte_bancaire = cbm.id_compte_bancaire
							LEFT JOIN compta_journaux cj ON cj.id_journal = cjo.id_journal
							LEFT JOIN compta_journaux_types cjt ON cjt.id_journal_type = cj.id_journal_type
							LEFT JOIN compta_journaux_opes_types cjot ON cjot.id_operation_type = cjo.id_operation_type
							".$query_join."
						WHERE ".$query_where." 
						GROUP BY cbm.id_compte_bancaire_move
						ORDER BY cbm.date_move DESC, cbm.lib_move ASC, cbm.id_compte_bancaire_move ASC
						";
			//echo $queryd;
			$resultatd = $bdd->query($queryd);
			while ($move = $resultatd->fetchObject()) {
				$move->export_type = 9;
				$this->moves[] = $move;
			}
			unset ($move, $resultat, $query);
			
			return true;
	}
	
	private function process_set_comptescomtpables(){
			global $bdd;
			$this->debugstate = "cc.init";

			//chargement des comptes pour clients
			$query_cli = "SELECT ac.defaut_numero_compte,
								 cc.defaut_numero_compte as categ_defaut_numero_compte			
								FROM annu_client ac
								LEFT JOIN clients_categories cc ON cc.id_client_categ = ac.id_client_categ
								LEFT JOIN plan_comptable pc ON pc.numero_compte = ac.defaut_numero_compte
								";	
			$resultat_cli = $bdd->query ($query_cli);
			while ($contact_client = $resultat_cli->fetchObject()) {
				$defaut_numero_compte = $contact_client->defaut_numero_compte;
				//remplissage du numéro de compte achat par soit celui de la categorie client
				if (!$defaut_numero_compte) {
				$defaut_numero_compte = $contact_client->categ_defaut_numero_compte;
				}
				//soit par celui par defaut
				if (!$defaut_numero_compte) {
				$defaut_numero_compte = $DEFAUT_COMPTE_TIERS_VENTE;
				}
				$this->comptescomptables_cli[$defaut_numero_compte] = $defaut_numero_compte;
			}
			unset ($contact_client, $resultat_cli, $query_cli);
			//chargement des comptes pour fournisseurs
			$query_fou = "SELECT af.defaut_numero_compte,
								 fc.defaut_numero_compte as categ_defaut_numero_compte					
								FROM annu_fournisseur af
								LEFT JOIN fournisseurs_categories fc ON fc.id_fournisseur_categ = af.id_fournisseur_categ
								LEFT JOIN plan_comptable pc ON pc.numero_compte = fc.defaut_numero_compte
								";	
			$resultat_fou = $bdd->query ($query_fou);
			while ($contact_fournisseur = $resultat_fou->fetchObject()) {
				$defaut_numero_compte = $contact_fournisseur->defaut_numero_compte;
				//remplissage du numéro de compte achat par soit celui de la categorie client
				if (!$defaut_numero_compte) {
				$defaut_numero_compte = $contact_fournisseur->categ_defaut_numero_compte;
				}
				//soit par celui par defaut
				if (!$defaut_numero_compte) {
				$defaut_numero_compte = $DEFAUT_COMPTE_TIERS_ACHAT;
				}
				$this->comptescomptables_fou[$defaut_numero_compte] = $defaut_numero_compte;
			}
			unset ($contact_fournisseur, $resultat_fou, $query_fou);
			
			return true;

	}
	
	private function process_traite_content(){
		//	methode de traitement des contents
		//	si traitements a effectuer
		if( $this->nb_traitements > 0 ){
			$this->debugstate = "process.tc.in";
			$this->process_pourcentage = number_format(($this->nb_traitements_effectues * 100) / $this->nb_traitements);
			//	traitements des documents ventes
			if( count($this->docs_ventes) != 0 && ( $this->nb_docs_ventes_traites < count($this->docs_ventes) ) ){
				//	blocs de traitements de X docs
				$bloc = $this->get_process_blocvalue();
				$this->debugstate = "bloc.is.".$bloc;
				//	tant que content in bloc
				$i = 1;
				while ($i <= $bloc && ( $this->nb_docs_ventes_traites < count($this->docs_ventes) ) ){
					$this->debugstate = "bloc.in.".$i;
					//	traite docs content
					$this->process_traite_docs_ventes();
					//	suivi sur les traitements effectués
					$this->nb_traitements_effectues ++;
					$i++;
				}
				//	retourn le step a effectuer ( b/c )
				return $this->get_process_nextstep();
			}
			//	traitements des documents achats
			if( count($this->docs_achats) != 0 && ( $this->nb_docs_achats_traites < count($this->docs_achats) ) ){
				//	blocs de traitements de X docs
				$bloc = $this->get_process_blocvalue();
				$this->debugstate = "bloc.is.".$bloc;
				//	tant que content in bloc
				$i = 1;
				while ($i <= $bloc && ( $this->nb_docs_achats_traites < count($this->docs_achats) ) ){
					$this->debugstate = "bloc.in.".$i;
					//	traite docs content
					$this->process_traite_docs_achats();
					//	suivi sur les traitements effectués
					$this->nb_traitements_effectues ++;
					$i++;
				}
				//	retourn le step a effectuer ( b/c )
				return $this->get_process_nextstep();
			}
			//	traitements des mouvements
			if(count($this->moves) != 0 && ( $this->nb_moves_traites < count($this->moves) ) ){
				//	blocs de traitements de X docs
				$bloc = $this->get_process_blocvalue();
				//	tant que content in bloc
				$i = 1;
				$this->debugstate = "bloc.is.".$bloc;
				while ($i <= $bloc && ( $this->nb_moves_traites < count($this->moves) ) ){
					$this->debugstate = "bloc.in.".$i;
					$this->process_traite_moves();
					//	suivi sur les traitements effectués
					$this->nb_traitements_effectues ++;
					$i++;
				}
				//	retourn le step a effectuer ( b/c )
				return $this->get_process_nextstep();
			}
			//	traitements des comptes comptables clients
			if(count($this->comptescomptables_cli) != 0 && ( $this->nb_comptescomptables_cli_traites < count($this->comptescomptables_cli) ) ){
				//	blocs de traitements de X docs
				$bloc = $this->get_process_blocvalue();
				//	tant que content in bloc
				$i = 1;
				$this->debugstate = "bloc.is.".$bloc;
				while ($i <= $bloc && ( $this->nb_moves_traites < count($this->moves) ) ){
					$this->debugstate = "bloc.in.".$i;
					$this->process_traite_comptescomptables();
					//	suivi sur les traitements effectués
					$this->nb_traitements_effectues ++;
					$i++;
				}
				//	retourn le step a effectuer ( b/c )
				return $this->get_process_nextstep();
			}
		} else {
			$this->process_pourcentage = false;
			return $this->get_process_nextstep(true);
		}
	}
	
	private function process_traite_docs_ventes(){
		global $bdd;
		$doc = $this->docs_ventes[$this->nb_docs_ventes_traites];
		$this->debugstate = "d.trait.ventes.".$doc->ref_doc.".".count($this->docs_ventes);
		$this->process_actual_type = $doc->type_journal;
		
		// Recherche des FAC
		$query_join 	= "";
		$query_where 	= "  cj.id_journal_parent = '".$doc->type_journal."' ";
		$query_group	= "";
		$query_limit	= "";
		
		if ($this->ref_contact) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " d.ref_contact = '".$this->ref_contact."' "; 
		}
		if ($this->date_debut) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " d.date_creation_doc >= '".date_Fr_to_Us($this->date_debut)." 00:00:00' "; 
		}
		if ($this->date_fin) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " d.date_creation_doc <= '".date_Fr_to_Us($this->date_fin)." 23:59:59' "; 
		}
			
		//recherche des lignes comptable
	 	$query = "SELECT  cd.ref_doc, cd.id_journal, cd.montant, cd.numero_compte,
											a.nom, a.ref_contact,
											d.date_creation_doc, df.date_echeance, d.id_type_doc, 
											pc.lib_compte,
											cj.lib_journal, cj.id_journal_parent
							FROM compta_docs cd
								LEFT JOIN documents d ON d.ref_doc = cd.ref_doc
								LEFT JOIN doc_faf df ON d.ref_doc = df.ref_doc
								LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
								LEFT JOIN plan_comptable pc ON pc.numero_compte = cd.numero_compte
								LEFT JOIN compta_journaux cj ON cj.id_journal = cd.id_journal
								
							WHERE ".$query_where." && cd.ref_doc = '".$doc->ref_doc."'
							ORDER BY d.date_creation_doc DESC, cd.id_journal ASC
							";
					//echo nl2br($query);
		$resultat = $bdd->query($query);
		
		// impression des lignes / fiche
		while ($fiche = $resultat->fetchObject()) {
			 //	compteurs d'exports 'id_ligne'
			$this->id_ligne++;
			$fiche->export_type = $doc->type_journal;
			$ligne = "";
			// selon le modèle 1>N champs / lignes.
			// affectation des informations
			foreach ($this->champs as $champ ){
				if($ligne != ""){ $ligne .= $this->separateur; } // separateur de champs
				// feed de la ligne
				$champ =  $this->process_champ_affectfromfiche ($champ,$fiche);
				$ligne .= $champ;
			}
			// impression dans le fichier d'export
			// préparation du fichier	
			$this->fic_process_loadfile($fiche);
			$this->fic_process_writeline($ligne.$this->finaliseur."\r\n" );
			$this->process_nbexports ++;
			$this->process_nbexports_doc_ventes ++;
		}
		unset ($fiche, $resultat, $query);
		//	update des compteurs
		//	suivi sur le tableau des docs
		$this->nb_docs_ventes_traites ++;
		// return true (always)
		return true;
	}
	
	private function process_traite_docs_achats(){
		global $bdd;
		$doc = $this->docs_achats[$this->nb_docs_achats_traites];
		$this->debugstate = "d.trait.achats.".$doc->ref_doc;
		$this->process_actual_type = $doc->type_journal;		 
		//	compteurs d'exports 'id_ligne'
		$this->id_ligne++;
		// Recherche des FAC
		$query_join 	= "";
		$query_where 	= "  cj.id_journal_parent = '".$doc->type_journal."' ";
		$query_group	= "";
		$query_limit	= "";
		
		if ($this->ref_contact) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " d.ref_contact = '".$this->ref_contact."' "; 
		}
		if ($this->date_debut) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " d.date_creation_doc >= '".date_Fr_to_Us($this->date_debut)." 00:00:00' "; 
		}
		if ($this->date_fin) {
			if ($query_where) { $query_where .= " &&  "; }
			$query_where .=  " d.date_creation_doc <= '".date_Fr_to_Us($this->date_fin)." 23:59:59' "; 
		}
			
		//recherche des lignes comptable
	 	$query = "SELECT  cd.ref_doc, cd.id_journal, cd.montant, cd.numero_compte,
											a.nom, a.ref_contact,
											d.date_creation_doc, df.date_echeance, d.id_type_doc, 
											pc.lib_compte,
											cj.lib_journal, cj.id_journal_parent
							FROM compta_docs cd
								LEFT JOIN documents d ON d.ref_doc = cd.ref_doc
								LEFT JOIN doc_faf df ON d.ref_doc = df.ref_doc
								LEFT JOIN annuaire a ON a.ref_contact = d.ref_contact
								LEFT JOIN plan_comptable pc ON pc.numero_compte = cd.numero_compte
								LEFT JOIN compta_journaux cj ON cj.id_journal = cd.id_journal
								
							WHERE ".$query_where." && cd.ref_doc = '".$doc->ref_doc."'
							ORDER BY d.date_creation_doc DESC, cd.id_journal ASC
							";
					//echo nl2br($query);
		$resultat = $bdd->query($query);
		
		// impression des lignes / fiche
		while ($fiche = $resultat->fetchObject()) {
			$fiche->export_type = $doc->type_journal;
			$ligne = "";
			// selon le modèle 1>N champs / lignes.
			// affectation des informations
			foreach ($this->champs as $champ ){
				if($ligne != ""){ $ligne .= $this->separateur; } // separateur de champs
				// feed de la ligne
				$champ =  $this->process_champ_affectfromfiche ($champ,$fiche);
				$ligne .= $champ;
			}
			// impression dans le fichier d'export
			// préparation du fichier	
			$this->fic_process_loadfile($fiche);
			$this->fic_process_writeline($ligne.$this->finaliseur."\r\n" );
			$this->process_nbexports ++;
			$this->process_nbexports_doc_achats++;
		}
		unset ($fiche, $resultat, $query);
		//	update des compteurs
		//	suivi sur le tableau des docs
		$this->nb_docs_achats_traites ++;
		// return true (always)
		return true;
	}
		
	private function process_traite_moves(){
		global $bdd;
		$move = $this->moves[$this->nb_moves_traites];
		$this->debugstate = "m.trait.".$move->id_compte_bancaire_move;
		//	compteurs d'exports 'id_ligne'
		$this->id_ligne++;
		$query_join 	= "";
		$query_where 	= " cbm.id_compte_bancaire_move = ".$move->id_compte_bancaire_move;
		$query_group	= "";
		$query_limit	= "";
		
		$count_modes = 0;
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " cbm.date_move > '".date_Fr_to_Us($this->date_debut)." 00:00:00' ";
		if ($query_where) { $query_where .= " &&  "; }
		$query_where .=  " cbm.date_move <= '".date_Fr_to_Us($this->date_fin)." 23:59:59' "; 
		 //recherche des operations
 		$queryd = "SELECT cbm.id_compte_bancaire_move, cbm.id_compte_bancaire, cbm.date_move, cb.defaut_numero_compte,
								 cbm.lib_move, montant_move, cbm.commentaire_move, cbm.id_operation, 
								 cjo.id_journal, cjo.numero_compte, cjo.montant, cjo.ref_operation, cjo.date_operation, cjo.id_operation_type,
 								cj.lib_journal, cj.desc_journal, cj.id_journal_parent, cj.id_journal_type, cj.contrepartie,
 								cjt.lib_journal as lib_journal_type, cjt.code_journal,
 								cjot.lib_operation_type, cjot.abrev_ope_type, cjot.table_liee
					FROM comptes_bancaires_moves cbm
						LEFT JOIN compta_journaux_opes cjo ON cjo.id_operation = cbm.id_operation
						LEFT JOIN comptes_bancaires  cb ON cb.id_compte_bancaire = cbm.id_compte_bancaire
						LEFT JOIN compta_journaux cj ON cj.id_journal = cjo.id_journal
						LEFT JOIN compta_journaux_types cjt ON cjt.id_journal_type = cj.id_journal_type
						LEFT JOIN compta_journaux_opes_types cjot ON cjot.id_operation_type = cjo.id_operation_type
						".$query_join."
					WHERE ".$query_where;
		//echo $queryd;
		$resultatd = $bdd->query($queryd);
		while ($move = $resultatd->fetchObject()) {
			$move->export_type = 9;
			$ligne = "";
			foreach ($this->champs as $champ ){
				if($ligne != ""){ $ligne .= $this->separateur; } // separateur de champs
				// feed de la ligne
				$champ =  $this->process_champ_affectfromfiche ($champ,$move);
				$ligne .= $champ;
			}
			// impression dans le fichier d'export
			$this->fic_process_writeline ($ligne.$this->finaliseur."\r\n" );
			$this->process_nbexports ++;
			$this->process_nbexports_moves++;
		}
		unset ($move, $resultat, $query);
		//	update des compteurs
		//	suivi sur le tableau des moves
		$this->nb_moves_traites ++;
	}	
	
	/* 
	private function process_traite_comptescomptables(){
				//C;10;CAPITAL ET RESERVE;G
			$compte = $this->comptescomptables[$this->nb_comptescomptables_traites];
			$this->debugstate = "cc.trait.".$compte->id_compte;
			//	compteurs d'exports 'id_ligne'
			$this->id_ligne++;
			foreach ($comptes_plan_general as $plan_entreprise) {
				$typ_ctp = "G";
				if (isset($liste_cpt_fourn[$plan_entreprise->numero_compte])) {		$typ_ctp = "F";}
				if (isset($liste_cpt_clients[$plan_entreprise->numero_compte])) {		$typ_ctp = "C";}
				echo "C;".$plan_entreprise->numero_compte.";".str_replace(";","",$plan_entreprise->lib_compte).";".$typ_ctp."\n";
			}
			$this->nb_comptescomptables_traites ++;
			$this->process_nbexports_comptescomptables++;
	}
	*/
	
	/**
	 * @param $cellule (stdClass)
	 * @return string
	 */
	private function process_champ_affectfromfiche ($champ,&$fiche){
		//SWITCH sur un champ de modèle d'exportation
		switch ($champ->type_script){
			// est une methode de classe export
			case "method":
				//teste l'exsitence de la methode
				//sinon faux
				if ( method_exists($this,$champ->script)  ){
					return call_user_func(array($this,$champ->script),$fiche);
				} else {
					return false;
				}
			break;
			// est un attribut de l'objet id
			case "attribute":
				$target_object = $champ->index;
				$target_attribute = $champ->script;
				// si index est un objet
				// et que l'attribut existe
				// sinon faux
				if( is_object(${$target_object}) && isset(${$target_object}->{$target_attribute}) ){
					return ${$target_object}->{$target_attribute};
				} else {
					return false;
				}
			break;
			// est une variable globale
			case "global":
				$target_var = $champ->script;
				global ${$target_var};
				// si la variable existe
				// sinon faux
				if (isset( ${$target_var})){
					// variable est un tableu
					// on prend l'index associé
					if(is_array(${$target_var})){
						return ${$target_var}[$champ->index];
					} else {
						return ${$target_var};
					}
				} else {
					return false;
				}
			break;
			// est un script php a evaluer
			case "eval":
				return eval ($champ->script);
				break;
			// est une date a metre en forme
			case "date":
				$target_object = $champ->index;
				$target_attribute = $champ->script;
				// si index est un objet
				// et que l'attribut existe
				// sinon faux
				if( is_object(${$target_object}) && isset(${$target_object}->{$target_attribute}) ){
					return date("dmY",strtotime(${$target_object}->{$target_attribute}));
				} else {
					return false;
				}
				break;
			// est un string statique
			case "string":
				return html_entity_decode($champ->script);
				break;
		}
		
	}
	
	/***********************************/
	/**  GETTERS DE PROCESS           **/
	/***********************************/
	
	/**
	 * @return chaine de characteres concernant le 'type' de process en cours
	 * langue : Francais, FR
	 */
	public function get_process_type(){
		switch ($this->process_actual_type){
			case "1" :
				return 'Document(s) - Ventes';
				break;
			case "2" :
				return 'Document(s) - Achats';
				break;
			case "9" :
				return 'Mouvement(s)';
				break;
			case "11" :
				return 'Compte(s) comptable';
				break;
			default:
				return 'Traitement(s)';
				break;
		}
	}
	
	/**
	 * @param $separateur : chaine concenant le séparateur de cheminement
	 * defaut : /
	 * ex : $separateur = ;  affichage 1;15
	 * @return chaine de characteres concernant le cheminement du process
	 * ex : 1/15
	 */
	public function get_process_cheminement($separateur = "/"){
		return $this->nb_traitements_effectues.$separateur.$this->nb_traitements;
	}
	
	/**
	 * @return entier concernant le pourcentage effectué de traitements
	 */
	public function get_process_pourcentage (){
		return $this->process_pourcentage;
	}
	
	/**
	 * @return entier concernant le nombres exact de lignes ecrites dans le fichier
	 */
	public function get_process_nbexports (){
		return $this->process_nbexports;
	}
	
	/**
	 * @param $force_next (booleen)
	 * @return charactere b/c : 
	 * en général 
	 * b = boucle pour traiter le prochain bloc = on boucle le step 4b
	 * c = traitements effectués ou force break = on sors du step 4b
	 */
	public function get_process_nextstep($force_next = false){
		//	step a effectuer dans le cycle ajax
		//	si fin de traitements => step C
		if( $this->nb_traitements == $this->nb_traitements_effectues or $force_next){ 
			return 'c'; }
		//	sinon on boucle sur le step B (traitements)
		else { 
			return 'b'; 
		}
	}
	
	/**
	 * @return entier concernant le nombre de traitements a faire par blocs
	 * il calcule un plafond de 10% des traitements totals a effectuer
	 */
	private function get_process_blocvalue(){
		switch ($this->process_actual_type){
			case "1":
				return ceil( (10*count($this->docs_ventes))/100 );
				break;
			case "2":
				return ceil( (10*count($this->docs_achats))/100 );
				break;
			case "9":
				return ceil( (10*count($this->moves))/100 );
				break;
			case "10":
				//return floor( (10*count($this->moves))/100 );
				return 1; //	en dev
				break;
			case "11":
				return ceil( (10*count($this->comptes))/100 );
				break;
			default:
				return ceil( (1*$this->nb_traitements)/100 );
				break;
		}
	}
	
	private function exp_active_journal(){
		// Préparation de la requete
		// en fonction du journal selectioné :
		foreach( $this->id_journaux as $id_journal ){
			switch ($id_journal) {
				case "1": //ventes
					$type1 = true;
					break;
				case "2": //achats
					$type2 = true;
					break;
				case "9": //banques
					$type9 = true;
					break;
				case "10": //caisse
					$type10 = true;
					break;
			}
		}
	}
	
	/***********************************/
	/**        CHAMPS                 **/
	/***********************************/
	
	private function champ_get_journalexport ($fiche){
		if( $fiche->export_type == 9 ){
			return "BQ".$fiche->defaut_numero_compte;
		} else {
			switch ($fiche->id_type_doc) {
				case "4": return "VE";
					break;
				
				case "8": return "AC";
				break;
			}	
		}	
	} 
	private function champ_get_typefacture ($fiche){
		
		switch ($fiche->id_type_doc) {
			case "4": return "FC";
				break;
			case "8": return "FF";
				break;
		}			
	} 
	private function champ_get_dorc($fiche){
		if ($fiche->montant == 0) {return false;}
		$montant_int = 0;
		if ($fiche->montant > 0) {$montant_int = 1;}
		if( $fiche->export_type == 9 ){
			return ($montant_int % 2)? 'C' : 'D';
		} else {
			switch ($fiche->id_type_doc) {
			case "4": 
				if( $fiche->id_journal == "5" ) { return ($montant_int % 2)? 'D' : 'C'; }
				else { return ($montant_int % 2)? 'C' : 'D'; }
				break;
			
			case "8": 
				if ($fiche->id_journal == "8") {return ($montant_int % 2)? 'C' : 'D';}
				else { return ($montant_int % 2)? 'D' : 'C'; }
				break;
			}
		}
	} 
	
	private function champ_get_ctp($fiche){
		$typ_ctp = "G";
		if (isset($liste_cpt_fourn[$plan_entreprise->numero_compte])) {		$typ_ctp = "F";}
		if (isset($liste_cpt_clients[$plan_entreprise->numero_compte])) {		$typ_ctp = "C";}
		return $typ_ctp;
	}
	
	/***********************************/
	/**  ADD MODELES ALPHA            **/
	/***********************************/
	
	public function add_new_modelname($model_name){
		global $bdd;
		// si le modele_name n'existe pas deja
		if( !$this->add_exist_modelbyname($model_name) ){
			$query = "INSERT INTO compta_export_modele c (lib_modele,idcompta_export_logiciel,id_journal_type)
						VALUES ( '".$model_name."', ".$this->getId_export_logiciel().", ".$this->getId_journal().")
				";
			$resultat = $bdd->exec ($query);
		// return IdModele
		return $resultat->lastInsertId() ;
		} else {
			return false;
		}
	}
	
	
	/*
	 * EXIST MODEL
	 * alpha
	 * 
	 */
	public function add_exist_modelbyname($model_name){
		global $bdd;
		// si le modele_name n'existe pas deja
		$query = "SELECT c.idcompta_export_modele FROM compta_export_modele c
					WHERE c.lib_modele = '".$model_name."'
				";
		$resultat = $bdd->query ($query);
		
		// return IdModele
		if( $resultat->rowCount() == 1 ){
			$row = $resultat->fetchObject();
			return $row->id_modele;
		} else {
			return false;
		}
	}

	/***********************************/
	/**  GETTERS selectFormated       **/
	/***********************************/
	
	/**
	 * @return option formated stdClass (id/value) or false
	 */
	public function getListe_logiciels_selectformated ( ){
		global $bdd;
		$query = "SELECT cel.idcompta_export_logiciels, cel.lib_logiciel, cel.desc_logiciel, cel.version_logiciel
					FROM compta_export_logiciels cel
					ORDER BY cel.idcompta_export_logiciels";
		$resultat = $bdd->query ($query);
		$options = array();
		if($resultat->rowCount() == 0){ 
				return false;
		}else{
			while ($logiciel = $resultat->fetchObject()){
				$option = new stdClass();
				$option->id = $logiciel->idcompta_export_logiciels;
				$option->value = $logiciel->desc_logiciel;
				if( $logiciel->version_logiciel != "" ){
					$option->value .= " [ ver: ".$logiciel->version_logiciel." ]";
				}
				$option->selected = ($option->id == $this->id_export_logiciel)?true:false;
				$options[] = $option; 
			}
		}
		return $options; 
	}
	
	public function getListe_journaux_selectformated () {
		global $bdd;
		
		$query = "SELECT id_journal, lib_journal
					FROM compta_journaux cj
					WHERE cj.id_journal_parent = 0
					ORDER BY id_journal ASC, lib_journal DESC";
		$resultat = $bdd->query ($query);
		$options = array();
		if($resultat->rowCount() == 0){ 
				return false;
		}else{
			while ($journal = $resultat->fetchObject()){
			 	$option = new stdClass();
				$option->id = $journal->id_journal;
				$option->value = $journal->lib_journal;
				if( is_array($this->id_journaux) ){
					//	si l'id_journal n'est pas dans l'objet
					$option->selected = ( array_search($option->id,$this->id_journaux) === false )? false : true ;
				} else {
					$option->selected = false;
				}
				$options[] = $option; 
			}
		}
		return $options; 
	}
	/*
	 * @param $id_journal
	 * @param $id_logiciel
	 * @return option formated stdClass (id/value) or false
	 */
	public function getListe_modeles_selectformated (){
		global $bdd;
		
		$query_where =" 1";
		if($this->id_export_logiciel != 0){ $query_where .= " && cel.idcompta_export_logiciels = ".$this->id_export_logiciel; }
		$query_where .= " && cem.compatible LIKE '%";
		foreach ($this->id_journaux as $id ){
			$query_where .= $id."%";
		}
		$query_where .= "'";
		$query = "
			SELECT *
				FROM compta_export_modele cem
				LEFT JOIN compta_export_logiciels cel
				ON cem.idcompta_export_logiciels = cel.idcompta_export_logiciels
				WHERE ".$query_where.";";
		$resultat = $bdd->query ($query);
		$options = array();
		if($resultat->rowCount() == 0){ 
			return false;
		}else{ 
			while ($modele = $resultat->fetchObject()){
				$option = new stdClass();
				$option->id = $modele->idcompta_export_modele;
				$option->value = $modele->lib_modele;
				$option->selected = ($this->id_modele == $option->id)?true:false;
				$options[] = $option; 
			}
		}
		return $options; 
	}
	
	public function getListe_champs_selectformated () {
		global $bdd;
		
		$query = "SELECT idcompta_export_champs, lib_champ, desc_champ, 
					( SELECT c.lib_journal FROM compta_journaux c
						WHERE c.id_journal = cec.type_champ ) as champ_typestring
					FROM compta_export_champs cec
					ORDER BY idcompta_export_champs";
		$resultat = $bdd->query ($query);
		$options = array();
		if($resultat->rowCount() == 0){ 
			return false;
		}else{
			while ($champ = $resultat->fetchObject()){
 				$option = new stdClass();
				$option->id = $champ->idcompta_export_champs;
				$string_type = ($champ->champ_typestring != "")?$champ->champ_typestring:'global';
				$option->value = htmlspecialchars ($champ->lib_champ.' ('.$string_type.')');
				$option->selected = false;
				$options[] = $option; 
			}
		}
		return $options; 
	}
	
	
	/***********************************/
	/**  STATICS METHODS SUR SESSION  **/
	/***********************************/
	
	static function obj_getfromsession ( $session_index ){
		if( isset ($_SESSION['compta_export']) ){ return unserialize( $_SESSION['compta_export'] ); }
		else { return new compta_export(); }
	}
	static function obj_setinsession (&$obj, $session_index ){
		unset ($_SESSION['compta_export']);
		$_SESSION['compta_export'] = serialize($obj);
		return true;
	}
	static function obj_resetall ( $session_index ){
		unset ($_SESSION['compta_export']);
		return new compta_export();
	}

}//end class

?>