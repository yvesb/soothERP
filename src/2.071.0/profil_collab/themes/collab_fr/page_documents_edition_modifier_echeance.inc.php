
<?php

// *************************************************************************************************************
// FUSION DE DOCUMENT
// *************************************************************************************************************

// Variables nécessaires Ã  l'affichage
$page_variables = array ("_ALERTES");
check_page_variables ($page_variables);


//******************************************************************
// Variables communes d'affichage
//******************************************************************

global $bdd;
$query = "SELECT `id_reglement_mode`, `lib_reglement_mode` FROM `reglements_modes`";
$retour = $bdd->query($query);
$reglements = Array();
while($res = $retour->fetchObject()){
	$reglements[$res->id_reglement_mode] = $res->lib_reglement_mode;
}
$echeancier_doc = array();
$query = "SELECT `montant`, `pourcentage`, `id_mode_reglement`, DATE_FORMAT(`date`,'%d/%m/%Y') date, `jour`, `type_reglement` FROM `doc_echeanciers` WHERE `ref_doc` = '".$ref_doc."' ORDER BY id_doc_echeance";
$retour = $bdd->query($query);
if($res = $retour->fetchObject()){
        $echeancier_doc[] = $res;
}
$facture = open_doc($ref_doc);
$date_creation = str_replace('-','/',date_Us_to_Fr ($facture->getDate_creation ()));
$echeances = $facture->getEcheancier();
//_vardump($echeances);
// *************************************************************************************************************
// AFFICHAGE
// *************************************************************************************************************
//echo $_REQUEST['desc_courte'];
?>
<input name="sortir" id="sortir" type="image" style="position:absolute;right:10px" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" />
<input name="valider" id="valider" type="image" style="position:absolute;bottom:30px;left:45%;" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-valider.gif" />
<div style="text-align:center; background-color:#809eb6; width : 97% " class="doc_bold2">Edition de l'échéancier</div>
<div style="height:5px">&nbsp;</div>
<div style="position:absolute;right:30px;top:40px;">
    Choix du modele d'échéancier :
    <select style="width:150px;" id="slct_modele_ech">
        <option value=""></option>
        <?php foreach($modeles as $modele){ ?>
        <option value="<?php echo $modele->id_echeancier_modele?>"><?php echo $modele->lib_echeancier_modele?></option>
        <?php }?>
    </select>
