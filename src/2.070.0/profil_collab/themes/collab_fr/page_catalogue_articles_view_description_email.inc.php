<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Envois de la fiche article par email</title>

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
<!--
body {
font:12px Arial, Helvetica, sans-serif;
}
img {
border:0px;
}
-->
</style>
</head>

<body style="overflow:auto; width:500px; height:350px">
<div style="margin:5px">
<strong>Envoi de la fiche article par email</strong>
<br />
<div style="color:#FF0000; font-weight:bolder"><?php if (isset($msg)) {echo $msg;}?></div>
<form id="form1" name="form1" method="post" action="catalogue_articles_view_description_email_send.php" >
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>Destinataires:</td>
			<td id="liste_dest"><?php
			$i = 0;
			if (isset($_REQUEST["destinataires"])) {
				$tmp = explode(";",  $_REQUEST["destinataires"]);
				foreach ($tmp as $linedest) {
					?>
					<div id="dest_<?php echo $i;?>"><?php echo $linedest;?>
					<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" alt="Vider la liste des destinataires" id="sup_list_dest_<?php echo $i;?>" title="Vider la liste des destinataires" style="cursor:pointer; float:right">
					</div>
					<script type="text/javascript">
					Event.observe('sup_list_dest_<?php echo $i;?>', 'click',  function(evt){
						Event.stop(evt); 
						$("new_dest_insert").value = "";
						$("destinataires").value = $("destinataires").value.replace("<?php echo $linedest;?>;", "");
						$("destinataires").value = $("destinataires").value.replace("<?php echo $linedest;?>", "");
						Element.remove($("dest_<?php echo $i;?>"));
					}, false);
					</script>
					<?php
					$i++;
				}
			}
			
			?></td>
			<td>
				<input name="destinataires" id="destinataires" type="hidden" value="<?php if (isset($_REQUEST["destinataires"])) {echo $_REQUEST["destinataires"];}?>" />	
				<input name="ref_article" id="ref_article" type="hidden" value="<?php echo $article->getRef_article ();?>" />	
			</td>
		</tr>
		<tr>
			<td>Nouveau destinataire: </td>
			<td>
				<div id="insert_dest" style="">
					<input  type="text" id="new_dest_insert" name="new_dest_insert" size="38"  /> 
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
			<td>Titre:</td>
			<td>
				<input name="titre" id="titre" type="text" value="<?php if (isset($_REQUEST["titre"])) {echo $_REQUEST["titre"];} else { echo $article->getLib_article();}?>" size="38" />
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Message:</td>
			<td><textarea name="message" id="message" cols="40" rows="8"><?php if (isset($_REQUEST["message"])) {echo $_REQUEST["message"];}?></textarea></td>
			<td><textarea name="fiche" id="fiche" cols="40" rows="8" style="display:none"></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Envoyer" /></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
line_num = <?php echo $i;?>;

$("fiche").value = window.opener.$("fiche_article").innerHTML;


Event.observe('add_new_dest_insert', 'click',  function(evt){
	Event.stop(evt); 
	if ($("new_dest_insert").value != "") {
		mail = $("new_dest_insert").value;
		if ((mail.indexOf("@")>=0)&&(mail.indexOf(".")>=0)) {
			if ($("destinataires").value == "" ) {
				$("destinataires").value = mail;
			} else {
				$("destinataires").value = $("destinataires").value +";"+ mail;
			}
			add_destline (mail);
			
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
			if ($("destinataires").value == "" ) {
				$("destinataires").value = mail;
			} else {
				$("destinataires").value = $("destinataires").value +";"+ mail;
			}
			add_destline (mail);
		}
	}
	if ($("destinataires").value == "" ) {
    alert("La liste des destinataire est vide");
	} else {
		$("form1").submit();
	}
}, false);

</script>
</div>
</body>
</html>
