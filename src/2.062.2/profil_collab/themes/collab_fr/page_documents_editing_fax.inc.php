<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Envois du document par fax</title>

<link href="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>css/_common_style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>javascript/prototype.js"/></script>
<style type="text/css">
<!--
body {
margin: 5px;
font:12px Arial, Helvetica, sans-serif;
}
img {
border:0px;
}
-->
</style>
</head>

<body>
<strong>Envoi du document par fax</strong>
<br />
<div style="color:#FF0000; font-weight:bolder"><?php if (isset($msg)) {echo $msg;}?></div>
<form id="form1" name="form1" method="post" action="documents_editing_fax_submit.php" >
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>Destinataire:</td>
			<td id="liste_dest"><?php if (isset($_REQUEST["destinataires"])) {echo $_REQUEST["destinataires"];}?></td>
			<td>
				<input name="destinataires" id="destinataires" type="hidden" value="<?php if (isset($_REQUEST["destinataires"])) {echo $_REQUEST["destinataires"];}?>" />	
				<input name="ref_doc" id="ref_doc" type="hidden" value="<?php echo $document->getRef_doc ();?>" />	
			<a href="#" id="sup_list_dest"><img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0" alt="Vider la liste des destinataires" title="Vider la liste des destinataires"></a>
			</td>
		</tr>
		<tr>
			<td>Nouveau destinataire: </td>
			<td>
			<select name="new_dest" id="new_dest" style="width:195px">
				<option value=""></option>
				<?php 
				foreach ($liste_fax as $fax) {
					?>
					<option value="<?php echo $fax->fax;?>"><?php echo $fax->fax;?></option>
					<?php
				}
				?>
				<option value="autre">autre...</option>
			</select>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr style="height:22px">
			<td>&nbsp;</td>
			<td>
				<div id="insert_dest" style="display: none">
					<input  type="text" id="new_dest_insert" name="new_dest_insert" size="38"  /> 
					<span id="add_new_dest_insert" style="text-decoration:underline">Ajouter</span>
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
				<input name="titre" id="titre" type="text" value="<?php if (isset($_REQUEST["titre"])) {echo $_REQUEST["titre"];} else { echo $document->getRef_doc ();}?>" size="38" />
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Message:</td>
			<td><textarea name="message" id="message" cols="40" rows="8"><?php if (isset($_REQUEST["message"])) {echo $_REQUEST["message"];}?></textarea></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Submit" value="Envoyer" /></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>
<script type="text/javascript">
Event.observe('new_dest', 'change',  function(evt){
	Event.stop(evt); 
	if ($("new_dest").value != "") {
		if ($("new_dest").value == "autre") {
			$("insert_dest").show();
		} else {
			$("liste_dest").innerHTML = $("new_dest").value;
			$("new_dest_insert").value = "";
			$("new_dest").selectedIndex="0";
			$("destinataires").value = $("liste_dest").innerHTML;
		}
	}
}, false);


Event.observe('add_new_dest_insert', 'click',  function(evt){
	Event.stop(evt); 
	if ($("new_dest_insert").value != "") {
		$("liste_dest").innerHTML = $("new_dest_insert").value;
		$("destinataires").value = $("liste_dest").innerHTML;
		$("insert_dest").hide();
		$("new_dest").selectedIndex="0";
	}
}, false);



Event.observe('form1', 'submit',  function(evt){
	Event.stop(evt); 
	if ($("destinataires").value == "" ) {
    alert("La liste des destinataire est vide");
	} else {
		$("form1").submit();
	}
}, false);

Event.observe('sup_list_dest', 'click',  function(evt){
	Event.stop(evt); 
	$("new_dest_insert").value = "";
	$("destinataires").value = "";
	$("liste_dest").innerHTML = "";

}, false);
</script>
</body>
</html>
