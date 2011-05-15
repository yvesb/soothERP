<?php
  


  final class doc_mod extends document {
    protected $types_docs;
	protected $lib_modele;
	protected $desc_modele;

	protected $ID_TYPE_DOC = 14;
	protected $LIB_TYPE_DOC = "Modèle";
	protected $CODE_DOC = "MOD";
	protected $DOC_ID_REFERENCE_TAG = 30;
    
	protected $DEFAUT_ID_ETAT 	= 57;
	protected $DEFAUT_LIB_ETAT 	= "Modèle actif";
	protected $ID_ETAT_ANNULE	= 58;
	
	protected $GESTION_SN = 0;
	
	public function open_doc($rien=null, $rien2=null){
	  global $bdd;
	  
      $this->check_profils(); 
      
      $select = ", dm.types_docs, dm.lib_modele, dm.desc_modele ";
      $left_join = " LEFT JOIN doc_mod dm ON dm.ref_doc = d.ref_doc ";
      
      if (!$doc = parent::open_doc($select, $left_join)) { return false; }
      
      $this->types_docs = $doc->types_docs;
      $this->lib_modele = $doc->lib_modele;
      $this->desc_modele = $doc->desc_modele;
      
      return true;
	}
	
	public function create_doc() {
	  global $bdd;
	  
	  if (!parent::create_doc()) { return false; }
	  
	  $query = "INSERT INTO doc_mod (ref_doc, types_docs, lib_modele, desc_modele)
	  	VALUES ('".$this->ref_doc."', '".$this->types_docs."', '".$this->lib_modele."'
	  	, '".$this->desc_modele."');";
	  
	  return $bdd->exec($query);
	}
	
	// Charge les lignes correspondantes aux modèles
	public function loadLines() {
	  global $bdd;
	  
	  $lines_mod = array();
	  $query = "SELECT ref_doc_line, ref_article, lib_article, desc_article, qte, pu_ht,
	  			remise, tva, ordre, ref_doc_line_parent, visible FROM docs_lines
	  			WHERE ref_doc = '".$this->ref_doc."';";
	  $res = $bdd->query($query);
	  while ($tmp = $res->fetchObject()) { $lines_mod[] = $tmp; }
	  return $lines_mod;
	}
	
	public function setTypesDocs($td) {
	  if (!is_array($td))
	    return false;
	  $this->types_docs = implode(";", $td);
	} 
	
	public function setLibModele($lm) {
	  $this->lib_modele = $lm;
	}
	
	public function setDescModele($dm) {
	  $this->desc_modele = $dm;
	}
	
	public function getTypesDocs() {
	  return explode(";", $this->types_docs);
	}
	
	public function getLibModele() {
	  return $this->lib_modele;
	}
	
	public function getDescModele() {
	  return $this->desc_modele;
	}
	
  	public function majTypesDocs($newtypes) {
  	  global $bdd;
  	  
  	  $this->types_docs = $newtypes;
  	  $query = "UPDATE doc_mod SET types_docs = '".$this->types_docs."' WHERE ref_doc='".$this->ref_doc."';";
	  return $bdd->exec($query);
	}
	
	public function majLibModele($newlib) {
	  global $bdd;
	  
	  $this->lib_modele = $newlib;
	  $query = "UPDATE doc_mod SET lib_modele = '".$this->lib_modele."' WHERE ref_doc='".$this->ref_doc."';";
	  return $bdd->exec($query);
	}
	
	public function majDescModele($newdesc) {
	  global $bdd;
	  
	  $this->desc_modele = $newdesc;
	  $query = "UPDATE doc_mod SET desc_modele = '".$this->desc_modele."' WHERE ref_doc='".$this->ref_doc."';";
	  return $bdd->exec($query);
	}
  }  
?>