</div>
<div id="id_body" onclick="close_mini_calendrier();refairecalculs(divToRefrsh,'<?php echo $date_creation ?>' );" style="position:fixed;left:-110px;top:10px">
</div>
<table style="width:100%;">
        <tr class="smallheight">
                <td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:60%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
                <td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
        </tr>
        <tr>
        <td style="text-align:right">Montant total du document :
        </td>
        <td>
            <div name="montant_tot" id="montant_tot" > <strong> <?php echo price_format($facture->getMontant_ttc())." ".$MONNAIE[1];?> </strong></div>
        </td>
        <td>&nbsp;</td>
        </tr>
        <tr>
        <td style="text-align:right">Nombre de règlements :
        </td>
        <td>
            <input name="nb_reglements" id="nb_reglements" type="text" value="" onfocus="$('valider_nb_reg').style.display = '';" class="classinput_xsize" style="width:20px" MAXLENGTH="2"/>
                &nbsp;&nbsp;&nbsp; <img id="valider_nb_reg" name="valider_nb_reg" style="cursor:pointer" onclick="this.style.display='none';" src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-continuer.gif" />
                <script type="text/javascript">
                Event.observe('nb_reglements', 'keypress',  function(evt){
                        if (evt.keyCode == 13){
                                Event.stop(evt);
                                this.blur();
                        }
                },false);
                Event.observe('nb_reglements', 'change',  function(){
                        $('valider_nb_reg').style.display = 'none';
                        $("tr_lignes_reglement").style.display = "block";
                        $("valider").style.display = "block";
                        $('slct_modele_ech').value = "";
                        $('div_lignes_reglement').style.display = "block";
                        $("div_lignes_reglement_modeles").style.display = "none";
                        <?php foreach($modeles as $modele){
                        $modele_echeancier = new modele_echeancier($modele->id_echeancier_modele);?>
                                $("div_lignes_reglement_<?php echo $modele_echeancier->getId_echeancier_modele();?>").style.display = "none";
                        <?php } ?>
                        i=1;
                        strlignetot = '<table id="tb_liste_regl" name="tb_liste_regl">'+
                        '<tr class="smallheight">'+
                        '<td style="width:25%"><strong>Echéance</strong></td>'+
                        '<td style="width:20%;text-align:center"><strong>Type d\'échéance</strong></td>'+
                        '<td style="width:20%;text-align:center"><strong>Mode de règlement</strong></td>'+
                        '<td style="width:20%;text-align:center"><strong><a href="#" id="lien_delai" onclick="toggleDisplay(\'inp_delai\',\'inp_date\');" >Délai</a> / <a href="#" id="lien_date" onclick="toggleDisplay(\'inp_date\',\'inp_delai\');" >Date</a></strong></td>'+
                        '<td style="width:15%;text-align:center"><strong><a href="#" id="lien_pourcent">%</a> / <a href="#" id="lien_euro"><?php echo $MONNAIE[1];?></a></strong></td>'+
                        '</tr>';
                    <?php if(!empty($ref_doc))
                        {
                            $document = open_doc($ref_doc);
                            //Récupération du contact
                            if(!empty($document)){

                                $contact_document = $document->getRef_contact();
                                $contact = new contact($contact_document);
                                //Récupération du mode préféré de paiement
                                if(!empty($contact))
                                {
                                    $profils = $contact->getProfils ();
                                    if(!empty($profils[4]))
                                    {
                                        $id_reglement_mode_favori = $profils[4]->getId_reglement_mode_favori (false);
                                        
                                        //Si pas de mode de reglement favori trouvé on va dans la categ
                                        if(empty($id_reglement_mode_favori))
                                        {
                                            $id_client_categ = $contact->getId_Categorie();
                                            //Charger la liste des catégories de client
                                            $liste_categories_client = contact_client::charger_clients_categories ();
                                            if(!empty($id_client_categ) && !empty($id_client_categ))
                                            {
                                                foreach ($liste_categories_client as $liste_categorie_client)
                                                {	if ( $id_client_categ == $liste_categorie_client->id_client_categ )
                                                        {
                                                                $categorie_client = $liste_categorie_client;
                                                        }
                                                }
                                                
                                                if(!empty($categorie_client)){
                                                    $id_reglement_mode_favori = $categorie_client->id_reglement_mode_favori;
                                                }

                                                //Si on a pas de reglement favoris alors on met choix du client
                                                if(empty($id_reglement_mode_favori))
                                                {
                                                    //rien
                                                }
                                                
                                            }
                                            
                                        }
                                    }
                                    

                                }
                                

                            }
                        }
                        
                             if(!empty($id_reglement_mode_favori))
                            {?>
                                str_mode_regl_select = '<option value="">Au choix du client</option><?php foreach ($reglements_modes as $reglement_mode) {?><option value="<?php echo $reglement_mode->id_reglement_mode; ?>" <?php if($reglement_mode->id_reglement_mode == $id_reglement_mode_favori){?>selected="selected"<?php }?> ><?php echo htmlentities($reglement_mode->lib_reglement_mode); ?></option><?php } ?>';
                           <?php  
                           }else
                           {?>
                               str_mode_regl_select = '<option value="">Au choix du client</option><?php foreach ($reglements_modes as $reglement_mode) {?><option value="<?php echo $reglement_mode->id_reglement_mode; ?>"><?php echo htmlentities($reglement_mode->lib_reglement_mode); ?></option><?php } ?>';
                        <?php    }?>
                        nbregl = parseInt(this.value);
                        this.value = parseInt(this.value);
                        if(nbregl>0){
                                if(nbregl>1){
                                        for(i=1;i<=nbregl;i++){
                                                if(i==nbregl){
                                                        strligne = '<tr>'+
                                                        '<td>'+ i +'<sup>e</sup> échéance : </td>'+
                                                        '<td style="text-align:center"><select name="slct_type_'+i+'" id="slct_type_'+i+'" style="width:100px"><option value="4">Solde</option></select></td>'+
                                                        '<td style="text-align:center"><select name="slct_mode_'+i+'" id="slct_mode_'+i+'" style="width:160px">'+str_mode_regl_select+'</select></td>'+
                                                        '<td style="text-align:center" name="inp_delai" ><input name="inp_delai_'+i+'" id="inp_delai_'+i+'" type="text" value="" onchange="maj_date(this.value,\'<?php echo $date_creation ?>\',\'inp_date_'+i+'\');" class="classinput_xsize" style="width:30px;text-align:right;" MAXLENGTH="3"/> jours</td>'+
                                                        '<td style="text-align:center;display:none" name="inp_date"><input id="inp_date_'+i+'" type="text" value="" onchange="datemaskslash2(this);maj_jour(this.value,\'<?php echo $date_creation ?>\',\'inp_delai_'+i+'\');" class="classinput_xsize" style="width:70px" MAXLENGTH="10"/>'+
                                                        '   <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/calendrier.gif" onclick="create_div(event,\'inp_date_'+i+'\',0);divToRefrsh=\'inp_date_'+i+'\';"/>'+
                                                        '</td>'+
                                                        '<td style="text-align:center" name="inp_montant" ><input name="inp_montant_'+i+'" id="inp_montant_'+i+'" type="text" value="" class="classinput_xsize" style="width:50px;text-align:right;" MAXLENGTH="3" readonly="readonly" /> %</td>'+
                                                        '<td style="text-align:center;display:none" name="inp_euro"><input name="inp_euro_'+i+'" id="inp_euro_'+i+'" type="text" value="" onKeyUp="" class="classinput_xsize" style="width:50px;text-align:right;" MAXLENGTH="5"/> <?php echo $MONNAIE[1];?></td>'+
                                                        '</tr>';
                                                }
                                                else{
                                                        if(i==1){
                                                                strligne = '<tr>'+
                                                                '<td>'+ i +'<sup>e</sup> échéance : </td>'+
                                                                '<td style="text-align:center"><select name="slct_type_'+i+'" id="slct_type_'+i+'" style="width:100px"><option value="1">Acompte</option><option value="2">Arrhes</option><option value="3">Echeance</option></select></td>'+
                                                                '<td style="text-align:center"><select name="slct_mode_'+i+'" id="slct_mode_'+i+'" style="width:160px">'+str_mode_regl_select+'</select></td>'+
                                                                '<td style="text-align:center" name="inp_delai" ><input name="inp_delai_'+i+'" id="inp_delai_'+i+'" type="text" value="" onchange="maj_date(this.value,\'<?php echo $date_creation ?>\',\'inp_date_'+i+'\');" class="classinput_xsize" style="width:30px;text-align:right;" MAXLENGTH="3"/> jours</td>'+
                                                                '<td style="text-align:center;display:none" name="inp_date"><input id="inp_date_'+i+'" type="text" value="" onchange="datemaskslash2(this);maj_jour(this.value,\'<?php echo $date_creation ?>\',\'inp_delai_'+i+'\');" class="classinput_xsize" style="width:70px" MAXLENGTH="10"/>'+
                                                                '   <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/calendrier.gif" onclick="create_div(event,\'inp_date_'+i+'\',0);divToRefrsh=\'inp_date_'+i+'\';"/>'+
                                                                '</td>'+
                                                                '<td style="text-align:center" name="inp_montant" ><input name="inp_montant_'+i+'" id="inp_montant_'+i+'" type="text" value="" onKeyUp="maj_mnt_solde(\'div_lignes_reglement\','+nbregl+');" onchange="majMontant(<?php echo $facture->getMontant_ttc() ?>,this.value,\'inp_euro_'+i+'\',\'div_lignes_reglement\','+nbregl+')" class="classinput_xsize" style="width:50px;text-align:right;" MAXLENGTH="3"/> %</td>'+
                                                                '<td style="text-align:center;display:none" name="inp_euro"><input name="inp_euro_'+i+'" id="inp_euro_'+i+'" type="text" value="" onKeyUp="maj_euro_solde(\'div_lignes_reglement\','+nbregl+', <?php echo $facture->getMontant_ttc() ?>)"  class="classinput_xsize" style="width:50px;text-align:right;" MAXLENGTH="5"/> <?php echo $MONNAIE[1];?></td>'+
                                                                '</tr>';
                                                        }else{
                                                                strligne = '<tr>'+
                                                                '<td>'+ i +'<sup>e</sup> échéance : </td>'+
                                                                '<td style="text-align:center"><select name="slct_type_'+i+'" id="slct_type_'+i+'" style="width:100px"><option value="3">Echeance</option></select></td>'+
                                                                '<td style="text-align:center"><select name="slct_mode_'+i+'" id="slct_mode_'+i+'" style="width:160px">'+str_mode_regl_select+'</select></td>'+
                                                                '<td style="text-align:center" name="inp_delai" ><input name="inp_delai_'+i+'" id="inp_delai_'+i+'" type="text" value="" onchange="maj_date(this.value,\'<?php echo $date_creation ?>\',\'inp_date_'+i+'\');" class="classinput_xsize" style="width:30px;text-align:right;" MAXLENGTH="3"/> jours</td>'+
                                                                '<td style="text-align:center;display:none" name="inp_date"><input id="inp_date_'+i+'" type="text" value="" onchange="datemaskslash2(this);maj_jour(this.value,\'<?php echo $date_creation ?>\',\'inp_delai_'+i+'\');" class="classinput_xsize" style="width:70px" MAXLENGTH="10"/>'+
                                                                '   <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/calendrier.gif" onclick="create_div(event,\'inp_date_'+i+'\',0);divToRefrsh=\'inp_date_'+i+'\';"/>'+
                                                                '</td>'+
                                                                '<td style="text-align:center" name="inp_montant" ><input name="inp_montant_'+i+'" id="inp_montant_'+i+'" type="text" value="" onKeyUp="maj_mnt_solde(\'div_lignes_reglement\','+nbregl+');" onchange="majMontant(<?php echo $facture->getMontant_ttc() ?>,this.value,\'inp_euro_'+i+'\',\'div_lignes_reglement\','+nbregl+')" class="classinput_xsize" style="width:50px;text-align:right;" MAXLENGTH="3"/> %</td>'+
                                                                '<td style="text-align:center;display:none" name="inp_euro"><input name="inp_euro_'+i+'" id="inp_euro_'+i+'" type="text" value="" onKeyUp="maj_euro_solde(\'div_lignes_reglement\','+nbregl+', <?php echo $facture->getMontant_ttc() ?>)"  class="classinput_xsize" style="width:50px;text-align:right;" MAXLENGTH="5"/> <?php echo $MONNAIE[1];?></td>'+
                                                                '</tr>';
                                                        }
                                                }
                                                strlignetot += strligne;
                                        }
                                }else{
                                        strlignetot += '<tr>'+
                                        '<td>1<sup>e</sup> échéance : </td>'+
                                        '<td style="text-align:center"><select name="slct_type_'+i+'" id="slct_type_'+i+'" style="width:100px"><option value="1">Acompte</option><option value="2">Arrhes</option><option value="4">Solde</option></select></td>'+
                                        '<td style="text-align:center"><select name="slct_mode_'+i+'" id="slct_mode_'+i+'" style="width:160px">'+str_mode_regl_select+'</select></td>'+
                                        '<td style="text-align:center" name="inp_delai" ><input name="inp_delai_'+i+'" id="inp_delai_'+i+'" type="text" value="" onchange="maj_date(this.value,\'<?php echo $date_creation ?>\',\'inp_date_'+i+'\');" class="classinput_xsize" style="width:30px;text-align:right;" MAXLENGTH="3"/> jours</td>'+
                                        '<td style="text-align:center;display:none" name="inp_date"><input id="inp_date_'+i+'" type="text" value="" onchange="datemaskslash2(this);maj_jour(this.value,\'<?php echo $date_creation ?>\',\'inp_delai_'+i+'\');" class="classinput_xsize" style="width:70px" MAXLENGTH="10"/>'+
                                        '   <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/calendrier.gif" onclick="create_div(event,\'inp_date_'+i+'\',0);divToRefrsh=\'inp_date_'+i+'\';"/>'+
                                        '<td style="text-align:center" name="inp_montant" ><input name="inp_montant_'+i+'" id="inp_montant_'+i+'" type="text" value="100" class="classinput_xsize" style="width:50px;text-align:right;" MAXLENGTH="3" readonly="readonly" /> %</td>'+
                                        '<td style="text-align:center;display:none" name="inp_euro"><input name="inp_euro_'+i+'" id="inp_euro_'+i+'" type="text" value="<?php echo $facture->getMontant_ttc() ?>" class="classinput_xsize" style="width:50px;text-align:right;" MAXLENGTH="5"/> <?php echo $MONNAIE[1];?></td>'+
                                        '</tr>';
                                }
                                strlignetot += '<input name="mnt_tot" type="hidden" value="<?php echo $facture->getMontant_ttc(); ?>"/>';
                                strlignetot += '<input name="inp_to_use" id="inp_to_use" type="hidden" value=""/> </table>';
                                $("div_lignes_reglement").innerHTML = strlignetot;
                                $("tr_lignes_reglement").style.display = "";

                        }else{
                        $("div_lignes_reglement").innerHTML = "";
                        $("tr_lignes_reglement").style.display = "none";
                        }
                        Event.observe('lien_pourcent', 'click', function(){
         toggleDisplay("inp_montant", "inp_euro");
         $('inp_to_use').value = 'pourcentage';
    });
    Event.observe('lien_euro', 'click', function(){
         toggleDisplay("inp_euro", "inp_montant");
         $('inp_to_use').value = 'montant';
     });
                        },
                true);

                </script>
        </td>
        </tr>
    </table>
    <table style="width:100%">
        <tr id="tr_lignes_reglement" style="width:100%" >
        <!--------Lignes en affichage dynamique en fonction du nombre de règlements -------->
        <td style="width:900px">
             <form action="documents_edition_modifier_echeance_maj.php" method="post" id="form_echeance" name="form_echeance" target="formFrame" >
                 <input type = "hidden" name="ref_doc" value ="<?php echo $ref_doc; ?>" >
                 <input type = "hidden" name="montant_acquite" value ="<?php echo $montant_acquite; ?>">
                 <div style="height:180px;overflow: auto;width:100%" id="div_lignes_reglement_sup">
                    <table style="width:100%;">
			<tr>
				<td style="width:95%">
					<table>
					<tr class="smallheight">
					<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:60%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>
				<tr>
				</tr>
				<tr id="tr_lignes_reglement" >
				<!--------Lignes en affichage dynamique en fonction du nombre de rÃ¨glements -------->
				<td colspan="4">
				<div id="div_lignes_reglement">
				<table id="tb_liste_regl" >
						<tr class="smallheight">
						<td style="width:25%"><strong>Echéance</strong></td>
						<td style="width:20%;text-align:center"><strong>Type d'échéance</strong></td>
						<td style="width:20%;text-align:center"><strong>Mode de règlement</strong></td>
						<td style="width:20%;text-align:center"><strong><a href="#" id="lien_delai" onclick='toggleDisplay("inp_delai","inp_date");' >Délai</a> / <a href="#" id="lien_date" onclick='toggleDisplay("inp_date","inp_delai");' >Date</a></strong></td>
						<td style="width:15%;text-align:center"><strong><a href="#" id="lien_pourcent">%</a> / <a href="#" id="lien_euro"><?php echo $MONNAIE[1];?></a></strong></td>
						</tr>
                                        <?php $i = 1;
					$echTot = count($echeances);
					 foreach($echeances as $echeance){?>
							<tr>
							<td><?php echo $i;?><sup>e</sup> échéance : </td>
							<td style="text-align:center">
							<select name="slct_type_<?php echo $i;?>" id="slct_type_<?php echo $i;?>" style="width:100px">
							<?php if($i==1 && $echTot> 1){?>
							<option value="1" <?php if($echeance->type_reglement == "Acompte"){echo "selected='selected'";}?>>Acompte</option>
							<option value="2" <?php if($echeance->type_reglement == "Arrhes"){echo "selected='selected'";}?>>Arrhes</option>
							<option value="3" <?php if($echeance->type_reglement == "Echeance"){echo "selected='selected'";}?>>Echeance</option>
							<?php } ?>
							<?php if($i==1 && $echTot== 1){?>
							<option value="1" <?php if($echeance->type_reglement == "Acompte"){echo "selected='selected'";}?>>Acompte</option>
							<option value="2" <?php if($echeance->type_reglement == "Arrhes"){echo "selected='selected'";}?>>Arrhes</option>
							<option value="4" <?php if($echeance->type_reglement == "Solde"){echo "selected='selected'";}?>>Solde</option>
							<?php } ?>
							<?php if($i!=1 && $i!=$echTot && $echTot> 1){?>
							<option value="3" <?php if($echeance->type_reglement == "Echeance"){echo "selected='selected'";}?>>Echeance</option>
							<?php } ?>
							<?php if($i==$echTot && $echTot > 1){?>
							<option value="4" <?php if($echeance->type_reglement == "Solde"){echo "selected='selected'";}?>>Solde</option>
							<?php } ?>
							</select></td>
							<td style="text-align:center"><select name="slct_mode_<?php echo $i;?>" id="slct_mode_<?php echo $i;?>" style="width:160px">
                                                        <option value="">Au choix du client</option>
							<?php
                                                        if(empty($echeance->mode_reglement) && !empty($id_reglement_mode_favori))
                                                        {
                                                            foreach ($reglements_modes as $reglement_mode) {?>
                                                            <option value="<?php echo $reglement_mode->id_reglement_mode; ?>" <?php if($id_reglement_mode_favori == $reglement_mode->id_reglement_mode){echo "selected='selected'";}?> >
                                                            <?php echo htmlentities($reglement_mode->lib_reglement_mode); ?></option>
                                                            <?php } 
                                                        }
                                                        else
                                                        {
                                                            foreach ($reglements_modes as $reglement_mode) {?>
                                                            <option value="<?php echo $reglement_mode->id_reglement_mode; ?>" <?php if($echeance->mode_reglement == $reglement_mode->id_reglement_mode){echo "selected='selected'";}?> >
                                                            <?php echo htmlentities($reglement_mode->lib_reglement_mode); ?></option>
                                                            <?php }
                                                        }?></select></td>
                                                        <td style="text-align:center" name="inp_delai"><input name="inp_delai_<?php echo $i;?>" id="inp_delai_<?php echo $i;?>" type="text" value="<?php echo $echeance->jour;?>" onchange="maj_date(this.value,'<?php echo $date_creation ?>','inp_date_<?php echo $i;?>');" class="classinput_xsize" style="width:30px;text-align:right;" MAXLENGTH="3"/> jours</td>
							<td style="text-align:center;display:none" name="inp_date"><input id="inp_date_<?php echo $i;?>" type="text" value="<?php echo str_replace('-','/',date_US_to_Fr($echeance->date));?>" onblur="datemaskslash2(this);maj_jour(this.value,'<?php echo $date_creation ?>','inp_delai_<?php echo $i;?>');" class="classinput_xsize" style="width:70px" MAXLENGTH="10"/>
                                                            <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/calendrier.gif" onclick="create_div(event,'inp_date_<?php echo $i;?>',0);divToRefrsh='inp_date_<?php echo $i;?>';"/>
                                                        </td>
                                                        <?php if($i!=$echTot){?>
								<td style="text-align:center" name="inp_montant"><input name="inp_montant_<?php echo $i;?>" id="inp_montant_<?php echo $i;?>" type="text" value="<?php echo $echeance->pourcentage;?>" onKeyUp="maj_mnt_solde('div_lignes_reglement',<?php echo $echTot;?>)" onchange="majMontant(<?php echo $facture->getMontant_ttc() ?>,this.value,'inp_euro_<?php echo $i;?>','div_lignes_reglement',<?php echo $echTot;?>)" class="classinput_xsize" style="width:50px;text-align:right;" MAXLENGTH="3"/> %</td>
							<?php }else {?>
								<td style="text-align:center" name="inp_montant"><input name="inp_montant_<?php echo $i;?>" id="inp_montant_<?php echo $i;?>" type="text" value="<?php echo $echeance->pourcentage;?>" class="classinput_xsize" style="width:50px;text-align:right;" MAXLENGTH="3" readonly="readonly"/> %</td>
							<?php }?>
                                                        <td style="text-align:center;display:none" name="inp_euro"><input name="inp_euro_<?php echo $i;?>" id="inp_euro_<?php echo $i;?>" type="text" value="<?php echo $echeance->montant;?>" onKeyUp="maj_euro_solde('div_lignes_reglement',<?php echo $echTot;?>, <?php echo $facture->getMontant_ttc() ?>)"  class="classinput_xsize" style="width:50px;text-align:right;" MAXLENGTH="5"/> <?php echo $MONNAIE[1];?></td>
							</tr>
					<?php $i++;}?>
                                                        <input name="inp_to_use" id="inp_to_use" type="hidden" value=""/>
					</table>
                                        <script type="text/javascript">
                                            maj_mnt_solde('div_lignes_reglement',<?php echo $echTot;?>);
                                            str_sauv_ech = $('tb_liste_regl').innerHTML;
                                        </script>
					</div>
				</td>
				<td>
				</td>
				</tr>
				</table>
				</td>
				<td>
				</td>

			</tr>
			</table>
                  </div>
             </form>
        </td>
        </tr>
    </table>
    <div style="position:absolute;bottom:10px;left:38%;cursor:pointer" id="div_regenere" >Regénérer l'échéancier par défaut</div>
