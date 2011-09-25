<?php
// ***************************************************************************************************************
// Decomposition de la date
// ***************************************************************************************************************

function extract_time($time)
{
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
/*Si l'id associé au lien est défini*/
<?php if(isset($_REQUEST['ref_lien'])){?>

/*On recupere la reference du lien*/
ref_lien="<?php echo $_REQUEST['ref_lien'];?>";
<?php }?>

/*On recupere l'id associé à la date*/
ref_date="<?php echo $_REQUEST['ref_date'];?>";
/*On récupère le type de MAJ a faire (1=MAJ, 0=aucune)*/
type_ref="<?php echo $_REQUEST['type_ref'];?>";
</script>

<!--  
// *************************************************************************************************************
// Affichage du calendrier
// *************************************************************************************************************
-->

<table width="200px" border="0" cellpadding="0" cellspacing="0" height="150%">
  <thead>
	  <tr valign="middle" align="center">
	  	<td>
	  		<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/gauche_on.gif" style="cursor:pointer" alt="mois précédent" title="mois précédent" id="mini_calendrier_mois_precedent" />
	  		<script type="text/javascript">
/**********************Mois Precedent*********************/
	  			Event.observe("mini_calendrier_mois_precedent", "click", function(ev) {
						Event.stop(ev);
						<?php 
						//Si pas de reference lien renseignée
						if(!isset($_REQUEST['ref_lien']))
						{ ?>
							page.traitecontent("mini_calendrier", "appercu_calendrier.php?Udate_mini_calendrier=<?php echo strtotime("-1 month", $Udate_mini_calendrier); ?>000&ref_date=<?php echo $_REQUEST['ref_date'];?>&type_ref=<?php echo $_REQUEST['type_ref'];?>", true ,"mini_calendrier");
<?php 					}
						else
						{?>
						page.traitecontent("mini_calendrier", "appercu_calendrier.php?Udate_mini_calendrier=<?php echo strtotime("-1 month", $Udate_mini_calendrier); ?>000&ref_date=<?php echo $_REQUEST['ref_date'];?>&type_ref=<?php echo $_REQUEST['type_ref'];?>&ref_lien=<?php echo $_REQUEST['ref_lien'];?>", true ,"mini_calendrier");
<?php 					}?>
					}, false);
  			</script>
	  	</td>
  		<td colspan="5" class="mini_calendrier_mois"><?php echo ucfirst(lmb_strftime("%B %Y", $INFO_LOCALE, $Udate_mini_calendrier)); ?></td>
  		<td>
  			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme();?>images/droite_on.gif" style="cursor:pointer" alt="mois suivant" title="mois suivant" id="mini_calendrier_mois_suivant" />
  			<script type="text/javascript">
/**********************Mois Suivant*********************/
	  			Event.observe("mini_calendrier_mois_suivant", "click", function(ev) {
						Event.stop(ev);
						<?php 
								//Si pas de reference lien renseignée
								if(!isset($_REQUEST['ref_lien']))
		{
		?>
						page.traitecontent("mini_calendrier", "appercu_calendrier.php?Udate_mini_calendrier=<?php echo strtotime("+1 month", $Udate_mini_calendrier); ?>000&ref_date=<?php echo $_REQUEST['ref_date'];?>&type_ref=<?php echo $_REQUEST['type_ref'];?>", true ,"mini_calendrier");
						<?php 					}
								else
								{?>
								page.traitecontent("mini_calendrier", "appercu_calendrier.php?Udate_mini_calendrier=<?php echo strtotime("+1 month", $Udate_mini_calendrier); ?>000&ref_date=<?php echo $_REQUEST['ref_date'];?>&type_ref=<?php echo $_REQUEST['type_ref'];?>&ref_lien=<?php echo $_REQUEST['ref_lien'];?>", true ,"mini_calendrier");
		<?php 					}?>
					}, false);
  			</script>
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
			while ($Udate_tmp < $Udate_fdm){
				if($j == 5 || $j == 6)//WEEK END 
				{			
					extract_time($Udate_tmp);
					if (!isset($_REQUEST['ref_lien']))
					{ 
					echo strftime('<td class="mini_calendrier_weekend_chiffre_hors_mois"  style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).');" >%d</td>', $Udate_tmp);
					}
					else
					{
						echo strftime('<td class="mini_calendrier_weekend_chiffre_hors_mois"  style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).',ref_lien);" >%d</td>', $Udate_tmp);
					}
				}
				else
				{	
					extract_time($Udate_tmp);
					if (!isset($_REQUEST['ref_lien']))
					{ 
					echo strftime('<td class="mini_calendrier_Jsemaine_chiffre_hors_mois" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).');" >%d</td>', $Udate_tmp);
					}
					else
					{
						echo strftime('<td class="mini_calendrier_Jsemaine_chiffre_hors_mois" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).',ref_lien);" >%d</td>', $Udate_tmp);
					}
				}
				$Udate_tmp = $Udate_tmp + 86400 ;
				$j++;
			}
			
			while ($j < 7) 
			{ 
				if($Udate_tmp <= $Udate_now && $Udate_now <= ($Udate_tmp+86400))//AUJOURD'HUI
				{ 
					extract_time($Udate_tmp);
					if (!isset($_REQUEST['ref_lien']))
					{ 
					echo strftime('<td class="mini_calendrier_now_chiffre" style="width:25px;height:20px;" >%d</td>', $Udate_tmp);
					}
					else
					{
						echo strftime('<td class="mini_calendrier_now_chiffre" style="width:25px;height:20px;" >%d</td>', $Udate_tmp);
					}
                                        if($j==6){
                                            echo "</tr><tr>";$j = -1;}
				}
				elseif($j == 5 || $j == 6)//WEEK END
				{	
					extract_time($Udate_tmp);
					if (!isset($_REQUEST['ref_lien']))
					{ 
					echo strftime('<td class="mini_calendrier_weekend_chiffre"  style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).');" >%d</td>', $Udate_tmp);
					}
					else
					{
						echo strftime('<td class="mini_calendrier_weekend_chiffre"  style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).',ref_lien);" >%d</td>', $Udate_tmp);
					}
                                }
				else
				{	
					extract_time($Udate_tmp);
					if (!isset($_REQUEST['ref_lien']))
					{ 
					echo strftime('<td class="mini_calendrier_Jsemaine_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).');" >%d</td>', $Udate_tmp);
					}
					else
					{
						echo strftime('<td class="mini_calendrier_Jsemaine_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).',ref_lien);" >%d</td>', $Udate_tmp);
					}
					}
				$Udate_tmp = $Udate_tmp + 86400 ;
				$j++;
			}?>
  	</tr>
  	<tr >
			<?php
			$j = 0;
			while ($Udate_tmp < ($Udate_ldm+86399)) 
			{ 
				if($Udate_tmp <= $Udate_now && $Udate_now <= ($Udate_tmp+86400))//AUJOURD'HUI
				{ 
					extract_time($Udate_tmp);
					if (!isset($_REQUEST['ref_lien']))
					{ 
					echo strftime('<td class="mini_calendrier_now_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).');" >%d</td>', $Udate_tmp);
					}
					else
					{
						echo strftime('<td class="mini_calendrier_now_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).',ref_lien);" >%d</td>', $Udate_tmp);
					}
                                        if($j==6){
                                            echo "</tr><tr>";$j = -1;}
				}
				elseif($j == 5)//SAMEDI
				{
					extract_time($Udate_tmp);
					if (!isset($_REQUEST['ref_lien']))
					{ 
					echo strftime('<td class="mini_calendrier_weekend_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).');" >%d</td>', $Udate_tmp);
					}
					else
					{
						echo strftime('<td class="mini_calendrier_weekend_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).',ref_lien);" >%d</td>', $Udate_tmp);
					}
					}
				elseif($j == 6)//DIMANCHE
				{
					extract_time($Udate_tmp);
					if (!isset($_REQUEST['ref_lien']))
					{ 
					echo strftime('<td class="mini_calendrier_weekend_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).');" >%d</td>', $Udate_tmp);
					}
					else
					{
						echo strftime('<td class="mini_calendrier_weekend_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).',ref_lien);" >%d</td>', $Udate_tmp);
					}
					
					echo "</tr><tr>";
					$j = -1; // à cause du $j++ à la fin du while
				}else
				{
					extract_time($Udate_tmp);
					if (!isset($_REQUEST['ref_lien']))
					{ 
					echo strftime('<td class="mini_calendrier_Jsemaine_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).');" >%d</td>', $Udate_tmp);
					}
					else
					{
						echo strftime('<td class="mini_calendrier_Jsemaine_chiffre" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).',ref_lien);" >%d</td>', $Udate_tmp);
					}
					}
				$Udate_tmp = $Udate_tmp + 86400 ;
				$j++;
			}
			while ($j > 0 && $j < 7){
				if($j == 5 || $j == 6)//WEEK END
				{			
					extract_time($Udate_tmp);
					if (!isset($_REQUEST['ref_lien']))
					{ 
					echo strftime('<td class="mini_calendrier_weekend_chiffre_hors_mois" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).');" >%d</td>', $Udate_tmp);
					}
					else
					{
						echo strftime('<td class="mini_calendrier_weekend_chiffre_hors_mois" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).',ref_lien);" >%d</td>', $Udate_tmp);
					}
				}
				else
				{	
					extract_time($Udate_tmp);
					if (!isset($_REQUEST['ref_lien']))
					{ 
					echo strftime('<td class="mini_calendrier_Jsemaine_chiffre_hors_mois" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).');" >%d</td>', $Udate_tmp);
					}
					else
					{
						echo strftime('<td class="mini_calendrier_Jsemaine_chiffre_hors_mois" style="width:25px;height:20px;" onclick="refresh_grille_agenda('.($Udate_tmp).'000,ref_date,type_ref,'.($DAY).','.($MONTH).','.($YEAR).',ref_lien);" >%d</td>', $Udate_tmp);
					}
					}
				$Udate_tmp = $Udate_tmp + 86400 ;
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
