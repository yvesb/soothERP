<?php
// *************************************************************************************************************
// ACCUEIL DU PROFIL COLLAB
// *************************************************************************************************************
// Variables nécessaires à l'affichage
$page_variables = array("Udate_mini_calendrier", "Udate_fdm", "Udate_ldm", "Udate_first_monday", "Udate_now");
check_page_variables($page_variables);

//******************************************************************
// Variables communes d'affichage
//******************************************************************
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>

<table style="width:99%" border="0" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <!--td id="mini_calendrier_aujourd_hui" class="clic" colspan="7">
                <div style="margin:5px 10px;text-align: center;" class="agenda_element panneau_agendas_enable_text"><?php echo langage::write("aujourd_hui") ?></div>
                <script type="text/javascript">
                    /*Event.observe("mini_calendrier_aujourd_hui", "click", function(ev){
                        Event.stop(ev);
                        var d = new Date();
                        refresh_grille_agenda(d.getTime());
                        page.traitecontent("mini_calendrier", "mini_calendrier.php?Udate_mini_calendrier=<?php echo time(); ?>000", true ,"mini_calendrier");
                    });*/
                </script>
            </td-->
        </tr>
        <tr valign="middle" align="center">
            <td>
                <img src="<?php echo $THIS_DIR . langage::image('gray_left.gif') ?>" style="cursor:pointer" alt="mois précédent" title="mois précédent" id="mini_calendrier_mois_precedent" />
                <script type="text/javascript">
                    Event.observe("mini_calendrier_mois_precedent", "click", function(ev) {
                        Event.stop(ev);
                        page.traitecontent("mini_calendrier", "mini_calendrier.php?Udate_mini_calendrier=<?php echo strtotime("-1 month", $Udate_mini_calendrier); ?>000", true ,"mini_calendrier");
                    }, false);
                </script>
            </td>
            <td colspan="5" class="mini_calendrier_mois"><?php echo ucfirst(lmb_strftime("%B %Y", $INFO_LOCALE, $Udate_mini_calendrier)); ?></td>
            <td>
                <img src="<?php echo $THIS_DIR . langage::image('gray_right.gif') ?>" style="cursor:pointer" alt="mois suivant" title="mois suivant" id="mini_calendrier_mois_suivant" />
                <script type="text/javascript">
                    Event.observe("mini_calendrier_mois_suivant", "click", function(ev) {
                        Event.stop(ev);
                        page.traitecontent("mini_calendrier", "mini_calendrier.php?Udate_mini_calendrier=<?php echo strtotime("+1 month", $Udate_mini_calendrier); ?>000", true ,"mini_calendrier");
                    }, false);
                </script>
            </td>
        </tr>
        <tr> <td style="height: 10px" colspan="3"></td> </tr>
        <tr>
            <th class="mini_calendrier_Jsemaine">Lun</th>
            <th class="mini_calendrier_Jsemaine">Mar</th>
            <th class="mini_calendrier_Jsemaine">Mer</th>
            <th class="mini_calendrier_Jsemaine">Jeu</th>
            <th class="mini_calendrier_Jsemaine">Ven</th>
            <th class="mini_calendrier_weekend" >Sam</th>
            <th class="mini_calendrier_weekend" >Dim</th>
        </tr>
    </thead>
    <tbody>
        <tr>
<?php
$j = 0;
$Udate_tmp = $Udate_first_monday;
while ($Udate_tmp < $Udate_fdm) {
    if ($j == 5 || $j == 6) {//WEEK END
        echo strftime('<td class="mini_calendrier_weekend_chiffre_hors_mois"  onclick="refresh_grille_agenda(' . ($Udate_tmp) . '000);" >%d</td>', $Udate_tmp);
    } else {
        echo strftime('<td class="mini_calendrier_Jsemaine_chiffre_hors_mois" onclick="refresh_grille_agenda(' . ($Udate_tmp) . '000);" >%d</td>', $Udate_tmp);
    }
    $Udate_tmp = $Udate_tmp + 86400;
    $j++;
}
while ($j < 7) {
    if ($Udate_tmp <= $Udate_now && $Udate_now <= ($Udate_tmp + 86400)) { //AUJOURD'HUI
        echo strftime("<td class='mini_calendrier_now_chiffre'>%d</td>", $Udate_tmp);
        if ($j == 6) {
            echo "</tr><tr>";
            $j = -1;
        }
    } elseif ($j == 5 || $j == 6) {//WEEK END
        echo strftime('<td class="mini_calendrier_weekend_chiffre"  onclick="refresh_grille_agenda(' . ($Udate_tmp) . '000);" >%d</td>', $Udate_tmp);
    } else {
        echo strftime('<td class="mini_calendrier_Jsemaine_chiffre" onclick="refresh_grille_agenda(' . ($Udate_tmp) . '000);" >%d</td>', $Udate_tmp);
    }
    $Udate_tmp = $Udate_tmp + 86400;
    $j++;
}
?>
        </tr>
        <tr>
            <?php
            $j = 0;
            while ($Udate_tmp < ($Udate_ldm + 10000)) { // +10000 sert à ajouter quelques secondes pour rentrer dans la journée
                if ($Udate_tmp <= $Udate_now && $Udate_now <= ($Udate_tmp + 86400)) { //AUJOURD'HUI
                    echo strftime('<td class="mini_calendrier_now_chiffre"     onclick="refresh_grille_agenda(' . ($Udate_tmp) . '000);" >%d</td>', $Udate_tmp);
                    if ($j == 6) {
                        echo "</tr><tr>";
                        $j = -1;
                    }
                } elseif ($j == 5) {//SAMDEDI
                    echo strftime('<td class="mini_calendrier_weekend_chiffre" onclick="refresh_grille_agenda(' . ($Udate_tmp) . '000);" >%d</td>', $Udate_tmp);
                } elseif ($j == 6) {//DIMANCHE
                    echo strftime('<td class="mini_calendrier_weekend_chiffre" onclick="refresh_grille_agenda(' . ($Udate_tmp) . '000);" >%d</td>', $Udate_tmp);
                    echo "</tr><tr>";
                    $j = -1; // à cause du $j++ à la fin du while
                } else {
                    echo strftime('<td class="mini_calendrier_Jsemaine_chiffre" onclick="refresh_grille_agenda(' . ($Udate_tmp) . '000);" >%d</td>', $Udate_tmp);
                }
                $Udate_tmp = $Udate_tmp + 86400;
                $j++;
            }
            while ($j > 0 && $j < 7) {
                if ($j == 5 || $j == 6) {//WEEK END
                    echo strftime('<td class="mini_calendrier_weekend_chiffre_hors_mois"  onclick="refresh_grille_agenda(' . ($Udate_tmp) . '000);" >%d</td>', $Udate_tmp);
                } else {
                    echo strftime('<td class="mini_calendrier_Jsemaine_chiffre_hors_mois" onclick="refresh_grille_agenda(' . ($Udate_tmp) . '000);" >%d</td>', $Udate_tmp);
                }
                $Udate_tmp = $Udate_tmp + 86400;
                $j++;
            }
            ?>
        </tr>
    </tbody>
</table>
<SCRIPT type="text/javascript">
    //on masque le chargement
    H_loading();
</SCRIPT>
