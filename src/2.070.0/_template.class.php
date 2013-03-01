<?php

class template {
	
	protected $main_file        = "";
	protected $loaded           = false;

        protected $global_vars      = array();
        protected $block_vars       = array();

	protected $contenu;
	
	
//*****************************************************************
// Constructeur
//*****************************************************************
	
	function __construct($filename = ""){
		if ( is_file($filename) ){
			$this->set_Main_file( $filename );
			$contenu = file_get_contents( $filename );
			if ( $contenu ){
				$this->set_Contenu($contenu);
				$this->loaded = true;
			}
		} 
		return false;
	}
	
//*****************************************************************
// Setters
//*****************************************************************		
	
	function set_Main_file($filename){
		
		if ( is_string($filename) ){
			$this->main_file = $filename;
			return true;
		}
		return false;
	}
	
	function set_Contenu($contenu){
		
		if ( is_string($contenu) ){
			$this->contenu = $contenu;
			return true;
		}
		return false;
	}
	
//*****************************************************************
// Getters
//*****************************************************************		
	
	protected function get_Contenu(){
		
		if ( $this->loaded ){
			return $this->contenu;
		}
		return false;
	}
	
//*****************************************************************
// Fonctions
//*****************************************************************

	protected function remplace_tag($tags){
		$function = $tags[1];
		if ( isset($tags[2]) ) { $params = $tags[2]; } else { $params = null; }
		if ( method_exists("template",$function) ){
			return $this->$function($params);
			//return call_user_func(array(&$this, $function), $params);
		}
		return $this->extract_vars($tags[1]);
	}

       public function _assign_vars($vars){

		if ( !is_array($vars) ) { return false; }

		foreach ($vars as $key=>$var){
			$this->global_vars[$key] = $var;
		}
        }
		public function extract_vars($name){
			return (isset($this->global_vars[$name])) ? $this->global_vars[$name] : $name ;
		}

        public function get_path_root($path){

            if ( !is_string($path) ) { return false; }

            $separateur_position = strpos($path, ".");

            if ( $separateur_position === 0 ) { return false; }

            if ( $separateur_position === false  ) { return $path; }

            if ( $separateur_position > 0 ){
                return substr($path, 0, $separateur_position);
            }
        }

        public function get_next_path($path){

            if ( !is_string($path) ) { return false; }

            $separateur_position = strpos($path, ".");

            if ( $separateur_position === 0 ) { return false; }

            if ( $separateur_position === false  ) { return false; }

            if ( $separateur_position > 0 ){
                return substr($path, $separateur_position+1, strlen($path)-$separateur_position);
            }
        }        

         public function get_node($path, &$current=false){
            
            if ( !$current ) { $current = &$this->block_vars; }
            $current_path = $this->get_path_root($path);
            $next = $this->get_next_path($path);
            if ( isset($current[$current_path]) ){
                $current = &$current[$current_path];
            }else{
                return false;
            }
            while ( $next ){
                if ( isset($current["CHILDREN"]) && is_array($current["CHILDREN"]) ){
                    return $this->get_node($next, $current["CHILDREN"]);
                }else{
                    return false;
                }
            }
            return $current;
        }

        public function &create_and_get_node($path, &$current=false){
            
            if ( $current === false ) { $current = &$this->block_vars; }
            $current_path = $this->get_path_root($path);
            $next = $this->get_next_path($path);
            if ( !$current_path ) { return false; }
            if ( isset($current[$current_path]) ){
                $current = &$current[$current_path];
            }else{
                $current[$current_path] = array();
                $current = &$current[$current_path];
            }
            if ( !isset($current["CHILDREN"]) ) { $current["CHILDREN"] = array(); }
            if ( !isset($current["DATA"]) ) { $current["DATA"] = array(); }
            if ( !isset($current["CONTENT"]) ) { $current["CONTENT"] = array(); }
            
            while ( $next ){
                if ( isset($current["CHILDREN"]) && is_array($current["CHILDREN"]) ){
                    return $this->create_and_get_node($next, $current["CHILDREN"]);
                }else{
                    $current["CHILDREN"] = array();
                    return $this->create_and_get_node($next, $current["CHILDREN"]);
                }
            }
            return $current;
        }
        
