<?php

require ("_dir.inc.php");
require ("_profil.inc.php");
require ($DIR."_session.inc.php");



if ( isset($_REQUEST["old_niveau"]) && isset($_REQUEST["new_niveau"]) ){
    _vardump($_REQUEST);
    echo "Yeepee!";
    $id_old_niveau = $_REQUEST["old_niveau"];
    $id_new_niveau = $_REQUEST["new_niveau"];
    
    $query = "UPDATE doc_fac SET id_niveau_relance = $id_new_niveau WHERE id_niveau_relance = $id_old_niveau;";
    $bdd->exec($query);
    $query = "DELETE FROM factures_niveaux_relances WHERE id_niveau_relance = $id_old_niveau;";
    $bdd->exec($query);

    ?>
    <script type="text/javascript">
    window.parent.page.traitecontent('transition_niveau_relance','_transition_niveau_relance.php','true','sub_content');
    </script>
    <?php

}else{

$old_niveaux = array();
$new_niveaux = array();

$query = "SELECT * FROM factures_niveaux_relances fnr LEFT JOIN clients_categories cc ON fnr.id_client_categ=cc.id_client_categ;";
$resultat = $bdd->query($query);
while ($res = $resultat->fetchObject()){
    $old_niveaux[] = $res;
}

$query = "SELECT * FROM factures_relances_niveaux frn LEFT JOIN factures_relances_modeles frm ON frn.id_relance_modele=frm.id_relance_modele WHERE frn.id_relance_modele IS NOT NULL;";
$resultat = $bdd->query($query);
while ($res = $resultat->fetchObject()){
    $new_niveaux[] = $res;
}
if (count($old_niveaux)>0){
echo "Choisissez un ancien niveau de relance a gauche, pour le faire correspondre avec l'un des nouveaux, a droite :<BR/><BR/>";

?>
<form action="_transition_niveau_relance.php" target="formFrame">
<table>
    <TR>
        <td>Anciens niveaux de relance</td><td>Nouveaux niveaux de relance</td><td></td>
    </TR>
    <TR>
        <td>
            <SELECT name="old_niveau" id="old_niveau">
            <?php
            foreach ($old_niveaux as $niveau){
                ?>
                <OPTION id="<?php echo $niveau->id_niveau_relance?>" value="<?php echo $niveau->id_niveau_relance?>"><?php echo $niveau->lib_niveau_relance?> - <?php echo $niveau->lib_client_categ?></OPTION>
                <?php
            }
            ?>
            </SELECT>
        </td>
        <td>
            <SELECT name="new_niveau" id="new_niveau">
            <?php
            foreach ($new_niveaux as $niveau){
                ?>
                <OPTION id="<?php echo $niveau->id_niveau_relance?>" value="<?php echo $niveau->id_niveau_relance?>"><?php echo $niveau->lib_niveau_relance?> - <?php echo $niveau->lib_relance_modele?></OPTION>
                <?php
            }
            ?>
            </SELECT>
        </td>
        <td><INPUT name="action" type="submit" value="Confirmer"</td>
    </TR>
</table>
</form>
<?php
}
}
?>
