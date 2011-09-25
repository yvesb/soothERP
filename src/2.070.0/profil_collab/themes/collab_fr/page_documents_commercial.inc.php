<?php

// *************************************************************************************************************
// ONGLET DES MARGES DU DOCUMENT
// *************************************************************************************************************

// Variables nécessaires à l'affichage
$page_variables = array ();
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************
$o = 0;
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
?>
<div style="width:100%; ">
	<div style="padding:20px">
		
		<?php 
		if ($_SESSION['user']->check_permission ("17")) {?>
		<br />
		<div class="roundedtable">
		<span class="comm_lib"><span class="bolder">Commerciaux:</span>
		</span>
		<span class="comm_val">&nbsp;
		</span>
		<span class="comm_pc">&nbsp;
		</span>
		<br />
		<form id="documents_commerciaux_attribution" name="documents_commerciaux_attribution" method="post" action="documents_commerciaux_attribution.php?ref_doc=<?php echo $document->getRef_doc();?>" target="formFrame">
		<?php
		$i = 0;
		foreach ($liste_commerciaux as $commercial) {
		 	?>
			<span class="comm_lib">&nbsp;
			</span>
			<span class="comm_val">
				<table style="width:100%">
					<tr>
						<td style="text-align:left">
							<input type="hidden" size="5" id="attrib_ref_commercial_<?php echo $i;?>" name="attrib_ref_commercial_<?php echo $i;?>" value="<?php echo $commercial->ref_contact;?>"/><span class="bolder"><?php echo  $commercial->nom;?> </span>
						</td>
						<td style="width:85px">
							<input type="text" size="5" id="part_<?php echo $i;?>" name="part_<?php echo $i;?>" value="<?php echo $commercial->part;?>" style="text-align:right"/>%
						</td>
					</tr>
				</table>
			</span>
			<br />
			<?php
			$i++;
		} 
		?>
			<span style="display:none" id="add_commercial_part">
			<span class="comm_lib">&nbsp;
			</span>
			<span class="comm_val">
			<table style="width:100%">
				<tr>
					<td>
						<!-- Afficher le moteur de recherche 1°param:id_associé, texte initial input, filtre sur affichage -->
						 <?php echo Helper::createInputAnnu("attrib_ref_commercial_$i","",array("filtres"=>"lib=Commercial")); ?>
					</td>
					<td style="width:85px">
						<input type="text" size="5" id="part_<?php echo $i;?>" name="part_<?php echo $i;?>" value="<?php if (!$i) {echo "100";} else {echo "0";} ?>" style="text-align:right"/>%
					</td>
				</tr>
			</table>
			</span>
			</span>
			<span style="display:" id="unshow_add_comm">
			<span class="comm_lib">&nbsp;
			</span>
			<span class="comm_val">
			<span style="font-weight:bolder; text-decoration:underline; display:; cursor:pointer" id="ajouter_commercial_part">Ajouter un commercial</span>
			<script type="text/javascript">
			Event.observe('ajouter_commercial_part', "click", function(evt){
				Event.stop(evt);
				$("unshow_add_comm").hide();
				$("add_commercial_part").show();
			}, false);
			</script>
			</span>
			</span>
		<span class="marge_pc">
				<input name="modifier_comm_attrib" id="modifier_comm_attrib" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
				
			<script type="text/javascript">
			<?php 
			for ($j=0; $j <= $i; $j++) {
				?>
				Event.observe('part_<?php echo $j;?>', "blur", function(evt){ nummask(evt, 0, "X");
					Event.stop(evt);
					
				}, false);
				<?php
			}
			?>
			Event.observe('modifier_comm_attrib', "click", function(evt){
				Event.stop(evt);
				if (check_document_commerciaux_attribution (<?php echo $i;?>)) {
					$("documents_commerciaux_attribution").submit();
					 
				}
			}, false);
			</script>
		</span>
			<br />
			
		</form>
		</div><br />

		<?php } ?>
	</div>
	
	<script type="text/javascript">
	//on masque le chargement
	H_loading();
	</script>
</div>
