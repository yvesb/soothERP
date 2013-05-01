<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Envois du courrier par email</title>
	
	<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_common_style.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/prototype.js"/></script>
	<script type="text/javascript">
		var line_num = 0;
		function add_destline (mail_insert) {
		
			var zone= $("liste_dest");
			var addiv= document.createElement("div");
				addiv.setAttribute ("id", "dest_"+line_num);
			var image= document.createElement("img");
				image.setAttribute ("id", "sup_list_dest_"+line_num);
				image.setAttribute ("src", "<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif");
			zone.appendChild(addiv);
			$("dest_"+line_num).innerHTML=mail_insert;
			$("dest_"+line_num).appendChild(image);
			
			sup_line_observer (line_num, mail_insert);
			line_num++;
		}
		
		function sup_line_observer (line_num, mail_insert) {
			
			new Event.observe('sup_list_dest_'+line_num, 'click',  function(evt){
								Event.stop(evt); 
								$("new_dest_insert").value = "";
								$("destinataires").value = $("destinataires").value.replace(mail_insert+";", "");
								$("destinataires").value = $("destinataires").value.replace(mail_insert, "");
								Element.remove($("dest_"+line_num));
							}, false);
		}
	</script>
	<style type="text/css">
		body {font:12px Arial, Helvetica, sans-serif;}
		img {border:0px;}
	</style>
