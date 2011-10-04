<script type="text/javascript">
</script>
<div class="emarge">

<div class="titre">Gestion des commerciaux</div>
<div class="articletview_corps" id="compta_situation_commerciaux_conteneur" >
	<div style="padding:8px">
            <table class="minimizetable">
            <tr>
            <td >
            <div style="padding-left:10px; padding-right:10px">
                    <span id="compta_situation_commerciaux" class="grey_caisse" style="float:right" >
                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Voir la situation des commerciaux
                    </span>
            </div>
            </td>
            <td>
                <div style="padding-left:10px; padding-right:10px">
                <span id="compta_bonus_commerciaux" class="grey_caisse" >
                        <img src="<?php echo $DIR.$_SESSION['theme']->getDir_theme()?>images/puce_bleue.gif"  style="padding-right:10px; float:left" vspace="3" /> Gérer les bonus et malus
                    </span>
                    </div>
            </td>
            </tr>
            </table>
        </div>

<SCRIPT type="text/javascript">

	Event.observe('compta_situation_commerciaux', "click", function(evt){
		page.verify('compta_situation_commerciaux','compta_situation_commerciaux.php','true','sub_content');
		Event.stop(evt);
});
	Event.observe('compta_bonus_commerciaux', "click", function(evt){
		page.verify('compta_bonus_commerciaux','compta_bonus_commerciaux.php','true','sub_content');
		Event.stop(evt);
});
//on masque le chargement
H_loading();
</SCRIPT>
</div>
</div>