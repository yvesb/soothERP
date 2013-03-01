<?php
// Variables nécessaires à l"affichage
$page_variables = array ();
check_page_variables ($page_variables);


function nb_mois($date1, $date2) {
   list($year1,$month1,$day1) = explode("-",$date1);
   list($year2,$month2,$day2) = explode("-",$date2);
   return (($year2-$year1)*12 + ($month2-$month1));
}
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
$niveau_relance_min = 12;
$niveau_relance_max = 20;
?>
<script type="text/javascript">
infos_niveau_relance = new Array();
array_menu_fnr_niveau	= new Array();

id_niveau_relance = <?php echo $niveau_relance_var; ?>;

<?php
$i = 0;

foreach ($liste_niveaux_relance as $niveau_relance) {
    $niv = intval($niveau_relance->niveau_relance);
    if($niv >= $niveau_relance_min && $niv <= $niveau_relance_max ){
        $relances_menu = get_Factures_pour_niveau_relance($i+1);
            if (count($relances_menu) !=0 ){
            ?>
            infos_niveau_relance[<?php echo $niveau_relance->id_niveau_relance;?>] = "<?php echo htmlentities($niveau_relance->lib_niveau_relance);?>";
            array_menu_fnr_niveau[<?php echo $i;?>] 	=	new Array('menu_recherche_niv', 'menu_niv_<?php echo $i;?>');
<?php }}
$i++;
}

