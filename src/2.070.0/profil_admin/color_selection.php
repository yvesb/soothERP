<HTML>
<head>
<title>Text Color</title>
<script>
function selectColor(couleur){
	parent.document.getElementById("<?php echo $_REQUEST['monNom']; ?>").style.display="none";
	<?php echo "window.parent.".$_REQUEST['fonctionRetour']; ?>;
}

function InitColorPalette() {
  var x;
  if (document.getElementsByTagName)
    x = document.getElementsByTagName('TD');
  else if (document.all)
    x = document.all.tags('TD');
  for (var i=0;i<x.length;i++)
  {
    x[i].onmouseover = over;
    x[i].onmouseout = out;
    x[i].onclick = click;
  }
}

function majDivColor(couleur){
	document.getElementById("divColor").style.backgroundColor = couleur;
}

function over(){
	this.style.border='1px dotted white';
}

function out(){
	this.style.border='1px solid gray';
}

function click(){
  selectColor(this.id);
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
td {
border:1px solid gray;
}
body {
	margin-left: 0px;
	margin-right: 0px;
	margin-top: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<body bgcolor="white"  onLoad="InitColorPalette()">
	<TABLE border="0" cellpadding="0" cellspacing="1">
		<TR>
			<TD id="#FFFFFF" bgcolor="#FFFFFF" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FFCCCC" bgcolor="#FFCCCC" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FFCC99" bgcolor="#FFCC99" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FFFF99" bgcolor="#FFFF99" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FFFFCC" bgcolor="#FFFFCC" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#99FF99" bgcolor="#99FF99" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#99FFFF" bgcolor="#99FFFF" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#CCFFFF" bgcolor="#CCFFFF" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#CCCCFF" bgcolor="#CCCCFF" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FFCCFF" bgcolor="#FFCCFF" width="15" height="15"><img width="1" height="1"></TD>
		</TR>
		<TR>
			<TD id="#CCCCCC" bgcolor="#CCCCCC" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FF6666" bgcolor="#FF6666" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FF9966" bgcolor="#FF9966" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FFFF66" bgcolor="#FFFF66" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FFFF33" bgcolor="#FFFF33" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#66FF99" bgcolor="#66FF99" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#33FFFF" bgcolor="#33FFFF" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#66FFFF" bgcolor="#66FFFF" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#9999FF" bgcolor="#9999FF" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FF99FF" bgcolor="#FF99FF" width="15" height="15"><img width="1" height="1"></TD>
		</TR>
		<TR>
			<TD id="#C0C0C0" bgcolor="#C0C0C0" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FF0000" bgcolor="#FF0000" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FF9900" bgcolor="#FF9900" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FFCC66" bgcolor="#FFCC66" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FFFF00" bgcolor="#FFFF00" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#33FF33" bgcolor="#33FF33" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#66CCCC" bgcolor="#66CCCC" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#33CCFF" bgcolor="#33CCFF" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#6666CC" bgcolor="#6666CC" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#CC66CC" bgcolor="#CC66CC" width="15" height="15"><img width="1" height="1"></TD>
		</TR>
		<TR>
			<TD id="#999999" bgcolor="#999999" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#CC0000" bgcolor="#CC0000" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FF6600" bgcolor="#FF6600" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FFCC33" bgcolor="#FFCC33" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#FFCC00" bgcolor="#FFCC00" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#33CC00" bgcolor="#33CC00" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#00CCCC" bgcolor="#00CCCC" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#3366FF" bgcolor="#3366FF" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#6633FF" bgcolor="#6633FF" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#CC33CC" bgcolor="#CC33CC" width="15" height="15"><img width="1" height="1"></TD>
		</TR>
		<TR>
			<TD id="#666666" bgcolor="#666666" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#990000" bgcolor="#990000" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#CC6600" bgcolor="#CC6600" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#CC9933" bgcolor="#CC9933" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#999900" bgcolor="#999900" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#009900" bgcolor="#009900" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#339999" bgcolor="#339999" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#3333FF" bgcolor="#3333FF" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#6600CC" bgcolor="#6600CC" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#993399" bgcolor="#993399" width="15" height="15"><img width="1" height="1"></TD>
		</TR>
		<TR>
			<TD id="#333333" bgcolor="#333333" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#660000" bgcolor="#660000" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#993300" bgcolor="#993300" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#996633" bgcolor="#996633" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#666600" bgcolor="#666600" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#006600" bgcolor="#006600" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#336666" bgcolor="#336666" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#000099" bgcolor="#000099" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#333399" bgcolor="#333399" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#663366" bgcolor="#663366" width="15" height="15"><img width="1" height="1"></TD>
		</TR>
		<tr>
			<TD id="#000000" bgcolor="#000000" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#330000" bgcolor="#330000" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#663300" bgcolor="#663300" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#663333" bgcolor="#663333" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#333300" bgcolor="#333300" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#003300" bgcolor="#003300" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#003333" bgcolor="#003333" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#000066" bgcolor="#000066" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#330099" bgcolor="#330099" width="15" height="15"><img width="1" height="1"></TD>
			<TD id="#330033" bgcolor="#330033" width="15" height="15"><img width="1" height="1"></TD>
		</tr>
		<tr>
	</TABLE>
	<?php if (isset($_REQUEST['codeCouleurActivated']) && $_REQUEST['codeCouleurActivated'] == 1) {?>
	<div style="float:left;">
		<div style="float:left; width:80px; text-align:left; margin-left:3px">
			<input id="code_couleur" name="code_couleur" class="classinput_lsize" type="text" style="width:72px;" maxlength="7" title="Code couleur de la forme #ffffff" alt="Code couleur de la forme #ffffff" onblur="majDivColor(this.value)" value="<?php if (isset($_REQUEST['couleur']) && $_REQUEST['couleur'] != "") {echo "#".$_REQUEST['couleur'];} ?>"/>
		</div>
		<div style="float:right; width:30px; text-align:center;">
			<div id="divColor" style="-moz-border-radius:3px; margin:3px; width: 20px; <?php if (isset($_REQUEST['couleur']) && $_REQUEST['couleur'] != "") {echo "background-color:#".$_REQUEST['couleur'].";";} ?>">
				&nbsp;
			</div>
		</div>
	</div>
	<div style="float:right; text-align:right; margin-right:3px">
		<input type="button" name="setCode_couleur" id="setCode_couleur" title="Valider le code couleur" value="ok" onclick="selectColor(document.getElementById('code_couleur').value)"/>
	</div>
	<?php }?>
</BODY>
</HTML>