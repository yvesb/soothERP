<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edition de l'article</title>
</head>

<frameset rows="32,*" frameborder="no" border="0" framespacing="0">
	<frame src="catalogue_articles_editing_button.php?ref_article=<?php echo $ref_article; ?><?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?><?php 	if (isset($_REQUEST["filigrane"])) {echo "&filigrane=".$_REQUEST["filigrane"];}?>" name="topediting" scrolling="No" noresize="noresize" id="topediting" title="topediting" />
	<frame src="catalogue_articles_editing_print.php?ref_article=<?php echo $ref_article; ?><?php if (isset($_REQUEST["print"])) { ?>&print=1<?php } ?><?php 	if (isset($_REQUEST["code_pdf_modele"])) {echo "&code_pdf_modele=".$_REQUEST["code_pdf_modele"];}?><?php 	if (isset($_REQUEST["filigrane"])) {echo "&filigrane=".$_REQUEST["filigrane"];}?>" name="mainediting" id="mainediting" title="mainediting" />
</frameset>
<noframes><body>
</body>
</noframes></html>