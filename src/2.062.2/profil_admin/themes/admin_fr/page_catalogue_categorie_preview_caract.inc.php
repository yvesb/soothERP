<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Preview caract&eacute;ristiques de cat&eacute;gories</title>
<style>
body {
font:1em Arial, Helvetica, sans-serif;
}
.colorise0 {
width:100%;
background-color:#732600;
color:#FFFFFF;
}
.colorise0 td {
font:0.8em Arial, Helvetica, sans-serif;
font-weight: bolder;
}
.colorise1 {
font:0.8em Arial, Helvetica, sans-serif;
line-height:20px;
background-color:#FFFFFF;
}
.colorise2 {
font:0.8em Arial, Helvetica, sans-serif;
line-height:20px;
background-color:#f0e8db;
}
</style>
<script type="text/javascript">
window.focus();
</script>
</head>

<body>

	<p>Liste des  caract&eacute;ristiques de <?php echo $art_categ->getLib_art_categ()?></p>
	<table style="width:100%;">
	<?php 
		$colorise=0;
		$ref_carac_groupe=NULL;
		
		foreach ($caracs as $carac) {
			$colorise++;
			$class_colorise= ($colorise % 2)? 'colorise1' : 'colorise2';
				if ($ref_carac_groupe!=$carac->ref_carac_groupe) {
					$ref_carac_groupe	=	$carac->ref_carac_groupe;
	
	?>		
	<tr class="colorise0">
	<td>
	<?php echo htmlentities($carac->lib_carac_groupe); ?>
	</td>
	</tr>
	<?php
						unset ($query, $resultat, $groupe, $caracs_groupes);
	 			}
	?>
	<tr class="<?php  echo  $class_colorise?>">
	<td>
	<?php echo htmlentities($carac->lib_carac); ?>
	</td>
	</tr>
	<?php }
	?>
	</table>
</body>
</html>