<div id="div_lignes_reglement_modeles">
   <?php
    if($modeles){   ?>
	<?php foreach($modeles as $modele){
	$modele_echeancier = new modele_echeancier($modele->id_echeancier_modele);?>
        <form action="documents_edition_modifier_echeance_maj.php" method="post" id="form_echeance_<?php echo $modele_echeancier->getId_echeancier_modele();?>" name="form_echeance_<?php echo $modele_echeancier->getId_echeancier_modele();?>" target="formFrame" >
            <input type = "hidden" name="ref_doc" value ="<?php echo $ref_doc; ?>">
            <input type = "hidden" name="montant_acquite" value ="<?php echo $montant_acquite; ?>">
            <div style="height:200px;overflow: auto;width:100%;display:none;" id="div_lignes_reglement_<?php echo $modele_echeancier->getId_echeancier_modele();?>">
			<table style="width:100%;">
			<tr>
				<td style="width:95%">
					<table>
					<tr class="smallheight">
					<td style="width:25%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:60%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					<td style="width:15%"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="100%" height="1" id="imgsizeform"/></td>
					</tr>
				<tr>
				</tr>
				<tr id="tr_lignes_reglement" >
				<!--------Lignes en affichage dynamique en fonction du nombre de règlements -------->
				<td colspan="4">
				<div id="div_lignes_reglement_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>">
				<table id="tb_liste_regl" >
						<tr class="smallheight">
						<td style="width:25%"><strong>Echéance</strong></td>
						<td style="width:20%;text-align:center"><strong>Type d'échéance</strong></td>
						<td style="width:20%;text-align:center"><strong>Mode de règlement</strong></td>
						<td style="width:20%;text-align:center"><strong>Délai</strong></td>
						<td style="width:15%;text-align:center"><strong>Montant</strong></td>
						</tr>
					<?php $i = 1;
					$echTot = count($modele_echeancier->getEcheances());
					 foreach($modele_echeancier->getEcheances() as $echeance){?>
							<tr>
							<td><?php echo $i;?><sup>e</sup> échéance : </td>
							<td style="text-align:center">
							<select name="slct_type_<?php echo $i;?>" id="slct_type_<?php echo $i;?>" style="width:100px">
							<?php if($i==1 && $echTot> 1){?>
							<option value="1" <?php if($echeance['type_reglement'] == "Acompte"){echo "selected='selected'";}?>>Acompte</option>
							<option value="2" <?php if($echeance['type_reglement'] == "Arrhes"){echo "selected='selected'";}?>>Arrhes</option>
							<option value="3" <?php if($echeance['type_reglement'] == "Echeance"){echo "selected='selected'";}?>>Echeance</option>
							<?php } ?>
							<?php if($i==1 && $echTot== 1){?>
							<option value="1" <?php if($echeance['type_reglement'] == "Acompte"){echo "selected='selected'";}?>>Acompte</option>
							<option value="2" <?php if($echeance['type_reglement'] == "Arrhes"){echo "selected='selected'";}?>>Arrhes</option>
							<option value="4" <?php if($echeance['type_reglement'] == "Solde"){echo "selected='selected'";}?>>Solde</option>
							<?php } ?>
							<?php if($i!=1 && $i!=$echTot && $echTot> 1){?>
							<option value="3" <?php if($echeance['type_reglement'] == "Echeance"){echo "selected='selected'";}?>>Echeance</option>
							<?php } ?>
							<?php if($i==$echTot && $echTot > 1){?>
							<option value="4" <?php if($echeance['type_reglement'] == "Solde"){echo "selected='selected'";}?>>Solde</option>
							<?php } ?>
							</select></td>
							<td style="text-align:center"><select name="slct_mode_<?php echo $i;?>" id="slct_mode_<?php echo $i;?>" style="width:160px">
                                                        <option value="">Au choix du client</option>
							<?php foreach ($reglements_modes as $reglement_mode) {?>
							<option value="<?php echo $reglement_mode->id_reglement_mode; ?>" <?php if($echeance['id_mode_reglement'] == $reglement_mode->id_reglement_mode){echo "selected='selected'";}?> >
							<?php echo htmlentities($reglement_mode->lib_reglement_mode); ?></option>
							<?php } ?></select></td>
							<td style="text-align:center"><input name="inp_delai_<?php echo $i;?>" id="inp_delai_<?php echo $i;?>" type="text" value="<?php echo $echeance['jour'];?>" class="classinput_xsize" style="width:30px;text-align:right;" MAXLENGTH="3"/> jours</td>
							<?php if($i!=$echTot){?>
								<td style="text-align:center"><input name="inp_montant_<?php echo $i;?>" id="inp_montant_<?php echo $i;?>" type="text" value="<?php echo $echeance['pourcentage'];?>" onKeyUp="maj_mnt_solde('div_lignes_reglement_mod_<?php echo $modele_echeancier->getId_echeancier_modele();?>',<?php echo $echTot;?>)" class="classinput_xsize" style="width:30px;text-align:right;" MAXLENGTH="3"/> %</td>
							<?php }else {?>
								<td style="text-align:center"><input name="inp_montant_<?php echo $i;?>" id="inp_montant_<?php echo $i;?>" type="text" value="<?php echo $echeance['pourcentage'];?>" class="classinput_xsize" style="width:30px;text-align:right;" MAXLENGTH="3" readonly="readonly"/> %</td>
							<?php }?>
							</tr>
					<?php $i++;}?>
                                                        <input name="inp_to_use" id="inp_to_use" type="hidden" value=""/>
					</table>
					</div>
				</td>
				<td>
				</td>
				</tr>
				</table>
				</td>
				<td>
				</td>

			</tr>
			</table>
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="1" height="1"/>
        </div>
        </form>
	<?php } ?>
<?php } ?>
        </div>
