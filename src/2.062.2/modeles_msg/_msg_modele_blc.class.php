<?php

class msg_modele_blc extends msg_modele{

    function initvars($ref_doc=false){

        if ($ref_doc){
           $this->template->_assign_vars( array("BLC"=>"$ref_doc") );
        }
    }
}

?>