</head>
<?php /*<body style="overflow:auto; width:580px; height:450px"> */?>
<body style="overflow:auto; width:800px; height:450px">
	<div style="margin:5px">
		<strong>Envoi du courrier (fichier pdf) par email</strong>
		<br />
		<div style="color:#FF0000; font-weight:bolder">
			<?php if (isset($msg)) {echo $msg;}?>
		</div>
		<form id="form1" name="form1" method="post" action="courriers_editing_email_submit.php" >
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>Destinataire(s) :</td>
					<td id="liste_dest">
					<?php 
							if (isset($liste_email)) {
								$i = 0;
								foreach ($liste_email as $e) { ?>
									<div id="dest_<?php echo $i;?>">
										<?php echo $e->email; ?>
										<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" alt="Vider la liste des destinataires" id="sup_list_dest_<?php echo $i;?>" title="Vider la liste des destinataires" style="cursor:pointer; float:right" />
									</div>
									<script type="text/javascript">
										Event.observe('sup_list_dest_<?php echo $i;?>', 'click',  function(evt){
											Event.stop(evt); 
											$("new_dest_insert").value = "";
											$("destinataires").value = $("destinataires").value.replace("<?php echo $e->email;?>;", "");
											$("destinataires").value = $("destinataires").value.replace("<?php echo $e->email;?>", "");
											Element.remove($("dest_<?php echo $i;?>"));
										}, false);
									</script>
									<?php
									$i++;
								}
							}  ?>
					</td>
					<td>
					<?php	if (isset($code_pdf_modele)) { ?>
						<input name="code_pdf_modele" id="code_pdf_modele" type="hidden" value="<?php echo $code_pdf_modele;?>" />	
					<?php } //@TODO COURRIER : Gestion des filigranes : 
								if (isset($filigrane)) { ?>
						<input name="filigrane" id="filigrane" type="hidden" value="<?php echo $filigrane;?>" />	
					<?php } ?>
						<!-- destinataires -> ???? -->
						<input name="destinataires" id="destinataires" type="hidden" value="<?php if (isset($_REQUEST["destinataires"])) {echo $_REQUEST["destinataires"];}?>" />	
						<input name="id_courrier" id="id_courrier" type="hidden" value="<?php echo $courrier->getId_courrier();?>" />	
					</td>
				</tr>
				<tr>
					<td>
						Sélectionner un destinataire :
					</td>
					<td>
						<select name="new_dest" id="new_dest" style="width:263px">
							<option value="" selected="selected"> </option>
							<?php 
								$line_num = 0;
								foreach ($liste_email as $email) { ?>
								<option <?php echo ' value="'.$email->email.'"';?>>
									<?php echo $email->email;?>
								</option>
							<?php } ?>
							<option value="autre">Saisir un nouveau destinataire</option>
						</select>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr style="height:22px">
					<td>&nbsp;</td>
					<td>
						<div id="insert_dest" style="display: none">
							<input  type="text" id="new_dest_insert" name="new_dest_insert" size="39"  /> 
							<span id="add_new_dest_insert" style="text-decoration:underline; cursor:pointer">Ajouter</span>
						</div></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Objet:</td>
					<td>
						<input name="titre" id="titre" type="text" size="79" value="<?php echo $courrier->getObjet(); ?>" />
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Message:</td>
					<td>
						<textarea name="message" id="message" cols="60" rows="12">
								<?php echo 
								"\nLe document ci-joint vous est envoy&eacute; par \"".$contact_entreprise->getNom()."\"".
								"\nLa lecture du fichier joint n&eacute;cessite la pr&eacute;sence sur votre ordinateur du logiciel Adobe Acrobat Reader.\n".
								"Si vous ne poss&eacute;dez pas ce logiciel cliquez sur : <a href=\"http://get.adobe.com/fr/reader/\">http://get.adobe.com/fr/reader/</a> pour le t&eacute;l&eacute;charger.\n"
								;?>
						</textarea>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="Submit" value="Envoyer" />
					</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</form>
		<script type="text/javascript">
		line_num = <?php echo $line_num;?>;
		
		Event.observe('new_dest', 'change',  function(evt){
			Event.stop(evt); 
			if ($("new_dest").value != "") {
				if ($("new_dest").value == "autre") {
					$("insert_dest").show();
				} else {
					if ($("destinataires").value.indexOf($("new_dest").value) < 0) {
						if ($("destinataires").value == "" ) {
							$("destinataires").value = $("new_dest").value;
						} else {
							$("destinataires").value = $("destinataires").value +";"+ $("new_dest").value;
						}
						add_destline ($("new_dest").value);
						$("new_dest_insert").value = "";
						$("new_dest").selectedIndex="0";
					}
				}
			}
		}, false);
		
		
		Event.observe('add_new_dest_insert', 'click',  function(evt){
			Event.stop(evt); 
			if ($("new_dest_insert").value != "") {
				mail = $("new_dest_insert").value;
				if ((mail.indexOf("@")>=0)&&(mail.indexOf(".")>=0)) {
					if ($("destinataires").value.indexOf(mail) < 0) {
						if ($("destinataires").value == "" ) {
							$("destinataires").value = mail;
						} else {
							$("destinataires").value = $("destinataires").value +";"+ mail;
						}
						add_destline (mail);
						$("insert_dest").hide();
						$("new_dest").selectedIndex="0";
					}
		     } else {
		         alert("Mail invalide !");
		         
		     }
			}
		}, false);
		
		
		Event.observe('form1', 'submit',  function(evt){
			Event.stop(evt); 
			if ($("new_dest_insert").value != "") {
				mail = $("new_dest_insert").value;
				if ((mail.indexOf("@")>=0)&&(mail.indexOf(".")>=0)) {
					if ($("destinataires").value.indexOf(mail) < 0) {
						if ($("destinataires").value == "" ) {
							$("destinataires").value = mail;
						} else {
							$("destinataires").value = $("destinataires").value +";"+ mail;
						}
						add_destline (mail);
						$("insert_dest").hide();
						$("new_dest").selectedIndex="0";
					}
				}
			}
			
			if ($("destinataires").value == "" ) {
				if ($("new_dest").value != "" && $("new_dest").value != "autre") {
					$("destinataires").value = $("new_dest").value;
						add_destline ($("new_dest").value);
						$("new_dest_insert").value = "";
						$("new_dest").selectedIndex="0";
					$("form1").submit();
				} else {
		    	alert("La liste des destinataire est vide");
				}
			} else {
				$("form1").submit();
			}
		}, false);
		
		</script>
	</div>
</body>
</html>