<script type="text/javascript">
    // envoi des pourcentage ou du montant


    Event.observe('lien_pourcent', 'click', function(){
         toggleDisplay("inp_montant", "inp_euro");
         $('inp_to_use').value = 'pourcentage';
    });
    Event.observe('lien_euro', 'click', function(){
         toggleDisplay("inp_euro", "inp_montant");
         $('inp_to_use').value = 'montant';
     });


    Event.observe('sortir', 'click',  function(evt){
        divPrinc = document.getElementById('id_body_princ');
        divPrinc.setAttribute('id', 'id_body');
        $('alert_pop_up_tab_echeancier').style.display = "none";
	$("alert_pop_up").style.display = "none";
        },false);
    Event.observe('div_regenere', 'click',  function(evt){
        $('valider_nb_reg').style.display = 'none';
        $("tr_lignes_reglement").style.display = "block";
        $("valider").style.display = "block";
        $('slct_modele_ech').value = "";
        $('div_lignes_reglement').style.display = "block";
        $("div_lignes_reglement_modeles").style.display = "none";
        <?php foreach($modeles as $modele){
	$modele_echeancier = new modele_echeancier($modele->id_echeancier_modele);?>
                $("div_lignes_reglement_<?php echo $modele_echeancier->getId_echeancier_modele();?>").style.display = "none";
        <?php } ?>
        $('tb_liste_regl').innerHTML = str_sauv_ech;
        },false);
    Event.observe('slct_modele_ech', 'change',  function(evt){
        <?php foreach($modeles as $modele){
	$modele_echeancier = new modele_echeancier($modele->id_echeancier_modele);?>
                $("div_lignes_reglement_<?php echo $modele_echeancier->getId_echeancier_modele();?>").style.display = "none";
        <?php } ?>
        $("valider").style.display = "block";
        $('nb_reglements').value = "";
        $("tr_lignes_reglement").style.display = "none";
        $("div_lignes_reglement").style.display = "none";
        $("div_lignes_reglement_modeles").style.display = "block";
	$("div_lignes_reglement_"+this.value).style.display = "block";
        },false);
     Event.observe('valider', 'click',  function(evt){
         divPrinc = document.getElementById('id_body_princ');
         divPrinc.setAttribute('id', 'id_body');
         $('alert_pop_up_tab_echeancier').style.display = "none";
	 $("alert_pop_up").style.display = "none";
         divs = document.getElementsByTagName('div');
         for(it=0;it<divs.length;it++){
            if (divs[it].id.substr(0,20) == 'div_lignes_reglement' && divs[it].id != 'div_lignes_reglement_modeles' && divs[it].id.substr(0,24) != 'div_lignes_reglement_sup' && divs[it].id.substr(0,25) != 'div_lignes_reglement_mod_'){
                if(divs[it].style.display == "" || divs[it].style.display == "block"){
                    formToSubmit = 'form_echeance'+divs[it].id.substr(20);
                    $(formToSubmit).submit();
                }                    
            }
         }
     },false);
</script>