$onglet_select = false;
?>
</script>
<div class="emarge" style="margin-top: 30px">
    <div class="articletview_corps" id="grand_livre_conteneur" >
        <div class="titre" style="margin-top: 10px; margin-left: 10px;" >Factures en contentieux</div>
        
        <ul id="menu_recherche_niv" class="menu">
        <?php
        $i = 0;
        $j = 0;
        foreach ($liste_niveaux_relance as $niveau_relance) {
            $niv = intval($niveau_relance->niveau_relance);
            if($niv >= $niveau_relance_min && $niv <= $niveau_relance_max ){
                $relances_menu = get_Factures_pour_niveau_relance($i+1);
                if (count($relances_menu) !=0 ){
                $compteur_factures= 0;
                foreach($relances_menu as $relance_menu){
                    $compteur_factures += count($relance_menu);
                }
                //_vardump($relances_menu);
                ?>
                <li id="doc_menu_niv_<?php echo $i;?>">
                        <a href="#" id="menu_niv_<?php echo $i;?>" class="menu_<?php if ($i+1 != $niveau_relance_var) {echo "un"; }else {$onglet_select = true;}?>select"> <?php echo htmlentities($niveau_relance->lib_niveau_relance);?> (<?php echo $compteur_factures;?>)</a>
                </li>
                <script type="text/javascript">
                    Event.observe('menu_niv_<?php echo $i;?>', "click", function(evt){
                    //alert('menu_niv_<?php echo $i;?>');
                    view_menu_1('menu_recherche_niv', 'menu_niv_<?php echo $i;?>', array_menu_fnr_niveau);
                    window.parent.page.traitecontent('compta_factures_client_contentieux','compta_factures_client_contentieux.php?niveau_relance_var=<?php echo $i+1; ?>','true','sub_content');
                    Event.stop(evt);
                    });
                </script>
                <?php $j++; }}
                $i++;
        }
        ?>
        </ul>

        <table style="width: 98%;margin-left: 10px;" class="document_box_head">
            <tr>
                <td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:8%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:12%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:8%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
           </tr>
            <tr>
                <td></td>
                <td><strong>Client</strong></td>
                <td style="text-align: center"><strong>Création</strong></td>
                <td style="text-align: center"><strong>Référence</strong></td>
                <td style="text-align: right;padding-right: 6px;"><strong>Montant</strong></td>
                <td></td>
                <td style="text-align: center"><strong>Echéance</strong></td>
                <td></td>
                <td><strong>Mode d'envoi</strong></td>
                <td></td>
            </tr>
        </table>
            <?php foreach ($relances as $client => $clientFacts) { ?>
        <br>
        <table id="tb_relance_<?php echo $client;?>" style="width: 98%;margin-left: 10px;" class="document_box_head">
            <tr>
                <td style="width:2%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:20%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:8%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:12%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:8%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:10%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:5%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
           </tr>
           <tr>
                <td><input type="checkbox"></td>
                <td style="font-weight: bold">
                    <a href="<?php echo $DIR ?>profil_collab/#annuaire_view_fiche.php?ref_contact=<?php echo $client ?>" style="text-decoration:none; color:#000000" target="_blank">
                          <?php global $bdd;
                          $query = "SELECT nom FROM annuaire WHERE ref_contact = '".$client."' ";
                          $retour = $bdd->query($query);
                          if($nom = $retour->fetchObject()){
                            if(strlen($nom->nom) > 22 ){
                                echo "<span title='".$nom->nom."'>".substr($nom->nom,0,19)."...</span>";
                            }else{
                                echo $nom->nom;}
                           }?>
                    </a>
                </td>
                <td colspan="6">
                <table style="width:100%"><?php foreach($clientFacts as $clientFact) { ?>
                <tr>
                    <td style="text-align: center;width:13%;padding-top: 2px;"><?php echo date_Us_to_Fr(substr($clientFact['date_creation'],0,10));?></td>
                    <td style="width:19%">
                        <a href="<?php echo $DIR ?>profil_collab/#documents_edition.php?ref_doc=<?php echo $clientFact['ref_doc'] ?>" style="text-decoration:none; color:#000000" target="_blank">
                        <?php echo "<span style='font-size: 10px;'>".$clientFact['ref_doc']."</span><br><span style='font-size: 10px;'>".$clientFact['etat_doc']."</span><br>"; ?>
                        </a>
                    </td>
                    <td style="text-align: right;padding-right:10px;width:16%;padding-top: 4px;"><?php echo price_format($clientFact['montant'])." ".$MONNAIE[1]; ?></td>
                    <td colspan="3" style="width:52%">
                    <table style="width:100%"><?php foreach($clientFact['echeances'] as $echeance){ ?>
                    <tr>
                    <td style="text-align: center;width:30%"><?php
                                echo date_Us_to_Fr($echeance->date)."<br>";
                                ?></td>
                    <td style="text-align: center;width:45%"><?php
                                if ($echeance->mode_reglement == "")
                                    echo "Au choix du client<br>";
                                else
                                    echo $reglements_modes[$echeance->mode_reglement-1]->lib_reglement_mode."<br>";
                                ?></td>
                    <td style="text-align: right;padding-right: 10px;width:25%"><?php
                                echo price_format($echeance->montant)." ".$MONNAIE[1]."<br>";
                               ?></td>
                    </tr><?php } ?>
                    </table>
                    </td>
                </tr>                
                <?php } ?>
                </table>
                </td>
                <td style="padding-top: 5px;"><select id="slct_edition_<?php echo $client; ?>" name="slct_edition_<?php echo $client; ?>" style="width:100%" ><?php foreach($editions_modes as $edition_mode){ ?>
                <option value="<?php echo $edition_mode->id_edition_mode ?>"><?php echo $edition_mode->lib_edition_mode ?></option><?php }?></select></td>
                <td style="padding-top: 6px;"><input id="bt_ok_<?php echo $client; ?>"  name="bt_ok_<?php echo $client; ?>" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bouton-ok.jpg"/>
                <script type="text/javascript">
                    Event.observe("bt_ok_<?php echo $client; ?>", "click", function(evt){
                            //alert(id_niveau_relance);
                            //$('tb_relance_<?php //echo $client;?>').style.display = "none";
                            envoi_relance('<?php echo $client; ?>',$("slct_edition_<?php echo $client; ?>").value, id_niveau_relance, "contentieux");
                    }, false);
                </script>
                </td>
                </tr>
            </table>
            <?php }
            //_vardump($relances);?>

        <br>
    </div>
</div>

