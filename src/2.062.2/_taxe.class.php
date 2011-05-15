<?php

// *************************************************************************************************************
// CLASSE REGISSANT LES INFORMATIONS SUR UNE TAXE 
// *************************************************************************************************************


final class taxe {

    private $id_taxe;
    private $lib_taxe;
    private $id_pays;
    private $code_taxe;
    private $info_calcul;

    function __construct($id_taxe = 0) {
        global $bdd;

        // Controle si l'Id_taxe est précisé
        if (!$id_taxe) {
            return false;
        }

        // Sélection des informations générales
        $query = "SELECT id_taxe, lib_taxe, id_pays, code_taxe, info_calcul
						FROM taxes
						WHERE id_taxe = '" . $id_taxe . "' ";
        $resultat = $bdd->query($query);

        // Controle si l'Id_taxe est trouvé
        if (!$taxe = $resultat->fetchObject()) {
            return false;
        }

        // Attribution des informations à l'objet
        $this->id_taxe = $id_taxe;
        $this->lib_taxe = $taxe->lib_taxe;
        $this->id_pays = $taxe->id_pays;
        $this->code_taxe = $taxe->code_taxe;
        $this->info_calcul = $taxe->info_calcul;

        return true;
    }

// *************************************************************************************************************
// FONCTIONS LIEES A LA CREATION D'UNE TAXE 
// *************************************************************************************************************
// Créé un Taux de TVA. Utile uniquement pour les développeur
    final public function create($lib_taxe, $id_pays, $code_taxe, $info_calcul) {
        global $bdd;

        // *************************************************
        // Controle des données transmises
        $this->lib_taxe = $lib_taxe;
        $this->id_pays = $id_pays;
        $this->code_taxe = $code_taxe;
        $this->info_calcul = $info_calcul;

        // *************************************************
        // Si les valeurs reçues sont incorrectes
        if (count($GLOBALS['_ALERTES'])) {
            return false;
        }

        // *************************************************
        // Insertion dans la base
        $query = "INSERT INTO taxes (lib_taxe, id_pays, code_taxe, info_calcul)
						VALUES ('" . addslashes($this->lib_taxe) . "', " . num_or_null($this->id_pays) . ",
										'" . addslashes($this->code_taxe) . "', '" . addslashes($this->info_calcul) . "')";
        $bdd->exec($query);

        // *************************************************
        // Résultat positif de la création
        return true;
    }

// Import d'un taux de TVA depuis la liste principale que nous tenons a jour.
    final public function import($id_taxe, $lib_taxe, $id_pays, $code_taxe, $info_calcul) {
        global $bdd;
        global $DIR;

        // *************************************************
        // Controle des données transmises
        $this->id_taxe = $id_taxe;
        $this->lib_taxe = $lib_taxe;
        $this->id_pays = $id_pays;
        $this->code_taxe = $code_taxe;
        $this->info_calcul = $info_calcul;

        // *************************************************
        // Si les valeurs reçues sont incorrectes
        if (count($GLOBALS['_ALERTES'])) {
            return false;
        }


        // *************************************************
        // Transfert du fichier nécessaire le cas échéant
        $local_taxe_file = $DIR . "taxes/taxe_" . $this->code_taxe . ".inc.php";
        if (!is_file($local_taxe_file)) {
            import_file($local_taxe_file, $distant_taxe_file);
        }

        // *************************************************
        // Insertion dans la base
        $query = "INSERT INTO taxes (id_taxe, lib_taxe, id_pays, code_taxe, info_calcul)
						VALUES (" . num_or_null($this->id_taxe) . ", '" . addslashes($this->lib_taxe) . "', " . num_or_null($this->id_pays) . ",
										'" . addslashes($this->code_taxe) . "', '" . addslashes($this->info_calcul) . "')";
        $bdd->exec($query);


        // *************************************************
        // Résultat positif de la création
        return true;
    }

// *************************************************************************************************************
// FONCTIONS LIEES A LA MODIFICATION D'UNE TAXE
// *************************************************************************************************************

