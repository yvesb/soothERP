<?php
  header("Cache-Control: max-age=0");
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title><?php echo $_GET['targeturl']?></title>
</head>

<script>
window._hash = '<?php echo $_GET['targeturl']?>'; 
window.onload = parent.hashListener.syncHash;

</script>
<body>
<?php echo $_GET['identifiant']?><br />
<?php echo $_GET['targeturl']?><br />
<?php echo $_GET['div_refresh']?><br />
<?php echo $_GET['div_target']?>

<script type="text/javascript">
//function reload() {
//retour_url= window.parent.history_reload();
//	if (retour_url!="<?php echo $_GET['targeturl']?>") {
//	window.parent.page.verify("<?php echo $_GET['identifiant']?>","<?php echo $_GET['targeturl']?>","<?php echo $_GET['div_refresh']?>","<?php echo $_GET['div_target']?>");
//	}
//}
</script>
</body>
</html>
