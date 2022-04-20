<style type="text/css">
th { text-align:left;  }
</style>
<h1>Relatório de Estoque</h1>
<fieldset>
	Ítens com estoque abaixo do mínimo!
</fieldset>
<br/>
<table border="0" width="100%">
	<tr>
		<th>Nome</th>
		<th>Preço</th>
		<th>Quant.</th>
		<th style="text-align:center">Quant. Min.</th>
		<th style="text-align:center">Diferença</th>
	</tr>

	<?php foreach($inventory_list as $product): ?>
		<tr>
			<td><?php echo $product['name']; ?></td>
			<td>R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></td>
			<td width="60" style="text-align:center"><?php echo $product['quant']; ?></td>
			<td style="text-align:center"><?php
				if($product['min_quant'] > $product['quant']) {
					echo '<strong><span style="color:red">'.($product['min_quant']).'</span></strong>';
				} else {
					echo $product['min_quant'];
				}
				?>
				<td style="text-align:center"><?php echo $product['dif']; ?></td>		
			</td>
		</tr>
	<?php endforeach; ?>

</table>