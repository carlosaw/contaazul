<h1>Permissões - Adicionar Grupo de Permissões</h1>

<form method="POST">

	<label for="gname">Nome do Grupo de Permissões</label><br/>
	<input type="text" name="gname" /><br/><br/>

	<label><strong>Permissões</strong></label><br/>
	<?php foreach($permissions_list as $p): ?>
		<div class="p_item">
			<input type="checkbox" name="permissions[]" value="<?php echo $p['id']; ?>" id="p_<?php echo $p['id']; ?>" />
			<label for="p_<?php echo $p['id']; ?>"><?php echo $p['name']; ?></label>
		</div>
	<?php endforeach; ?>
	<br/><br/>
	<input type="submit" value="Adicionar" />
	
	
</form>