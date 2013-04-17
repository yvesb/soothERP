<?php
echo '
<br />
<div style="width:100%; text-align:center;">
<span id="stitre"><b>Statistiques</b></span>
</div>
<br />
<table width="100%" border="0">
<tr><td align="center">
<select name="magasins" id="magasins">';
foreach($Magasins as $Magasin){
	echo '<option value="'.$Magasin->id_magasin.'"';
	if($Magasin->id_magasin==$magasin) echo ' selected="selected"';
	echo '>'.$Magasin->lib_magasin.'</option>';
}
echo '
</select>
</td></tr>
</table>
<table width="100%">
	<tr>
		<td align="center">
			Du <input type="text" name="date_d" id="date_d" value="'.$periode[0].'" /> au <input type="text" value="'.$periode[1].'" name="date_f" id="date_f" /> <span id="ok">ok</span>
		</td>
	</tr>
</table>
<br />
<table width="100%" id="tab_stats">
	<tr>
		<td align="center">Chiffre d\'affaires</td>
		<td align="center">'.$Ca.' &euro; TTC</td>
	</tr>
	<tr>
		<td align="center">NB Ticket(s)</td>
		<td align="center">'.$Nbticket.'</td>
	</tr>
	<tr>
		<td align="center">Panier Moyen</td>
		<td align="center">
			'.$PanierMoyen.' &euro; TTC
		</td>
	</tr>
</table>
<br />
<div style="width:100%; text-align:center;"><span id="print">Imprimer</span><span id="close">Fermer</span></div>';
?>
<script type="text/javascript">
 Event.observe("ok","click",function(ev){
	new Ajax.Updater("popup_stats","<?php echo $DIR; ?>interface_caisse/popup_stats.php",{
		method: "get",
		evalScripts:true,
		parameters: {
			date_d : $F("date_d"),
			date_f : $F("date_f"),
			magasins : $F("magasins")
		}
	});
});
$('date_d').attachMiniCalendar({format:'%d-%m-%Y %H:%i'});
$('date_f').attachMiniCalendar({format:'%d-%m-%Y %H:%i'});
Event.observe("close","click",function(ev){
	$('popup_stats').hide();
});
Event.observe("print","click",function(ev){
	 if ("createEvent" in document){
		var element = document.createElement("LMBPrintDataElement");
		element.setAttribute("url", window.location.protocol+"//"+window.location.host+window.location.pathname+"caisse_imprimer_stats.php?ca=<?php echo $Ca;?>&nb=<?php echo $Nbticket;?>&pm=<?php echo $PanierMoyen;?>&ped=<?php echo $periode[0]; ?>&pef=<?php echo $periode[1]; ?>");
		element.setAttribute("printer_type", "ticket");
		document.documentElement.appendChild(element);
		var ev = document.createEvent("Events");
		ev.initEvent("LMBPrintRequest", true, false);
		element.dispatchEvent(ev);
	}
});
</script>