<?php

// *************************************************************************************************************
// CONTROLE DU THEME
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
tableau_smenu[0] = Array('smenu_communication', 'smenu_communication.php' ,'true' , 'sub_content', 'Communication');
tableau_smenu[1] = Array('communication_mod_etat_stocks','communication_mod_etat_stocks.php','true','sub_content', 'Mod&egrave;les d\'état de stock');
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Gestion des mod&egrave;les d'état de stock</p>
<div style="height:50px">
<div class="contactview_corps">
	<table style="width:100%;">
		<tr>
			<td class="titre_config" colspan="4">Ajouter un mod&egrave;le d'état de stock</td>
		</tr>
		<tr>
			<td>
				<form action="communication_mod_etat_stocks_add.php" enctype="multipart/form-data" method="POST"  id="communication_mod_etat_stocks_add" name="communication_mod_etat_stocks_add" target="formFrame" >
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width:35%" class="lib_config">Création de ce modèle </td>
				<td style="width:30%">
					à partir d'un modèle existant
				</td>
				<td style="text-align:left"><input type="radio" name="choix_source" id="exist_model" value="1" /></td>
			</tr>
			<tr>
				<td> </td>
				<td>
					à partir des fichiers programme
				</td>
				<td style="text-align:left"><input type="radio" name="choix_source" id="new_model" value="2" /></td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none" id="step2_a">
			<tr>
				<td style="width:35%" class="lib_config">Nouveau nom de ce modèle: </td>
				<td style="width:30%">
					<input type="text" name="lib_modele" id="lib_modele" value="" class="classinput_xsize" />
				</td>
				<td class="infos_config">&nbsp;</td>
			</tr>
			<tr>
				<td class="lib_config">Description de ce modèle: </td>
				<td>
					<textarea name="desc_modele" id="desc_modele" class="classinput_xsize" ></textarea>
				</td>
				<td class="infos_config">&nbsp;</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none" id="step2_b">
			<tr>
				<td style="width:35%" class="lib_config">Modèle source:  </td>
				<td style="width:30%">
					<select name="id_pdf_modele" id="choix_id_pdf_stocks" class="classinput_xsize">
					<?php 
					foreach ($liste_pdf_modeles as $pdf_modele) {
						?>
						<option value="<?php echo $pdf_modele->id_pdf_modele;?>"><?php echo $pdf_modele->lib_modele;?></option>
						<?php
					}
					?>
					</select>
				</td>
				<td></td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none" id="step2_c">
			<tr>
				<td style="width:35%" class="lib_config">Fichiers de programme: </td>
				<td style="width:30%">
					<input type="file" name="file_1" id="file_1" value="" class="classinput_nsize" size="35" />
				</td>
				<td class="infos_config">&nbsp;Indiquez l'emplacement du fichier de configuration</td>
			</tr>
			<tr>
				<td> </td>
				<td>
					<input type="file" name="file_2" id="file_2" value="" class="classinput_nsize" size="35" />
				</td>
				<td class="infos_config">&nbsp;Indiquez l'emplacement du fichier de classe</td>
			</tr>
		</table>

<p style="text-align:center">
	
	
	<input name="ajouter" id="ajouter" type="image" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-ajouter.gif" style="display:none" />
</p>
</form>
				
			</td>
		</tr>
	</table>


