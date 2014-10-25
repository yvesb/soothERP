<div id="caract_recherche_a" class="caract_simple">
<?php 
$serialisation_carac = 0;
foreach ($caracs as $carac) {
	?>
	<div id="caract_<?php echo $serialisation_carac; ?>">
		<table>
		<tr>
		<td style="width:135px">
		<span class="search_lib_carac">
		<?php echo htmlentities($carac->lib_carac, ENT_QUOTES, "UTF-8"); ?>:
		</span>
		</td>
		<td style="width:135px">
		<?php 
		if ($carac->allowed_values!="" && count(explode(";", $carac->allowed_values))>0) {
			?>
			<select name="carac<?php echo $carac->ref_carac; ?>" id="carac<?php echo $carac->ref_carac; ?>"  class="classinput_xsize">
			<?php
				$allowed_values= explode(";", $carac->allowed_values);
				foreach ($allowed_values as $allowed_value){
					?>
					<option value="<?php echo htmlentities($allowed_value, ENT_QUOTES, "UTF-8")?>" <?php 
					if ($allowed_value==$carac->default_value) {echo 'selected="selected"';} ?>><?php echo htmlentities($allowed_value, ENT_QUOTES, "UTF-8")?></option>
					<?php 
				}
				?>
				</select>
				<?php
			} else{
				?>
				<input name="carac<?php echo $carac->ref_carac; ?>" id="carac<?php echo $carac->ref_carac; ?>" type="text" value="<?php echo htmlentities($carac->default_value, ENT_QUOTES, "UTF-8"); ?>" class="classinput_xsize" />
				<?php
			}
			?>
		</td>
		<td style="width:25px; text-align:left;">
		<span  class="labelled_text"><?php echo htmlentities($carac->unite, ENT_QUOTES, "UTF-8"); ?></span>
		</td></tr></table>
	</div>
	<?php 
	$serialisation_carac++;
}
?>
</div><br />