        public function _assign_block_vars($namespace, $vars, $multiple_dataset = false){

            $node = &$this->create_and_get_node($namespace);
            if (is_array($node)){
                if ( !isset($node["DATA"]) ){
                    $node["DATA"] = array();
                }
                if ($multiple_dataset){
                    $node["DATA"] = $vars;
                }else{
                    $node["DATA"][] = $vars;
                }
            }
        }

	public function generate_html($contenu = ""){

		if ( $contenu == "" && !$this->loaded ) { return false; }
		if ( $contenu == "" ){
			$contenu = $this->get_Contenu();
		}
		$contenu = $this->parse_contenu();
		return preg_replace_callback( "#\{([A-Z]+):([^\}]*)\}#s", array(&$this, 'remplace_tag'), $contenu );
		
	} 

	protected function get_vars($var_name){
		
		if ( !array_key_exists($var_name,$this->global_vars) ) { return false; }
		return $this->global_vars[$var_name];
		
	}

        public function parse_contenu(&$contenu = false, &$vars = false){

            if ( $contenu === false ) { $contenu = &$this->contenu; }
            if ( $vars === false ) { $vars = &$this->block_vars; }
            $results = array();
            $nb_blocks = preg_match_all( "#\{BLOCK:([^\}]*)\}(.*)\{BLOCKEND:\\1\}#s", $contenu, $results );

            if ($nb_blocks){
                for ($i=1; $i<=$nb_blocks; $i++){
                    $block_name = $results[1][0];
                    $block_content = $results[2][0];
                    $node = &$this->create_and_get_node($block_name);
                    $node["CONTENT"] = $this->parse_contenu($block_content);
                    $contenu = preg_replace("#\{BLOCK:([^\}]*)\}(.*)\{BLOCKEND:\\1\}#s", "{BLOCK:$1}", $contenu);
                }   
            }
            return $contenu;
        }

//*****************************************************************
// Fonctions des TAGS
//*****************************************************************	

	protected function BLOCK($block_name){

		$result = "";
		$node = $this->get_node($block_name);
                $datasets = $node["DATA"];
                foreach ($datasets as $dataset){
                    $patterns = array();
                    $replace = array();
                    foreach ($dataset as $champ=>$valeur){
                        $patterns[] = "#\{DATA:$block_name.$champ}#s";
                        $replace[] = "$valeur";
                    }

                    $result .= preg_replace($patterns, $replace, $node["CONTENT"]);
                }
                return preg_replace_callback( "#\{([A-Z]+):([^\}]*)\}#s", array(&$this, 'remplace_tag'), $result );
	}


	protected function TPLINCLUDE($tpl_file){
                global $TPL_MODELES_DIR;
		$tpl = new template( $TPL_MODELES_DIR.$tpl_file );
		return $tpl->generate_html();
	}


	protected function CONTACT($ref_contact, $valeur){

		if ( $ref_contact && $valeur ){
			$contact = new contact($ref_contact);
			if ( $contact->getRef_contact() == $ref_contact ){
				switch ($valeur){
					case "nom" :
						return $contact->getNom();
						break;
					case "adresse" :
						$adresses = $contact->getAdresses();
						return isset($adresses[0]) ? $adresses[0]->getText_adresse() : "";
						break;
					case "cp" :
						$adresses = $contact->getAdresses();
						return isset($adresses[0]) ? $adresses[0]->getCode_postal() : "";
						break;
					case "ville" :
						$adresses = $contact->getAdresses();
						return isset($adresses[0]) ? $adresses[0]->getVille() : "";
						break;
					case "tel" :
						$coords = $contact->getCoordonnees();
						return isset($coords[0]) ? $coords[0]->getTel1() : "";
						break;
					case "fax" :
						$coords = $contact->getCoordonnees();
						return isset($coords[0]) ? $coords[0]->getFax() : "";
						break;
                                        case "email" :
						$coords = $contact->getCoordonnees();
						return isset($coords[0]) ? $coords[0]->getEmail() : "";
						break;
					case "site" :
						$sites = $contact->getSites();
						return isset($sites[0]) ? "<A HREF='".$sites[0]->getUrl()."'>".$sites[0]->getUrl()."</A>" : "";
						break;
				}
			}
		}
		return "";
	}