    final public function modification($lib_taxe, $id_pays, $code_taxe, $info_calcul) {
        global $bdd;

        // *************************************************
        // Controle des données transmises
        $this->lib_taxe = $lib_taxe;
        $this->id_pays = $id_pays;
        $this->code_taxe = $code_taxe;
        $this->info_calcul = $info_calcul;

        // *************************************************
        // Si les valeurs reçues sont incorrectes
        if (count($GLOBALS['_ALERTES'])) {
            return false;
        }

        // *************************************************
        // Mise à jour de la base
        $query = "UPDATE taxes
						SET lib_taxe = '" . addslashes($this->lib_taxe) . "', id_pays = '" . $this->id_pays . "',
								code_taxe = '" . addslashes($this->code_taxe) . "', info_calcul = '" . addslashes($this->info_calcul) . "'
						WHERE id_taxe = '" . $this->id_taxe . "' ";
        $bdd->exec($query);

        // *************************************************
        // Résultat positif de la modification
        return true;
    }

//modifiation parametrage de la taxe
    final public function modif_taxe($lib_taxe, $visible) {
        global $bdd;

        $this->$lib_taxe = $lib_taxe;
        $this->$visible = $visible;

        $query = "UPDATE taxes SET lib_taxe = '" . addslashes($this->$lib_taxe) . "', visible = '" . $this->$visible . "'
						  WHERE id_taxe = '" . $this->id_taxe . "' ";
        $bdd->exec($query);

        return true;
    }

    final public function suppression() {
        global $bdd;

        // *************************************************
        // Controle que la taxe n'est pas utilisée
        $query = "SELECT id_taxe FROM art_categs_taxes
						WHERE id_taxe ='" . $this->id_taxe . "' ";
        $resultat = $bdd->query($query);
        // Controle si l'Id_taxe est trouvé
        if ($taxe = $resultat->fetchObject()) {
            $GLOBALS['_ALERTES']['taxe_used'] = 1;
            return false;
        }



        // *************************************************
        // Suppression de l'taxe
        $query = "DELETE FROM taxes
						WHERE id_taxe = '" . $this->id_taxe . "' ";
        $bdd->exec($query);

        unset($this);
    }

// *************************************************************************************************************
// FONCTIONS DE LECTURE DES DONNEES 
// *************************************************************************************************************

       public function calculMontant_taxe(&$article, $info_calcul = ""){
            global $DIR;

            
            if(!is_numeric($info_calcul)){
               $info_calcul = $this->getInfo_calcul();
               if(!is_numeric($info_calcul)){
                   $info_calcul = 0;
               }
            }

            // *************************************************
            // Fichier gérant la taxe
            $taxe_file = $DIR."taxes/taxe_".$this->getCode_taxe().".inc.php";
            if (!is_file($taxe_file)) {
                    $erreur = "Le fichier ".$taxe_file." permettant le calcul du montant de la taxe ".$this->getId_taxe()." n'est pas défini";
                    alerte_dev ($erreur);
            }
            include ($taxe_file);

            // *************************************************
            // Montant de la taxe
            if (!is_numeric($montant_taxe)) {
                    $erreur = "Le calcul du montant de la taxe ".$this->getId_taxe()." ne s'effecue pas correctement.";
                    alerte_dev ($erreur);
            }

            return $montant_taxe;

     }


    function getId_taxe() {
        return $this->id_taxe;
    }

    function getLib_taxe() {
        return $this->lib_taxe;
    }

    function getId_pays() {
        return $this->id_pays;
    }

    function getCode_taxe() {
        return $this->code_taxe;
    }

    function getInfo_calcul() {
        return $this->info_calcul;
    }

}

//liste des taxes du pays 
function taxes_pays($id_pays) {
    global $bdd;

    $query = "SELECT id_taxe, lib_taxe, ta.id_pays, code_taxe, info_calcul, p.pays, visible
						FROM taxes ta
						JOIN pays p ON ta.id_pays=p.id_pays
						WHERE ta.id_pays='" . $id_pays . "'
						ORDER BY lib_taxe ASC";
    $resultat = $bdd->query($query);
    return $resultat->fetchAll();
}

//liste des pays ayant des taxes définies
function defined_taxes_pays() {
    global $bdd;

    $query = "SELECT ta.id_pays, p.pays
						FROM taxes ta	
						JOIN pays p ON ta.id_pays=p.id_pays
						GROUP BY ta.id_pays
						ORDER BY ta.id_pays ASC";
    $resultat = $bdd->query($query);
    return $resultat->fetchAll();
}



?>