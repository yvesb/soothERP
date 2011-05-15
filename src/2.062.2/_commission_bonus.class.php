<?php
// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR LES JOURNAUX DE BANQUE ET CAISSE
// *************************************************************************************************************


final class commission_bonus {

    public $id_commission_bonus;
    public $ref_commercial;
    public $date_bonus;
    public $lib_bonus;
    public $desc_bonus;
    public $montant;


    public function __construct ($id_commission_bonus = 1) {
        global $bdd;

        $query = "SELECT * FROM commissions_bonus WHERE id_commission_bonus = $id_commission_bonus";

        $resultat = $bdd->query ($query);
        if (!$bonus = $resultat->fetchObject()) {
            return false;
        }

        $this->id_commission_bonus = $bonus->id_commission_bonus;
        $this->ref_commercial	= $bonus->ref_commercial;
        $this->date_bonus	= $bonus->date_bonus;
        $this->lib_bonus = $bonus->lib_bonus;
        $this->desc_bonus	= $bonus->desc_bonus;
        $this->montant     = $bonus->montant;

        return true;
    }


    public function create ($ref_commercial, $lib_bonus, $desc_bonus, $montant) {
        global $bdd;

        $query = "INSERT INTO commissions_bonus
                    (ref_commercial, date_bonus, lib_bonus, desc_bonus, montant)
                    VALUES ('".addslashes($ref_commercial)."', NOW(), '".addslashes($lib_bonus)."', '".addslashes($desc_bonus)."', '".$montant."')";

        $bdd->exec ($query);

        return true;
    }

    public function update ($ref_commercial, $lib_bonus, $desc_bonus, $montant) {
        global $bdd;

        $query = "UPDATE commissions_bonus
                    SET ref_commercial = '".addslashes($ref_commercial)."',
                        lib_bonus = '".addslashes($lib_bonus)."', 
                        desc_bonus = '".addslashes($desc_bonus)."',
                        montant = '".$montant."'
                    WHERE id_commission_bonus = $this->id_commission_bonus";

        $bdd->exec ($query);

        return true;
    }

    public function getComissions($ref_commercial) {
        global $bdd;

        $query = "SELECT * FROM commissions_bonus WHERE ref_commercial = '$ref_commercial'";

        $resultat = $bdd->query($query);
        $retour = array();
        while($tmp = $resultat->fetchObject()) {
            $retour[] = $tmp;
        }

        return $retour;
    }

    public function findBonus($params) {
        global $bdd;

        $query = "SELECT id_commission_bonus, ref_commercial, nom, date_bonus, lib_bonus, montant, desc_bonus
                    FROM commissions_bonus cb
                    JOIN annuaire a ON a.ref_contact = cb.ref_commercial";

        $where = array();
        if(!empty($params["ref_commercial"]))
            $where[] = "ref_commercial = '{$params["ref_commercial"]}'";

        if(!empty($params["date_debut"]) && !empty($params["date_fin"]))
            $where[] = "date_bonus BETWEEN '{$params["date_debut"]}' AND '{$params["date_fin"]}'";

        if(!empty($params["lib_bonus"]))
            $where[] = "lib_bonus = '{$params["lib_bonus"]}'";

        if(!empty($params["montant"]) && isset($params["ecart"])) {
            $min = $params["montant"]-$params["ecart"];
            $max = $params["montant"]+$params["ecart"];
            $where[] = "montant BETWEEN '$min' AND '$max'";
        }

        if(!empty($where))
            $query = $query." WHERE ".implode(" AND ", $where);

        /*if(!empty($params["order"])){
            $query .= " ORDER BY {$params["order"]}";
        }*/

        $resultat = $bdd->query($query);
        $retour = array();
        while($tmp = $resultat->fetchObject()) {
            $retour[] = $tmp;
        }

        return $retour;
    }

// *************************************************************************************************************
// FONCTIONS DE RESTITUTION DES DONNEES 
// *************************************************************************************************************



}
?>