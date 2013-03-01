<HTML>
<head>
<title>Text Color</title>
<script>
function selectColor(couleur){
	var couleurs = couleur.split("_");
	var couleur_1 = "#"+couleurs[0];
	var couleur_2 = "#"+couleurs[1];
	parent.document.getElementById("<?php echo $_REQUEST['monNom']; ?>").style.display="none";
	<?php $fonctions = explode(";", $_REQUEST['fonctionRetour']);
	foreach($fonctions as $fonction) {
		echo "window.parent.".$fonction.";\n";
	} ?>
}

function InitColorPalette() {
  var x;
  if (document.getElementsByTagName)
    x = document.getElementsByTagName('TR');
  else if (document.all)
    x = document.all.tags('TR');
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

	<TABLE border="0" cellpadding="0" cellspacing="2px" width="100%">
		<TR id="97bf0d_ccdf88">
			<TD id="97bf0d" bgcolor="97bf0d" width="50%" height="25px"></TD>
			<TD id="ccdf88" bgcolor="ccdf88" width="50%" height="25px"></TD>
		</TR>
		<TR id="678713_94ab59">
			<TD id="678713" bgcolor="678713" width="50%" height="25px"></TD>
			<TD id="94ab59" bgcolor="94ab59" width="50%" height="25px"></TD>
		</TR>
		<TR id="4d6811_829558">
			<TD id="4d6811" bgcolor="4d6811" width="50%" height="25px"></TD>
			<TD id="829558" bgcolor="829558" width="50%" height="25px"></TD>
		</TR>
		<TR id="124525_597c66">	
			<TD id="124525" bgcolor="124525" width="50%" height="25px"></TD>
			<TD id="597c66" bgcolor="597c66" width="50%" height="25px"></TD>
		</TR>
		<TR id="00524f_4c8683">
			<TD id="00524f" bgcolor="00524f" width="50%" height="25px"></TD>
			<TD id="4c8683" bgcolor="4c8683" width="50%" height="25px"></TD>
		</TR>
		<TR id="002454_4c6587">
			<TD id="002454" bgcolor="002454" width="50%" height="25px"></TD>
			<TD id="4c6587" bgcolor="4c6587" width="50%" height="25px"></TD>
		</TR>
		<TR id="004a7f_4c80a5">
			<TD id="004a7f" bgcolor="004a7f" width="50%" height="25px"></TD>
			<TD id="4c80a5" bgcolor="4c80a5" width="50%" height="25px"></TD>
		</TR>
		<TR id="006f9f_4c9abc">
			<TD id="006f9f" bgcolor="006f9f" width="50%" height="25px"></TD>
			<TD id="4c9abc" bgcolor="4c9abc" width="50%" height="25px"></TD>
		</TR>
		<TR id="61569d_9088ba">
			<TD id="61569d" bgcolor="61569d" width="50%" height="25px"></TD>
			<TD id="9088ba" bgcolor="9088ba" width="50%" height="25px"></TD>
		</TR>
		<TR id="622181_9163a7">
			<TD id="622181" bgcolor="622181" width="50%" height="25px"></TD>
			<TD id="9163a7" bgcolor="9163a7" width="50%" height="25px"></TD>
		</TR>
		<TR id="93117e_b358a4">
			<TD id="93117e" bgcolor="93117e" width="50%" height="25px"></TD>
			<TD id="b358a4" bgcolor="b358a4" width="50%" height="25px"></TD>
		</TR>
		<TR id="d7420e_eb4c83">
			<TD id="d7420e" bgcolor="d7420e" width="50%" height="25px"></TD>
			<TD id="eb4c83" bgcolor="eb4c83" width="50%" height="25px"></TD>
		</TR>
		<TR id="9f0038_bc4c73">
			<TD id="9f0038" bgcolor="9f0038" width="50%" height="25px"></TD>
			<TD id="bc4c73" bgcolor="bc4c73" width="50%" height="25px"></TD>
		</TR>
		<TR id="790e11_a15658">
			<TD id="790e11" bgcolor="790e11" width="50%" height="25px"></TD>
			<TD id="a15658" bgcolor="a15658" width="50%" height="25px"></TD>
		</TR>
		<TR id="d7420e_e37a56">
			<TD id="d7420e" bgcolor="d7420e" width="50%" height="25px"></TD>
			<TD id="e37a56" bgcolor="e37a56" width="50%" height="25px"></TD>
		</TR>
		<TR id="e95d0f_f08d57">
			<TD id="e95d0f" bgcolor="e95d0f" width="50%" height="25px"></TD>
			<TD id="f08d57" bgcolor="f08d57" width="50%" height="25px"></TD>
		</TR>
		<TR id="7d5024_a48465">
			<TD id="7d5024" bgcolor="7d5024" width="50%" height="25px"></TD>
			<TD id="a48465" bgcolor="a48465" width="50%" height="25px"></TD>
		</TR>
		<TR id="4e3216_836f5b">
			<TD id="4e3216" bgcolor="4e3216" width="50%" height="25px"></TD>
			<TD id="836f5b" bgcolor="836f5b" width="50%" height="25px"></TD>
		</TR>
		<TR id="38302b_736e6a">
			<TD id="38302b" bgcolor="38302b" width="50%" height="25px"></TD>
			<TD id="736e6a" bgcolor="736e6a" width="50%" height="25px"></TD>
		</TR>
	</TABLE>

</BODY>
</HTML>