<hr />
<?php
if (count($liste_pour_activation)) {
	?>
	Modèles disponibles pour l'impression d'état de stock: 
        <?php
      //  $pdf_inactif = 0;
        foreach ($liste_pour_activation as $modele_pdf) {
                //if ($modele_pdf->usage == "inactif") { continue;}
        if ($modele_pdf->usage != "inactif") { 
                ?>
                <table width="100%" border="0">
                        <tr>
                                <td style="width:5%">
                                <input type="radio" name="def_pdf_<?php echo $modele_pdf->id_pdf_modele; ?>" id="def_pdf_<?php echo $modele_pdf->id_pdf_modele; ?>" <?php if ($modele_pdf->usage == "defaut") {?> checked="checked" <?php } ?> />

                                        <form action="communication_mod_etat_stocks_def.php" method="post" id="communication_mod_etat_stocks_def_<?php echo $modele_pdf->id_pdf_modele;?>" name="communication_mod_etat_stocks_def_<?php echo $modele_pdf->id_pdf_modele;?>" target="formFrame" >
                                                <input name="id_pdf_modele" type="hidden" value="<?php echo $modele_pdf->id_pdf_modele; ?>" />
                                        </form>
                                        <?php if ($modele_pdf->usage != "defaut") {?>
                                        <script type="text/javascript">
                                 Event.observe('def_pdf_<?php echo $modele_pdf->id_pdf_modele; ?>', "click" , function(evt){
                                        if ($('def_pdf_<?php echo $modele_pdf->id_pdf_modele;?>').checked == true) { 
                                                $("communication_mod_etat_stocks_def_<?php echo $modele_pdf->id_pdf_modele;?>").submit();
                                        }
                                 } , false);
                                        </script>
                                        <?php } ?> 
                                </td>
                                <td><?php echo $modele_pdf->lib_modele;?>
                                <div style="display:none; font-style:italic;" id="desc_pdf_<?php echo $modele_pdf->id_pdf_modele;?>"><?php echo $modele_pdf->desc_modele;?></div>
                                </td>
                                <td style="width:15%"><span style="text-decoration:underline; cursor:pointer" id="show_desc_<?php echo $modele_pdf->id_pdf_modele;?>">Plus d'informations</span></td>
               
                                <td style="width:15%">
                                <?php if ($modele_pdf->usage != "defaut") {?>
                                        <span id="unactive_pdf_<?php echo $modele_pdf->id_pdf_modele;?>" style="cursor:pointer; text-decoration:underline">Désactiver</span>

                                        <form action="communication_mod_etat_stocks_des.php" method="post" id="communication_mod_etat_stocks_des_<?php echo $modele_pdf->id_pdf_modele;?>" name="communication_mod_etat_stocks_des_<?php echo $modele_pdf->id_pdf_modele;?>" target="formFrame" >
                                                <input name="id_pdf_modele" type="hidden" value="<?php echo $modele_pdf->id_pdf_modele; ?>" />
                                                
                                        </form>
                                        <script type="text/javascript">
                                 Event.observe('unactive_pdf_<?php echo $modele_pdf->id_pdf_modele;?>', "click" , function(evt){
                                                $("communication_mod_etat_stocks_des_<?php echo $modele_pdf->id_pdf_modele;?>").submit();
                                 } , false);
                                        </script>
                                <?php } ?>
                                </td>
                        </tr>
                </table>
                <script type="text/javascript">

         Event.observe('show_desc_<?php echo $modele_pdf->id_pdf_modele;?>', "click" , function(evt){
                $("desc_pdf_<?php echo $modele_pdf->id_pdf_modele;?>").show();
         } , false);
                </script>
                <?php
        }}
        //if ($pdf_inactif) {
        ?>
        <span style="cursor:pointer; text-decoration:underline; display:" id="show_pdf_inactif">Utiliser un nouveau modèle d'impression.</span><br />
        <div id="more_pdf" style="display:none;">
        <?php
        foreach ($liste_pour_activation as $modele_pdf) {
                if ($modele_pdf->usage == "inactif") {
                ?>
                <table width="100%" border="0">
                        <tr>
                                <td style="width:5%">&nbsp;</td>
                                <td><?php echo $modele_pdf->lib_modele;?>
                                <div style="display:none; font-style:italic;" id="desc_pdf_<?php echo $modele_pdf->id_pdf_modele;?>"><?php echo $modele_pdf->desc_modele;?></div>
                                </td>
                                <td style="width:15%"><span style="text-decoration:underline; cursor:pointer" id="show_desc_<?php echo $modele_pdf->id_pdf_modele;?>">Plus d'informations</span></td>
                                <!-- <td style="width:15%; color:#999999"><a href="configuration_pdf_preview.php" target="_blank" style="color:#000000">Visualiser</a></td> -->
                                <!-- <td style="width:15%; color:#999999">Paramétrer</td> -->
                                <td style="width:15%">

                                        <span id="active_pdf_<?php echo $modele_pdf->id_pdf_modele;?>" style="cursor:pointer; text-decoration:underline">Activer</span>

                                        <form action="communication_mod_etat_stocks_act.php" method="post" id="communication_mod_etat_stocks_act_<?php echo $modele_pdf->id_pdf_modele;?>" name="communication_mod_etat_stocks_act_<?php echo $modele_pdf->id_pdf_modele;?>" target="formFrame" >
                                                <input name="id_pdf_modele" type="hidden" value="<?php echo $modele_pdf->id_pdf_modele; ?>" />
                                                
                                        </form>
                                        <script type="text/javascript">
                                 Event.observe('active_pdf_<?php echo $modele_pdf->id_pdf_modele;?>', "click" , function(evt){
                                <?php 

                                            ?> 
                                        //ouvre_mini_moteur_doc_type();
                                       // charger_param_pdf ("documents_gestion_type_param_pdf.php?id_pdf_modele=<?php //echo $modele_pdf->id_pdf_modele;?>&act=1&id_stock=<?php //echo $modele_pdf->id_stock;?>");
                                        <?php // } else { ?>
                                        $("communication_mod_etat_stocks_act_<?php echo $modele_pdf->id_pdf_modele;?>").submit();
                                        <?php
                                ?>
                                } , false);
                                        </script>
                                </td>
                        </tr>
                </table>
                                <?php
        }}
        ?>
                        </div>
</div>
                <script type="text/javascript">

         Event.observe('show_desc_<?php echo $modele_pdf->id_pdf_modele;?>', "click" , function(evt){
                $("desc_pdf_<?php echo $modele_pdf->id_pdf_modele;?>").show();
         } , false);
                </script>

                <?php
       // }}
        ?>
        </div>
        <script type="text/javascript">
         Event.observe('show_pdf_inactif', "click" , function(evt){
                $("more_pdf").show();
                $("show_pdf_inactif").hide();
         } , false);
        </script>
        <?php
}
?>



<script type="text/javascript">
	Event.observe('exist_model', "click" , function(evt){
	 	$("step2_a").show();
	 	$("step2_b").show();
	 	$("step2_c").hide();
		$("ajouter").show();
	 } , false);
	 Event.observe('new_model', "click" , function(evt){
	 	$("step2_a").show();
	 	$("step2_b").hide();
	 	$("step2_c").show();
		$("ajouter").show();
	 } , false);
	 
//on masque le chargement
H_loading();
</SCRIPT>
</div>