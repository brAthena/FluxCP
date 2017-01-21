<?php if (!defined('FLUX_ROOT')) exit; ?>
<br/>
<h2>DELETAR SITE DE VOTO</h2>
<?php if (isset($errorMessage)): ?>
<p class="red" style="font-weight: bold"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>

<?php if (!empty($vpdel)): ?>
<form action="<?php echo $this->url ?>&sid=<?php echo $site_id; ?>&return=edit_site"  method="post" enctype="multipart/form-data" class="generic-form">
<table class="vertical-table" width="100%">
	<tr>
		<th align="left">
			<?php echo Flux::message('SITE_NAME_LABEL'); ?>				
		</th>
		<td>
			<?php echo $vpdel->site_name; ?>
		</td>
	</tr>
	<tr>
		<th align="left">
			<?php echo Flux::message('ADDRESS_LABEL'); ?>				
		</th>
		<td>
			<?php echo $vpdel->address; ?>
		</td>
	</tr>
	<tr>
		<th align="left">
			<?php echo Flux::message('BANNER_LABEL'); ?>		
		</th>
		<td>
			<?php if($vpdel->banner_url==""): ?>
				<i><?php echo Flux::message('BANNER_IS_UPLOADED'); ?>.
			<?php endif; ?>
			<?php if($vpdel->banner_url!=""): ?>
				<?php echo $vpdel->banner_url; ?>
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<th align="left">
			<?php echo Flux::message('BLOCK_TIME_LABEL'); ?>		
		</th>
		<td>
			<?php echo $hours.":".$minutes.":00"; ?>
		</td>
	</tr>
	<tr>
		<th align="left">
			<?php echo Flux::message('POINTS_LABEL'); ?>		
		</th>
		<td>
			<?php echo $vpdel->points; ?> pt('s)
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			Tem certeza que deseja deletar esse top?
			<input type="submit" name="Delete" id="Delete" value="Sim"/>
			&nbsp;&nbsp;|
			&nbsp;
			<a href="index.php?module=voteforpoints&action=list">Não</a>
		</td>
	</tr>
</table>
</form>
<script type="text/javascript" language="javascript">
	$('#id_cbox_banner_url').change(function(){
		var checked = $(this).attr('CHECKED');
			$('#id_banner_url').attr('DISABLED',!checked);
			$('#id_banner_upload').attr('DISABLED',!!checked);
	});
</script>
<?php else: ?>
<i>No voting sites found</i>
<?php endif ?>