<?php
// *************************************************************************************************************
// commissionnements des catégories d'articles
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************



// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************

?>
<script type="text/javascript">
</script>
<div class="emarge" style="text-align:left">
<div style=" float:right; text-align:right">
<span id="retour_compta_auto" style="cursor:pointer; text-decoration:underline">Retour aux modes de livraison</span>
<script type="text/javascript">
Event.observe('retour_compta_auto', 'click',  function(evt){
Event.stop(evt); 
page.verify('livraison_modes','livraison_modes.php' ,"true" ,"sub_content");
}, false);
</script>
</div>
<p class="titre">Coûts de livraison associés aux catégories d'articles</p>
<div style="height:50px">
<table class="minimizetable">
<tr>
<td class="contactview_corps">
<div style="padding-left:10px; padding-right:10px">
<br />

	<table>
		<tr style="">
			<td>
			<div style="text-align:right; font-size:16px; padding-right:35px; font-weight:bolder">
			Valeurs par défaut:
			</div>
			</td>
			<td style="text-align:left; font-weight:bolder;  width:50%">
				<span><?php  echo $livraison_article->getLib_article();?></span>
						<div style="border-bottom:1px solid #999999; "></div>
				<?php
				foreach ($livraison_cost as $cost) {
					$fixe = substr($cost->formule, 0, strpos($cost->formule, "+"));
					$variab = substr($cost->formule, strpos($cost->formule, "+")+1);
					$nd=0;
					if ($fixe < 0 && $variab <0) {$nd = 1; $fixe = 0; $variab = 0 ;}
					
					if ($nd) {
						?>
						<?php echo $BASE_CALCUL_LIVRAISON[$cost->base_calcul][0];?> >= <?php echo $cost->indice_min;?> <?php echo $BASE_CALCUL_LIVRAISON[$cost->base_calcul][1];?> <br />
						Non disponible.
						<div style="border-bottom:1px solid #999999; "></div>
						<?php 
					} else {
						?>
						<?php echo $BASE_CALCUL_LIVRAISON[$cost->base_calcul][0];?> >= <?php echo $cost->indice_min;?> <?php echo $BASE_CALCUL_LIVRAISON[$cost->base_calcul][1];?> <br />
						Coût = <?php echo $fixe;?> + <?php echo $variab;?> x <?php echo $BASE_CALCUL_LIVRAISON[$cost->base_calcul][0];?> 
						<div style="border-bottom:1px solid #999999; "></div>
						<?php 
					}
				}
				?>
			</td>
			<td>&nbsp;
			</td>
		</tr>
		<tr style=" ">
			<td  style="border-bottom:1px solid #333333">&nbsp;
			</td>
			<td  style="border-bottom:1px solid #333333">&nbsp;
			</td>
		</tr>
		<?php
		foreach ($fiches as $fiche){
			?>
			<tr id="line_comm_art_categ_<?php echo $fiche->ref_art_categ;?>">
				<td style=" border-bottom:1px solid #FFFFFF">
					<span><?php echo $fiche->lib_art_categ;?></span>
				</td>
				<td style="text-align:center; border-bottom:1px solid #FFFFFF;">
					<div id="mode_liv_cost_<?php echo $fiche->ref_art_categ;?>">
						<?php if (!count($fiche->livraisons_tarifs)) { ?>
							<div id="more_mode_liv_<?php echo $fiche->ref_art_categ;?>" style="cursor:pointer; display:inherit"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ajouter.gif" /> Définir </div>
							
							<script type="text/javascript">
							Event.observe('more_mode_liv_<?php echo $fiche->ref_art_categ;?>', 'click',  function(){
								page.traitecontent('livraison_modes_cost_art_categ_det','livraison_modes_cost_art_categ_det.php?id_livraison_mode=<?php echo $livraison_mode->getId_livraison_mode();?>&ref_art_categ=<?php echo $fiche->ref_art_categ;?>' ,"true" ,"mode_liv_cost_<?php echo $fiche->ref_art_categ;?>");
							}, false);
							</script>
						<?php } else { 
							include $DIR.$_SESSION['theme']->getDir_theme()."page_livraison_modes_cost_art_categ_det.inc.php";
						} ?>
					</div>
				</td>
				<td>&nbsp;
				</td>
			</tr>
			<?php
		}
		?>
	</table>

</div>
</td>
</tr>
</table>
<SCRIPT type="text/javascript">

//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>