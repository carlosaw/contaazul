<h1>Compras - Editar</h1>

	<!--<strong>Nome do Usuário</strong><br/>
	<?php echo $purchases_info['info']['user_name']; ?><br/><br/>

	<strong>Data da Compra</strong><br/>
	<?php echo $purchases_info['info']['date_purchase']; ?><br/><br/>

	<strong>Total da Compra</strong><br/>
	<?php echo $purchases_info['info']['total_price']; ?><br/><br/>-->

																		
	<label for="name">Nome do Usuário</label><br/>
	<input type="text" name="name" value="<?php echo $purchases_info['info']['user_name']; ?>" disabled="disabled" /><br/><br/>

	<label for="date_purchase">Data da Compra</label><br/>
	<input type="text" name="date_purchase" value="<?php echo $purchases_info['info']['date_purchase']; ?>" disabled="disabled"/><br/><br/>

	<label for="total_price">Total da Compra</label><br/>
	<input type="text" name="total_price" value="<?php echo number_format($purchases_info['info']['total_price'], 2, ',', '.'); ?>" disabled="disabled" /><br/><br/>

	<strong>Status da Compra</strong><br/>
	<?php if($permission_edit): ?>
		<form method="POST">
			<select name="status">
				<?php foreach($statuses as $statusKey => $statusValue):?>
					<option value="<?php echo $statusKey; ?>" <?php echo ($statusKey == $purchases_info['info']['status'])?'selected="selected"':''; ?>><?php echo $statusValue; ?></option>
				<?php endforeach; ?>
			</select>
			<br/><br/>
			<input type="submit" value="Salvar" />
		</form>
		<?php else: ?>
			<?php echo $statuses[$purchases_info['info']['status']]; ?>
	<?php endif; ?>
<br/><br/>

<hr/>
<table border="0" width="100%">
	<tr>
		<th>Nome do Produto</th>
		<th>Quantidade</th>
		<th>Preço Unitário</th>
		<th>Preço Total</th>
	</tr>
	<?php foreach($purchases_info['products'] as $productitem): ?>
	<tr>
		<td><?php echo $productitem['name']; ?></td>
		<td><?php echo $productitem['quant']; ?></td>
		<td>R$ <?php echo number_format($productitem['purchase_price'], 2, ',', '.'); ?></td>
		<td><strong>R$ <?php echo number_format($productitem['purchase_price'] * $productitem['quant'], 2, ',', '.'); ?></strong></td>
	</tr>
	<?php endforeach; ?>
</table>