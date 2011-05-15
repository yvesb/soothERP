

<div style="padding-left: 10px; padding-bottom: 4px; padding-right:10px">
<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/bt-promotions.gif" id="bt_r_dev_1" style="cursor:pointer"/>
</div>

<script type="text/javascript">

Event.observe("bt_r_dev_1", "click", function(evt){
$("page_to_show_s").value= "1";
$("recherche_auto").value= "1"; page.document_recherche_article();}, false);

</script>