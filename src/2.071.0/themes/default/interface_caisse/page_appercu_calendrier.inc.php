<?php
// ***************************************************************************************************************
// Decomposition de la date
// ***************************************************************************************************************

function extract_time($time) {
    global $DAY;
    $DAY=strftime("%d",$time);
    global $MONTH;
    $MONTH=strftime("%m",$time);
    global $YEAR;
    $YEAR=strftime("%Y",$time);
}

// *************************************************************************************************************
// Contrôle des paramètres
// *************************************************************************************************************
?>
<script type="text/javascript">
    /*On recupere l'id associé à la date*/
    ref_date = "<?php echo $_REQUEST['ref_date'];?>";
    date_format = "<?php echo $date_format ?>"
 
</script>

<!--  
// *************************************************************************************************************
// Affichage du calendrier
// *************************************************************************************************************
-->

<table width="200px" border="0" cellpadding="0" cellspacing="0" height="150%">
    <thead>
        <tr valign="middle" align="center">
            <td colspan="2">

             <?php if(date("Y-m", $Udate_fdm) != date("Y-m", $date_min)): ?>
                <div id="mini_calendrier_mois_precedent" class="clic">
                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/gauche_on.gif" alt="mois précédent" title="mois précédent" />
                </div>
                <script type="text/javascript">
                    /**********************Mois Precedent*********************/
                    Event.observe("mini_calendrier_mois_precedent", "click", function(ev) {
                        Event.stop(ev);
                        page.traitecontent("mini_calendrier", "appercu_calendrier.php?Udate_mini_calendrier=<?php echo strtotime("-1 month", $Udate_mini_calendrier); ?>000&ref_date=<?php echo $_REQUEST['ref_date'];?>&date_format=<?php echo $date_format;?>&accept_null=<?php echo $_REQUEST['accept_null']?>&date_min=<?php echo $min ?>&date_max=<?php echo $max ?>", true ,"mini_calendrier");
                    }, false);
                </script>
            <?php endif; ?>
            </td>
            <td colspan="3" class="mini_calendrier_mois"><?php echo ucfirst(lmb_strftime("%B %Y", $INFO_LOCALE, $Udate_mini_calendrier)); ?></td>
            <td colspan="2">
              <?php
             
              if(date("Y-m", $Udate_ldm) != date("Y-m", $date_max)): ?>
                <div id="mini_calendrier_mois_suivant" class="clic">
                <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/droite_on.gif" alt="mois suivant" title="mois suivant" />
                </div>
                <script type="text/javascript">
                    /**********************Mois Suivant*********************/
                    Event.observe("mini_calendrier_mois_suivant", "click", function(ev) {
                        Event.stop(ev);
                        page.traitecontent("mini_calendrier", "appercu_calendrier.php?Udate_mini_calendrier=<?php echo strtotime("+1 month", $Udate_mini_calendrier); ?>000&ref_date=<?php echo $_REQUEST['ref_date'];?>&date_format=<?php echo $date_format;?>&accept_null=<?php echo $_REQUEST['accept_null']?>&date_min=<?php echo $min ?>&date_max=<?php echo $max ?>", true ,"mini_calendrier");
                    }, false);
                </script>
                <?php endif; ?>
            </td>
        </tr>
        <!-- Noms des jours de la semaine -->
        <tr height="15px"> <td colspan="3"></td> </tr>
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
            //Jours avant le mois en cours
            while ($Udate_tmp < $Udate_fdm) {
                if($j == 5 || $j == 6)//WEEK END
                {
                    extract_time($Udate_tmp);
                    if($Udate_tmp>$date_min)
                    echo strftime('<td class="mini_calendrier_weekend_chiffre_hors_mois"  style="width:25px;height:20px;" onclick="refresh_grille_agenda(ref_date,new Date('.($YEAR*1).','.($MONTH-1).','.($DAY*1).'),date_format);" >%d</td>', $Udate_tmp);
                    else
                    echo '<td></td>';
                }
                else {
                    extract_time($Udate_tmp);
                    if($Udate_tmp>$date_min)
                    echo strftime('<td class="mini_calendrier_Jsemaine_chiffre_hors_mois" style="width:25px;height:20px;" onclick="refresh_grille_agenda(ref_date,new Date('.($YEAR*1).','.($MONTH-1).','.($DAY*1).'),date_format);" >%d</td>', $Udate_tmp);
                    else
                    echo '<td></td>';

                }
                $Udate_tmp = $Udate_tmp + 86400 ;
                $j++;
            }

            while ($j < 7) {
                if($Udate_tmp <= $Udate_now && $Udate_now <= ($Udate_tmp+86400))//AUJOURD'HUI
                {
                    extract_time($Udate_tmp);
                    echo strftime('<td class="mini_calendrier_now_chiffre" style="width:25px;height:20px;" >%d</td>', $Udate_tmp);
                    if($j==6) {
                        echo "</tr><tr>";
                        $j = -1;
                    }
                }
                elseif($Udate_tmp <= $Udate_selected && $Udate_selected < ($Udate_tmp+86400)){
                    extract_time($Udate_tmp);
                    echo strftime('<td class="mini_calendrier_select_chiffre" style="width:25px;height:20px;" >%d</td>', $Udate_tmp);
                }
                elseif($j == 5 || $j == 6)//WEEK END
                {
                    extract_time($Udate_tmp);
                    echo strftime('<td class="mini_calendrier_weekend_chiffre"  style="width:25px;height:20px;" onclick="refresh_grille_agenda(ref_date,new Date('.($YEAR*1).','.($MONTH-1).','.($DAY*1).'),date_format);" >%d</td>', $Udate_tmp);
                }
                else {
                    extract_time($Udate_tmp);
                    echo strftime('<td class="mini_calendrier_Jsemaine_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda(ref_date,new Date('.($YEAR*1).','.($MONTH-1).','.($DAY*1).'),date_format);" >%d</td>', $Udate_tmp);
                }
                $Udate_tmp = $Udate_tmp + 86400 ;
                $j++;
            }?>
        </tr>
        <tr>
            <?php
            $j = 0;
            while ($Udate_tmp < ($Udate_ldm+10000)) {
                if($Udate_tmp <= $Udate_now && $Udate_now <= ($Udate_tmp+86400))//AUJOURD'HUI
                {
                    extract_time($Udate_tmp);
                    echo strftime('<td class="mini_calendrier_now_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda(ref_date,new Date('.($YEAR*1).','.($MONTH-1).','.($DAY*1).'),date_format);" >%d</td>', $Udate_tmp);
                    if($j==6) {
                        echo "</tr><tr>";
                        $j = -1;
                    }
                }
                elseif($Udate_tmp <= $Udate_selected && $Udate_selected < ($Udate_tmp+86400)){
                    extract_time($Udate_tmp);
                    echo strftime('<td class="mini_calendrier_select_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda(ref_date,new Date('.($YEAR*1).','.($MONTH-1).','.($DAY*1).'),date_format);">%d</td>', $Udate_tmp);
                }
                elseif($j == 5)//SAMEDI
                {
                    extract_time($Udate_tmp);
                    echo strftime('<td class="mini_calendrier_weekend_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda(ref_date,new Date('.($YEAR*1).','.($MONTH-1).','.($DAY*1).'),date_format);" >%d</td>', $Udate_tmp);
                }
                elseif($j == 6)//DIMANCHE
                {
                    extract_time($Udate_tmp);
                    echo strftime('<td class="mini_calendrier_weekend_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda(ref_date,new Date('.($YEAR*1).','.($MONTH-1).','.($DAY*1).'),date_format);" >%d</td>', $Udate_tmp);
                    echo "</tr><tr>";
                    $j = -1; // à cause du $j++ à la fin du while
                }else {
                    extract_time($Udate_tmp);
                    echo strftime('<td class="mini_calendrier_Jsemaine_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda(ref_date,new Date('.($YEAR*1).','.($MONTH-1).','.($DAY*1).'),date_format);" >%d</td>', $Udate_tmp);
                }
                $Udate_tmp = $Udate_tmp + 86400 ;
                $j++;
            }
            while ($j > 0 && $j < 7) {
                if($j == 5 || $j == 6)//WEEK END
                {
                    extract_time($Udate_tmp);
                    if($Udate_tmp<$date_max)
                    echo strftime('<td class="mini_calendrier_weekend_chiffre_hors_mois" style="width:25px;height:20px;" onclick="refresh_grille_agenda(ref_date,new Date('.($YEAR*1).','.($MONTH-1).','.($DAY*1).'),date_format);" >%d</td>', $Udate_tmp);
                    else
                    echo '<td></td>';

                }
                else {
                    
                    extract_time($Udate_tmp);
                    if($Udate_tmp<$date_max)
                    echo strftime('<td class="mini_calendrier_Jsemaine_chiffre_hors_mois" style="width:25px;height:20px;" onclick="refresh_grille_agenda(ref_date,new Date('.($YEAR*1).','.($MONTH-1).','.($DAY*1).'),date_format);" >%d</td>', $Udate_tmp);
                    else
                    echo '<td></td>';

                }
                $Udate_tmp = $Udate_tmp + 86400 ;
                $j++;
            }
            ?>
        </tr>
        <?php if($_REQUEST['accept_null'] == "true"): ?>
        <tr>
            <td></td>
            <td colspan="5"><span class="clic" onclick="refresh_grille_agenda(ref_date,null,date_format);">Ne pas définir de date</span></td>
            <td></td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
<script type="text/javascript">
    //on masque le chargement
    H_loading();
</script>
