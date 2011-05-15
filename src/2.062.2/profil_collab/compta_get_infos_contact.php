<?php
// *************************************************************************************************************
// journal client
// *************************************************************************************************************


require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");


if (!$_SESSION['user']->check_permission ("12")) {
	//on indique l'interdiction et on stop le script
	echo "<br /><span style=\"font-weight:bolder;color:#FF0000;\">Vos droits  d'accés ne vous permettent pas de visualiser ce type de page</span>";
	exit();
}

$query = "SELECT * FROM annuaire a
            WHERE ref_contact = '".$_REQUEST['ref_contact']."';";

$resultat = $bdd->query ($query);
$infos = array();
while ($tmp = $resultat->fetchObject()) { $infos[] = $tmp; }

$query = "SELECT * FROM pieces_associations pa
            JOIN pieces p ON p.id_piece = pa.id_piece
            WHERE pa.type_objet = 'contact'
            AND p.id_piece_type = 5
            AND ref_objet = '".$_REQUEST['ref_contact']."';";

$resultat = $bdd->query ($query);
$pieces = array();
while ($tmp = $resultat->fetchObject()) { $pieces[] = $tmp; }

$infos['pieces'] = array();
foreach($pieces as $piece){
    $infos['pieces'][] = $piece;
}

$query = "SELECT * FROM comptes_bancaires cb
            WHERE actif = 1
            AND cb.ref_contact = '".$_REQUEST['ref_contact']."';";

$resultat = $bdd->query ($query);
$comptes = array();
while ($tmp = $resultat->fetchObject()) { $comptes[] = $tmp; }

$infos['comptes'] = array();
foreach($comptes as $compte){
    $infos['comptes'][] = $compte;
}

header("Content-type: text/javascript");
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

/*
<infos_contact ref_contact="<?php echo $infos->ref_contact; ?>">
    <nom><?php echo $infos->nom_contact; ?></nom>
    <societe></societe>
    <categorie></categorie>
    <comptes_bancaires>
        <?php foreach($infos['comptes'] as $compte){ ?>
        <compte id="<?php echo $compte->id_compte_bancaire ?>" ref_banque="<?php echo $compte->ref_banque ?>" rib="<?php echo $compte->numero_compte ?>" iban="<?php echo $compte->iban ?>" swift="<?php echo $compte->swift ?>" actif=""><?php echo $compte->lib_compte ?></compte>
        <?php } ?>
    </comptes_bancaires>
    <pieces>
        <?php foreach($infos['pieces'] as $piece){ ?>
        <piece id="<?php echo $piece->id_piece ?>" fichier="<?php echo $piece->fichier ?>" nom="<?php echo $piece->nom ?>" libelle="<?php echo $piece->lib_piece ?>"><?php echo $piece->note ?></piece>
        <?php } ?>
    </pieces>
</infos_contact>
 */
?>
var lib_compte = "";
$("id_compte_src").innerHTML = "";
<?php
foreach($infos['comptes'] as $num=>$compte){
?>
lib_compte = "<?php echo $compte->lib_compte ?> : ";
lib_compte += "<?php echo $compte->iban ?>";
var opt = new Option(lib_compte, "<?php echo $compte->id_compte_bancaire ?>");
$("id_compte_src").appendChild(opt);
<?php } ?>

var firstOpt = $("id_pj_prelev").options[0];
$("id_pj_prelev").innerHTML = "";
$("id_pj_prelev").appendChild(firstOpt);
<?php
foreach($infos['pieces'] as $num=>$piece){
?>
var opt = new Option("<?php echo $piece->nom ?>", "<?php echo $piece->id_piece ?>");
$("id_pj_prelev").appendChild(opt);
<?php } ?>

H_loading();