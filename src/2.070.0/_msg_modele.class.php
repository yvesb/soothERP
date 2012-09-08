<?php

class msg_modele {

    protected $template = "";
    
    function  __construct($id_msg_modele) {
        
        global $bdd;
        global $TPL_MODELES_DIR;

        $id_msg_modele = intval($id_msg_modele);
        
        $query = "SELECT code_msg_modele FROM msg_modeles WHERE id_msg_modele = $id_msg_modele";
        
        if ( $resultat = $bdd->query($query) ){
            if ( $modele = $resultat->fetchObject() ){
                $this->template = new template($TPL_MODELES_DIR.$modele->code_msg_modele.".tpl");
            }
        }
    }
 
    
    public function get_html(){
        return $this->template->generate_html();
    }
}

?>
