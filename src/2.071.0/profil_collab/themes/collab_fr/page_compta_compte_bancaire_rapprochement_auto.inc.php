<?php
// *************************************************************************************************************
// Affichage RAPPROCHEMENT BANCAIRE automatique
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
<div class="emarge"><br />

<span class="titre" style="float:left; padding-left:140px; width: 70%">Rapprochements automatique compte <?php echo $compte_bancaire->getLib_compte ();?></span>


<span style=" float:right; text-align:right;"><br />
<span id="retour_gestion" style="cursor:pointer; text-decoration:underline">Retour</span>

<script type="text/javascript">
Event.observe('retour_gestion', 'click',  function(evt){
Event.stop(evt); 
page.verify('compta_compte_bancaire_rapprochement_gestion','compta_compte_bancaire_rapprochement_gestion.php','true','sub_content');
}, false);
</script>
</span>
<div class="emarge" style="text-align:right" >
<div  id="corps_gestion_compte_bancaire">

<table width="950px" height="350px" border="0" align="right" cellpadding="0" cellspacing="0" >
	<tr>
		<td rowspan="2" style="width:50px; height:50px; background-color:#FFFFFF">
			<div style="position:relative; top:-35px; left:-35px; width:105px; border:1px solid #999999; background-color:#FFFFFF; text-align:center">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/ico_banque.jpg" />				</div>
			<span style="width:35px">
			<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/blank.gif" width="50px" height="20px" id="imgsizeform"/>				</span>			</td>
		<td colspan="2" style="width:90%; background-color:#FFFFFF" ><br />
		<br />
		<br />
		<br />
		<br />
		<br />

		<div style="text-align:center">
		<span class="bolder">LundiMatin Business</span> va rapprocher les opérations bancaires du compte <?php echo $compte_bancaire->getLib_compte ();?> <?php echo $compte_bancaire->getNumero_compte ();?>  avec le journal de banque <?php echo $journal->getContrepartie();?><br />
		<br />
		<br /><br />



			(cette opération peut durer plusieurs minutes)<br />
			<div id="rapprochement_auto_result" style="text-align:center" >
			
						
						<SCRIPT type="text/javascript">
					
						Event.observe("lauch_rapprochement", "click", function(evt){
							Event.stop(evt);
							$("lauch_rapprochement").hide();
							$("progverify").style.width = "0%"
							$("verify_journal").show();
							var AppelAjax = new Ajax.Updater(
												"verify_journal", 
												"compta_compte_bancaire_rapprochement_auto_result.php", {
												method: 'post',
												asynchronous: true,
												contentType:  'application/x-www-form-urlencoded',
												encoding:     'UTF-8',
												parameters: { recherche: '1', id_compte_bancaire: '<?php echo $_REQUEST["id_compte_bancaire"];?>', a_rapprocher: '<?php echo $_REQUEST["a_rapprocher"];?>'},
												evalScripts:true, 
												onLoading:S_loading,
												onComplete:H_loading}
												);
						}, false);
						</SCRIPT>
						<div style="text-align:left; ">
						</div>
						<table style="width:100%">
						<tr>
						<td>
						</td>
						<td style="width:420px;">
						<div id="aff_compta_verify" style=" width:420px;">
						<div class="progress_barre"; margin-left:30%; margin-right:30%><div class="files_progress" id="progverify"></div></div>
						</div>
						</td>
						<td>
						</td>
						</tr>
						</table>
						<div id="verify_journal" style="display:none"></div><br /><br />

			<span id="lauch_rapprochement" class="bolder" style="cursor:pointer">Lancer le Rapprochement automatique</span><br />
			
			
			</div>
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