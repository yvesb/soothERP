
<div id="pop_up_article_ref_externe_content" class="mini_moteur_article_ref_externe" style="display:none">
	<a href="#" id="close_article_ref_externe" style="float:right">
	<img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/supprime.gif" border="0">
	</a>
	
	<div id="aff_ref_externe_content" style="overflow:auto; "></div>
	
	<script type="text/javascript">
	Event.observe("close_article_ref_externe", "click",  function(evt){Event.stop(evt); close_article_ref_externe();}, false);
		
	//on masque le chargement
	H_loading();
		
	//centrage du mini_moteur
	
	centrage_element("pop_up_article_ref_externe_content");
	
	Event.observe(window, "resize", function(evt){
	centrage_element("pop_up_article_ref_externe_content");
	});
	</SCRIPT>
</div>