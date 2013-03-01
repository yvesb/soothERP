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
tableau_smenu[1] = Array('communication_mod_export_documents','communication_mod_export_documents.php','true','sub_content', 'Mod&egrave;les d&acute;export de la liste de documents');
update_menu_arbo();
</script>
<div class="emarge">

<p class="titre">Gestion des mod&egrave;les d&acute;export de la liste de documents</p>
<div style="height:50px">
<div class="contactview_corps">
	<table style="width:100%;">
		<tr>
			<td class="titre_config" colspan="4">Ajouter un mod&egrave;le d&acute;export de la liste de documents</td>
		</tr>
		<tr>
			<td>
				<form action="communication_mod_export_documents_add.php" enctype="multipart/form-data" method="POST"  id="communication_mod_export_documents_add" name="communication_mod_export_documents_add" target="formFrame" >
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
					<select name="id_export_modele" id="choix_id_export_documents" class="classinput_xsize">
					<?php 
					foreach ($liste_export_modeles as $export_modele) {
						?>
						<option value="<?php echo $export_modele->id_export_modele;?>"><?php echo $export_modele->lib_modele;?></option>
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
	Modèles disponibles pour l'impression de fiche statistiques : 
        <?php
      //  $export_inactif = 0;
        foreach ($liste_pour_activation as $modele_export) {
                //if ($modele_export->usage == "inactif") { continue;}
        if ($modele_export->usage != "inactif") { 
                ?>
                <table width="100%" border="0">
                        <tr>
                                <td style="width:5%">
                                <input type="radio" name="def_export_<?php echo $modele_export->id_export_modele; ?>" id="def_export_<?php echo $modele_export->id_export_modele; ?>" <?php if ($modele_export->usage == "defaut") {?> checked="checked" <?php } ?> />

                                        <form action="communication_mod_export_documents_def.php" method="post" id="communication_mod_export_documents_def_<?php echo $modele_export->id_export_modele;?>" name="communication_mod_export_documents_def_<?php echo $modele_export->id_export_modele;?>" target="formFrame" >
                                                <input name="id_export_modele" type="hidden" value="<?php echo $modele_export->id_export_modele ?>" />
                                        </form>
                                        <?php if ($modele_export->usage != "defaut") {?>
                                        <script type="text/javascript">
                                 Event.observe('def_export_<?php echo $modele_export->id_export_modele; ?>', "click" , function(evt){
                                        if ($('def_export_<?php echo $modele_export->id_export_modele;?>').checked == true) {
                                                $("communication_mod_export_documents_def_<?php echo $modele_export->id_export_modele;?>").submit();
                                        }
                                 } , false);
                                        </script>
                                        <?php } ?> 
                                </td>
                                <td><?php echo $modele_export->lib_modele;?>
                                <div style="display:none; font-style:italic;" id="desc_export_<?php echo $modele_export->id_export_modele;?>"><?php echo $modele_export->desc_modele;?></div>
                                </td>
                                <td style="width:15%"><span style="text-decoration:underline; cursor:pointer" id="show_desc_<?php echo $modele_export->id_export_modele;?>">Plus d'informations</span></td>
               
                                <td style="width:15%">
                                <?php if ($modele_export->usage != "defaut") {?>
                                        <span id="unactive_export_<?php echo $modele_export->id_export_modele;?>" style="cursor:pointer; text-decoration:underline">Désactiver</span>

                                        <form action="communication_mod_export_documents_des.php" method="post" id="communication_mod_export_documents_des_<?php echo $modele_export->id_export_modele;?>" name="communication_mod_export_documents_des_<?php echo $modele_export->id_export_modele;?>" target="formFrame" >
                                                <input name="id_export_modele" type="hidden" value="<?php echo $modele_export->id_export_modele; ?>" />                       
                                        </form>
                                        <script type="text/javascript">
                                 Event.observe('unactive_export_<?php echo $modele_export->id_export_modele;?>', "click" , function(evt){
                                                $("communication_mod_export_documents_des_<?php echo $modele_export->id_export_modele;?>").submit();
                                 } , false);
                                        </script>
                                <?php } ?>
                                </td>
                        </tr>
                </table>
                <script type="text/javascript">

         Event.observe('show_desc_<?php echo $modele_export->id_export_modele;?>', "click" , function(evt){
                $("desc_export_<?php echo $modele_export->id_export_modele;?>").show();
         } , false);
                </script>
                <?php
        }}
        //if ($export_inactif) {
        ?>
        <span style="cursor:pointer; text-decoration:underline; display:" id="show_export_inactif_<?php echo $modele_export->id_export_modele; ?>">Utiliser un nouveau modèle d'impression.</span><br />
        <div id="more_export_<?php echo $modele_export->id_export_modele ?>" style="display:none;">
        <?php
        foreach ($liste_pour_activation as $modele_export) {
                if ($modele_export->usage == "inactif") {
                ?>
                <table width="100%" border="0">
                        <tr>
                                <td style="width:5%">&nbsp;</td>
                                <td><?php echo $modele_export->lib_modele;?>
                                <div style="display:none; font-style:italic;" id="desc_export_<?php echo $modele_export->id_export_modele;?>"><?php echo $modele_export->desc_modele;?></div>
                                </td>
                                <td style="width:15%"><span style="text-decoration:underline; cursor:pointer" id="show_desc_<?php echo $modele_export->id_export_modele;?>">Plus d'informations</span></td>
                                <!-- <td style="width:15%; color:#999999"><a href="configuration_export_preview.php?id_export_modele=" target="_blank" style="color:#000000">Visualiser</a></td> -->
                                <!-- <td style="width:15%; color:#999999">Paramétrer</td> -->
                                <td style="width:15%">

                                        <span id="active_export_<?php echo $modele_export->id_export_modele;?>" style="cursor:pointer; text-decoration:underline">Activer</span>

                                        <form action="communication_mod_export_documents_act.php" method="post" id="communication_mod_export_documents_act_<?php echo $modele_export->id_export_modele;?>" name="communication_mod_export_documents_act_<?php echo $modele_export->id_export_modele;?>" target="formFrame" >
                                                <input name="id_export_modele" type="hidden" value="<?php echo $modele_export->id_export_modele; ?>" />
                                                <input name="id_export_modele" type="hidden" value="<?php echo $modele_export->id_export_modele; ?>" />
                                                
                                        </form>
                                        <script type="text/javascript">
                                 Event.observe('active_export_<?php echo $modele_export->id_export_modele;?>', "click" , function(evt){
                                     $("communication_mod_export_documents_act_<?php echo $modele_export->id_export_modele;?>").submit();

                                } , false);
                                        </script>
                                </td>
                        </tr>
                </table>
				<script type="text/javascript">

         Event.observe('show_desc_<?php echo $modele_export->id_export_modele;?>', "click" , function(evt){
                $("desc_export_<?php echo $modele_export->id_export_modele;?>").show();
         } , false);
                </script>
				<?php }}?>
                </div>
				</div>
                <?php
        //}}
        ?>
        </div>
        <script type="text/javascript">

         Event.observe('show_export_inactif_<?php echo $modele_export->id_export_modele; ?>', "click" , function(evt){
                $("more_export_<?php echo $modele_export->id_export_modele; ?>").show();
                $("show_export_inactif_<?php echo $modele_export->id_export_modele; ?>").hide();
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