        protected function DOCUMENT($ref_doc, $valeur){
            
                if ( $ref_doc && $valeur ){
                    $document = open_doc($ref_doc);
                    if ( $document->getRef_doc() == $ref_doc ){
                            switch ($valeur){
                                    case "nom_complet" :
						return $document->getNom_contact();
						break;
                                    case "port_lib" :
                                                $port_line = $document->getLivraison_line();
                                                if ( $port_line ){
                                                    return $port_line->lib_article;
                                                }else{
                                                    return "";
                                                }
						break;
                                    case "port_numero_colis" :
                                                $port_line = $document->getLivraison_line();
                                                if ( $port_line ){
                                                    return $port_line->desc_article;
                                                }else{
                                                    return "";
                                                }
						break;
                                   case "port_fournisseur_site" :
                                               $port_line = $document->getLivraison_line();
                                                if ( $port_line ){
                                                    $ref_port_article = $port_line->ref_article;
                                                    $port_article = new article($ref_port_article);
                                                    if ($port_article->getRef_article() == $ref_port_article){
                                                        $port_fournisseur = $port_article->getRef_constructeur();
                                                        if ($port_fournisseur){
                                                            return $this->CONTACT($port_fournisseur, "site");
                                                        }
                                                    }
                                                }else{
                                                    return "";
                                                }
						break;
                                    case "date" :
                                                return $document->getDate_creation();
						break;
                            }
                    }
                }
        }


	protected function USER($valeur){
		
		$ref_contact = $this->get_vars(__FUNCTION__);
                if (!$ref_contact){
                    $ref_contact = $_SESSION['user']->getRef_contact();
                }
		if ( $ref_contact ){
                    return $this->CONTACT($ref_contact, $valeur);
		}
		return "";
	}

	protected function DESTINATAIRE($valeur){
		
		$ref_contact = $this->get_vars(__FUNCTION__);
		return $this->CONTACT($ref_contact, $valeur);
	}

	protected function EXPEDITEUR($valeur){
		
		$ref_contact = $this->get_vars(__FUNCTION__);
		return $this->CONTACT($ref_contact, $valeur);
	}

	protected function ENTREPRISE($valeur){

                global $REF_CONTACT_ENTREPRISE;
		$ref_contact = $this->get_vars(__FUNCTION__);
                if (!$ref_contact){ $ref_contact = $REF_CONTACT_ENTREPRISE; }
                return $this->CONTACT($ref_contact, $valeur);
        }

	protected function SOLDECOMPTABLE($valeur){

                global $MONNAIE;
                $solde_comptable = $this->get_vars(__FUNCTION__);
                return price_format($solde_comptable)." ".$MONNAIE[1];
        }

	protected function BLC($valeur){

                $ref_doc = $this->get_vars(__FUNCTION__);
                switch ($valeur){
                    case "ref_cdc" :
                        global $COMMANDE_CLIENT_ID_TYPE_DOC;
                        $document = open_doc($ref_doc);
                        $ref_doc_cdc = document_echeancier::get_ref_doc_from_type($COMMANDE_CLIENT_ID_TYPE_DOC, $document->getId_type_doc(), $ref_doc);
                        $doc_cdc = open_doc($ref_doc_cdc);
                        if ($doc_cdc->getId_type_doc() == $COMMANDE_CLIENT_ID_TYPE_DOC){
                            return $ref_doc_cdc;
                        }
                        break;
                    case "date_cdc" :
                        global $COMMANDE_CLIENT_ID_TYPE_DOC;
                        $document = open_doc($ref_doc);
                        $ref_doc_cdc = document_echeancier::get_ref_doc_from_type($COMMANDE_CLIENT_ID_TYPE_DOC, $document->getId_type_doc(), $ref_doc);
                        $doc_cdc = open_doc($ref_doc_cdc);
                        if ($doc_cdc->getId_type_doc() == $COMMANDE_CLIENT_ID_TYPE_DOC){
                            return date_Us_to_Fr($this->DOCUMENT($ref_doc_cdc, "date"));
                        }
                        break;
                    default :
                        return $this->DOCUMENT($ref_doc, $valeur);
                        break;
                }
        }
	
}

?>